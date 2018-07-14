<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model("survey_model");
    
  }

  private function loadConfiguration()
  {
    $configdata = $this->survey_model->getConfiguration();
    
    if ($configdata != null)
    {
        /*Set station name of this device.*/
        $this->config->set_item('station_name', $configdata->station_name);
        /*Set fix path of attached usb.*/
        $this->config->set_item('usb_path', $configdata->usb_path);
        /*Set path of mysql and mysqldump.*/
        $this->config->set_item('mysql_path', $configdata->mysql_path);
        $this->config->set_item('mysqldump_path', $configdata->mysqldump_path);
        $this->config->set_item('mysqladmin_path', $configdata->mysqladmin_path);
        /*Set carousel image relative dimension.*/
        /*1280x800=88vh 800x480=78vh 1366x768=85vh*/
        $this->config->set_item("carousel_fit", $configdata->carousel_fit);
        /*Set begin, load database and return button relative dimension.*/
        /*<!--800x480 = 3vw 1280x800 = 5vw -->*/
        $this->config->set_item("begin_button_fit", $configdata->begin_button_fit);
        $this->config->set_item("begin_text", $configdata->begin_text);
        $this->config->set_item('company_name', $configdata->company_name);
        $this->config->set_item('posted_by', $configdata->posted_by);
        $this->config->set_item('posted_email', $configdata->posted_email);
        $this->config->set_item('thanks_path', $configdata->thanks_audio);
        $this->config->set_item('main_back', $configdata->main_back);
        $this->config->set_item('fav_icon', $configdata->fav_icon);
        $this->config->set_item('logo_text', $configdata->logo_text);
        $this->config->set_item('default_title', $configdata->default_title);
        $this->config->set_item('dbver', $configdata->dbver);
    }
  }
  
  public function index()
  {
    try{
        $this->session->set_userdata(array('response_id' => 0));
        $this->session->set_userdata(array('survey_slug' => ''));
        $this->session->set_userdata(array('footerhidden' => true));
        //$this->load->database();
        $data["active_surveys"] = $this->survey_model->getActiveSurveys();
        $data["active_surveys_ex"] = $data["active_surveys"];
        $this->loadConfiguration();
        $configdata = $this->survey_model->getConfiguration();
        
        if($configdata != null)
        {
            $data["thanks_audio"] = $configdata->thanks_audio;
            $data["main_back"] = $configdata->main_back;
        }
        else
        {
            $data["main_back"] = file_get_contents($this->config->item('main_back'));
        }
        
        $this->load->view('templates/survey/header', $data);
        $this->load->view('templates/survey/nav');
        $this->load->view('templates/survey/intro', $data);
        $this->load->view('templates/survey/footer');
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
  
  public function thanks()
  {
    $this->session->set_userdata('response_id', 0);
    $this->loadConfiguration();
    $configdata = $this->survey_model->getConfiguration();
    if ($configdata != null){
        $data["thanks_audio"] = $configdata->thanks_audio;
        $data["main_back"] = $configdata->main_back;
        $data["active_surveys"] = "";
    }
    else{
        $data["main_back"] = file_get_contents($this->config->item('main_back'));
    }    
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/thanks', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function reward()
  {
    $this->loadConfiguration();
    $configdata = $this->survey_model->getConfiguration();
    if ($configdata != null){
        $data["thanks_audio"] = $configdata->thanks_audio;
        $data["main_back"] = $configdata->main_back;
        $data["active_surveys"] = "";
    }
    else{
        $data["main_back"] = file_get_contents($this->config->item('main_back'));
    }    
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/reward', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function registercell()
  {
    $this->loadConfiguration();
    $surveyPrefix = "";
    $survey=$this->session->userdata('survey_slug');
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    if($surveyData != null) {
        // populate survery information
        $surveyPrefix = $surveyData->prefix;
    }
    
    if(isset($_POST["cellnumber"])){
        $cellnumber = $_POST["cellnumber"];
        
        $this->survey_model->saveCell($surveyPrefix, $cellnumber);
        echo $surveyPrefix.' '.$cellnumber;
    }
  }
  
  public function aquestion($survey = "")
  {
    $this->loadConfiguration();
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;

    // check if the provided slug was valid
    if($surveyData != null) {
        // populate survery information
        $surveyPrefix = $surveyData->prefix;
        $data["survey_title"] = $surveyData->title;
        $data["survey_subtitle"] = $surveyData->subtitle;
    }
    else {
        $data["valid_survey"] = false; // display error
    }

    // check if the survey was submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $data["valid_survey"]) {
        $result = $this->survey_model->validateSubmission($surveyPrefix);
        if(array_key_exists("errors", $result)) {
            $data["errors"] = $result["errors"];
            $data["survey_errors"] = true;
        }
        else {
            $data["show_questions"] = false;
        }
    }
  }
  
  /**
   * renders an error if a survey parameter is not passed
   * as a parameter in the url
   */
  public function questions($survey = "")
  {
    $this->loadConfiguration();
    $this->session->set_userdata('survey_slug', $survey);
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;
    $configdata = $this->survey_model->getConfiguration();
    if ($configdata != null)
    {
        $data["thanks_audio"] = $configdata->thanks_audio;
        $data["main_back"] = $configdata->main_back;
    }
    else{
        $data["main_back"] = file_get_contents($this->config->item('main_back'));
    }
    
    // check if the provided slug was valid
    if($surveyData != null) {
        // populate survery information
        $surveyPrefix = $surveyData->prefix;
        $data["survey_title"] = $surveyData->title;
        $data["survey_subtitle"] = $surveyData->subtitle;
    }
    else {
        $data["valid_survey"] = false; // display error
    }

    // check if the survey was submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $data["valid_survey"]) {
        $result = $this->survey_model->validateSubmission($surveyPrefix);
        if(array_key_exists("errors", $result)) {
            $data["errors"] = $result["errors"];
            $data["survey_errors"] = true;
        }
        else {
            $data["show_questions"] = false;
        }
    }
    // check if the user specified a valid survey
    if(!empty($surveyPrefix)) {
        $data["questions"] = $this->survey_model->getSurveyData($surveyPrefix);
        ($data["questions"] === null) ? $data["valid_survey"] = false: "";
    }
    $data["active_surveys"] = "";
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/survey', $data);
    $this->load->view('templates/survey/footer');
  }
    
  public function is_session_started()
  {
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
  }
  
  public function setfooterhidden(){
    if ( $this->is_session_started() === FALSE ) {
        session_start();
    }
    if(isset($_POST["footerhidden"])){
        $this->session->set_userdata(array('footerhidden' => $_POST["footerhidden"]));
    }
  }
  
  public function getfooterhidden(){
    if ($this->is_session_started() === FALSE) {
        session_start();
        //$this->session->set_userdata(array('footerhidden' => true));
        //echo $this->is_session_started();
    }
    
    $footerhiddenval = $this->session->userdata('footerhidden');
    echo ($footerhiddenval === true) ? 'true' : 'false';
  }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model("survey_model");
    
  }

  public function loadConfiguration()
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
  
  public function loaddb()
  {
    $this->loadConfiguration();
    $data["active_surveys"] = null;
    $data["active_surveys_ex"] = $this->survey_model->getActiveSurveys();
    $configdata = $this->survey_model->getConfiguration();
    if ($configdata != null){
        $data["thanks_audio"] = $configdata->thanks_audio;
        $data["main_back"] = $configdata->main_back;
    }
    else{
        $data["main_back"] = file_get_contents($this->config->item('main_back'));
    }     
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/intro', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function importdb()
  {
    try{
        $this->loadConfiguration();
        if(isset($_POST["dbfile"])){
            $dbasedir = $_POST["dbfile"];
        }
        else{
            $theusbpath = $this->whereusb();
            $dbasedir = $theusbpath.'survey.sql';
        }
          
        if(isset($_POST["dbfile"])){
            $mysqlbin = $this->config->item("mysql_path");
            $mysqldumpbin = $this->config->item("mysqldump_path");
            $mysqladminbin = $this->config->item("mysqladmin_path");
                
            if (!file_exists($mysqlbin)){
                if (DIRECTORY_SEPARATOR == '\\') {
                    $mysqlbin = realpath($this->config->item("bw_mysql_path"));
                    $mysqldumpbin = realpath($this->config->item("bw_mysqldump_path"));
                    $mysqladminbin = realpath($this->config->item("bw_mysqladmin_path"));
                }
            }
            //Backup current database in local app folder.
            $sublocation = $this->config->item("db_prefix").date('m-d-Y_hisa').$this->config->item("db_ext");
            $dbexpfile = $this->config->item("back_path").$sublocation;
            $shellcommand= $mysqldumpbin." -u ".$this->db->username." -p".$this->db->password." ".$this->db->database." --opt --routines --triggers --databases BANCO > ".$dbexpfile."\n";
            exec($shellcommand);
            
            //Backup current database in USB flash drive.
            $theusbpath = $this->whereusb();
            $dbexpfile = $theusbpath.'/'.$sublocation;
            if (!file_exists($dbexpfile)) {
                $dbexpfile = $this->config->item("back_usb_path").$sublocation;
            }
            $shellcommand= $mysqldumpbin." -u ".$this->db->username." -p".$this->db->password." ".$this->db->database." --opt --routines --triggers --databases BANCO > ".$dbexpfile."\n";
            exec($shellcommand);

            if(file_exists($dbasedir)){
                //Drop database only when new db file is available.
                $shellcommand= $mysqladminbin." -u ".$this->db->username." -p".$this->db->password." -f drop ".$this->db->database."\n";
                exec($shellcommand);
                //Import database.
                $shellcommand= $mysqlbin." -u ".$this->db->username." -p".$this->db->password." < ".$dbasedir."\n";
                exec($shellcommand);
            }
            //redirect($this.base_url());
        }
    } catch (Exception $ex) {

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
  
  public function export($survey = "")
  {
    $this->loadConfiguration();
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;
    $data["export_result"] = "";
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
    $result = $this->survey_model->getSurveyDataForExport($surveyPrefix);
    $this->load->dbutil();
    $this->load->helper('file');
    $theusbpath = $this->whereusb();
    if ($theusbpath!=''){
        if (!file_exists($theusbpath)) {
            $theusbpath = $this->config->item('back_usb_path');
        } 
        $thefile = $this->config->item("exp_prefix").date('m-d-Y_hisa').$this->config->item("exp_ext");
        $outfile = $theusbpath.$thefile;
        $csvdata = $this->dbutil->csv_from_result($result);
        if ( ! write_file($outfile, $csvdata)){
            $data["export_result"] = "Export failed.";
        }
        else{
            $data["export_result"] = "File, ".$thefile.", successfully exported in <br>".$theusbpath." folder.";
        }
    }
    else{
        $data["export_result"] = "Export failed . USB stick not detected.";
    }
    //sleep(3);
    echo $data["export_result"];
    
//    $data["active_surveys"] = "";
//    $this->load->view('templates/survey/header', $data);
//    $this->load->view('templates/survey/nav');
//    $this->load->view('templates/survey/exported', $data);
//    $this->load->view('templates/survey/footer'); 
  }
  
  public function displayexport($exportresult="")
  {
    $exportresult = $_GET['exportresult'];
    $this->loadConfiguration();
    $configdata = $this->survey_model->getConfiguration();
    if ($configdata != null){
        $data["thanks_audio"] = $configdata->thanks_audio;
        $data["main_back"] = $configdata->main_back;
    }
    else{
        $data["main_back"] = file_get_contents($this->config->item('main_back'));
    }
    $data["export_result"] = $exportresult;
    $data["active_surveys"] = "";
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/exported', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function whereusb(){
    $usb_path = $this->config->item('usb_path');
    $good_usb_path = "";
    if (file_exists($usb_path)){
        $directories = glob($usb_path . '*' , GLOB_ONLYDIR);
        foreach($directories as $directory){
            if(is_writable($directory) == true){
                if(touch($directory.'/test.txt') == true){
                    if(unlink($directory.'/test.txt') == true){
                        $good_usb_path = $directory;
                        return $good_usb_path;
                    }
                }
            }
        }
    }
    return '';
  }
  
  public function reloadlist(){
    
    $theusbpath = $this->whereusb();
    if($theusbpath != ''){
        echo '<p>Please select Database File and click [Load Database] button.<br> USB Path detected: '.$theusbpath.'.</p>';

        if (!file_exists($theusbpath)) {
            echo '<p><strong>Loading from backup path '.$this->config->item('back_usb_path').'</strong>.</p>';
            $flist = glob($this->config->item('back_usb_path').'*'.$this->config->item('db_ext'));
        } 
        else {
            $flist = glob($theusbpath.'/*'.$this->config->item('db_ext'));
        }

        echo '<div class="radio" style="display: block">';
        foreach($flist as $fileitem){
            echo '<label><input type="radio" style="display: inline" name="dbfile" value="'.$fileitem.'"/>'.basename($fileitem).'</label><br>';
        }
        echo '</div>';
    }
    else{
        echo '';
    }
  }
  
  public function setfooterhidden(){
    if(isset($_POST["footerhidden"])){
        $this->session->set_userdata(array('footerhidden' => $_POST["footerhidden"]));
    }
  }
  
  public function getfooterhidden(){
    echo $this->session->userdata('footerhidden');
  }
  
}
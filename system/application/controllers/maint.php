<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maint extends CI_Controller {

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
    $this->session->set_userdata(array('footerhidden' => false));
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/intro', $data);
    $this->load->view('templates/survey/footer');
  }
  
    public function reloadlist(){
    $this->loadConfiguration();
    $theusbpath = $this->whereusb(true);
    if($theusbpath != ''){
        echo '<p>Please select Database File and click [Load Database] button.<br> USB Path detected, '.$theusbpath.'.</p>';

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
        echo '<p>USB stick not detected.</p>';
    }
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
            echo 'Database loaded successfully.';
            //redirect($this.base_url());
        }
    } catch (Exception $ex) {

    }
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
  
  public function whereusb($withfallback = false){
    $usb_path = $this->config->item('usb_path');
    $good_usb_path = "";
    
    if (file_exists($usb_path)){
        $directories = glob($usb_path . '*' , GLOB_ONLYDIR);
        foreach($directories as $directory){
            exec('/usr/bin/sudo /bin/chmod 777 '.$directory);
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
    if (($good_usb_path === "") && $withfallback){
        return $this->config->item('back_usb_path');
    }
    return '';
  }

  public function reloadZiplist(){
    $this->loadConfiguration();
    $theusbpath = $this->whereusb();
    if($theusbpath != ''){
        echo '<p>Please select Code File and click [Stage Code] button.<br> USB Path detected, '.$theusbpath.'.</p>';

        if (!file_exists($theusbpath)) {
            echo '<p><strong>Loading from backup path '.$this->config->item('back_usb_path').'</strong>.</p>';
            $flist = glob($this->config->item('back_usb_path').'*'.$this->config->item('zip_ext'));
        } 
        else {
            $flist = glob($theusbpath.'/*'.$this->config->item('zip_ext'));
        }

        echo '<div class="radio" style="display: block">';
        foreach($flist as $fileitem){
            echo '<label><input type="radio" style="display: inline" name="codefile" value="'.$fileitem.'"/>'.basename($fileitem).'</label><br>';
        }
        echo '</div>';
    }
    else{
        echo '<p>USB stick not detected.</p>';
    }
  }

  public function loadcode()
  {
    try{
        $this->loadConfiguration();
        if(isset($_POST["codefile"])){
            $dbasedir = $_POST["codefile"];
        }
        else{
            $theusbpath = $this->whereusb();
            $dbasedir = $theusbpath.'default.tar';
        }
         
        if(isset($_POST["codefile"])){
            $dateappend = date('mdYhisa');
            $path_parts = pathinfo($_POST["codefile"]);
            $destfolder = $this->config->item('code_path').$path_parts['filename'].$dateappend;
            mkdir($destfolder, 0777);
            if (DIRECTORY_SEPARATOR == '/') {
                exec('tar -C '.$destfolder.' -xvf '.$_POST["codefile"]);
                //$phar = new PharData($_POST["codefile"]);
                //if($phar->extractTo($destfolder)){
                echo $_POST["codefile"].' successfully extracted to '.$destfolder.'.';
                //}
                //else{
                //        echo 'Code loading failed!';
                //}
            }
            else{
                //$zip = new ZipArchive;
                $phar = new PharData($_POST["codefile"]);
                //$res = $zip->open($_POST["codefile"]);
                //if ($res === TRUE) {
                    //if ($zip->setPassword("P@ssw0rd"))
                    //{
                    if($phar->extractTo($destfolder)){
                    //if($zip->extractTo($destfolder)){
//                        if(unlink('/home/pi/start.sh') == true){
//                            $data_to_write='/usr/bin/chromium-browser --incognito --start-maximized --kiosk http://localhost/riemann'.$dateappend;
//                            $file_handle = fopen($file_path, 'w'); 
//                            fwrite($file_handle, $data_to_write);
//                            fclose($file_handle);
//                            echo 'woot!';
//                        }
                        echo $_POST["codefile"].' successfully extracted to '.$destfolder.'.';
                    }
                    else{
                        echo 'Code loading failed!';
                    }
                    //}
                    //$zip->close();
                //} else {
                //  echo 'doh!';
                //}
            }
        }
    } catch (Exception $ex) {

    }
  }
  
  public function reloadcodelist(){
    $this->loadConfiguration();
    $thecodepath = $this->config->item('code_path');
    if($thecodepath != ''){
        echo '<p>Please select Code File and click [Load Code] button.<br>';
        echo 'Current code is '.base_url().'</p>';
        $dirlist = glob($thecodepath.'*', GLOB_ONLYDIR);

        echo '<div class="radio" style="display: block">';
        foreach($dirlist as $diritem){
            $codefile = glob($diritem.'/A4590CF3209F22E92B');
            $htaccessfile = glob($diritem.'/.htaccess');
            
            if ((count($codefile) > 0) && (count($htaccessfile) > 0)){
                echo '<label><input type="radio" style="display: inline" name="codefolder" value="'.basename($diritem).'"/>'.basename($diritem).'</label><br>';
            }
        }
        echo '</div>';
    }
  }
  
  public function selectthecode()
  {
    try{
        $this->loadConfiguration();

        if(isset($_POST['codefolder'])){
            if(file_exists($this->config->item('start_path'))){
                unlink($this->config->item('start_path'));
            }
            $data_to_write='/usr/bin/chromium-browser --incognito --start-maximized --kiosk http://localhost/'.$_POST["codefolder"];
            $file_handle = fopen($this->config->item('start_path'), 'w'); 
            fwrite($file_handle, $data_to_write);
            fclose($file_handle);
            echo 'Code successfully selected.';
        }
    } catch (Exception $ex) {
        echo 'Code selection failed.';
    }
  }

  public function rebootsystem()
  {
      try{
        //exec ('/usr/bin/sudo /etc/init.d/portmap restart');
        shell_exec("/usr/bin/sudo /sbin/reboot");
        exec("/usr/bin/sudo /sbin/reboot");
        system("/usr/bin/sudo /sbin/reboot");
        echo 'true';
      }
      catch (Exception $ex){
        echo 'false';
      }
  }
  
  public function mutesound($mute = 0){
      try{
        //0 - Mute; 1 - UnMute;
        $imute = (string) ($mute);
        if ($this->config->item('vol_ctrl') != ''){
            exec("sudo amixer cset numid=2 ".$imute);
        }
        echo 'true';
      }
      catch (Exception $ex){
        echo 'false';
      }
  }
  
  public function getsoundlevel(){
      try{
        $retval = '';
        if ($this->config->item('vol_ctrl') != ''){  
            $retval = exec("/usr/bin/sudo ".$this->config->item('vol_ctrl')); 
        }
        if ($retval === "") {
            $retval = "50";
        }
        return $retval;
      }
      catch (Exception $ex){
        return '';
      }
  }
  
  public function adjustsound($vol = 0){
      try{
        if(isset($_POST["vol"])){
            $ivol = (string) ($_POST["vol"]);
            if ($this->config->item('vol_ctrl')!= ''){
                echo exec("/usr/bin/sudo ".$this->config->item('vol_ctrl')." ".$ivol);
            }
            //echo 'true';
        }
      }
      catch (Exception $ex){
        //echo 'false';
      }
  }
  
  public function reloadvolume(){
    $this->loadConfiguration();
    $thesoundlevel = $this->getsoundlevel();
    if ($thesoundlevel === "") {
        $thesoundlevel = "50";
    }
    echo '<audio control id="popsoundonvol">';
    echo '    <source src="<?php echo \'../../\'.$this->config->item(\'pop_path\'); ?>" type="audio/mpeg">';
    echo '</audio>';
    echo '<div><br></div>';
    echo '<div id="voldiv">';
    echo '    <input type="range" id="volid" style="width:100%;" min="0" max="100" value="'.$thesoundlevel.'" data-rangeslider>';
    echo '    <output>'.$thesoundlevel.'</output>';
    echo '<input type="number" style="display: none;" value="'.$thesoundlevel.'">';
    echo '</div>';
  }
  
}

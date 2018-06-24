<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*Set station name of this device.*/
$config['station_name']                     = 'station1';
/*Set fix path of attached usb.*/
$config['usb_path']                         = 'assets/downloads/';
/*Set path of mysql and mysqldump.*/
if (DIRECTORY_SEPARATOR == '\\') {
    $config['mysql_path']                       = 'D:\xampp\mysql\bin\mysql.exe';
    $config['mysqldump_path']                   = 'D:\xampp\mysql\bin\mysqldump.exe';
    $config['mysqladmin_path']                  = 'D:\xampp\mysql\bin\mysqladmin.exe';
}
else
{
    $config['mysql_path']                       = '/usr/bin/mysql';
    $config['mysqldump_path']                   = '/usr/bin/mysqldump';
    $config['mysqladmin_path']                  = '/usr/bin/mysqladmin';
}
/*Set carousel image relative dimension.*/
/*1280x800=88vh 800x480=78vh 1366x768=85vh*/
$config["carousel_fit"]                     = "height:85vh";
/*Set begin, load database and return button relative dimension.*/
/*<!--800x480 = 3vw 1280x800 = 5vw -->*/
$config["begin_button_fit"]                 = "5vw";
$config["begin_text"]                       = "";

$config['company_name']                     = 'FSDII';
$config['posted_by']                        = 'Pelolito A. Aparece';
$config['posted_email']                     = 'paparece@lexmark.com';
$config['thanks_path']                      = 'assets/audios/ty.mp3';
$config['img_path']                         = 'assets/images/general/';
$config['main_back']                        = 'assets/images/general/mainback2.jpg';
$config['button_back']                      = 'assets/images/general/submit.jpg';
$config['fav_icon']                         = 'assets/images/general/fav_icon.png';
$config['back_path']                        = 'assets/downloads/backup/';
$config['exp_prefix']                       = 'data_export_';
$config['exp_ext']                          = '.csv';
$config['db_prefix']                        = 'survey_';
$config['db_ext']                           = '.sql';
$config['taste_cafe']                       = 'assets/images/general/tastecafe.gif';
$config['sonnets']                          = 'assets/images/general/sonnets.gif';

//Bootstrap
$config['bootflat_css']                     = 'assets/css/bootflat.min.css';
$config['style_css']                        = 'assets/css/style.css';
$config['bootstrap_css']                    = 'assets/frameworks/bootstrap-4.0.0/dist/css/bootstrap.css';
$config['rating_css']                       = 'assets/css/rating.css';
$config['fontawesome_css']                  = 'assets/frameworks/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.css';
$config['bootstrap_theme_css']              = 'assets/frameworks/bootstrap-4.0.0/dist/css/bootstrap-theme.min.css';
$config['bootstrap_js']                     = 'assets/frameworks/bootstrap-4.0.0/dist/js/bootstrap.min.js';
$config['bootstrap_justified_css']          = 'assets/frameworks/bootstrap-4.0.0/dist/css/justified-nav.css';
$config['bootstrap_narrow_css']             = 'assets/frameworks/bootstrap-4.0.0/dist/css/jumbotron-narrow.css';
$config['bootstrap_starter_css']            = 'assets/frameworks/bootstrap-4.0.0/dist/css/starter-template.css';
$config['bootstrap_dashboard_css']          = 'assets/frameworks/bootstrap-4.0.0/dist/css/dashboard.css';
$config['bootstrap_footer_css']             = 'assets/frameworks/bootstrap-4.0.0/dist/css/sticky-footer.css';

$config['jQuery_js']                        = 'assets/js/jquery/jquery-3.3.1.min.js';
$config['survey_js']                        = 'assets/js/survey_js.js';
$config['rating_js']                        = 'assets/js/rating.js';
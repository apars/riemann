<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      <?php echo ((isset($survey_title)) ? $survey_title : getDefaultTitle() ); ?>
    </title>
    <link rel="Stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('bootstrap_css'); ?>"  />
    <link rel="Stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('rating_css'); ?>"  />
    <link rel="Stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('fontawesome_css'); ?>"  />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('bootflat_css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('style_css'); ?>"/>
    <link rel="icon" href="data:image/png;base64,<?php echo base64_encode($this->config->item('fav_icon')); ?>"/>
    <link rel="Stylesheet" type="text/css" href="<?php echo base_url().$this->config->item('loader_css'); ?>"  />
    <script type="text/javascript"> var base_url = "<?php echo base_url(); ?>";</script>
  </head>
  <body class="body" style="background-image: url(data:image/jpeg;base64,<?php echo base64_encode($main_back); ?>)">     
      <!--<div class="imageback"></div>-->
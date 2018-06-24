<div class="col-md-12" style='transform: translate(0%,25%);'>
  <audio autoplay>
    <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
  </audio>
    <div>
    <h2 class="introtext" style="text-align: center; font-family: AmaticSC; font-size: 14vh;margin-top: auto;margin-bottom: auto;">SALAMAT! <br>
        For helping us serve you better.<br>
  </h2>
        <div class="row col-8" style='margin-left: auto;margin-right: auto;'>
            <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;width:40vw;">
        <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
        </div>
            <div class="column" style="width:20vw;margin-top: auto;margin-bottom: auto;justify-content: center;">
        <img class="d-block" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="max-width: 100%;max-height: 100%;">
        </div>
        </div>
        <?php header("Refresh: 3; url=".base_url()); ?>
    </div>
    
</div>


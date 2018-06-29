<div class="container imageloc">
<div class="col-md-12" style='transform: translate(0%,25%);'>
    <audio autoplay>
        <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
    </audio>
    <div class="col-md-12 startpagetext vmarginauto">
        <span style="font-size: 12vh;"><strong>SALAMAT!</strong></span>
        <p style="font-size: 8vh;">For helping us serve you better.</p>
<!--        <h2 class="startpagetext vmarginauto">SALAMAT! <br></h2>
            For helping us serve you better.<br>
        </h2>-->
        <div class="row col-12" style='position: absolute; top: 39vh; margin-left: auto;margin-right: auto;'>
            <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;height:12vw;">
                <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
            </div>
            <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;height:12vw;">
                <img class="d-block" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="max-width: 100%;max-height: 100%;">
            </div>
        </div>
        <?php header("Refresh: 3; url=".base_url()); ?>
    </div>    
</div>
</div>

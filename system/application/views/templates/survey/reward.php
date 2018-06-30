<div class="container-fluid imageloc">
<div class="col-md-12" style='transform: translate(0%,25%);'>
<!--    <audio autoplay>
        <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
    </audio>-->
    <div>
        <h2 class="rewardtext vmarginauto">Register your cellphone number for a chance to win <u>AMAZING PRIZES</u>!</h2>
        <div class="col-md-8 form-group hmarginauto cellentrytext">
            <label class="vmarginauto" for="text-basic" ><br>Click box below...<br></label>
            <input type="number" class="form-control cellentrytext" id="text-basic" style="max-height: 100%;max-width: 100%" placeholder="Enter cellphone number...">
	</div>
        <div class="col-md-3 hmarginauto">
            <br>
            <button type="button" class="btn btn-lg btn-info" onclick="registerCellNumber('<?php echo base_url().'registercell'; ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">Done!</button>
            
        </div>
<!--        <div class="row col-8" style='margin-left: auto;margin-right: auto;'>
            <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;width:40vw;">
                <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
            </div>
            <div class="column" style="width:18vw;margin-top: auto;margin-bottom: auto;justify-content: center;">
                <img class="d-block" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="max-width: 100%;max-height: 100%;">
            </div>
        </div>-->
    </div>
    
</div>
    <div class="col-md-12" style="<?php echo $this->config->item('taste_cafe_pos'); ?>">
        <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
    </div>
</div>
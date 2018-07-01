<div class="container-fluid imageloc">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
    <?php if(isset($valid_survey) && $valid_survey && isset($show_questions) && $show_questions): ?>
        <ol class="carousel-indicators">
        <?php $j = 0 ?>
        <?php foreach($questions as $question): ?>
            <?php if($j == 0): ?>
                <li data-target="#carouselExampleIndicators" class="active" name="carindicate"></li>
            <?php else : ?>
                <li data-target="#carouselExampleIndicators" name="carindicate"></li>
            <?php endif; ?>
            <?php $j++ ?>
        <?php endforeach; ?>
        <!--<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $j ?>"></li>-->
        </ol>
    <form role="form" method="post" class="survey-form clearfix" id="mainsurveyform">
        <div class="carousel-inner">
        <?php $i = 0 ?>
        <?php foreach($questions as $question): ?>
            <?php if($i == 0): ?>
                <div class="carousel-item active">
            <?php else : ?>
                <div class="carousel-item">
            <?php endif; ?>
            <img class="d-block w-100" src="data:image/jpeg;base64,<?php echo base64_encode($question->image_back); ?>" alt="" style="<?php echo $this->config->item('carousel_fit'); ?>">
            <?php if($question->question_type == 0): ?>
            <div class="carousel-caption d-md-blockn" style="left: 0;width: 100%;">                          
                    <h1 class="questiontext"><?php echo $question->question_text; ?></h1>
                    <div class="form-group" id="options<?php echo $question->id; ?>">
                        <span class="rating" id="ratingentry">
                            <ul>
                                <?php foreach($question->options as $option): ?>
                                    <li><label for="rating_<?php echo $option->id ?>">
                                        <!--<img class="d-block rateimg" src="data:image/gif;base64,<?php echo base64_encode($option->option_image); ?>" alt="" style="max-width: 12.5vw;max-height: 12.5vh;">-->
                                        <i class="<?php echo (($question->icon_text != null ) ? $question->icon_text : 'fas fa-star fa-5x'); ?>" aria-hidden="true"></i>
                                        </label>
                                        <input type="radio" name="ratings<?php echo $i+1 ?>" id="rating_<?php echo $option->id ?>" value="<?php echo $option->id ?>" 
                                        <?php 
                                            $ivalue = (string) ($i+1);
                                            echo ((isset($_POST["ratings".$ivalue]) && $_POST["ratings".$ivalue] == $option->id) ? "checked" : "" ); 
                                        ?>/>
                                        <!--<p class="optionx"><?php echo $option->option_text ?></p>-->
                                    </li> 
                                <?php endforeach; ?>
                            </ul>
                        </span>
                    </div>
<!--                    <div class="col-md-12" style="position: relative;margin-left: auto;margin-right: 0; width:20vw;">
                        <img class="d-block" src="../<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
                    </div>  -->
                </div>
            <?php endif; ?>
            <?php if($question->question_type == 3): ?>
                <div class="carousel-caption d-none d-md-block">                          
                    <h1 class="questiontext"><?php echo $question->question_text; ?></h1>
                    <br>
                    <div class="form-group" id="options<?php echo $question->id; ?>">
                        <span class="rating" id="ratingentry">
                            <div id="checkboxes<?php echo $i+1 ?>" class="checkbox">
                            <?php foreach($question->options as $option): ?>
                                <label for="rating_<?php echo $option->id ?>">
                                <input type="checkbox" style="width:8vw; height:8vh;" name="ratings<?php echo $i+1 ?>" id="rating_<?php echo $option->id ?>" value="<?php echo $option->id ?>" 
                                <?php echo ((isset($_POST["ratings".$i+1]) && $_POST["ratings".$i+1] == $option->id) ? "checked" : "" ); ?>/>
                                <p class="optionstext"><?php echo $option->option_text ?></p>
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </span>
                        <br><br><br>
                        <button id="checkboxsubmit<?php echo $option->id ?>" type="button" class="btn btn-lg btn-success pull-center" 
                            onclick="submitCheckbox('ratings<?php echo $i+1 ?>')" 
                            style="height:100%;width:50%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                            Submit
                        </button>
                    </div>
                    
                </div>
            <?php endif; ?>
                </div>
            <?php $i++ ?>
        <?php endforeach; ?>
            <!--
          <div class="carousel-item">
            <img class="d-block w-100" src="<?php echo base_url().$this->config->item('button_back'); ?>" alt="Submit Button" style="<?php echo $this->config->item('carousel_fit'); ?>">
            <div class="carousel-caption d-none d-md-block" style="height:50%;width:50%;left:25%;">
              <button id="demo" type="submit" class="btn btn-lg btn-success pull-center" style="height:100%;width:100%;font-size:5vw;border-radius: 3vh;">Submit Response</button>
            </div>              
          </div>-->
                </div>          
     <!--
          <a class="carousel-control-prev" id="carprevid" href="#carouselExampleIndicators" role="button" data-slide="prev" >
          <div style="text-shadow: 2px 2px 4px #000000;">Previous</div>
            <span class="carousel-control-prev-icon" aria-hidden="true" style=" height: 40%; width:40%;"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" id="carnextid" href="#carouselExampleIndicators" role="button" data-slide="next" >
            <span class="carousel-control-next-icon" aria-hidden="true" style=" height: 40%; width:40%;"></span>
            <span class="sr-only">Next</span>
            <div style="text-shadow: 2px 2px 4px #000000;">Next</div>
          </a>
     -->
            <audio control id="popsound">
                <source src="../<?php echo $this->config->item('pop_path'); ?>" type="audio/mpeg">
            </audio>
        </div> 
        <div class="col-md-12" style="<?php echo $this->config->item('taste_cafe_pos'); ?>">
            <img class="d-block" src="../<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
        </div>
    </form>
    <div class="col-md-12">
    <?php elseif(isset($valid_survey) && $valid_survey && !(isset($survey_errors) && $survey_errors)): ?>
        <audio autoplay>
            <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
        </audio>
        <div>
            <h2 class="introtext" style="text-align: center; font-family: AmaticSC; font-size: 14vh;margin-top: auto;margin-bottom: auto;">SALAMAT! <br>
                For helping us serve you better.<br>
            </h2>
            <div class="row col-8" style='margin-left: auto;margin-right: auto;'>
                <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;">
                    <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="width:30vw;">
                </div>
                <div class="column" style="margin-top: auto;margin-bottom: auto;justify-content: center;">
                    <img class="d-block" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="width:30vw;">
                </div>
            </div>
        </div>
        <?php header("Refresh: 2; url=".base_url()); ?>
    <?php endif; ?>
    </div>
</div>
</div>


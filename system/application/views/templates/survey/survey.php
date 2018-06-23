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
          <div class="carousel-caption d-none d-md-block">                          
            <h1 style="text-shadow: 2px 2px 4px #000000;"><?php echo $question->question_text; ?></h1>
              <div class="form-group" id="options<?php echo $question->id; ?>">
                <span class="rating" id="ratingentry">
                  <ul>
                    <?php foreach($question->options as $option): ?>
                    <li><label for="rating_<?php echo $option->id ?>"><i class="<?php echo (($question->icon_text != null ) ? $question->icon_text : 'fas fa-star fa-5x'); ?>" aria-hidden="true"></i></label>
                        <input type="radio" name="ratings<?php echo $i+1 ?>" id="rating_<?php echo $option->id ?>" value="<?php echo $option->id ?>" 
                            <?php echo ((isset($_POST["ratings".$i+1]) && $_POST["ratings".$i+1] == $option->id) ? "checked" : "" ); ?>/>
                        <p style="color:white;text-shadow: 2px 2px 4px #000000;"><?php echo $option->option_text ?></p>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </span>
              </div>
          </div>
      <?php endif; ?>
      <?php if($question->question_type == 3): ?>
          <div class="carousel-caption d-none d-md-block">                          
            <h1 style="text-shadow: 2px 2px 4px #000000;"><?php echo $question->question_text; ?></h1>
            <br>
              <div class="form-group" id="options<?php echo $question->id; ?>">
                <span class="rating" id="ratingentry">
                  <div id="checkboxes<?php echo $i+1 ?>" class="checkbox">
                    <?php foreach($question->options as $option): ?>
                    <label for="rating_<?php echo $option->id ?>">
                        <input type="checkbox" style="width:8vw; height:8vh;" name="ratings<?php echo $i+1 ?>" id="rating_<?php echo $option->id ?>" value="<?php echo $option->id ?>" 
                            <?php echo ((isset($_POST["ratings".$i+1]) && $_POST["ratings".$i+1] == $option->id) ? "checked" : "" ); ?>/>
                        <p style="color:white;text-shadow: 2px 2px 4px #000000;"><?php echo $option->option_text ?></p>
                    </label>
                    <?php endforeach; ?>
                  </div>
                </span>
                  <br><br><br>
                 <button id="checkboxsubmit<?php echo $option->id ?>" type="button" class="btn btn-lg btn-success pull-center" 
                      onclick="submitCheckbox('ratings<?php echo $i+1 ?>')" 
                      style="height:100%;width:50%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">
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
              <button id="demo" type="submit" class="btn btn-lg btn-success pull-center" style="height:100%;width:100%;font-size:5vw;border-radius: 25px;">Submit Response</button>
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
       </div>
    </form>
    <div class="col-md-12">
  <?php elseif(isset($valid_survey) && $valid_survey && !(isset($survey_errors) && $survey_errors)): ?>
        <audio autoplay>
          <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
          </audio>
      <h2 class="introtext" style="text-align: center"><br>All Done! <br><br>
         Thank you for completing the survey.<br><br>
      </h2>
      <?php header("Refresh: 2; url=".base_url()); ?>
   <?php endif; ?>
    </div>
</div>


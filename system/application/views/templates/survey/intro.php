<div class="container imageloc">
    <div class="row">
      <div class="col-md-12">
        <!--<img class="d-block img-responsive imagecenter w-100" src="<?php echo base_url().$this->config->item('main_back'); ?>" alt="Main_Back">-->
        <?php if(isset($active_surveys) && $active_surveys != null): ?>
          <div class="col-md-12" style="position: absolute; transform: translate(0%, 10%); margin-top: auto;margin-bottom: auto;margin-left: auto;margin-right: auto;">
              <div class="col-md-12" style="margin-left: auto;margin-right: auto; width:70vw;">
        <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
        </div>
                  <div class="col-md-12" style="width:20vw; position: absolute;right: 0px;">
        <img class="d-block" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="max-width: 100%;max-height: 100%;">
        </div>
              <h2 class="introtext" style="font-family: AmaticSC; font-size: 9vh;"><?php echo $this->config->item('begin_text'); ?></h2>
          <div style="width: 20vw; height: 15vh;margin: 0 auto;">
            <?php foreach($active_surveys as $survey): ?>
<!--              <a href="<?php echo base_url() . "questions/" . $survey->slug; ?>" class="list-group-item" style="text-align: center">
                <?php echo $survey->title; ?>
                <span class="glyphicon glyphicon-chevron-right pull-center"></span>
              </a>-->
              
              <button id="demo" type="submit" class="btn btn-lg btn-success pull-center" 
                      onclick="redirectOnBeginClick('<?php echo base_url() . "questions/" . $survey->slug; ?>')" 
                      style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">
                          Begin
              </button>
              
              
            <?php endforeach; ?>
              <audio control id="popsoundbegin">
          <source src="<?php echo $this->config->item('pop_path'); ?>" type="audio/mpeg">
          </audio>
       </div>
          </div>
        <?php else: ?>
        <div class="alert alert-danger text-center" role="alert">
            <strong>
                ACHTUNG! <br>MAINTENANCE MODE<br>
            </strong>
              Proceed with extreme caution.
          </div>
              <div id="theloaddbbuttons">
                  <!--800x480 = 3vw 1280x800 = 5vw -->
                  <div><br><br></div>
                  <button type="button" class="btn btn-info btn-sm btn btn-lg btn-danger" data-toggle="modal" data-target="#loadUSB" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">Load Database...</button>
                  <div><br><br></div>
                  <button type="button" class="btn btn-info btn-sm btn btn-lg" onclick="redirectOnClick('<?php echo base_url(); ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 25px;">Return</button>
                  <!-- Load USB Modal -->
                    <div id="loadUSB" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Insert USB</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body">
                            <p>Please insert USB stick and hit OK button.</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loadDBFile" data-dismiss="modal">OK</button>
                              <!--<button type="button" class="btn btn-default" onclick="redirect2importDB('<?php echo base_url().'importdb'; ?>')" data-dismiss="modal">OK</button>-->
                          </div>
                        </div>

                      </div>
                    </div>
                  <!-- Load Database File Modal -->
                    <div id="loadDBFile" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Load Database</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body" style="height: 250px;">
                            <p>Please select Database File and hit OK button.</p>
                            <?php
                                $flist = glob($this->config->item('usb_path').'*'.$this->config->item('db_ext'));
                            ?>
                            <div class="radio" style="display: block">
                                <?php foreach($flist as $fileitem): ?>
                                    <label><input type="radio" style="display: inline" name="dbfile" value="<?php echo $fileitem ?>"  
                                    
                                                  /> <?php echo basename($fileitem) ?>
                                    </label><br>
                                <?php endforeach; ?>
                                <!--<label><input type="radio" style="display: inline" name="dbfile" value="female"> Female</label><br>
                                <label><input type="radio" style="display: inline" name="dbfile" value="other"> Other</label>-->
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" onclick="redirect2importDB('<?php echo base_url().'importdb'; ?>')">Load Database</button>
                          </div>
                        </div>

                      </div>
                    </div>
              </div>
              <div class="loader" id="theloader" style="display: none"></div>
        <?php endif; ?>
          </div>
     </div>
    </div>
    
  </div>


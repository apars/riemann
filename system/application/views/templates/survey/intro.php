<div class="container imageloc">
    <div class="row">
        <div class="col-md-12">
            <!--<img class="d-block img-responsive imagecenter w-100" src="<?php echo base_url().$this->config->item('main_back'); ?>" alt="Main_Back">-->
            <?php if(isset($active_surveys) && $active_surveys != null): ?>
                <div class="col-md-12 vmarginauto hmarginauto" id="beginintro" style="position: absolute; top: 3vh; left: 0px;">
                    <div class="col-md-12 hmarginauto" style="width: 85%">
                        <img class="d-block" src="<?php echo $this->config->item('taste_cafe'); ?>" alt="" style="max-width: 100%;max-height: 100%;">
                    </div>
                    
                    <div class="startpagetext"><?php echo $this->config->item('begin_text'); ?></div>
                    <div style="width: 20vw; height: 15vh;margin: 0 auto;">
                    <?php foreach($active_surveys as $survey): ?>
                        <!--<a href="<?php echo base_url() . "questions/" . $survey->slug; ?>" class="list-group-item" style="text-align: center">
                        <?php echo $survey->title; ?>
                        <span class="glyphicon glyphicon-chevron-right pull-center"></span>
                        </a>-->
              
                        <button id="demo" type="submit" class="btn btn-lg btn-success pull-center" 
                        onclick="redirectOnBeginClick('<?php echo base_url() . "questions/" . $survey->slug; ?>')" 
                        style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                            Begin
                        </button>
                    <?php endforeach; ?>
                        <audio control id="popsoundbegin">
                            <source src="<?php echo $this->config->item('pop_path'); ?>" type="audio/mpeg">
                        </audio>
                    </div>
                    
                </div>
                    <div class="col-md-12" style="<?php echo $this->config->item('sonnet_intro_pos'); ?>">
                        <img class="d-block" id="sonnetimg" src="<?php echo $this->config->item('sonnets'); ?>"    alt="" style="max-width: 100%;max-height: 100%;">
                    </div>

                <div class="loader" id="beginloader" style="display: none;"></div>
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
                <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#loadUSB" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">Load Database...</button>
                <div><br></div>
                <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#loadUSBforCode" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">Load Code...</button>
                <div><br></div>
                <?php if(($active_surveys_ex != "") && ($active_surveys_ex != null)): ?>
                    <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#exportData" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">Export Data...</button>
                <?php endif; ?>
                <div><br></div>    
                <button type="button" class="btn btn-lg btn-info" onclick="redirectOnClick('<?php echo base_url(); ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">Return</button>
                
                <!-- Load USB for Database -->
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
                                <button type="button" id="usbinsert" class="btn btn-default" data-toggle="modal" onclick="refreshfilelist()" data-dismiss="modal">OK</button>
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
                            <div class="modal-body" style="height: 33vh;">
                                <p>Please select Database File and click [Load Database] button.</p>
                                <?php    
                                    if (!file_exists($this->config->item('usb_path'))) {
                                        echo '<p><strong>Loading from backup path '.$this->config->item('back_usb_path').'</strong>.</p>';
                                        $flist = glob($this->config->item('back_usb_path').'*'.$this->config->item('db_ext'));
                                    } 
                                    else {
                                        $flist = glob($this->config->item('usb_path').'*'.$this->config->item('db_ext'));
                                    }
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
                
                <!-- Load USB for Code -->
                <div id="loadUSBforCode" class="modal fade" role="dialog">
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
                                <button type="button" id="usbinsert" class="btn btn-default" data-toggle="modal" onclick="refreshzipfilelist()" data-dismiss="modal">OK</button>
                                <!--<button type="button" class="btn btn-default" onclick="redirect2importDB('<?php echo base_url().'importdb'; ?>')" data-dismiss="modal">OK</button>-->
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- Load Code Modal -->
                <div id="loadCodeFile" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Load Code</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="height: 33vh;">
                                <p>Please select Code File and click [Load Code] button.</p>
                                <?php    
                                    if (!file_exists($this->config->item('usb_path'))) {
                                        echo '<p><strong>Loading from backup path '.$this->config->item('back_usb_path').'</strong>.</p>';
                                        $flist = glob($this->config->item('back_usb_path').'*'.$this->config->item('zip_ext'));
                                    } 
                                    else {
                                        $flist = glob($this->config->item('usb_path').'*'.$this->config->item('zip_ext'));
                                    }
                                ?>
                                <div class="radio" style="display: block">
                                    <?php foreach($flist as $fileitem): ?>
                                        <label><input type="radio" style="display: inline" name="codefile" value="<?php echo $fileitem ?>"          
                                                      /> <?php echo basename($fileitem) ?>
                                        </label><br>
                                    <?php endforeach; ?>
                                    <!--<label><input type="radio" style="display: inline" name="dbfile" value="female"> Female</label><br>
                                    <label><input type="radio" style="display: inline" name="dbfile" value="other"> Other</label>-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" onclick="redirect2loadcode('<?php echo base_url().'loadcode'; ?>')">Load Code</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export Data Modal -->
                <div id="exportData" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Export Data</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Please insert USB stick and hit OK button.</p>
                            </div>
                            <div class="modal-footer">
                                <?php foreach($active_surveys_ex as $survey): ?>
                                    <button type="button" class="btn btn-default" onclick="redirect2exportData('<?php echo base_url().$this->config->item('export_url').'/'.$survey->slug; ?>',
                                    '<?php echo base_url().$this->config->item('disp_export_url'); ?>')" data-dismiss="modal">OK</button>
                                <?php endforeach; ?>
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
    



<div class="container imageloc" id="intropage">
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
                    MAINTENANCE PAGE<br>
                </strong>
                Proceed with extreme caution.<br>
                <?php echo $ipaddress; ?>
            </div>
            <div id="theloaddbbuttons">
                <!--800x480 = 3vw 1280x800 = 5vw -->
                <div class="row">
                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#loadUSB" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-database"></div>
                        <div class="settingstext">Load DB</div></button>
                    </div>
                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#loadUSBforCode" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-file-archive"></div>
                        <div class="settingstext">Stage Code</div></button>
                    </div>
                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" onclick="refreshcodefolderlist()" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fab fa-php"></div>
                        <div class="settingstext">Select Code</div></button>
                    </div>
                    <div class="col-md-2"><br>
                    <?php if(($active_surveys_ex != "") && ($active_surveys_ex != null)): ?>
                        <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#exportData" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                            <div class="fas fa-file-excel"></div>
                            <div class="settingstext">Export</div></button>
                    <?php endif; ?>
                    </div>

                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" onclick="rebootsystem('<?php echo base_url().'importdb'; ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-power-off"></div>
                        <div class="settingstext">Reboot</div></button>
                    </div>

                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" onclick="redirectOnClick('<?php echo base_url(); ?>')" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-sign-out-alt"></div>
                        <div class="settingstext">Return</div></button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2" id ="refvolbut"><br>
                    <button type="button" class="btn btn-lg btn-default" onclick="refreshvolume()" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-volume-up"></div>
                        <div class="settingstext">Volume Adjust</div></button>
                    </div>
                    <div class="col-md-2" id ="wificonn"><br>
                    <button type="button" class="btn btn-lg btn-default" onclick="refreshwifilist()" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-wifi"></div>
                        <div class="settingstext">Connect WiFi</div></button>
                    </div>
                    <div class="col-md-2" id ="refreshpage"><br>
                    <button type="button" class="btn btn-lg btn-default" onclick="refreshpage()" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-sync-alt"></div>
                        <div class="settingstext">Refresh Page</div></button>
                    </div>
                    <!-- This is for auto-downloading-->
                    <a id="target" style="display: none"></a>
<!--                    <div class="col-md-2"><br>
                    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" onclick="refreshcodefolderlist()" style="height:100%;width:100%;font-size:<?php echo $this->config->item('begin_button_fit'); ?>;border-radius: 3vh;">
                        <div class="fas fa-sun"></div>
                        <div class="settingstext">Brightness</div></button>
                    </div>-->
                </div>
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
<!--                                <p>Please select Database File and click [Load Database] button.</p>
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
                                    <label><input type="radio" style="display: inline" name="dbfile" value="female"> Female</label><br>
                                    <label><input type="radio" style="display: inline" name="dbfile" value="other"> Other</label>
                                </div>-->
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
                                <h4 class="modal-title">Stage Code</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="height: 33vh;">
                                <p>Please select Code File and click [Stage Code] button.</p>
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
                                <button type="button" class="btn btn-default" onclick="redirect2stagecode('<?php echo base_url().'loadcode'; ?>')">Stage Code</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Load WiFi List -->
                <div id="loadwifilist" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Connect WiFi</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="height: 33vh;">
                                <p>Please select a WiFi SSID and click [Connect] button.</p>
                                <div class="radio" style="display: block">
                                    <?php foreach($flist as $fileitem): ?>
                                        <label><input type="radio" style="display: inline" name="codefile" value="<?php echo $fileitem ?>"          
                                                      /> <?php echo basename($fileitem) ?>
                                        </label><br>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loadwifipass">Connect</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Load WiFi Password -->
                <div id="loadwifipass" class="modal modal-wide fade" role="dialog">
                    <div class="modal-dialog" style="width: 1000px;">
                        <!-- Modal content-->
                        <div class="modal-content" style="width: 1000px; margin-left: -250px;">
                            <div class="modal-header">
                                <h4 class="modal-title">Connect WiFi</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <!--Please input WiFi password and click [OK] button.-->
                                <br>
                                <div class="col-md-12 hmarginauto cellentrytext" style="margin-left: auto; margin-right: auto;">
                                    
                                    <input class="cellentrytext" name="wifipasswd" type="text" placeholder="WiFi Password">
                                <br>
                                </div>
                                <div id="virtualKeyboard"></div>
                                <div class="col-md-12 hmarginauto cellentrytext" style="margin-left: auto; margin-right: auto;">
                                <br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="enterwifipass" class="btn btn-default" style="display: none;" onclick="redirect2tryconnwifi('<?php echo base_url().'tryconnectwifi'; ?>')">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Load Code List -->
                <div id="loadCodeList" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Load Code</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="height: 33vh;">
                                <div class="radio" style="display: block">
                                        <label><input type="radio" style="display: inline" name="codefolder" value="checkpost"/>
                                        </label><br>
                                    <!--<label><input type="radio" style="display: inline" name="dbfile" value="female"> Female</label><br>
                                    <label><input type="radio" style="display: inline" name="dbfile" value="other"> Other</label>-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" onclick="redirect2loadcode('<?php echo base_url().'selectthecode'; ?>')">Load Code</button>
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
                                    <button type="button" class="btn btn-default" onclick="redirect2exportData('<?php echo base_url().$this->config->item('export_url').'/'.$survey->slug; ?>')" data-dismiss="modal">OK</button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Adjust Volume -->
                <div id="adjustVolume" class="modal fade" role="dialog" style="display: none;">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Volume Control</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
<!--                                <audio control id="popsoundonvol">
                                    <source src="<?php echo $this->config->item('pop_path'); ?>" type="audio/mpeg">
                                </audio>-->
<!--                                <div><br></div>
                                <div>
                                    <input type="range" id="volid" min="0" max="100" data-rangeslider>
                                    <output></output>
                                </div>-->
                                <audio control id="popsoundonvol">
                                    <source src="<?php echo base_url().$this->config->item('pop_path'); ?>" type="audio/mpeg">
                                </audio>
                                <div><br></div>
                                <div id="voldiv">
                                    <input type="range" id="volid" style="width:100%;" min="0" max="100" value="<?php echo $soundlevel; ?>" data-rangeslider>
                                    <output id="voltxtid"></output>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!--<button type="button" id="usbinsert" class="btn btn-default" data-toggle="modal" onclick="refreshzipfilelist()" data-dismiss="modal">OK</button>-->
                                <!--<button type="button" class="btn btn-default" onclick="redirect2importDB('<?php echo base_url().'importdb'; ?>')" data-dismiss="modal">OK</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="introtext" id="theloadertext" style="text-align: center; display: none;"><p>Please wait...<br></p></div>
            <div class="loader" id="theloader" style="display: none"></div>
            <?php endif; ?>
        </div>
    </div>
</div>
    



        <footer style="background:transparent !important; padding: 10px;">
            <div class="container footer-text" id="thefooter" style="display: none; vertical-align: middle;">
                <p class="text-muted">
                <div class="div-left" style="display: inline-block;">&copy; 2018 <?php echo $this->config->item('company_name'); ?> All rights reserved. 
                <!--<?php if($active_surveys != ""): ?>
                  <?php foreach($active_surveys as $survey): ?>
                    <?php echo getFooterContent($survey->slug); ?>
                  <?php endforeach; ?>
                <?php endif; ?>-->
                </div>
                <!-- Trigger the modal with a button -->
                
                <div class="form-group" style="display: none;">
                    <label for="password">Pin code</label>
                    <input type="password" class="form-control" id="password" placeholder="Pin code">
                </div>
                
                <div class="div-right footer-text" style="display: inline-block;">Follow Us
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-google"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    [CDV <?php echo $this->config->item('code_ver').'_'.$this->config->item('dbver'); ?>]
                    <?php if(($active_surveys != "") && ($active_surveys != null)): ?>
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">E</button>-->
                    <!--<button type="button" class="btn btn-info btn-sm btn-danger" data-toggle="modal" data-target="#inputpin" data-dismiss="modal">M</button>-->
                    <button type="button" id="pinconfirm" class="btn btn-info btn-sm btn-danger" onclick="inputPinCode()" data-dismiss="modal">M</button>
                    
                    <!--<button type="button" class="btn btn-info btn-sm btn-danger" onclick="redirectOnClick('<?php echo base_url().$this->config->item('loaddb_url').'/'; ?>')" >M</button>-->
                    <?php endif; ?>
                    
                    
                    
                    
            <!--<strong>Posted by: <?php echo $this->config->item('posted_by'); ?> Contact information: <a href="mailto:<?php echo $this->config->item('posted_email'); ?>"><?php echo $this->config->item('posted_email'); ?></a>.</strong>-->
                </div>
            </div>
            
<!--             Input Pin 
            <div id="inputpin" class="modal fade" role="dialog">
                <div class="modal-dialog">
                     Modal content
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Pin Code:</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
				<label for="password">Pin code</label>
				<input type="password" class="form-control" id="password" placeholder="Pin code">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php foreach($active_surveys as $survey): ?>
                                <button type="button" id="pinconfirm" class="btn btn-default" onclick="checkPinCode('<?php echo base_url().$this->config->item('loaddb_url').'/'; ?>')" data-dismiss="modal">OK</button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
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
                            <?php foreach($active_surveys as $survey): ?>
                                <button type="button" class="btn btn-default" onclick="redirect2exportData('<?php echo base_url().$this->config->item('export_url').'/'.$survey->slug; ?>',
                                '<?php echo base_url().$this->config->item('disp_export_url'); ?>')" data-dismiss="modal">OK</button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('jQuery_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('bootstrap_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('jqnumpad_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('screensaver_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('rating_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('slider_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('survey_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('maint_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('numpad_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('jskeyboard_js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().$this->config->item('main_js'); ?>"></script>
        
    </body>
</html>
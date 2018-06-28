<div class="col-md-12">    
    <h2 class="introtext" style="text-align: center"><br>
    <?php echo urldecode($export_result) ?><br>
    </h2>
    <?php header("Refresh: 4; url=".base_url().$this->config->item('loaddb_url').'/'); ?>
</div>
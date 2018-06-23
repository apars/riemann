<div class="col-md-12">
  <audio autoplay>
    <source src="data:audio/mpeg;base64,<?php echo base64_encode($thanks_audio); ?>" type="audio/mpeg">
  </audio>
  <h2 class="introtext" style="text-align: center"><br>All Done! <br><br>
    Thank you for completing the survey.<br><br>
  </h2>
  <?php header("Refresh: 2; url=".base_url()); ?>
</div>

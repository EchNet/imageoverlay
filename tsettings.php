<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<?php 
  $template_name = substr($_SERVER["PATH_INFO"], 1);
?>
<head>
  <title>Image Overlay - Template Settings</title>
  <link rel='stylesheet' id='bootstrap-css'  href='https://diuineuubyags.cloudfront.net/wp-content/themes/leadengine/core/assets/css/bootstrap.min.css?ver=5.3.2' type='text/css' media='all' />
  <link rel='stylesheet' href='../css/imageoverlay.css' type='text/css' media='all' />
</head>
<body>
  <div class="content">
    <h2><i>Image Overlay</i> - <a href="..">Templates</a> - <?php echo $template_name ?></h2>
    <div class="imageContainer">
      <img class="preview" src="../script3.php?image=<?php echo $template_name ?>.jpg" />
    </div>
    <form method="POST">
      <div class="formField">
        <label>Font Color:</label>
        <input id="simple-color-picker" type="text" name="fontcolor1" value="000000" size="50" class="jscolor wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true"   aria-invalid="false" placeholder="Font Color"/>
      </div>
      <div class="formField">
        <label>Font Size (8-100):</label>
        <input type="number" name="fontsize1" value="40" size="50" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" placeholder="Font Size (8-100)" min="8" max="100"/>
      </div>
      <div class="formField">
        <label>Left Margin:</label>
        <input type="number" name="xmargin1" value="120" size="50" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true"   aria-invalid="false" placeholder="Left Margin"/>
      </div>
      <div class="formField">
        <label>Top Margin:</label>
        <input type="number" name="ymargin1" value="350" size="50" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" placeholder="Top Margin"/>
      </div>
      <div style="formField">
        <button id="submit_btn" type="submit" class="wpcf7-form-control wpcf7-submit" name="submit">Save</button>
      </div>
    </form>
  </div>
</body>
<script src="js/jscolor.js"></script>
<script src="js/imageoverlay.js"></script>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <title>Image Overlay - Control Panel</title>
  <link rel='stylesheet' id='bootstrap-css'  href='https://diuineuubyags.cloudfront.net/wp-content/themes/leadengine/core/assets/css/bootstrap.min.css?ver=5.3.2' type='text/css' media='all' />
  <link rel='stylesheet' href='css/imageoverlay.css' type='text/css' media='all' />
</head>
<body>
  <div class="content">
    <h2><i>Image Overlay</i> / Template Manager</h2>
    <div class="prompt">Select from available templates</div>
    <div>
      <select class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
          onchange="handleImageSelection(event)">
        <option value="">--- Select ---</option>
        <?php
          $files = glob("images/*.jpg");
          foreach ($files as $file) {
            $len = strlen($file);
            $value = substr($file, 7, $len - 7 - 4);
            echo "<option value='" . $value . "'>" . $value . "</option>";
          }
        ?>
      </select>
      <button id="editTemplateSettings" disabled="disabled">Edit Template Settings</button>
    </div>
    <div class="imageContainer">
      <img class="preview" src="" style="visibility: hidden"/>
    </div>
    <hr/>
    <div class="prompt">
      Upload a new template image
    </div>
    <div>
      <form>
        <input type="file" accept="image/jpeg"/>
      </form>
    </div>
  </div>
</body>
<script src="js/jscolor.js"></script>
<script src="js/imageoverlay.js"></script>
</html>

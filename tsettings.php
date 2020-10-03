<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<?php 
  include "settings/_default.php";

  # URI is path/to/script.php/template_name
  $template_name = substr($_SERVER["PATH_INFO"], 1);

  # Settings for the identified template are expressed in a PHP settings file.
  $settings_file_path = "settings/" . $template_name . ".php";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    # Write POSTed parameters to PHP settings file.
    $settings_file_data = array("<?php\n");

    # Margin fields are singleton.
    $marginfields = array("margin_left", "margin_right", "margin_top", "margin_bottom");
    foreach ($marginfields as $f) {
      if (isset($_POST[$f]) && $_POST[$f] !== "") {
        $value = $_POST[$f];
        array_push($settings_file_data, "\$$f = \"$value\";\n");
      }
    }

    # One set of text fields for each text area.
    for ($t = 1; $t <= $ntext; $t++) {
      $textfields = array("xalign", "yalign", "fontface", "fontsize", "fontcolor");
      foreach ($textfields as $f) {
        if (isset($_POST["$f$t"]) && $_POST["$f$t"] !== "") {
          $value = $_POST["$f$t"];
          array_push($settings_file_data, "\$$f$t = \"$value\";\n");
        }
      }
    }

    array_push($settings_file_data, "?>\n");

    if (file_put_contents($settings_file_path, $settings_file_data) === false) {
      echo("File write operation failed");
    }
  }

  # Load PHP settings files: default and specific.
  if (file_exists($settings_file_path)) {
    include $settings_file_path;
  }
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
      <div class="flexwrap">
        <div class="formField">
          <label>Left Margin:</label>
          <input type="number" name="margin_left" value="<?php echo $margin_left ?>" size="20" class="form-control" placeholder="Left Margin"/>
        </div>
        <div class="formField">
          <label>Right Margin:</label>
          <input type="number" name="margin_right" value="<?php echo $margin_right ?>" size="20" class="form-control" placeholder="Right Margin"/>
        </div>
        <div class="formField">
          <label>Top Margin:</label>
          <input type="number" name="margin_top" value="<?php echo $margin_top ?>" size="20" class="form-control" placeholder="Top Margin"/>
        </div>
        <div class="formField">
          <label>Bottom Margin:</label>
          <input type="number" name="margin_bottom" value="<?php echo $margin_bottom ?>" size="20" class="form-control" placeholder="Bottom Margin"/>
        </div>
      </div>
      <?php
        for ($t = 1; $t <= $ntext; $t++) {
          echo '<h4>Text Area #' . $t . '</h4>';
          echo '<div class="flexwrap">';
          $fieldname = "fontface" . $t;
          echo '<div class="formField">';
          echo '<label>Font Face:</label>';
          echo '<input type="text" name="fontface' . $t . '" value="' . $$fieldname . '" size="20" class="form-control" placeholder="Font Face"/>';
          echo '</div>';
          $fieldname = "fontcolor" . $t;
          echo '<div class="formField">';
          echo '<label>Text Color:</label>';
          echo '<input type="text" name="fontcolor' . $t . '" value="' . $$fieldname . '" size="20" class="jscolor form-control" placeholder="Text Color"/>';
          echo '</div>';
          $fieldname = "fontsize" . $t;
          echo '<div class="formField">';
          echo '<label>Font Size:</label>';
          echo '<input type="number" name="fontsize' . $t . '" value="' . $$fieldname . '" size="20" class="form-control" min="8" max="100"/>';
          echo '</div>';
          echo '</div>';
          echo '<div class="flexwrap">';
          $fieldname = "xalign" . $t;
          echo '<div class="formField">';
          echo '<label>Horizontal Alignment:</label>';
          echo '<input type="text" name="xalign' . $t . '" value="' . $$fieldname . '" size="20" class="form-control" placeholder="left, center, or right"/>';
          echo '</div>';
          $fieldname = "yalign" . $t;
          echo '<div class="formField">';
          echo '<label>Vertical Alignment:</label>';
          echo '<input type="text" name="yalign' . $t . '" value="' . $$fieldname . '" size="20" class="form-control" placeholder="top, center, or bottom"/>';
          echo '</div>';
          echo '</div>';
        }
      ?>
      <div class="flexwrap">
        <button id="submit_btn" type="submit" class="wpcf7-form-control wpcf7-submit" name="submit">Save</button>
      </div>
    </form>
  </div>
</body>
<script src="../js/jscolor.js"></script>
</html>

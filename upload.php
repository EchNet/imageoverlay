<!DOCTYPE HTML>
<html>
<head>
<?php
  // Get parameters.
  $extension = ".jpg";
  $target_fname = basename($_FILES["file"]["name"]);
  $template_name = basename($target_fname, $extension);
  $target_path = "images/" . $target_fname;
  $temp_path = $_FILES["file"]["tmp_name"];

  // Validate.
  $success = false;
  $error_message = "";
  if (!$temp_path) {
    $error_message = "The file may be too large or the file system is full.";
  }
  else if (substr($target_fname, -4) !== $extension) {
    $error_message = "File name extension must be " . $extension . " (case sensitive).";
  }
  else if (getimagesize($temp_path) === false) {
    $error_message = "That file is not an image.";
  }
  else if (!move_uploaded_file($temp_path, $target_path)) {
    // File operation failed.
  }
  else {
    echo '<meta http-equiv="refresh" content="0; url=templatemanager.php?open=' . $template_name . '"/>';
    $success = true;
  }
?>
</head>
<body>
<?php
  if ($error_message) {
    echo '<h3>File Upload Failed</h3>';
    echo '<div>' . $error_message . '</div>';
  }
  if (!$success) {
    echo '<div>&nbsp;</div>';
    echo '<div><a href="templatemanager.php">Back to Template Manager<a></div>';
  }
?>
</body>
</html>

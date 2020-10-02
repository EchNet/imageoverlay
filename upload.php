<!DOCTYPE HTML>
<html>
<head>
<?php
  $target_fname = basename($_FILES["file"]["name"]);
  $target_path = "images/" . $target_fname;
  $temp_path = $_FILES["file"]["tmp_name"];

  $success = false;
  $error_message = "";
  if (substr($target_fname, -4) !== ".jpg") {
    $error_message = "File name extension must be .jpg (case sensitive).";
  }
  else if (getimagesize($temp_path) === false) {
    $error_message = "That file is not an image.";
  }
  else if (file_exists($target_path)) {
    $error_message = "File already exists.";
  }
  else if (!move_uploaded_file($temp_path, $target_path)) {
  }
  else {
    echo '<meta http-equiv="refresh" content="0; url=templatemanager.php"/>';
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

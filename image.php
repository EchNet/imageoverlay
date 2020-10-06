<?php
error_reporting(E_ERROR | E_PARSE);
extract($_REQUEST);

$SETTINGS_DIR = "./settings/";
$IMAGES_DIR = "./images/";
$FONTS_DIR = "./fonts/";

# make sure the GD library is installed
if (!extension_loaded('gd') || !function_exists('gd_info')) {
   echo 'You do not have the GD Library installed.
   This script requires the GD library to function properly.
   visit http://us2.php.net/manual/en/ref.image.php for more information';
   exit;
}

# URI is path/to/image.php/template_name
$template_name = substr($_SERVER["PATH_INFO"], 1);

# Settings for the identified template are expressed in a PHP settings file.
$settings_file_path = $SETTINGS_DIR . $template_name . ".php";

# Load PHP settings files.
include $SETTINGS_DIR . "_default.php";
if (file_exists($settings_file_path)) {
  include $settings_file_path;
}
$margin_left = intval($margin_left);
$margin_right = intval($margin_right);
$margin_top = intval($margin_top);
$margin_bottom = intval($margin_bottom);

# Base image is found in the images folder.
$base_image_path = $IMAGES_DIR . $template_name . ".jpg";

# Load the base image.
list($image_width, $image_height, $image_type) = getimagesize($base_image_path);
switch($image_type) {
  case "1": # GIF
    $image_p = imagecreatefromgif($base_image_path);
    break;
  case "2": # JPG
    $image_p = imagecreatefromjpeg($base_image_path);
    break;
  case "3": # PNG
    $image_p = imagecreatefrompng($base_image_path);
    break;
  default:
    errorIMG("Bad image type");
}

for ($N = 1; $N <= $ntext; $N++) {
  $text = isset($_GET["t$N"]) ? $_GET["t$N"] : "";
  $fontface = ${"fontface$N"};
  $fontcolor = ${"fontcolor$N"};
  $fontsize = intval(${"fontsize$N"});
  $xalign = ${"xalign$N"};
  $yalign = ${"yalign$N"};

  # Fix white space in text.
  $text = preg_replace("/\r/", "", $text);
  if (!$text || !$fontface || !$fontsize) {
    continue;
  }

  # Validate font color, derive supporting colors.
  if (!preg_match('#[a-z0-9]{6}#i', $fontcolor)) $fontcolor = 'FFFFFF';  # default white
  $fcint = hexdec("#$fontcolor");
  $fcarr = array("red" => 0xFF & ($fcint >> 0x10),"green" => 0xFF & ($fcint >> 0x8),"blue" => 0xFF & $fcint);
  $fsarr = array("red" => 0xFF & ($fsint >> 0x10),"green" => 0xFF & ($fsint >> 0x8),"blue" => 0xFF & $fsint);
  $fcolor  = imagecolorallocate($image_p, $fcarr["red"], $fcarr["green"], $fcarr["blue"]);
  $fscolor = imagecolorallocate($image_p, $fsarr["red"], $fsarr["green"], $fsarr["blue"]);

  # Analyze font face.
  $font = $FONTS_DIR . $fontface . ".ttf";
  if (!file_exists($font)) {
    errorIMG("font " . $font . " not found");
  }
  $_b = imageTTFBbox($fontsize, 0, $font, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
  $fontheight = abs($_b[7] - $_b[1]);
  $_b = imageTTFBbox($fontsize, 0, $font, $text);
  $stringwidth = abs($_b[2] - $_b[0]);

  # Find start position.
  if ($xalign == "left") {
    $x = $margin_left;
  }
  else if ($xalign == "right") {
    $x = $image_width - $stringwidth - $margin_right;
  }
  else {
    $x = $margin_left + ($image_width - $stringwidth - $margin_left - $margin_right) / 2;
  }
  if ($yalign == "top") {
    $y = $margin_top;
  }
  else if ($yalign == "bottom") {
    $y = $image_height - $fontheight - $margin_bottom;
  }
  else {
    $y = $margin_top + ($image_height - $fontheight - $margin_top - $margin_bottom) / 2;
  }
  $y += $fontsize; # fudge adjustment for truetype margin

  # Render slight SE shadow to stand out.
  imagettftext($image_p, $fontsize, 0, $x + 1, $y, $fscolor, $font, $text);
  imagettftext($image_p, $fontsize, 0, $x, $y - 1, $fcolor, $font, $text);
}

# Respond with a JPEG file, regardless of the base image format.
$jpegcompress = 75; # (range of 50 - 95 recommended)
header("Content-type: image/jpeg");
imagejpeg($image_p, NULL, $jpegcompress);
imagedestroy($im);
exit;

/*
 Write error into an image.
*/
function errorIMG($error) {
 $im  = imagecreate (480, 240);
 $bgc = imagecolorallocate ($im, 255, 255, 255);
 $tc  = imagecolorallocate ($im, 0, 0, 0);
 imagefilledrectangle ($im, 0, 0, $image_width, $image_height, $bgc);
 imagestring ($im, 5, 5, 5, "Error: $error", $tc);
 header('Content-type: image/gif');
 imagegif($im);
 imagedestroy($im);
 exit;
}
?>

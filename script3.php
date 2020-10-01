<?php
//error_reporting(E_ALL); // Report all errors and warnings (very strict, use for testing only)
//ini_set('display_errors', 1); // turn error reporting on
extract($_REQUEST);

# make sure the GD library is installed
if (!extension_loaded('gd') || !function_exists('gd_info')) {
   echo 'You do not have the GD Library installed.
   This script requires the GD library to function properly.
   visit http://us2.php.net/manual/en/ref.image.php for more information';
   exit;
}

# Which image are we overlaying?  This version of the script does not support download of 
# the base image.  It must be one of those that appears in the images subfolder.
$baseImageName = "Honda.jpg";
if (isset($_GET["image"])) $baseImageName = $_GET["image"];
$baseImagePath = './images/' . $baseImageName;

# What is the overlay text?
$text1 = '';
$text2 = '';
$text3 = '';
if (isset($_GET["text1"])) $text1 = $_GET["text1"];
if (isset($_GET["text2"])) $text2 = $_GET["text2"];
if (isset($_GET["text3"])) $text3 = $_GET["text3"];

# Text alignment
$textalign1 = 'upperleft';
$textalign2 = 'lowerleft';
$textalign3 = 'centerbottom';
# your textalign options are ...
# upperright upperleft lowerleft lowerright center centertop centerbottom
$xmargin1 = 120; # side margin in pixels
if (isset($_GET["xmargin1"])) $xmargin1 = $_GET["xmargin1"];
$xmargin2 = 5; # side margin in pixels
$xmargin3 = 5; # side margin in pixels

$ymargin1 = 350; # top or bottom margin in pixels
if (isset($_GET["ymargin1"])) $ymargin1 = $_GET["ymargin1"];
$ymargin2 = 5; # top or bottom margin in pixels
$ymargin3 = 5; # top or bottom margin in pixels

# Font style
$fontstyle1 = 5; # There are 5 built in GD fonts: 1 2 3 4 5 ONLY!
$fontstyle2 = 5; # There are 5 built in GD fonts: 1 2 3 4 5 ONLY!
$fontstyle3 = 5; # There are 5 built in GD fonts: 1 2 3 4 5 ONLY!

# Font color in Hex
$fontcolor1 = '000000'; # FFFFFF white
if (isset($_GET["fontcolor1"])) $fontcolor1 = $_GET["fontcolor1"];
$fontcolor2 = '000000'; # FFFFFF white
$fontcolor3 = 'FFFFFF'; # FFFFFF white

# Font drop shadow color in Hex
$fontshadowcolor1 = '808080'; # 808080 grey
$fontshadowcolor2 = '808080'; # 808080 grey
$fontshadowcolor3 = '808080'; # 808080 grey

# Override built in (Font style) fonts with a True Type Font
# Any .ttf font file is supported, file must appear in the script directory.
$ttfont1 = 'arial.ttf';
$ttfont2 = '';
$ttfont3 = '';

# Font size.
$fontsize1 = 40; # size for text1
if (isset($_GET["fontsize1"])) $fontsize1 = $_GET["fontsize1"];
$fontsize2 = 13; # size for True Type Font2 only (8-18 recommended)
$fontsize3 = 13; # size for True Type Font3 only (8-18 recommended)

# Load the base image.
list($imageWidth, $imageHeight, $type) = getimagesize($baseImagePath);
switch($type) {
  case "1": # GIF
    $im = imagecreatefromgif($baseImagePath);
    break;
  case "2": # JPG
    $im = imagecreatefromjpeg($baseImagePath);
    break;
  case "3": # PNG
    $im = imagecreatefrompng($baseImagePath);
    break;
  default:
    errorIMG('007');
}

$text1 != '' and textoverlay(1, $im, $imageWidth, $imageHeight);
$text2 != '' and textoverlay(2, $im, $imageWidth, $imageHeight);
$text3 != '' and textoverlay(3, $im, $imageWidth, $imageHeight);

# Respond with a JPEG file, regardless of the base image format.
$jpegcompress = 75; # (range of 50 - 95 recommended)
header('Content-type: image/jpeg');
imagejpeg($im, NULL, $jpegcompress);
imagedestroy($im);
exit;

############# Begin Functions #################

function textoverlay($textoption, $image_p, $imageWidth, $imageHeight) {
    global $text1, $ttfont1, $fontsize1, $fontcolor1, $fontshadowcolor1, $fontstyle1, $textalign1, $xmargin1, $ymargin1;
    global $text2, $ttfont2, $fontsize2, $fontcolor2, $fontshadowcolor2, $fontstyle2, $textalign2, $xmargin2, $ymargin2;
    global $text3, $ttfont3, $fontsize3, $fontcolor3, $fontshadowcolor3, $fontstyle3, $textalign3, $xmargin3, $ymargin3;
    if ($textoption == 1) {
      $text = $text1; $ttfont = $ttfont1; $fontsize = $fontsize1; $fontstyle = $fontstyle1;
      $fontcolor = $fontcolor1; $fontshadowcolor = $fontshadowcolor1;
      $textalign = $textalign1; $xmargin = $xmargin1; $ymargin = $ymargin1;
    }
    if ($textoption == 2) {
      $text = $text2; $ttfont = $ttfont2; $fontsize = $fontsize2; $fontstyle = $fontstyle2;
      $fontcolor = $fontcolor2; $fontshadowcolor = $fontshadowcolor2;
      $textalign = $textalign2; $xmargin = $xmargin2; $ymargin = $ymargin2;
    }
    if ($textoption == 3) {
      $text = $text3; $ttfont = $ttfont3; $fontsize = $fontsize3; $fontstyle = $fontstyle3;
      $fontcolor = $fontcolor3; $fontshadowcolor = $fontshadowcolor3;
      $textalign = $textalign3; $xmargin = $xmargin3; $ymargin = $ymargin3;
    }
    if (!preg_match('#[a-z0-9]{6}#i', $fontcolor)) $fontcolor = 'FFFFFF';  # default white
    if (!preg_match('#[a-z0-9]{6}#i', $fontshadowcolor)) $fontshadowcolor = '808080'; # default grey
    $fcint = hexdec("#$fontcolor");
    $fsint = hexdec("#$fontshadowcolor");
    $fcarr = array("red" => 0xFF & ($fcint >> 0x10),"green" => 0xFF & ($fcint >> 0x8),"blue" => 0xFF & $fcint);
    $fsarr = array("red" => 0xFF & ($fsint >> 0x10),"green" => 0xFF & ($fsint >> 0x8),"blue" => 0xFF & $fsint);
    $fcolor  = imagecolorallocate($image_p, $fcarr["red"], $fcarr["green"], $fcarr["blue"]);
    $fscolor = imagecolorallocate($image_p, $fsarr["red"], $fsarr["green"], $fsarr["blue"]);
    if ($ttfont != '') {
       # using ttf fonts
       $_b = imageTTFBbox($fontsize,0,$ttfont,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
       $fontheight = abs($_b[7]-$_b[1]);
    } else {
      $font = $fontstyle;
      # using built in fonts, find alignment
      if($font < 0 || $font > 5){ $font = 1; }
          $fontwidth = ImageFontWidth($font);
          $fontheight = ImageFontHeight($font);
      }
      $text = preg_replace("/\r/",'',$text);
      # wordwrap line if too many characters on one line
      if ($ttfont != '') {
         # array lines
         $lines = explode("\n", $text);
         $lines = ttf_wordwrap($lines,$ttfont,$fontsize,floor($imageWidth - ($xmargin * 2)));
      } else {
        $maxcharsperline = floor(($imageWidth - ($xmargin * 2)) / $fontwidth);
        $text = wordwrap($text, $maxcharsperline, "\n", 1);
        # array lines
        $lines = explode("\n", $text);
      }
      # determine alignment
      $align = 'ul'; # default upper left
      if ($textalign == 'lowerleft')    $align = 'll';
      if ($textalign == 'upperleft')    $align = 'ul';
      if ($textalign == 'lowerright')   $align = 'lr';
      if ($textalign == 'upperright')   $align = 'ur';
      if ($textalign == 'center')       $align = 'c';
      if ($textalign == 'centertop')    $align = 'ct';
      if ($textalign == 'centerbottom') $align = 'cb';
      # find start position for each text position type
      if ($align == 'ul') { $x = $xmargin; $y = $ymargin;}
      if ($align == 'll') { $x = $xmargin;
         $y = $imageHeight - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'ur') $y = $ymargin;
      if ($align == 'lr') { $x = $xmargin;
         $y = $imageHeight - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'ct') $y = $ymargin;
      if ($align == 'cb') { $x = $xmargin;
         $y = $imageHeight - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'c') $y = ($imageHeight/2) - ((count($lines) * $fontheight)/2);
      if ($ttfont != '') $y +=$fontsize; # fudge adjustment for truetype margin
         while (list($numl, $line) = each($lines)) {
             # adjust position for each text position type
             if ($ttfont != '') {
                $_b = imageTTFBbox($fontsize,0,$ttfont,$line);
                $stringwidth = abs($_b[2]-$_b[0]);
             }else{
                $stringwidth = strlen($line) * $fontwidth;
             }
             if ($align == 'ur'||$align == 'lr') $x = ($imageWidth - ($stringwidth) - $xmargin);
             if ($align == 'ct'||$align == 'cb'||$align == 'c') $x = $imageWidth/2 - $stringwidth/2;
             if ($ttfont != '') {
                # write truetype font text with slight SE shadow to standout
                imagettftext($image_p, $fontsize, 0, $xmargin1-1, $ymargin1, $fscolor, $ttfont, $line);
                imagettftext($image_p, $fontsize, 0, $xmargin1, $ymargin1-1, $fcolor, $ttfont, $line);
             }else{
                # write text with slight SE shadow to standout
                imagestring($image_p,$font,$x-1,$y,$line,$fscolor);
                imagestring($image_p,$font,$x,$y-1,$line,$fcolor);
             }
             # adjust position for each text position type
             if ($align == 'ul'||$align == 'ur'||$align == 'ct'||$align == 'c') $y += $fontheight;
             if ($align == 'll'||$align == 'lr'||$align == 'cb') $y -= $fontheight;
         } # end while
} // end textoverlay function

function ttf_wordwrap($srcLines,$font,$textSize,$width) {
    $dstLines = Array(); // The destination lines array.
    foreach ($srcLines as $currentL) {
        $line = '';
        $words = explode(" ", $currentL); //Split line into words.
        foreach ($words as $word) {
            $dimensions = imagettfbbox($textSize, 0, $font, $line.' '.$word);
            $lineWidth = $dimensions[4] - $dimensions[0]; // get the length of this line, if the word is to be included
            if ($lineWidth > $width && !empty($line) ) { // check if it is too big if the word was added, if so, then move on.
                $dstLines[] = trim($line); //Add the line like it was without spaces.
                $line = '';
            }
            $line .= $word.' ';
        }
        $dstLines[] =  trim($line); //Add the line when the line ends.
    }
    return $dstLines;
} // end of ttf_wordwrap function

/*
 Write errors into an image.
 Error codes:
 Error 002: Base file type not gif, jpg, or png. This script only supports .jpg .gif and .png
 Error 003: Download error: cannot write to file, check server permission settings
 Error 004: Download error: reading or opening file
 Error 005: Error loading image
 Error 006: Missing downloaded temp file
 Error 008: Missing cache file
 Error 009: Missing downloaded file
 Error 010: Copy cache image failed
 Error 011: Convert_download: touch image last modified time failed
 Error 012: Chmod 0644 image failed
 Error 016: $outputimgName file type not gif, jpg, or png. This script only supports .jpg .gif and .png
 Error 018: fetching timestamp failed for URL (remote_image) 404 not found?
 Error 019: could not connect to remote image
*/
function errorIMG($error) {
 # shows error messages in an image output
 global $imageWidth, $imageHeight;
 $im  = imagecreate ($imageWidth, $imageHeight);
 $bgc = imagecolorallocate ($im, 255, 255, 255);
 $tc  = imagecolorallocate ($im, 0, 0, 0);
 imagefilledrectangle ($im, 0, 0, $imageWidth, $imageHeight, $bgc);
 imagestring ($im, 5, 5, 5, "Error: $error", $tc);
 header('Content-type: image/gif');
 imagegif($im);
 imagedestroy($im);
 exit;
} // end of errorIMG function
?>

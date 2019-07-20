<?php
include 'dir.php';
$fn=$get["fn"];

function liquid ( $image_path1 ) {
  $image_path2 = "../tmp/".$image_path1;
  global $newwidth, $newheight, $keywords;

    $maxwidth = 1000;
    $maxheight= 1000;
    $img = imagecreatefromjpeg( "../".$image_path1 );
    imagealphablending($img, true);

    $width = imagesx($img);
    $height = imagesy($img);
    if ($height > $width) {
      $ratio = $maxheight / $height;  
      $newheight = $height * $ratio;
      $newwidth = $width * $ratio; 
    }
    elseif ($height == $width) {
      $ratio = $maxheight / $height;  
      $newheight = $height * $ratio;
      $newwidth = $width * $ratio; 
    }
    else {
      $ratio = $maxwidth / $width;   
      $newwidth = $width * $ratio;
      $newheight = $height * $ratio;
    }

    if (!$img) $img=imagecreatetruecolor($newheight,$newwidth);
    $col = imagecolorallocate($img, 211, 211, 211);
    $txt = date("Y") . ' wjst.de/images';
    $newimg = imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($newimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    # imagestring($newimg, 2, ($newwidth/2)+250, ($newheight/2)+260, $txt, $col);
    imagejpeg($newimg, $image_path2, 80);
    imagedestroy($img);
}

liquid($fn);
$size = filesize("../tmp/".$fn);

ini_set('session.cache_limiter', '');
header("Content-type: image/jpeg");
header("Content-Length: " . $size);
header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header("Content-Type: application/octet-stream");
header("Content-Disposition: disposition-type=attachment; filename=\"$fn\"");
readfile("../tmp/".$fn);

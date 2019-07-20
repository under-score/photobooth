<?php
include 'dir.php';

function scd($dir) {
  $files = preg_grep('~\.(jpeg|jpg)$~', scandir($dir));
  $files2=[];
  foreach ($files as $file) {
    $files2[$file] = filemtime($dir .'/' . $file);
  }
  arsort($files2);
  $files = array_keys($files2);
  return ($files) ? $files[0] : false;
}

$dbf = getcwd();
$dbf = strrpos($dbf,"full")>0 ? "../../".$dir1 : (strrpos($dbf,"library")>0 ? "../".$dir1 : $dir1);
echo scd($dbf);
?>
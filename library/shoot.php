<?php
include "dir.php";
$fn = date("Ymd_His")."_D42_".mt_rand(10,99).".jpg";
$fp = '/Users/wjst/NextCloud/booth/Server/picture/'.$fn;

$cmd = "~/photobooth/binary/gphoto2 --capture-image-and-download --keep-raw --filename " . $fp;
$res = shell_exec($cmd);
sleep(4);

#file_put_contents('debug.log', print_r(get_defined_vars(),1));

if (strpos($res,"Error") === false && $res!="") {
  echo $fn;
}
else {
  http_response_code(400);
}
?>

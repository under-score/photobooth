<?php
include 'log.php';
include 'dir.php';
$fn = $dir2 . "../" . $dir1 . "/" . $post["fn"] . date('_dHi', time()) . ".jpg";
$baseFromJavascript = $post["pic"];
$base_to_php = explode(',', $baseFromJavascript);
$data = base64_decode($base_to_php[1]);
file_put_contents($fn,$data);
#file_put_contents( 'debug.log', print_r(get_defined_vars(),1) );
?>
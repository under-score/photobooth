<pre>
<?php
include 'dir.php';
$fn = $dir2 . "../".$get["fn"];
$cmd = "mdls " . $fn."|grep 'MDItemStarRating'|sed 's/kMDItemStarRating//'";
$out = shell_exec($cmd);
$rating = strpos($out,"1") ? 0 : 1;
$cmd = "/xattr -w kMDItemWhiteBalance 3 " . $fn;
$out = shell_exec($cmd);
sleep(2);
$cmd = "mdls " . $fn;
$out = shell_exec($cmd);
#file_put_contents( 'debug.log', print_r(get_defined_vars(),1) );
header('Location: ../index.php?dir='.$dir4);
?>
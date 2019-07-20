<?php
include 'dir.php';
$fn=$dir2 . "../" . $get["fn"];
rename($fn,$fn.".original");
header('Location: ../index.php?dir='.$dir4);
?>

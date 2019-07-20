<?php
date_default_timezone_set("Europe/Berlin");

foreach($_POST as $k => $v) {
  $post[$k] = is_array($_POST[$k]) ? filter_var_array($_POST[$k], FILTER_SANITIZE_STRING) : filter_var($_POST[$k], FILTER_SANITIZE_STRING);
}
foreach($_GET as $k => $v) {
  $get[$k] = is_array($_GET[$k]) ? filter_var_array($_GET[$k], FILTER_SANITIZE_STRING) : filter_var($_GET[$k], FILTER_SANITIZE_STRING);
}

# $backtrace = debug_backtrace();
# $call = dirname($backtrace[0]["file"]);

$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$dir0 = "picture/";
$dir1 = isset($get["dir"]) ? "picture/" . $get["dir"] . "/" : "picture/";
$dir2 = getcwd(). "/";
$dir3 = dirname($url) . "/";
$dir4 = rtrim(substr($dir3, strpos($dir3, "picture/") + 8), "/");
?>
<!DOCTYPE HTML>
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
<meta name="mobile-web-app-capable" content="yes">

<!---REMOTE CONTROL 
up=forward
dn=backward
b=shoots
f5=overview
--->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">

<style type="text/css">
html, body {
  position: relative;
  height: 100%;
  background: #000;
  font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
  font-size: 14px;
  color:#000;
  margin: 0;
  padding: 0;
}
.swiper-container {
  width: 100%;
  height: 100%;
}
.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #000;
}
.swiper-slide img {
  width: auto;
  height: auto;
  max-width: 100%;
  max-height: 100%;
  -ms-transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  position: absolute;
  left: 50%;
  top: 50%;
}    
.modal {
  display:none;
  position:fixed;
  z-index:9;
  left:0;
  top:0;
  width:100%;
  height:100%;
  overflow:auto;
  background-color: rgba(0,0,0,0.6);
}
.modal-content {
  font-size: 2em;
  background-color:white;
  margin-top:20%;
  margin-left:auto;
  margin-right:auto;
  padding:20px;
  border:1px solid #888;
  width:150px;
}
</style>

</head>

<body">

<div class="swiper-container">
    <div class="swiper-wrapper">

<?
#include '../log.php';
include '../dir.php';
$fn= isset($get["fn"]) ? str_replace("picture/","",$get["fn"]) : "";

function scd($dir) {
  $files = preg_grep('~\.(jpeg|jpg)$~', scandir($dir));
  $files2=[];
  foreach ($files as $file) {
    $files2[$file] = filemtime($dir .'/' . $file);
  }
  asort($files2);
  $files = array_keys($files2);
  return $files;
}

$files= scd("../../".$dir1);

if (($key = array_search(basename($fn), $files)) !== false) {
	$arr1 = array_slice($files,$key);
	$arr2 = array_diff($files, $arr1);
	#$files =array_merge($arr1,$arr2);
	
}
foreach ($files as $k => $file) { 
  echo <<<EOF
<div class="swiper-slide" id="{$file}">
  <div class="swiper-zoom-container">
    <img data-src="../../{$dir1}{$file}" class="swiper-lazy">
  </div>
</div>
EOF;
}
?>

    </div>
</div>

<div id="myModal" class="modal">
	<div class="modal-content">
		smile ;-)
	</div>
</div>

<script>
var frag = '<? echo $fn; ?>';
var ff = $('img[data-src*="'+frag+'"]');
var gg = $('img');
var now=0;
if (gg.index(ff)>0) now=gg.index(ff);

var mySwiper = new Swiper('.swiper-container', {
  lazy: {
    loadPrevNextAmount:3
  },
  initialSlide: now,
  zoom: {
    maxRatio: 4,
  },
});

var modal = document.getElementById('myModal');

var bool=true;

$('.swiper-slide').click(function(event) {
  bool ? window.location.href ="/?fn="+mySwiper.slides[mySwiper.activeIndex].id : true;
});

$(window).keydown(function(event) {
  event.preventDefault();
  switch (event.which) {

    case 27:
    case 13:
      //alert('escape');
      window.location.href ="/?fn="+mySwiper.slides[mySwiper.activeIndex].id;
      break;
      
    case 90:
      //alert('zoom out workaround');
      bool ? mySwiper.zoom.in() : location.reload();
      bool = !bool;
      break;
      
    case 32:
    case 66:
      //alert('shoot / bang');
      modal.style.display = "block";
      $.ajax({
        'url' : '../shoot.php',
        'type' : 'POST',
        'success' : function(data) {
          //append to DOM not to slide array
          $(".swiper-wrapper div:last-child").after('<div class="swiper-slide" id="'+data+'"><img data-src="../../<? echo $dir1; ?>'+data+'" class="swiper-lazy"></div>');
          mySwiper.update();
          mySwiper.slideTo(mySwiper.slides.length -1, 1000,false );
          //window.location.href ="/library/full/index.php?fn="+data;
          
        }, 
        'error' : function(request,error) {}
      });
      setTimeout(function(){ modal.style.display = "none"; },2000);
      break;
  
    case 38:
      //alert('Up arrow');
      mySwiper.slidePrev();
      break;
         	
    case 40:
      //alert('Right arrow');
      mySwiper.slideNext();
      break;
  }
});

</script>

</body>
</html>

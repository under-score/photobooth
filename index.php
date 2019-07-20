<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=utf-8">

<style>
body {
  background-color: black;
}
img {
  border: 5px solid black;
}
.container {
  width:250px;
  height:166px;
  padding:5px;
  float:left;
  position: relative;
  text-align: left;
  color: white;
  overflow: hidden;
}
.container img {
  max-width: 90%;
}
.centered {
    position: absolute;
    top: 10px;
    left: 10px;
}
.icon {
  display: inline-block;
  width: 3em;
  height: 3em;
  stroke-width: 0;
  stroke: currentColor;
  fill: white;
  opacity:0.5;
}
.y {
  fill:white;
  opacity:0.7;
}
.g {
  fill: grey;
  opacity:1;
}
.small {
  font-size:0.7em;
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

<body>

<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<defs>

<symbol id="icon-download" viewBox="0 0 48 48">
<path d="M34.5 21l-12 12-12-12h7.5v-18h9v18zM22.5 33h-22.5v12h45v-12h-22.5zM42 39h-6v-3h6v3z"></path>
</symbol>

<symbol id="icon-pencil" viewBox="0 0 48 48">
<path d="M40.5 0c4.142 0 7.5 3.358 7.5 7.5 0 1.688-0.558 3.246-1.5 4.5l-3 3-10.5-10.5 3-3c1.254-0.942 2.811-1.5 4.5-1.5zM3 34.5l-3 13.5 13.5-3 27.75-27.75-10.5-10.5-27.75 27.75zM33.543 17.043l-21 21-2.585-2.585 21-21 2.585 2.585z"></path>
</symbol>

<symbol id="icon-bin" viewBox="0 0 48 48">
<path d="M9 48h30l3-33h-36zM30 6v-6h-12v6h-15v9l3-3h36l3 3v-9h-15zM27 6h-6v-3h6v3z"></path>
</symbol>

</defs>
</svg>

<?php
#include ("library/log.php");
include ("library/dir.php");
$date = date('d M Y H:i:s', time());
$fn= isset($get["fn"]) ? str_replace("picture/","",$get["fn"]) : "";

#$h = shell_exec("hostname");
$files = preg_grep('~\.(jpeg|jpg)$~', scandir($dir1));
$files2=[];
foreach ($files as $file) {
	$files2[$file] = filemtime($dir1 . '/' . $file);
}
asort($files2);
$files = array_keys($files2);
$f = count($files);

$pic =<<<EOF
<a href="library/upload/" title="upload"></span><svg class="icon g icon-upload"><use xlink:href="#icon-upload"></use></svg></a>
<a href="library/shoot.php" title="shoot!"><svg class="icon g icon-camera"><use xlink:href="#icon-camera"></use></svg><span class="name"></span></a>
<a href="library/full/" title="fullscreen"><svg class="icon g icon-enlarge"><use xlink:href="#icon-enlarge"></use></svg><span class="name"></span></a-->
<a href="." title="Home"><svg class="icon g icon-folder"><use xlink:href="#icon-folder"></use></svg><span class="name"></span></a>
<a class="button" href="http://127.0.0.1:5000/library/stat.html" target="newtab">liveview</a>
EOF;

foreach(glob($dir0 . '/*', GLOB_ONLYDIR) as $subdir) {
    $pic .= '<a href=".?dir=' .basename($subdir).'" title="' .basename($subdir). '"><svg class="icon g icon-folder"><use xlink:href="#icon-folder"></use></svg></a> ';
}
$pic = '<div id="theParent">';

foreach($files as $img) {
    $img = $dir1 . $img;
    $img2 = str_replace ("#","",$img);
    if( $img != $img2) { rename($img,$img2); $img=$img2; }
    
    $fn1 = $dir2 . $img;
   	$fn2 = $dir2 . "tmp/" . $img;

   	if (!file_exists(dirname($fn2))) mkdir(dirname($fn2), 0777, true);   	
   	$cmd = "sips -s format jpeg -s formatOptions 80 --resampleWidth 280 ". $fn1 . " --out " . $fn2;
   	if (!file_exists($fn2)) shell_exec($cmd);
	
   	$pic  .= '<div class="container">';
   	$pic .= '<a href="library/full/index.php?fn=' . $img . '"><img src="tmp/' . $img . '"></a>';
   	$pic .= '<div class="centered" id="' . basename($img) . '"></div>';
   	$pic .= '</div>';
}
echo $pic;

#$cmd="mdfind 'kMDItemStarRating == \"1\"' -onlyin " . $dir1;
#$out = shell_exec($cmd);
#$out = explode("\n",$out);
?>
</div>

<div id="myModal" class="modal">
	<div class="modal-content">
		smile ;-)
	</div>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
var marks = [];
<?php 
#foreach ($out as $key => $val) { if ($val!="") echo "marks.push('" . basename($val) . "');".PHP_EOL; } 
?>
var dir = '<?php echo $dir1; ?>';

window.addEventListener('load', 
  function() { 
    var divs = document.getElementsByClassName("centered");
    if (dir=="picture/") {}
      for(var i = 0; i < divs.length; i++){
         //old version
         //divs[i].innerHTML += '<a href="library/download.php?fn=' +dir +divs[i].id+ '" title="download"><svg class="icon oplow icon-download"><use xlink:href="#icon-download"></use></svg></a>';
         //new but not sure this works for mobile download
         divs[i].innerHTML += '<a href="' +dir+divs[i].id+ '" download="' +divs[i].id+ '" title="download"><svg class="icon y oplow icon-download"><use xlink:href="#icon-download"></use></svg></a>';
         if ( marks.indexOf(divs[i].id)>=0 ) {
           //divs[i].innerHTML += '<a href="library/mark.php?fn=' +dir +divs[i].id+ '" title="star"><svg class="icon y icon-star-full"><use xlink:href="#icon-star-full"></use></svg></a>';     
         }
         else {
           //divs[i].innerHTML += '<a href="library/mark.php?fn=' +dir +divs[i].id+ '" title="star"><svg class="icon icon-star-full"><use xlink:href="#icon-star-full"></use></svg></a>';
         }
         //if (window.location.search.match( /master/gi ) ) {
	       divs[i].innerHTML += '<a href="library/edit.php?fn=' +dir +divs[i].id+ '" title="edit"><svg class="icon oplow icon-pencil"><use xlink:href="#icon-pencil"></use></svg></a>';
           divs[i].innerHTML += '<a href="library/delete.php?fn=' +dir +divs[i].id+ '" title="delete"><svg class="icon oplow icon-bin"><use xlink:href="#icon-bin"></use></svg></a>';
           //divs[i].innerHTML += '<a href="library/print.php?fn=' +dir +divs[i].id+ '" title="print"><svg class="icon oplow icon-printer"><use xlink:href="#icon-printer"></use></svg></a>';
           //divs[i].innerHTML += '<a href="javascript:void(str=prompt(\'edit ' +divs[i].id+ '\',\'\'));window.location.href=\'library/exif.php?fn=' +dir+divs[i].id+ '&title=\'+escape(str);" title="edit"><svg class="icon oplow icon-user-plus"><use xlink:href="#icon-user-plus"></use></svg></a>';
           //divs[i].innerHTML += '<a href="library/full/?fn=' +dir +divs[i].id+ '"><svg class="icon oplow icon-enlarge"><use xlink:href="#icon-enlarge" title="fullscreen"></use></svg></a>';
         //}
      }
  },
  false
);

function filterByTop(top) {
  return function(i) { return $(this).offset().top == top; };
}

var el = $('img:first');
var frag = '<? echo $fn;?>';
var ff = $('img[src*="'+frag+'"]');
var gg = $('img');
var now=0;
if (gg.index(ff)>0) now=gg.index(ff);
$('img:eq('+now+')').css("outline", "5px solid grey");
var y= 1000;
var a = $(window).height();
var b = $('img:eq('+now+')')[0].getBoundingClientRect().bottom;
$(window).scrollTop( b-(a/2) );

var modal = document.getElementById('myModal');

$(document).keydown(function(event) {
  $('img:eq('+now+')').css("outline", "5px solid transparent");
  y = $(window).scrollTop();
  irow = $('img').filter(filterByTop(el.offset().top)).length;
  icount = $(document).find('img').length;
  a = $(window).height();
  b = $('img:eq('+now+')')[0].getBoundingClientRect().bottom;
  event.preventDefault();
  switch (event.which) {
  
    case 13:
    case 27:
     //alert('escape');
      $('img:eq('+now+')').click();
      break;
      
    case 37:
      //alert('Left arrow');
      if (now == 0) window.parent.location = '/images/pretty/<?php echo explode('/',$_SERVER[REQUEST_URI])[3]; ?>';
      now = (now-1)>-1 ? now-1 : now;
      break;
      
    case 38:
      //alert('Up arrow');
      if (now == 0) window.parent.location = '/images/pretty/<?php echo explode('/',$_SERVER[REQUEST_URI])[3]; ?>';
      if ((now-irow)>-1) {now=now-irow};
      // 180px pic + 2*15px border
      if (b<420) {$(window).scrollTop(y-210)};
      break;
      
    case 39:
      //alert('Right arrow');
      if ((now+1)<icount) {now=now+1};
      break;
      
    case 40:
      //alert('Down arrow');
      if ((now+irow)<icount) {now=now+irow};
      if (b>(a-420)) {$(window).scrollTop(y+210)};
      break;
      
    case 32:
    case 83:
      //alert('space / bang');
      modal.style.display = "block";
      $.ajax({
        'url' : 'library/shoot.php',
        'type' : 'POST',
        'success' : function(data) {
        
            theParent = document.getElementById("theParent");
            theKid = document.createElement("div");
            theKid.classList.add('container');
            var content ='<img src="' +dir+ data +'">';
            theKid.innerHTML = content;
            theParent.insertAfter(theKid, theParent.firstChild);

        }, 
        'error' : function(request,error) { }
      });
      setTimeout(function(){ modal.style.display = "none"; },2000);
      break;
      
  }
  $('img:eq('+now+')').css("outline", "5px solid grey");
});

</script>
<div style="clear: both;"></div>
</body>
</html>
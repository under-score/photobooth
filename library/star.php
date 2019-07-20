<?php
function iptc_make_tag($rec, $data, $value) {
    $length = strlen($value);
    $retval = chr(0x1C) . chr($rec) . chr($data);
    if($length < 0x8000) {
        $retval .= chr($length >> 8) .  chr($length & 0xFF);
    }
    else {
        $retval .= chr(0x80) . 
                   chr(0x04) . 
                   chr(($length >> 24) & 0xFF) . 
                   chr(($length >> 16) & 0xFF) . 
                   chr(($length >> 8) & 0xFF) . 
                   chr($length & 0xFF);
    }
    return $retval . $value;
}

function star($fn) {
	$image = getimagesize($fn, $info);
	if(isset($info['APP13'])) {
		$iptc = iptcparse($info['APP13']);
		if (is_array($iptc)) {
			$star = $iptc["2#105"][0];
    	}
	}
    $star=="0" ? $star="1" : $star="0";
  	$iptc = array(
    	'2#105' => $star
  	);
	$data = "";
	foreach($iptc as $tag => $string) {
		$tag = substr($tag, 2);
		$data .= iptc_make_tag(2, $tag, $string);
	}
	$content = iptcembed($data, $fn);
	$fp = fopen($fn, "wb");
	fwrite($fp, $content);
	fclose($fp);
    return $star;
}

foreach($_GET as $k => $v) {
  $get[$k] = is_array($_GET[$k]) ? filter_var_array($_GET[$k], FILTER_SANITIZE_STRING) : filter_var($_GET[$k], FILTER_SANITIZE_STRING);
}
$fn = realpath(dirname(__FILE__)).'/'.$get["fn"];
echo $get["fn"] != "" ? star( $fn ) : 0;
?>

<script>
  $('img').click(function () {
    x=$(this);
    fn=x.attr('src');
    $.ajax({
      'url' : 'star.php?fn='+fn,
      'type' : 'GET',
        'success' : function(e) {
          if (e==1) {
            $(x)..css('border', "solid 2px red");  
          }
          else {
            $(x)..css('border', "solid 0px red");  
          }
      }
    });
  });
</script>


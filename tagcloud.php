<?php

$tags = getTags();
$counts = array_values($tags);
if(is_array($counts)){
	rsort($counts);
	$max = $counts[0];
}else{
	$max = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<title>del.icio.us - noworks</title>
</head>
<body>
<div id="containar">
	<ul id="navigation">
		<li><a href="tagcloud.php">tag cloud</a></li>
		<li><a href="renametolower.php">replace upper to lower</a></li>
	</ul>

	<h1>Your Tags</h1>
	<div id="result">
		<>
	<?foreach ($tags as $k => $v) {?>
	<a href=""><span class="tagname" style="font-size:<?=((int)(48 * $v/$max)<9)? 9:(int)(48 * $v/$max)?>px"><?=$k?></span></a>
	<?}?>
	</div>
</div>
</body>
</html>

<?

function renametolower($tag){
}

function getTags(){
	$url = 'https://noworks:bridget@api.del.icio.us/v1/tags/get';
	$fp = fopen($url, 'r');
	$body = stream_get_contents($fp);
	$xml = new SimpleXMLElement($body); 

	$tags = array();
	foreach ($xml->tag as $tag) {
		$tags[(string)$tag['tag']] = (string)$tag['count'];
	}
	return $tags;
}
/*
function cmp($a, $b) {
	return strnatcasecmp(strtolower($a), strtolower($b));
}*/
?>
<?php
set_time_limit(0);
require_once 'init.php';
require_once 'Log.php';

$conf = array('mode' => 0644);
$logger =& Log::singleton('file', 'app.log', 'ident', $conf, PEAR_LOG_INFO);

$tags = getTags();

$msgs = array();
foreach ($tags as $k => $v) {
	if(preg_match("/^[a-zA-Z0-9\+\/\\.\-#]+$/", $k) && $k != strtolower($k)){
		if(renametolower($k)){
			$msgs[] = "「". $k. "」を「".  strtolower($k). "」に変更しました。";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.0/build/reset/reset-min.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<title></title>
</head>
<body>
<div id="result">
<?foreach ($msgs as $x) {?>
<?=$x?><br />
<?}?>
</div>
</body>
</html>

<?

function renametolower($tag){
	global $logger;
	
	$url = 'https://noworks:bridget@api.del.icio.us/v1/tags/rename?';
	$query = "&old=". urlencode($tag). "&new=". urlencode(strtolower($tag));
	
	//print($url. $query);
	//print("<br />");

	$fp = fopen($url. $query, 'r');
	if(false === $fp){
		$logger->warn('エラー');
		return false;
	}else{
		$logger->info($url. $query);
	}
	
	
	$body = stream_get_contents($fp);
	$xml = new SimpleXMLElement($body); 

	fclose ($fp);
	return true;
}

function getTags(){
	$url = 'https://noworks:bridget@api.del.icio.us/v1/tags/get';
	$fp = fopen($url, 'r');
	if(false === $fp){
		return false;
	}

	$body = stream_get_contents($fp);
	$xml = new SimpleXMLElement($body); 

	$tags = array();
	foreach ($xml->tag as $tag) {
		$tags[(string)$tag['tag']] = (string)$tag['count'];
	}
	fclose ($fp);
	return $tags;
}

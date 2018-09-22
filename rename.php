<?php
set_time_limit(0);

require_once 'Log.php';

$conf = array('mode' => 0644);
$logger =& Log::singleton('file', 'app.log', 'ident', $conf, PEAR_LOG_INFO);


if(!empty ($_GET['old']) && !empty($_GET['new'])){
	if($_GET['old'] != $_GET['new']){
		$logger->info("try rename ". $_GET['old']. " to ". $_GET['new']);
		if(tagrename($_GET['old'], $_GET['new'])){
			print("success rename ". $_GET['old']. " to ". $_GET['new']);
			$logger->info("「". $k. "」を「".  ($k). "」に変更しました。");
		}else{
			print("failed rename ". $_GET['old']. " to ". $_GET['new']);
			$logger->info("「". $k. "」を「".  ($k). "」に変更に失敗しました。");
		}
	}else{
		print("tag unchanged");
	}
}else{
	print("Request invalid");
}
?>
<?
function tagrename($old, $new){
	global $logger;
	
	$url = 'https://noworks:bridget@api.del.icio.us/v1/tags/rename?';
	$query = "&old=". urlencode($old). "&new=". urlencode(strtolower($new));
	
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
?>

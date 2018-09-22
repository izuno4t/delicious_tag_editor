<?php
require_once 'init.php';
require_once 'delicious.php';

$delicious = new Delicious($_SESSION['name'], $_SESSION['password']);

$tags = $delicious->getTags();
if(false !== $tags){
	$counts = array_values($tags);
	if(is_array($counts)){
		rsort($counts);
		$max = $counts[0];
	}else{
		$max = 0;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<title>del.icio.us - <?=$_SESSION['name']?></title>
</head>
<body>
<div id="containar">
	<ul id="navigation">
		<li><a href="taglist.php">tag list</a></li>
		<li><a href="tagcloud.php">tag cloud</a></li>
		<li><a href="logout.php">logout</a></li>
	</ul>

	<h1>Your Tag Cloud</h1>
	<div id="result">
	<?foreach ($tags as $k => $v) {?>
	<a href="http://del.icio.us/<?=$_SESSION['name']?>/<?=urlencode($k)?>"><span class="tagname" style="font-size:<?=((int)(48 * $v/$max)<9)? 9:(int)(48 * $v/$max)?>px"><?=$k?></span></a>
	<?}?>
	</div>
</div>
</body>
</html>
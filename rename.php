<?php
set_time_limit(0);
require_once 'init.php';
require_once 'delicious.php';

$delicious = new Delicious($_SESSION['name'], $_SESSION['password']);

if(!empty ($_GET['old']) && !empty($_GET['new'])){
	if($_GET['old'] != $_GET['new']){
		if($delicious->tagrename($_GET['old'], $_GET['new'])){
			print("success rename ". $_GET['old']. " to ". $_GET['new']);
		}else{
			print("failed rename ". $_GET['old']. " to ". $_GET['new']);
		}
	}else{
		print("tag unchanged");
	}
}else{
	print("Request invalid");
}
?>

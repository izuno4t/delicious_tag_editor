<?
require_once 'init.php';
require_once 'delicious.php';

$delicious = new Delicious($_POST["name"], $_POST["password"]);

$res = $delicious->update();

if(false !== $res){
	$_SESSION['name'] = $_POST["name"];
	$_SESSION['password'] = $_POST["password"];
	header('Location: taglist.php');
}else{
	$_SESSION['message'] = 'login failed.';
	header("Location: index.php");
}
?>
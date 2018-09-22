<?
require_once 'init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.0/build/reset/reset-min.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<title>del.icio.us tag editor</title>
<script type="text/javascript" src="jquery-1.2.1.js"></script>
<script type="text/javascript">
</script>
</head>
<body id="login">
<div id="containar">
<h1>del.icio.us tag editor</h1>
<? if(!empty($_SESSION['message'])){?>
<div id="message"><?=$_SESSION['message']?></div>
<? unset($_SESSION['message']);}?>
<form action="login.php" id="authentication" method="post">
  <div class="login_form">
    <p class="password_entry">
      <label for="name">Username:</label>
      <input class="user_name" id="name" name="name" type="text" />
    </p>

    <p class="password_entry">
      <label for="password">Password:</label>
      <input id="password" name="password" type="password" />
    </p>
	
    <p class="remember_me">
		<input id="save_login" name="save_login" type="checkbox" value="1" />Remember me <span style="color:#f00">(now not work!)</span>
	</p>

    <div class="submit">
      <p><input name="commit" onclick="this.setAttribute('originalValue', this.value);this.disabled=true;this.value='Getting&hellip;';;result = (this.form.onsubmit ? (this.form.onsubmit() ? this.form.submit() : false) : this.form.submit());if (result == false) { this.value = this.getAttribute('originalValue'); this.disabled = false };return result" type="submit" value="Get your tags" /></p>
    </div>
	
  </div>
</form>
</div>
</body>
</html>
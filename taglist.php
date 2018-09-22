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
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.0/build/reset/reset-min.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<title>del.icio.us - <?=$_SESSION['name']?></title>
<script type="text/javascript" src="jquery-1.2.1.js"></script>
<script type="text/javascript">
function renametag(obj){
	var form = $(obj).parent();
	$(obj).val("sending...");
	$("input[@name=cancel]", form).hide();
	$.ajax({
		type: "GET",
		url: "rename.php",
		data: form.serialize(),
		success: function(msg){
			var target = $('span.tagname', $(obj).parent().parent());
			var newtag = $("input:text", form).val();
			console.log("new tag:" + newtag);
			console.log("tag exists:" + tag_duplicated(newtag));
			if(tag_duplicated(newtag)){
				//alert(target.parent().html());
				target.parent().remove();
			}else{
				target.text(newtag);
				removeform(obj);
				showmessage(msg);
			}
		},
		error:function(msg){
			alert("エラーです。\nHTTP Status=" + msg.status);
			removeform(obj);
		}
	});
	return false;
}
function togglebg(obj, s){
	if(s){
		obj.css('background', '#ffffd3');
	}else{
		obj.css('background', '#fff');
	}
	return false;
}
function removeform(obj){
	$target = $('span.tagname', $(obj).parent().parent());
	$target.attr('style', '');
	$(obj).parent().remove();
    $('span.tagname').hover(function(){togglebg($(this),true)}, function(){togglebg($(this), false)});
    $('span.tagname').click(function(){addform($(this))});	
	return false;
}
function addform(obj){
	$(obj).css('display', 'none');
	var tag = $(obj).html();
	var parent = $(obj).parent();
	$html = '<form onsubmit="renametag(this.submit);return false;"><input type="hidden" name="old" value="' + tag + '"><input tyle="text" name="new" value="' + tag + '" /><input type="button" name="submit" value="submit" onclick="renametag(this);return false;"/><input type="button" name="cancel" value="cancel" onclick="removeform(this);return false;"/></form>';
	$html += parent.html();
	parent.html($html);
	
	var txt = $("input[@name=new]", parent);
	txt.focus();
	txt.select();
	
	return false;
}

function tag_duplicated(val){
	var exists = false;
	$('span.tagname').each(function (i, obj) {
		if(val == $(obj).text()){
			console.log(val + " is duplicated");
			exists=true;
			return false;
		}
	});
	return exists;
}

function showmessage(msg){
	$("#message").html(msg);
	$("#message:hidden").slideDown("slow");
}

$(function(){
    $('span.tagname').hover(function(){togglebg($(this),true)}, function(){togglebg($(this), false)});
    $('span.tagname').click(function(){addform(this)});	
});


</script>
</head>
<body>
<div id="containar">
	<ul id="navigation">
		<li><a href="taglist.php">tag list</a></li>
		<li><a href="tagcloud.php">tag cloud</a></li>
		<li><a href="logout.php">logout</a></li>
	</ul>
	<h1>Your Tags</h1>
	<div id="result">
	<div id="message" style="display:none"></div>
	<?if(is_array($tags)){?>
		<ul>
		<?foreach ($tags as $k => $v) {?>
		<li><span class="tagname"><?=$k?></span></li>
		<?}?>
		</ul>
	<?}?>
	</div>
</div>
</body>
</html>
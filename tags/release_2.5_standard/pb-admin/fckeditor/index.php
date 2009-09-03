<?php 
include("fckeditor.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>FCKeditor</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow">
	</head>
	<body>
		<h1>FCKeditor</h1>
		<p><a href="?toolbar=Basic">Basic</a> - <a href="?toolbar=Default">Default</a></p>
		<form action="posteddata.php" method="post">
<?php
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $sBasePath ;
//if ($_GET['toolbar'] == 'Basic') {
$oFCKeditor->ToolbarSet = 'Basic';
//}
$oFCKeditor->Value		= '<p>This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.</p>
<p>You are welcome.</p>
<p><a target="_blank" href="http://www.sablog.net"><img alt="" border="0" src="http://www.sablog.net/s_logo.gif" /></a></p>' ;
$oFCKeditor->Create() ;
?>
			<br />
			<input type="submit" value="Submit">
		</form>
	</body>
</html>
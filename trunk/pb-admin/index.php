<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require_once(SITE_ROOT. './configs/db_session.php');
require("session_cp.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHPB2B Control Panel</title>
<meta http-equiv=Content-Type content="text/html; charset=<?php echo $charset;?>">
</head>
<frameset rows="63,*" cols="*" frameborder="no" border="0" framespacing="0">
	<frame name="header" noresize scrolling="no" src="./top.php">
	<frameset cols="165,*" rows="*" frameborder="no" border="0" framespacing="0">
		<frame name="menu" noresize scrolling="yes" src="./left.php">
		<frame name="main" noresize scrolling="yes" src="./home.php">
	</frameset>
</frameset>
</html>
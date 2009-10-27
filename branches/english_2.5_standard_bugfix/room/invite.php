<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
$tplname = "invite";
$invitecode = authcode($_SESSION['MemberID'].$time_stamp.getRadomStr(6));
setvar("InviteCode", $invitecode);
template($office_theme_name."/".$tplname);
?>
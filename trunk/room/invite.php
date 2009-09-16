<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
$tplname = "invite";
$invitecode = authcode($_SESSION['MemberID'].$time_stamp.pb_radom(6));
setvar("InviteCode", $invitecode);
template($tplname);
?>
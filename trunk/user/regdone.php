<?php
$inc_path = "../";
require($inc_path."global.php");
uses("member");
$member = new Members();
$member_name = rawurldecode($_GET['name']);
setvar("NewMemberName",$member_name);
template($theme_name."/user_regdone");
?>
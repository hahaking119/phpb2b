<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("adzone");
require(SITE_ROOT.'./libraries/page.php');
$tpl_file = "ads";
$adzone = new Adzones();
$amount = $adzone->findCount();
pageft($amount,15);
$result = $adzone->findAll("*",$conditions, " id desc", $firstcount, $displaypg);
setvar("Lists",$result);

uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));

template($tpl_file);
?>
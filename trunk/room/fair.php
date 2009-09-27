<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("expo", "expotype", "company");
$fair = new Expoes();
$company = new Companies();
$fairtype = new Expotypes();
if(isset($_GET['join'])){
	$_tmpvar = explode(",", $_GET['join']);
	$expo_id = intval($_tmpvar[0]);
	$_tmpres = $fair->field("ew", "id=".$expo_id);
	$_tmpres = unserialize($_tmpres);
	$if_exists = false;
	if(is_array($_tmpres)){
		$if_exists = array_key_exists($_SESSION['MemberName'], $_tmpres);
		if(!$if_exists) {
			$_tmpres[$_SESSION['MemberName']] = $company->field("name", "member_id=".$_SESSION['MemberID']);
		}
	}else{
		unset($_tmpres);
		$_tmpres[$_SESSION['MemberName']] = $company->field("name", "member_id=".$_SESSION['MemberID']);
	}
	$result = $fair->saveField("ew", serialize($_tmpres), $expo_id);
	if($result && !$if_exists){
		flash("./tip.php", "./fair.php");
	}else {
		flash("./tip.php", "./fair.php", "Apply wrong!",0);
	}
}
template($office_theme_name."/".$tpl_file);
?>
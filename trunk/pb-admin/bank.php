<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("./fckeditor/fckeditor.php") ;
require("session_cp.inc.php");
uses("setting");
$setting = new Settings();
if (isset($_POST['save'])) {
	$updated = false;
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","variable");
		if($exists){
			$sql = "update ".$setting->getTable()." set valued='$vval' where variable='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (variable,valued) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	flash("alert.php");
}
$ua_sets = $setting->getValues();
setvar("U",$ua_sets);
template("bank");
?>
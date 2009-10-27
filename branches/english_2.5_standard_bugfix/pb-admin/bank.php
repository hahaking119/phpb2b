<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("./fckeditor/fckeditor.php") ;
require("session_cp.inc.php");
uses("setting");
$setting = new Settings();
if ($_POST['save']) {
	$updated = false;
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","aa");
		if($exists){
			$sql = "update ".$setting->getTable()." set ab='$vval' where aa='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (aa,ab) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	flash("alert.php");
}
$ua_sets = $setting->getValues();
setvar("U",$ua_sets);
template("pb-admin/bank");
?>
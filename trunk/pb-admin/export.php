<?php
$inc_path = "../";
$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require(LIB_PATH .'class-excel-xml.inc.php');
require("session_cp.inc.php");

$table_name = $tb_prefix.$_POST['tbname'];
if(!empty($_POST['tradeid'])){
	$action_ids = implode(",", $_POST['tradeid']);
	$result = $g_db->GetAll("select id,topic,content from ".$table_name." where id in (".$action_ids.")");
	$doc = $result;

	$xls = new Excel_XML;
	$xls->addArray ( $doc );
	$xls->generateXML ($_POST['tbname'].$time_stamp);
}else{
	$doc = null;
	flash("alert.php", "home.php", lgg('action_false'),0);
}
?>
<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","companyoutlink","company");
$company = new Companies();
$member = new Members();
$companyoutlink = new Companyoutlinks();
$conditions = "member_id=".$_SESSION['MemberID'];
$tpl_file = "outlink";
if (isset($_POST['delete'])) {
	$deleted = false;
	if (is_array($_POST['id'])) {
		$result = $companyoutlink->del($_POST['id'], $conditions);
		if($result){
			PB_goto("./tip.php?id=1000");
		}else{
			PB_goto("./tip.php?id=1004");
		}
	}else{
		$errmsg = lgg('no_data_deleted');
		echo $errmsg;
	}
}
$fields = $companyoutlink->getFieldAliasNames();
setvar("Links",$companyoutlink->findAll($fields,$conditions,"id DESC",0,10));
template($office_theme_name."/".$tpl_file);
?>
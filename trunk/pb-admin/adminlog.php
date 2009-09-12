<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("adminlog","adminer");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$adminer = new Adminers();
$adminlog = new Adminlogs();
$conditions = null;
if ($_GET['action'] == "clear") {
	$result = $g_db->Execute("truncate ".$adminlog->getTable());
	$data['Adminlog']['action_description'] = "清空管理员操作日志";
	$adminlog->add();
}
$fields = "Adminlog.id as LogId,Adminlog.action_description as AdminAction,Adminlog.created as AdminlogCreated";
$amount = $adminlog->findCount($conditions);
pageft($amount,$display_eve_page);
$joins = array(
"Adminer"=>array("fullTableName"=>$adminer->getTable(true),"foreignKey"=>"adminer_id","fields"=>"Adminer.user_name as AdminerName")
);
setvar("LogList",$adminlog->findAll($fields, $conditions, "Adminlog.id desc ",$firstcount,$displaypg));
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
template("pb-admin/adminlog_index");
?>
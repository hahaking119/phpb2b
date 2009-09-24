<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
uses("memberlog","member", "adminlog");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
function MaskIp($params){
	extract($params);
	$ip1 = explode(".",$params['ip']);
	array_splice($ip1,3,count($ip1),"*");
	$ip2 = implode(".",$ip1);
	return $ip2;
}
$smarty->register_function("mask_ip", "MaskIp");
$member = new Members();
$adminlog = new Adminlogs();
$memberlog = new Memberlogs();
$conditions = "1";
if ($_GET['action'] == "clear") {
	$result = $g_db->Execute("truncate ".$memberlog->getTable());
	$data['Adminlog']['action_description'] = lgg('clear_memberlogs');
	$adminlog->add();
}
if(isset($_GET['search'])){
	if(!empty($_GET['memberlog']['username'])){
		$conditions.=" and Member.username='".$_GET['memberlog']['username']."'";
	}
}
$amount = $memberlog->findCount(null, "id");
$joins = array(
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username as MemberUsername")
);
$fields = "Memberlog.id AS LogId,Memberlog.member_id AS LogMemberid,Memberlog.login_time AS LogLogintime,inet_ntoa(Memberlog.login_ip) AS LogLoginip ";
pageft($amount,$display_eve_page);
setvar("LogList",$memberlog->findAll($fields, $conditions, "Memberlog.id DESC ",$firstcount,$displaypg));
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
template("memberlog_index");
?>
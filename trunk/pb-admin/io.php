<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
uses("membertype");
$membertype = new Membertypes();
require("session_cp.inc.php");
$result = $membertype->findAll("id as MembertypeId,name as MembertypeName", null, " id desc", 0,15);
$user_types = array();
foreach ($result as $key=>$val) {
	$user_types[$val['MembertypeId']] = $val['MembertypeName'];
}
setvar("UserTypes",$user_types);
if(isset($_POST['start']) && !empty($_POST['io']['from'])){
	$result = false;


	$dbinfo = $_POST['io'];
	function delSpace(&$value){
		$value = trim($value);
	}
	array_walk(&$dbinfo, "delSpace");
	$conn = mysql_connect($dbinfo['hostname'], $dbinfo['username'], $dbinfo['userpass']) or die(lgg("db_connect_error"));

	if($dbinfo['method'] == "2"){
		$sql = "truncate `".$db_links['dbname']."`.`{$tb_prefix}members`";
		mysql_query($sql);
	}
	$set_membertype_to = intval($_POST['member']['user_type']);
	if($dbinfo['from']==1){
		$sql = "replace into `".$db_links['dbname']."`.`{$tb_prefix}members` (`username`,`userpass`,`gender`,`reg_ip`,`last_ip`,`last_login`,`created`,`email`,`user_type`)  select `username`,`password`,`gender`,`regip`,`lastip`,`lastvisit`,`regdate`,`email`,".$set_membertype_to."  from `".$dbinfo['dbname']."`.`".$dbinfo['tbname']."`";
	}elseif($dbinfo['from']==2){
		$sql = "replace into `".$db_links['dbname']."`.`{$tb_prefix}members` (`username`,`userpass`,`gender`,`created`,`email`,`user_type`)  select `username`,`password`,`gender`,`regdate`,`email`,".$set_membertype_to." from `".$dbinfo['dbname']."`.`".$dbinfo['tbname']."`";;
	}
	$result = mysql_query($sql);
	if($result){
		echo "导入成功,共导入会员".mysql_affected_rows()."名,转到<a href='member.php'>会员管理页面</a>";
	}else{
		echo lgg("action_false");
	}
	exit;
}
setvar("dbInfo", $db_links);
template("pb-admin/io_import");
?>
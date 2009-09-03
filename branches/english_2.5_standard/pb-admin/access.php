<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("access","membertype", "member");
require(SITE_ROOT.'./app/include/page.php');
$tpl_file = "access_index";
$access = new Accesses();
$member = new Members();
$membertype = new Membertypes();
setvar("AccessStatus", explode(",",lgg('yes_no')));
$result = $membertype->findAll("id as MembertypeId,name as MembertypeName",$conditions, " id desc", 0,15);
$user_types = array();
foreach ($result as $key=>$val) {
	$user_types[$val['MembertypeId']] = $val['MembertypeName'];
}
setvar("LiveTimes", explode(",",lgg("live_times")));
setvar("AfterLiveTime", explode(",",lgg("after_livetimes_do")));
setvar("UserTypes",$user_types);
if ($_POST['save']) {
	$vals = $_POST['access'];
	$access_id = $_POST['id'];
	$data['Membertype']['access_id'] = $access_id;
	if (!empty($access_id)) {
		$access_res = $access->field("id", "id=".$access_id);
		if(empty($access_res) || !($access_res)){
			$result = $access->save($vals);
			$data['Membertype']['access_id'] = $access->getMaxId();
		}else{
			$result = $access->save($vals, "update", $access_id);
		}
	}else{
		$vals['created'] = $time_stamp;
		$result = $access->save($vals);
		$data['Membertype']['access_id'] = $access->getMaxId();
	}
	if ($vals['default_livetime']!=$_POST['old_defaultlivetime']) {
		//update all membertype to new livetime
		$sep_times = $access->getExpireTime($vals['default_livetime']);
		$sep_times = $sep_times-$time_stamp;
		$sql = "update ".$member->getTable()." set service_end_date=service_start_date+".$sep_times." where user_type=".$vals['membertype_id'];
		$result = $g_db->Execute($sql);
	}
	$result2 = $membertype->save($data['Membertype'], "update", $vals['membertype_id']);
	if (!$result) {
		flash("./alert.php", "access.php?action=list", null, 0, null, "./membertype.php");
	}else{
		flash("./alert.php", "access.php?action=list", null, 1, null, "./membertype.php");
	}
}
if ($_POST['del'] && !empty($_POST['id'])) {
	$result = $access->del($_POST['id']);
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$result = $access->del($_GET['id'])	;
}
if ($_GET['action'] == "mod") {
	if (!empty($_GET['id'])) {
		$result = $access->read("*", $_GET['id']);
		setvar("a",$result);
	}
	$tpl_file = "access_edit";
}
template("pb-admin/".$tpl_file);
?>
<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
require(LIB_PATH .'time.class.php');
uaCheckPermission(2);
uses("company","job","access");
$company = new Companies();
$access = new Accesses();
$job = new Jobs();
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$company->checkStatus($company_id);
$tpl_file = "job_index";
if($_GET['action']=="del" && !empty($_GET['id'])){
	$job->del(intval($_GET['id'],"member_id=".$_SESSION['MemberID']));
}
if (!empty($_POST['job']) && $_POST['save']) {
	$vals = array();
	$vals = $_POST['job'];
	$vals['expire_time'] = Times::dateConvert($_POST['ExpireTime']);
	array_walk($vals,"uatrim");
	$check_job_update = $access->field("check_job_update","membertype_id=".$ua_user['user_type']);
	if ($check_job_update=="0") {
		$vals['status'] = 1;
	}else {
		$vals['status'] = 0;
		$message_info = lgg('msg_wait_check');
	}
	if($_POST['id']){
		$result = $job->save($vals, "update", $_POST['id'],null, " AND member_id=".$_SESSION['MemberID']);
	}else{
		$vals['created'] = $time_stamp;
		$vals['company_id'] = $company->field("id", "member_id=".$_SESSION['MemberID']);

		$vals['member_id'] = $_SESSION['MemberID'];
		$result = $job->save($vals);
	}
	if($result){
		$message_info = "Save successfully";
		flash("./tip.php",null,$message_info);
	}else {
		flash("./tip.php", "./job.php",$message_info,0);
	}
}
if($_GET['action'] == "mod"){
	uses("member");
	$member = new Members();
	setvar("Genders",$member->genders);
	setvar("Educations",$job->educations);
	$jid = intval($_GET['id']);
	if($jid){
		$res = $job->read(null, $jid, null, " AND Job.member_id=".$_SESSION['MemberID']);
		if (empty($res)) {
			PB_goto("./tip.php?id=1004");
		}
		setvar("j",$res);
	}
	$tpl_file = "job_edit";
}else{
	$res = $job->findAll(null, "Job.member_id=".$_SESSION['MemberID'], "id DESC", 0, 10);
	setvar("CompanyJobs",$res);
}
setvar("Worktype",$job->worktype);
setvar("Salary",$job->salary);
template($tpl_file);
?>
<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("job","company","member");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$job = new Jobs();
$member = new Members();
$company = new Companies();
$conditions = null;
$table = array();
$job_status = explode(",",lgg('product_status'));
setvar("CheckStatus", $job_status);
$table['member'] = $member->getTable(true);
$table['company'] = $company->getTable(true);
$table['job'] = $job->getTable(true);
$tpl_file = "job_index";
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	$job->del($_GET['id']);
}
if (isset($_POST['ua_action'])) {
	if ($_POST['ua_action'] == "none" || array_key_exists($_POST['ua_action'], $job_status)) {
		$result = $job->saveField("status", intval($_POST['ua_action']), $_POST['id']);
	}elseif ($_POST['ua_action'] == "del"){
		$result = $job->del($_POST['id']);
	}
}
if ($_GET['action'] == "view" && !empty($_GET['id'])) {
	$tpl_file = "job_view";
	$joins = " LEFT JOIN ".$table['company']." ON Job.company_id=Company.id LEFT JOIN ".$table['member']." ON Job.member_id=Member.id";
	$sql = "select ".$job->getFieldAliasNames().",Company.name as CompanyName,Member.username as MemberName from ".$table['job'].$joins." where Job.id=".$_GET['id'];
	$result = $g_db->GetRow($sql);
	setvar("j",$result);
	setvar("Genders",$member->genders);
	setvar("Educations",$job->educations);
	setvar("Worktypes",$job->worktype);
	setvar("SalaryLevels",$job->salary);
}else{
	$fields = "Job.id as JobId,Job.name as JobName,Job.created as JobCreated,Job.status as JobStatus, Company.name as CompanyName,Member.username as MemberName";
	$sql = "SELECT count(Job.id) AS Amount FROM ".$table['job'];
	$joins = " LEFT JOIN ".$table['company']." ON Job.company_id=Company.id LEFT JOIN ".$table['member']." ON Job.member_id=Member.id";
	$amount = $g_db->GetOne($sql.$joins);
	pageft($amount,$display_eve_page);
	$sql = "select ".$fields." from ".$table['job'].$joins." order by Job.id desc limit $firstcount,$displaypg";
	setvar("RecordList",$g_db->GetArray($sql));
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
template($tpl_file);
?>
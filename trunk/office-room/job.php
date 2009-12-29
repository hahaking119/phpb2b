<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: job.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(LIB_PATH .'time.class.php');
uses("company","job");
check_permission("job");
require(LIB_PATH. "typemodel.inc.php");
$company = new Companies();
$job = new Jobs();
$tpl_file = "job";
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)){
		$job->del($id, "member_id=".$_SESSION['MemberID']);
	}
	if($do == "edit"){
		setvar("Genders", get_cache_type('gender'));
		setvar("Educations", get_cache_type('education'));
		setvar("Salary", get_cache_type('salary'));
		if(!empty($id)){
			$res = $job->read("*", $id, null, "Job.member_id=".$_SESSION['MemberID']);
			if (empty($res)) {
				flash("action_failed");
			}
			setvar("item",$res);
		}
		$tpl_file = "job_edit";
		template($tpl_file);
		exit;
	}
}
if (!empty($_POST['job']) && $_POST['save']) {
	$vals = $_POST['job'];
	pb_submit_check('job');
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	if(!empty($vals['expire_time'])) {
		$vals['expire_time'] = Times::dateConvert($_POST['expire_time']);
	}
	$check_job_update = $g['job_check'];
	if ($check_job_update=="0") {
		$vals['status'] = 1;
	}else {
		$vals['status'] = 0;
		$message_info = 'msg_wait_check';
	}
	if(!empty($id)){
		$vals['modified'] = $time_stamp;
		$result = $job->save($vals, "update", $id, null, "member_id=".$_SESSION['MemberID']);
	}else{
		$vals['created'] = $vals['modified'] = $time_stamp;
		$vals['company_id'] = $companyinfo['id'];
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['cache_spacename'] = $pdb->GetOne("SELECT space_name FROM {$tb_prefix}members WHERE id=".$_SESSION['MemberID']);
		$result = $job->save($vals);
	}
	if(!$result){
		flash();
	}else{
		flash($message_info);
	}
}
$result = $job->findAll("*", null, "Job.member_id=".$_SESSION['MemberID'], "id DESC", 0, 10);
setvar("Items",$result);
setvar("Worktype",get_cache_type("work_type"));
setvar("Salary",get_cache_type("salary"));
template($tpl_file);
?>
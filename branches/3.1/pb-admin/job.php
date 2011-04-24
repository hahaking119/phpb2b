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
 * @version $Id: job.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("job","company","member");
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
require(LIB_PATH. "typemodel.inc.php");
$job = new Jobs();
$page = new Pages();
$member = new Members();
$company = new Companies();
$conditions = null;
$table = array();
$job_status = explode(",",L('product_status', 'tpl'));
setvar("CheckStatus", $job_status);
$tpl_file = "job";
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "del" && !empty($id)) {
		$job->del($_GET['id']);
	}
	if ($do == "view" && !empty($id)) {
		$tpl_file = "job.view";
		$sql = "SELECT j.name,j.work_station,j.content,j.require_gender_id,j.peoples,j.require_education_id,j.require_age,j.salary_id,j.worktype_id,j.clicked,j.created,j.expire_time,c.name as cache_companyname,m.username as cache_username from {$tb_prefix}jobs as j LEFT JOIN {$tb_prefix}companies c ON j.company_id=c.id LEFT JOIN {$tb_prefix}members m ON j.member_id=m.id where j.id=".$id;
		$result = $pdb->GetRow($sql);
		setvar("item", $result);
		setvar("Genders", get_cache_type("gender"));
		setvar("Educations", get_cache_type('education'));
		setvar("Worktypes", get_cache_type('work_type'));
		setvar("SalaryLevels", get_cache_type('salary'));
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['pb_action'])) {
	if (!empty($_POST['id'])) {
		if ($_POST['pb_action'] == "none" || array_key_exists($_POST['pb_action'], $job_status)) {
			$result = $job->saveField("status", intval($_POST['pb_action']), $_POST['id']);
		}elseif ($_POST['pb_action'] == "del"){
			$result = $job->del($_POST['id']);
		}
	}
}
if(isset($_POST['del'])){
	if(!empty($_POST['id'])){
		$job->del($_POST['id']);
	}
}
$fields = "Job.id,Job.name as jobname,Job.created as pubdate,Job.status as jobstatus, c.name as companyname,m.username";
$sql = "SELECT count(id) AS Amount FROM {$tb_prefix}jobs";
$amount = $pdb->GetOne($sql);
$joins = "LEFT JOIN {$tb_prefix}companies c ON Job.company_id=c.id LEFT JOIN {$tb_prefix}members m ON Job.member_id=m.id";
$page->setPagenav($amount);
$sql = "SELECT ".$fields." FROM {$tb_prefix}jobs AS Job {$joins} ORDER BY Job.id DESC LIMIT $page->firstcount,$page->displaypg";
setvar("Items", $pdb->GetArray($sql));
uaAssign(array("ByPages"=>$page->pagenav));
template($tpl_file);
?>
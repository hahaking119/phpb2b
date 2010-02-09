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
 * @version $Id: list.php 458 2009-12-27 03:05:45Z steven $
 */
define('CURSCRIPT', 'search');
require("../libraries/common.inc.php");
require("../share.inc.php");
require(LIB_PATH. "page.class.php");
uses("job", "industry", "area");
$job = new Jobs();
$area = new Areas();
$industry = new Industries();
$page = new Pages();
$conditions[] = "Job.status=1";
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "search") {
		if(!empty($_GET['q'])){
			$title = trim($_GET['q']);
			$conditions[]= "Job.name like '%".$title."%'";
		}
		if (!empty($_GET['data']['salary_id'])) {
			$conditions[] = "Job.salary_id=".intval($_GET['data']['salary_id']);
		}
		if (!empty($_GET['data']['area_id1'])) {
			$conditions[] = "Job.area_id1=".intval($_GET['data']['area_id1']);
		}
		if (!empty($_GET['data']['area_id2'])) {
			$conditions[] = "Job.area_id2=".intval($_GET['data']['area_id2']);
		}
		if (!empty($_GET['data']['area_id3'])) {
			$conditions[] = "Job.area_id3=".intval($_GET['data']['area_id3']);
		}
	}
}
if (isset($_GET['industryid'])) {
	$industry_id = intval($_GET['industryid']);
	$tmp_info = $industry->setInfo($industry_id);
	if (!empty($tmp_info)) {
		$conditions[] = "Job.industry_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "hr/list.php?industryid=".$tmp_info['id']);
	}
}
if (isset($_GET['areaid'])) {
	$area_id = intval($_GET['areaid']);
	$tmp_info = $area->setInfo($area_id);
	if (!empty($tmp_info)) {
		$conditions[] = "Job.area_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "hr/list.php?areaid=".$tmp_info['id']);
	}
}
$joins[] = "LEFT JOIN {$tb_prefix}companies Company ON Company.member_id=Job.member_id";
$amount = $job->findCount($joins, $conditions, "Job.id");
$page->setPagenav($amount);
$result = $job->findAll("Job.work_station,Job.created AS pubdate,Job.name,Job.id,Company.name as companyname,Company.member_id,Company.id AS companyid,Company.cache_spacename AS userid", $joins, $conditions, "Job.id DESC", $page->firstcount, $page->displaypg);
$viewhelper->setTitle(L("search", "tpl"));
$viewhelper->setPosition(L("search", "tpl"));
setvar("Items", $result);
setvar("ByPages", $page->pagenav);
render("hr.list");
?>
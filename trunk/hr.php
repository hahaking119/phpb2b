<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:06:28 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: advsearch.php 438 2009-07-07 14:28:27Z stevenchow811 $
 */
$inc_path = "./";
$li = 8;
require("global.php");
$conditions = null;
$tpl_file = "hr_index";
include(SITE_ROOT.'./app/include/page.php');
include(SITE_ROOT."./data/tmp/data/".$cookiepre."area.inc.php");
uses("industry", "area", "job", "company", "member");
$industry = new Industries();
$member = new Members();
$area = new Areas();
$company = new Companies();
$job = new Jobs();
$conditions = null;
$_positions[] = $_titles[] = lgg("hr_channel");
$areas = array();
foreach ($UL_DBCACHE_AREAS as $key=>$val){
    if ('0000' == substr($key, -4, 4)) {
        $areas[$key] = $val;
    }
}
$parent_industry = $g_db->GetArray("select id,name from ".$industry->getTable()." where parentid=0;");
setvar("ParentIndustry", $parent_industry);
$parent_area = $g_db->GetArray("select id,code_id,name from ".$area->getTable()." where INSTR(code_id,'0000');");
setvar("ParentArea", $parent_area);
setvar("IndustryList", $industry->getIndustryPage(0,"hr","industry3"));
if(isset($_GET['searchkeywords']) && !empty($_GET['skeyword'])){
	$title = trim($_GET['skeyword']);
	$conditions.= " and Job.name like '%".$title."%'";
	$_titles[] = sprintf(lgg("search_info_center"), $title);
	$_positions[] = sprintf(lgg("search_info_center"), $title);
}
if (!empty($_GET['industryname'])) {
	$ind_res = $g_db->GetRow("select id,parentid,name from ".$tb_prefix."industries where name='".urldecode($_GET['industryname'])."'");
	if($ind_res['parentid']==0){
		$conditions.= " and Company.industry_id in (".$ind_res['id'].",".$industry->getSubIndustries($ind_res['id']).")";
	}else{
		$conditions.= " and Company.industry_id=".$ind_res['id'];
	}
	$sid = $ind_res['id'];
	setvar("IndsutryName", $industry_name = $ind_res['name']);
	$_titles[] = $industry_name;
	$_positions[] = $industry_name;
}
if (isset($_GET['ac'])) {
	if ($_GET['ac']=="list") {
		$tpl_file = "hr_list";
	}
}
if (!empty($_GET['areaid'])) {
	$conditions.= " and Company.province_code_id=".$_GET['areaid'];
}
$job->setPageTitle($_titles, $_positions);

$ListAmount = $g_db->GetOne("select count(Job.id) as JobAmount from ".$job->getTable(true)." left join ".$company->getTable(true)." on Company.member_id=Job.member_id and Job.status=1");
$ListAmount = $ListAmount['JobAmount'];
pageft($ListAmount,10);
$sql = "select Job.name as JobName,Job.id as JobId,Company.name as CompanyName,Company.member_id as MemberId,Company.id as CompanyId from ".$job->getTable(true)." ,".$company->getTable(true)." where Company.member_id=Job.member_id and Job.status=1 ".$conditions." order by Job.id desc limit $firstcount,$displaypg";

$result = $g_db->GetAll($sql);
//select personal that find job,photo, age.
$sqlResume = "select firstname,lastname,country_id,province_code_id,city_code_id,gender,photo from ".$member->getTable()." where status='1' and user_level='1' limit 0,10";

$arrResumes = $g_db->GetArray($sqlResume);
if (!empty($arrResumes)) {
	$smarty->assign("Resumes", $arrResumes);
}
uaAssign(array("pageTitle"=>$job->title, "pagePosition"=>$job->position, "lists"=>$result,"ByPages"=>$pagenav, "Areas"=>$areas));
template($theme_name."/".$tpl_file);
?>
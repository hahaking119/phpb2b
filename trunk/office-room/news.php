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
 * @version $Id: news.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(PHPB2B_ROOT.'./libraries/page.class.php');
uses("companynews", "company");
check_permission("companynews");
$companynews = new Companynewses();
$company = new Companies;
$tables = $companynews->getTable(true);
$tpl_file = "news";
$page = new Pages();
if(isset($company_id))
$conditions = "company_id=".$company_id;
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit") {
		if(!empty($id)){
			$res = $companynews->read("Companynews.id AS ID,title AS Title,content AS Content,created AS CreateDate",$id);
			setvar("item",$res);
			setvar("ShowCaption","none");
		}
		$tpl_file = "news_edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save'])) {
	pb_submit_check('title');
	$vals = null;
	$vals['title'] = trim($_POST['title']);
	$vals['content'] = trim($_POST['content']);
	if(!empty($_POST['newsid'])){
		$vals['modified'] = $time_stamp;
		$companynews->save($vals, "update",$_POST['newsid'],null, "member_id=".$_SESSION['MemberID']);
		pheader("location:news.php?action=list");
	}else {
		$vals['created'] = $time_stamp;
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['company_id'] = $company_id;
		$result = $companynews->save($vals);
		flash("success");
	}
}
if (isset($_POST['del'])) {
	$result = $companynews->del($_POST['newsid'], $conditions);
	if ($result) {
		flash("success");
	}else {
		flash("action_failed");
	}
}
$amount = $companynews->findCount(null, $conditions);
$page->setPagenav($amount);
$fields = "title as CompanynewsTitle,created as CompanynewsCreated,id as CompanynewsId";
setvar("Companynewses",$companynews->findAll($fields,null, $conditions,"id DESC",$page->firstcount,$page->displaypg));
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>
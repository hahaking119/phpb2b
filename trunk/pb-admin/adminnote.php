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
 * @version $Id: adminnote.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require(LIB_PATH .'page.class.php');
require("session_cp.inc.php");
uses("adminnote");
$adminnote = new Adminnotes();
$tpl_file = "adminnote";
$page = new Pages();
$conditions = array("member_id=".$current_adminer_id);
if (isset($_POST['save']) && !empty($_POST['data']['adminnote']['title'])) {
	$vals = $_POST['data']['adminnote'];
	$id = $_POST['id'];
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$result = $adminnote->save($vals, "update", $id);
	}else{
		$vals['member_id'] = $current_adminer_id;
		$vals['created'] = $vals['modified'] = $time_stamp;
		$result = $adminnote->save($vals);
	}
	if (!$result) {
		flash();
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $adminnote->del($_POST['id']);
}
if (isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)) {
		$result = $adminnote->del($_GET['id'])	;
	}
	if ($do == "edit") {
		if (!empty($id)) {
			$result = $adminnote->read("*", $id);
			setvar("item",$result);
		}
		$tpl_file = "adminnote.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "search") {
		if (!empty($_GET['q'])) {
			$conditions[] = "title like '%".$_GET['q']."%' OR content like '%".$_GET['q']."%'";
		}
	}
}
$amount = $adminnote->findCount();
$page->setPagenav($amount);
$result = $adminnote->findAll("*", null, $conditions, " id desc", $page->firstcount, $page->displaypg);
setvar("Items",$result);
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>
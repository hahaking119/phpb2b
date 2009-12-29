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
 * @version $Id: pms.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(PHPB2B_ROOT.'libraries/page.class.php');
uses("message");
$pms = new Messages();
$page = new Pages();
$fields = "id,title,content";
$conditions[] = "to_member_id=".$_SESSION['MemberID'];
if (isset($_GET['type'])) {
	$type = trim($_GET['type']);
	if (in_array($type, array("system", "user", "inquery"))) {
		$conditions[] = "type='".$type."'";
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do=="send") {
		$item = array();
		if (isset($_GET['to'])) {
			$item['to'] = $_GET['to'];
		}
		setvar("item", $item);
		template("pms_send");
		exit;
	}
	if($do == "view" && !empty($id)){
		$message_info = $pms->read("*", $id, null, $conditions);
		if(!$message_info || empty($message_info)){
			flash();
		}else{
			$pdb->Execute("UPDATE {$tb_prefix}messages SET status=1 WHERE to_member_id=".$_SESSION['MemberID']." AND id=".$id);
			setvar("item",$message_info);
			$tpl_file = "pms_detail";
			template($tpl_file);
			exit;
		}
	}
}
if (isset($_POST['send']) && !empty($_POST['pms'])) {
	pb_submit_check('pms');
	$vals = array();
	$vals = $_POST['pms'];
	if (is_int($_POST['to'])) {
		$to_memberid = intval($_POST['to']);
		$member_info = $pdb->GetRow("SELECT id,username FROM {$tb_prefix}members WHERE id='".$to_memberid."'");
	}else{
		$member_info = $pdb->GetRow("SELECT id,username FROM {$tb_prefix}members WHERE username='".$_POST['to']."'");
	}
	if (!$member_info || empty($member_info) || $member_info['id']==$_SESSION['MemberID']) {
		flash();
	}
	$result = $pms->SendToUser($_SESSION['MemberName'], $member_info['username'], $vals);

	if (!$result) {
		flash();
	}
}

if (isset($_POST['del'])) {
	$result = $pms->del($_POST['messageid'],"to_member_id=".$_SESSION['MemberID']);
	if ($result) {
		pheader("location:pms.php");
	}else {
		flash();
	}
}
$tpl_file = "pms";
$amount = $pms->findCount(null, $conditions);
$page->setPagenav($amount);
$res = $pms->findAll("id,from_member_id,cache_from_username,title,content,status,created", null, $conditions, "id DESC", $page->firstcount, $page->displaypg);
setvar("MessageStatus", $pms->read_status);
setvar("Items",$res);
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>
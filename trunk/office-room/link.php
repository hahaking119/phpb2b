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
 * @version $Id: link.php 481 2009-12-28 01:05:06Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("space");
$spacelink = new Spaces();
$tpl_file = "link";
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_POST['delete'])) {
	$deleted = false;
	if (is_array($_POST['id'])) {
		$ids = "(".implode(",", $_POST['id']).")";
		$deleted = $pdb->Execute("DELETE FROM {$tb_prefix}spacelinks WHERE id IN $ids AND member_id={$_SESSION['MemberID']} AND company_id={$companyinfo['id']}");
		if($deleted){
			flash("success");
		}else{
			flash();
		}
	}else{
		flash("no_data_deleted");
	}
}
if (isset($_POST['save'])) {
	$record = array();
	$vals = $_POST['spacelink'];
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	if (!empty($id)) {
		$updated = $spacelink->add($vals, "update", $id, "{$tb_prefix}spacelinks", "member_id=".$_SESSION['MemberID']." AND company_id=".$companyinfo['id']);
	}else{
		$vals['created'] = $time_stamp;
		$vals['company_id'] = $companyinfo['id'];
		$vals['member_id'] = $_SESSION['MemberID'];
		if (strstr($vals['url'], 'http://') || strstr($vals['url'], 'www')) {
			$vals['is_outlink'] = 1;
		}
		$updated = $spacelink->save($vals, '', '', "{$tb_prefix}spacelinks");
	}
	if (!$updated) {
		flash("action_failed");
	}else{
		flash("success", '', 0);
	}
}
if (isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do == "edit") {
		if (!empty($id)) {
			$linkinfo = $spacelink->read("*", $id);
			setvar("item",$linkinfo);
		}
		$tpl_file = "link_edit";
		template($tpl_file);
		exit;
	}
}
$result = $spacelink->getSpaceLinks($_SESSION['MemberID'], $companyinfo['id']);
if (!empty($result)) {
	setvar("Items", $result);
}
template($tpl_file);
?>
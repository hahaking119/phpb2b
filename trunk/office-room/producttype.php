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
 * @version $Id: producttype.php 458 2009-12-27 03:05:45Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("product","producttype");
$tpl_file = "producttype";
$product = new Products();
$producttype = new Producttypes();
$conditions[] = "member_id = ".$_SESSION['MemberID'];
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)) {
		$product_amount = $pdb->GetOne("SELECT count(id) FROM {$tb_prefix}products WHERE producttype_id={$id} AND member_id={$_SESSION['MemberID']}");
		if ($product_amount>0) {
			flash('pls_del_first');
		}else{
			$result = $producttype->del($id, $conditions);
		}
	}
	if ($do=="edit") {
		$company->newCheckStatus($companyinfo['status']);		
		if (!empty($id)) {
			$res = $producttype->read('id,name', $id, null, $conditions);
			setvar("item",$res);
		}
		$tpl_file = "producttype_edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['name'])) {
	pb_submit_check('data');
	$record = array();
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	$record['name'] = $_POST['data']['name'];
	if(!empty($id)){
		$record['modified'] = $time_stamp;
		$result = $producttype->save($record, "update", $id, null, $conditions);
	}else{
		$orignal_count = $producttype->findCount(null, $conditions);
		if ($g['max_producttype'] && $orignal_count>=$g['max_producttype']) {
			flash("post_max");
		}
		$record['member_id'] = $_SESSION['MemberID'];
		$record['created'] = $record['modified'] = $time_stamp;
		$record['company_id'] = $company_id;
		$result = $producttype->save($record);
	}
	if(!$result){
		flash();
	}
}

$result = $producttype->findAll('id,name',null,$conditions," id DESC");
setvar("Items",$result);
template($tpl_file);
?>
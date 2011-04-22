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
 * @version $Id: upgrade.php 458 2009-12-27 03:05:45Z steven $
 */
session_start();
define('CURSCRIPT', 'upgrade');
require("../libraries/common.inc.php");
require("../api/payments/tenpay/tenpay.php");
uses("member","order","goods");
$member = new Members();
$goods = new Goods();
$order = new Orders();
$tpl_file = "upgrade";
$result = $goods->findAll("id,name,price");
$payment = $pdb->GetArray("SELECT id,description FROM {$tb_prefix}payments WHERE available=1");
if (!empty($pb_userinfo)) {
	$member_info = $pdb->GetRow("SELECT m.email,mf.tel,mf.first_name,mf.last_name FROM {$tb_prefix}members m LEFT JOIN {$tb_prefix}memberfields mf ON m.id=mf.member_id WHERE m.id=".$pb_userinfo['pb_userid']);
	setvar("MemberInfo", $member_info);
}else{
	flash("please_login_first", "../logging.php");
}
if (isset($_POST['apply'])) {
	pb_submit_check('product_id');
	$add = array();
	$vals = array();
	$goods_id = intval($_POST['product_id']);
	$payment_id = intval($_POST['payment_id']);
	if (!empty($_POST['tel'])) {
		$add[] = "mf.tel='".addslashes($_POST['tel'])."'";
	}
	if (!empty($_POST['email'])) {
		$add[] = "m.email='".addslashes($_POST['email'])."'";
	}
	if (!empty($add)) {
		$add = implode(",", $add);
		$pdb->Execute("UPDATE {$tb_prefix}members m,{$tb_prefix}memberfields mf SET {$add} WHERE m.id={$pb_userinfo['pb_userid']} AND mf.member_id={$pb_userinfo['pb_userid']}");
	}
	$vals['content'] = $_POST['content'];
	$vals['member_id'] = $pb_userinfo['pb_userid'];
	$vals['cache_username'] = $pb_userinfo['pb_username'];
	$vals['total_price'] = $pdb->GetOne("SELECT price FROM {$tb_prefix}goods WHERE id='".$goods_id."'");
	$product = $pdb->GetOne("SELECT name FROM {$tb_prefix}goods WHERE id='".$goods_id."'");
	$payment = $pdb->GetOne("SELECT name FROM {$tb_prefix}payments WHERE id='".$payment_id."'");
	$total_price = floatval($vals['total_price'])*100;
	if($payment =='paypal'){
		pay($product,$total_price);
	}elseif($payment == 'post'){
		render("member.upgrade.done");
	}
	$last_order_id = $order->Add($vals);
	if ($last_order_id) {
		$pdb->Execute("INSERT INTO {$tb_prefix}ordergoods (order_id,goods_id) VALUE ('".$last_order_id."','".$goods_id."')");
		flash("order_submited", URL.$viewhelper->office_dir."/");
	}else{
		flash();
	}
}
formhash();
setvar("payments",$payment);
setvar("Items",$result);
render("member.".$tpl_file);
?>
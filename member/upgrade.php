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
define('CURSCRIPT', 'upgrade');
require("../libraries/common.inc.php");
require("../share.inc.php");if (session_id() == '' ) { 
	require_once(LIB_PATH. "session_php.class.php");
	$session = new PbSessions();
}
require(API_PATH. "payments/tenpay/tenpay.php");
uses("member","order","goods");
$member = new Members();
$goods = new Goods();
$order = new Orders();
$adzones = $pdb->GetArray("SELECT id,name,price FROM {$tb_prefix}adzones");
$good = $goods->findAll("id,name,price");
$payment = $pdb->GetArray("SELECT id,title FROM {$tb_prefix}payments WHERE available=1");
if (!empty($pb_userinfo)) {
	$member_info = $pdb->GetRow("SELECT m.email,mf.tel,mf.first_name,mf.last_name FROM {$tb_prefix}members m LEFT JOIN {$tb_prefix}memberfields mf ON m.id=mf.member_id WHERE m.id=".$pb_userinfo['pb_userid']);
	setvar("MemberInfo", $member_info);
}else{
	flash("please_login_first", "../logging.php");
}

if(isset($_GET['do'])){
    $do = trim($_GET['do']);
	if($do=="upgrade"){
        setvar("index",0);
	}elseif($do=="buy"){
        setvar("index",2);
    }elseif($do=="charge"){
	   setvar("index",1);
	}
}
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if ($do == "apply") {
		pb_submit_check('product_id');
		$add = array();
		$goods_id = intval($_POST['product_id']);
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
		$vals['cache_username'] = $vals['username'] = $pb_userinfo['pb_username'];
		$online = $pdb->GetRow("SELECT if_online_support,config,description FROM {$tb_prefix}payments WHERE id='".intval($_POST['payment_id'])."'");
		if(!empty($_POST['total_price'])){
			if(is_numeric($_POST['total_price'])){
				$total_price = $vals['total_price'] = $_POST['total_price'];
	            $last_order_id = $order->Add($vals);
				if($last_order_id){
	              	$pdb->Execute("INSERT INTO {$tb_prefix}ordergoods (order_id,goods_id) VALUE ('".$last_order_id."','".$_POST['product_id']."')");
		            setvar("total_price", $total_price);
		            setvar("payment", $payment);
		            $configs = unserialize($online['config']);
					if($online['if_online_support']){
						setvar("OnlineSupport", 1);
						setvar("OnlineSupportUrl", $configs['gateway']);
					 }else{
					 	setvar("OnlineSupport", 0);
					 }
					 setvar("Description", $online['description']);
					 render("member.pay", 1);
				}else{
					flash();
				}
			}else{
				flash("charge_check");
			}
		}else{
				flash("charge_check");
		}
	}
}
formhash();
setvar("Items",$good);
setvar("Adzones",$adzones);
setvar("payments",$payment);
render("member.apply");
?>
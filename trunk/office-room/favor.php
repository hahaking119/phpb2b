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
 * @version $Id: favor.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("trade");
$trade = new Trade();
$trade_model = new Trades();
if (isset($_POST['del'])) {
	pb_submit_check('id');
	$ids = implode(",", $_POST['id']);
	$ids = "(".$ids.")";
	$sql = "DELETE FROM {$tb_prefix}favorites WHERE id IN ".$ids." AND member_id=".$_SESSION['MemberID'];
	$res = $pdb->Execute($sql);
	if (!$res) {
		flash("action_failed");
	}
}
if(isset($_POST['do']) && isset($_POST['id'])){
	if ($trade_model->checkExist($_POST['id'])) {
		$sql = "INSERT INTO {$tb_prefix}favorites (target_id,member_id,type_id,created,modified) VALUE (".$_POST['id'].",".$_SESSION['MemberID'].",1,".$time_stamp.",".$time_stamp.")";
		$result = $pdb->Execute($sql);
	}
	if($result){
		echo "<script language='javascript'>window.close();</script>";
		exit;
	}else {
		flash("been_favorited", '', 0);
	}
}
$tpl_file = "favor";
$sql = "select f.id,t.id as offerid,t.title,t.type_id,f.created as pubdate from {$tb_prefix}trades as t,{$tb_prefix}favorites as f where f.member_id=".$pb_userinfo['pb_userid']." and f.target_id=t.id";
$result = $pdb->GetArray($sql);
setvar("Items", $result);
setvar("TradeTypes", $trade->getTradeTypes());
template($tpl_file);
?>
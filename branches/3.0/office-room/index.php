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
 * @version $Id: index.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("membergroup", "trade");
$membergroup = new Membergroups();
$trade = new Trade();
if (!empty($memberinfo)) {
	$service_info = false;
	$membergroup_id = $memberinfo['membergroup_id'];
	if (empty($memberinfo['service_end_date']) or empty($memberinfo['service_start_date'])) {
		$service_info = false;
	}else{
		$total_days = ($memberinfo['service_end_date'] - $memberinfo['service_start_date']);
		if($total_days<=0) {
			$total_days=1;
			$service_interation = 1;
		}else{
			$service_interation = intval((($time_stamp - $memberinfo['service_start_date'])/$total_days)*100);
		}
		setvar("service_days", $service_interation>100?100:$service_interation);
		$service_info = true;
	}
	if(isset($service_interation))
	if ($service_interation>=100) {
		$group_info = $pdb->GetRow("SELECT default_live_time,after_live_time FROM {$tb_prefix}membergroups WHERE id=".$membergroup_id);
		$membergroup_id = $group_info['after_live_time'];
		$time_add = $membergroup->getServiceEndtime($group_info['default_live_time']);
		$pdb->Execute("UPDATE {$tb_prefix}members SET membergroup_id='".$group_info['after_live_time']."',service_start_date='".$time_stamp."',service_end_date='".$time_add."' WHERE id=".$_SESSION['MemberID']);
	}
	uaAssign(array(
		"UserName"=>$memberinfo['first_name'].$memberinfo['last_name'],
		"MemberGenger"=>$memberinfo['gender'],
		"LastLogin"=>date("Y-m-d",$memberinfo['last_login']))
	);
	$offer_count = $pdb->GetArray("SELECT count(id) AS amount,type_id AS typeid FROM {$tb_prefix}trades WHERE member_id=".$_SESSION['MemberID']." GROUP BY type_id");
	$offer_stat = array();
	$types = $trade->getTradeTypes();
	if (!empty($offer_count)) {
		foreach ($offer_count as $offer_key=>$offer_val) {
			$offer_stat[$types[$offer_val['typeid']]] = $offer_val['amount'];
		}
		setvar("items_offer", $offer_stat);
	}
	$pm_count = $pdb->GetArray("SELECT count(id) AS amount,type AS typename FROM {$tb_prefix}messages WHERE to_member_id=".$_SESSION['MemberID']." GROUP BY type");
	if (!empty($pm_count)) {
		$pm_result = array();
		foreach ($pm_count as $pm_val) {
			$pm_result[$pm_val['typename']] = intval($pm_val['amount']);
		}
		setvar("pm", $pm_result);
	}
	setvar("ServiceInfo", $service_info);
	setvar("MemberInfo", $memberinfo);
	$group['name'] = $g['name'];
	$group['image'] = $g['avatar'];
	setvar("group", $group);
	template("index");
}else{
	flash('invalid_user');
}
?>
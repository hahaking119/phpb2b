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
 * @version $Id: membergroup.php 481 2009-12-28 01:05:06Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. 'cache.class.php');
require(CACHE_PATH. "cache_membergroup.php");
require(LIB_PATH. "typemodel.inc.php");
require(CACHE_PATH. 'cache_membertype.php');
uses("membergroup");
$cache = new Caches();
$conditions = array();
$membergroup = new Membergroups();
$tpl_file = "membergroup";
setvar("AskAction", get_cache_type("common_option"));
setvar("Membertypes", $_PB_CACHE['membertype']);
if (isset($_POST['updateDefault']) && !empty($_POST['gid'])) {
	$id = intval($_POST['gid'][0]);
	$pdb->Execute("UPDATE {$tb_prefix}membergroups SET is_default='0' WHERE 1");
	$pdb->Execute("UPDATE {$tb_prefix}membergroups SET is_default='1' WHERE id=".$id);
}
if (isset($_POST['saveauth'])) {
	$vals = $_POST['membergroup'];
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	$vals['allow_offer'] = bindec($_POST['offer']['allow'].$_POST['offer']['check']);
	$vals['allow_product'] = bindec($_POST['product']['allow'].$_POST['product']['check']);
	$vals['allow_job'] = bindec($_POST['job']['allow'].$_POST['job']['check']);
	$vals['allow_companynews'] = bindec($_POST['companynews']['allow'].$_POST['companynews']['check']);
	$vals['allow_album'] = bindec($_POST['album']['allow'].$_POST['album']['check']);
	$vals['allow_market'] = bindec($_POST['market']['allow'].$_POST['market']['check']);
	$vals['allow_company'] = bindec($_POST['company']['allow'].$_POST['company']['check']);
	if (!empty($id)) {
		$result = $membergroup->save($vals, "update", $id);
	}else{
		$result = $membergroup->save($vals);
	}
	if (!$result) {
		flash();
	}else{
		$cache->writeCache("membergroup", "membergroup");
		flash("success", "membergroup.php?type=".$_POST['type']);
	}
}
if (isset($_POST['save_data'])) {
	if (!empty($_POST['id'])) {
		$count = count($_POST['id']);
		for($i=0; $i<$count; $i++){
			$result = $pdb->Execute("UPDATE {$tb_prefix}membergroups SET name='".$_POST['name'][$i]."',picture='".$_POST['picture'][$i]."',point_min='".$_POST['point_min'][$i]."',point_max='".$_POST['point_max'][$i]."' WHERE id=".$_POST['id'][$i]);
		}
		if (!$result) {
			flash();
		}else{
			$cache->writeCache("membergroup", "membergroup");
		}
	}
}
if (isset($_GET['type'])) {
	$conditions[] = "type='".$_GET['type']."'";
	setvar("MembergroupType", $_GET['type']);
}
$result = $membergroup->find("exempt,id,name,description,picture,point_max,point_min,is_default", null, null, $conditions, "id ASC");
if(!function_exists('str_split')) {
  function str_split($string, $split_length = 1) {
    $array = explode("\r\n", chunk_split($string, $split_length));
    array_pop($array);
    return $array;
  }
}
for ($i=0; $i<count($result); $i++){
	$tmp_power = sprintf("%04b", $result[$i]['exempt']);
	$result[$i]['exemptval'] = array_reverse(str_split($tmp_power));
	$result[$i]['exemptval'] = str_split($tmp_power);
	if(!empty($_PB_CACHE['membergroup'])) {
		$result[$i]['image'] = URL."images/group/".$_PB_CACHE['membergroup'][$result[$i]['id']]['avatar'];
		$result[$i]['avatar'] = $_PB_CACHE['membergroup'][$result[$i]['id']]['avatar'];
	}
}
if (isset($_POST['save_permission'])) {
	foreach ($result as $key=>$val) {
		$exempt = null;
		$exempt.=(in_array($val['id'], $_POST['basic']))?"1":"0";
		$exempt.=(in_array($val['id'], $_POST['offer']))?"1":"0";
		$exempt.=(in_array($val['id'], $_POST['product']))?"1":"0";
		$exempt.=(in_array($val['id'], $_POST['company']))?"1":"0";
		$exempt_value = bindec($exempt);
		$sql = "UPDATE {$tb_prefix}membergroups SET exempt='{$exempt_value}',modified={$time_stamp} WHERE id={$val['id']}";
		$pdb->Execute($sql);
	}
	$cache->writeCache('membergroup', 'membergroup');
	pheader("location:membergroup.php?do=permission");
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do=="permission") {
		$tpl_file = "membergroup.permission";
	}
	if ($do == "edit") {
		$data = array();
		foreach ($_PB_CACHE['membergroup'] as $key1=>$val1) {
			$data[$key1] = $val1['name'];
		}
		setvar("LiveTimes", explode(",",L("live_times", 'tpl')));
		setvar("MembergroupOption", $data);
		if (!empty($id)) {
			$item = $membergroup->read("*", $id);
			if (!empty($item)) {
				$allow_offer = sprintf("%02d", decbin($item['allow_offer']));
				$item['offer_allow'] = $allow_offer[0];
				$item['offer_check'] = $allow_offer[1];
				$allow_product = sprintf("%02d", decbin($item['allow_product']));
				$item['product_allow'] = $allow_product[0];
				$item['product_check'] = $allow_product[1];
				$allow_job = sprintf("%02d", decbin($item['allow_job']));
				$item['job_allow'] = $allow_job[0];
				$item['job_check'] = $allow_job[1];
				$allow_companynews = sprintf("%02d", decbin($item['allow_companynews']));
				$item['companynews_allow'] = $allow_companynews[0];
				$item['companynews_check'] = $allow_companynews[1];
				$allow_album = sprintf("%02d", decbin($item['allow_album']));
				$item['album_allow'] = $allow_album[0];
				$item['album_check'] = $allow_album[1];
				$allow_market = sprintf("%02d", decbin($item['allow_market']));
				$item['market_allow'] = $allow_market[0];
				$item['market_check'] = $allow_market[1];
				$allow_company = sprintf("%02d", decbin($item['allow_company']));
				$item['company_allow'] = $allow_company[0];
				$item['company_check'] = $allow_company[1];
				$item['image'] = URL."images/group/".$item['picture'];
				setvar("item", $item);
			}
		}
		$tpl_file = "membergroup.edit";
		template($tpl_file);
		exit;
	}
}
setvar("Items", $result);
template($tpl_file);
?>
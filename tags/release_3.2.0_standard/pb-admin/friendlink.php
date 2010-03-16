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
 * @version $Id: friendlink.php 427 2009-12-26 13:45:47Z steven $
 */
session_cache_limiter('nocache');
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. "typemodel.inc.php");
require(CACHE_PATH. "cache_friendlinktype.php");
uses("friendlink", "industry");
$link = new Friendlinks();
$industry = new Industries();
$conditions = null;
$tpl_file = "friendlink";
setvar("AskAction", get_cache_type("common_option"));
if (!empty($_PB_CACHE['friendlinktype'])) {
	setvar("FriendlinkTypes", $_PB_CACHE['friendlinktype']);
}
if (isset($_POST['save']) && !empty($_POST['data']['friendlink']['title'])) {
	$vals = array();
	$vals = $_POST['data']['friendlink'];
	$vals['industry_id'] = $industry->getMinalId($_POST['data']['industry_id1'], $_POST['data']['industry_id2'], $_POST['data']['industry_id3']);
	$vals['area_id'] = $industry->getMinalId($_POST['data']['area_id1'], $_POST['data']['area_id2'], $_POST['data']['area_id3']);
	if(isset($_POST['id'])){
		$id = intval($_POST['id']);
	}
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$updated = $link->save($vals, "update", $id);
	} else {
		$vals['created'] = $vals['modified'] = $time_stamp;
		$updated = $link->save($vals);
	}
	if (!$updated) {
		flash();
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "del" && !empty($id)) {
		$result = $link->del($id);
	}
	if ($do == "edit") {
		$tpl_file = "friendlink.edit";
		if(!empty($id)){
			$fields = "*";
			$link_info = $link->read($fields,$id);
			setvar("item",$link_info);
		}
		template($tpl_file);
		exit;
	}
}
if(isset($_POST['del']) && !empty($_POST['id'])){
	$result = $link->del($_POST['id']);
	if(!$result){
		flash();
	}
}
$fields = "*";
setvar("Items",$link->findAll($fields, null, $conditions, "priority ASC,id DESC"));
template($tpl_file);
?>
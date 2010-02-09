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
 * @version $Id: templet.php 427 2009-12-26 13:45:47Z steven $
 */
define('CURSCRIPT', 'templet');
require("../libraries/common.inc.php");
uses("templet");
require("session_cp.inc.php");
require(CACHE_PATH. "cache_membergroup.php");
require(CACHE_PATH. "cache_membertype.php");
require(LIB_PATH. "typemodel.inc.php");
require_once LIB_PATH.'chinese.class.php';
$chinese = new Chinese('gbk', 'utf8', TRUE);
$templet = new Templets();
$templet_controller = new Templet();
$conditions = null;
$tpl_file = "templet";
setvar("AskAction", get_cache_type("common_option"));
if(isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "uninstall" && !empty($id)) {
		$templet->del($id);
	}
	if ($do == "install" && !empty($_GET['entry'])) {
		$entry = trim($_GET['entry']);
		$templet_controller->install($entry);
		flash("tpl_installed_ok");
	}
	if($do == "edit"){
		if (!empty($id)) {
			setvar("item",$templet->read("*", $id));
		}
		$user_types = array();
		foreach ($_PB_CACHE['membergroup'] as $key=>$val) {
			$user_types[$key] = $val['name'];
		}
		setvar("Membergroups", $user_types);
		setvar("Membertypes", $_PB_CACHE['membertype']);
		$tpl_file = "templet.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$result = $templet->del($_POST['id']);
}
if (isset($_POST['save']) && !empty($_POST['data']['templet']['title'])) {
	$vals = array();
	$vals = $_POST['data']['templet'];
	if(!in_array(0, $_POST['data']['require_membertype']) && !empty($_POST['data']['require_membertype'])){
		$res = "[".implode("][", $_POST['data']['require_membertype'])."]";
		$vals['require_membertype'] = $res;
	}elseif(!empty($_POST['data']['require_membertype'])){
		$vals['require_membertype'] = 0;
	}
	if(!in_array(0, $_POST['data']['require_membergroups']) && !empty($_POST['data']['require_membergroups'])){
		$res = "[".implode("][", $_POST['data']['require_membergroups'])."]";
		$vals['require_membergroups'] = $res;
	}elseif(!empty($_POST['data']['require_membergroups'])){
		$vals['require_membergroups'] = 0;
	}
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	if(!empty($id)){
		$result = $templet->save($vals, "update", $id);
		if ($_POST['data']['templet']['is_default']==1) {
			$pdb->Execute("UPDATE {$tb_prefix}templets SET is_default='0'");
			$pdb->Execute("UPDATE {$tb_prefix}templets SET is_default='1' WHERE id='".$_POST['id']."'");
		}
	}else{
		$result = $templet->save($vals);
	}
	if(!$result){
		flash();
	}
}
$result = $templet_controller->getTemplate();
setvar("Items", $result);
template("templet");
?>
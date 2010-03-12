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
 * @version $Id: tradetype.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
uses("tradetype");
require(LIB_PATH. "cache.class.php");
$cache = new Caches();
$conditions = null;
$tradetype = new Tradetypes();
$tpl_file = "offertype";
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $tradetype->del($_POST['id']);
	if (!$result) {
		flash();
	}else{
		$cache->writeCache("offertype","offertype");
	}
}
if (isset($_POST['update'])) {
	if (!empty($_POST['tid'])) {
		$type_count = count($_POST['tid']);
		for($i=0; $i<$type_count; $i++){
			if (!empty($_POST['name'][$i])) {
				$pdb->Execute("UPDATE {$tb_prefix}tradetypes SET name='".$_POST['name'][$i]."',display_order='".$_POST['display_order'][$i]."' WHERE id=".$_POST['tid'][$i]);
			}
		}
		$name_count = count($_POST['name']);
		if ($name_count<=$type_count) {
			break;
		}else{
			for($j=$type_count; $j<$name_count; $j++){
				if (!empty($_POST['name'][$j])) {
					$pdb->Execute("INSERT INTO {$tb_prefix}tradetypes (name) values ('".$_POST['name'][$j]."')");
				}
			}
		}
		$cache->writeCache("offertype", "offertype");
		flash("success");;
	}
}
if(isset($_POST['save'])){
	$id = $_POST['id'];
	$vals = $_POST['data']['tradetype'];
	if(!empty($id)){
		$result = $tradetype->save($vals, "update", $id);
	}else{
		$result = $tradetype->save($vals);
	}
	if(!$result){
		flash();
	}else{
		$cache->writeCache("tradetype","tradetype");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit") {
		$tpl_file = "tradetype.edit";
		if (!empty($id)) {
			$result = $tradetype->read("*",$id);
			setvar("item",$result);
		}
	}
	if ($do == "del" && !empty($_GET['id'])){
		$result = $tradetype->del($_GET['id']);
		if (!$result) {
			flash();
		}else{
			$cache->writeCache("offertype","offertype");
		}
	}
}
$sql = "SELECT * FROM {$tb_prefix}tradetypes";
$result = $pdb->GetArray($sql);
setvar("Items",$result);
template($tpl_file);
?>
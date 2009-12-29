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
require("../libraries/common.inc.php");
require("session_cp.inc.php");
uses("friendlink");
$link = new Friendlinks();
$conditions = null;
$tpl_file = "friendlink";
if (isset($_POST['save']) && !empty($_POST['friendlink']['title'])) {
	$vals = array();
	$vals = $_POST['friendlink'];
	$id = intval($_POST['id']);
	if ($id) {
		$updated = $link->save($vals, "update", $id);
	} else {
		$vals['created'] = $time_stamp;
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
		if($id){
			$fields = "id,title,logo,priority,url";
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
setvar("Items",$link->findAll($fields, null, $conditions, "id DESC"));
template($tpl_file);
?>
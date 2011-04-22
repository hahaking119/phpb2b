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
 * @version $Id: announce.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("announcement");
require("session_cp.inc.php");
require(LIB_PATH. "page.class.php");
require(CACHE_PATH. "cache_announcetype.php");
$page = new Pages();
$announce = new Announcements();
$tpl_file = "announce";
setvar("Types", $_PB_CACHE['announcetype']);
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $announce->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)) {
		$announce->del($id);	
	}
	if($do=="edit"){
		if(!empty($id)){
			$res= $announce->read("*",$id);
			setvar("item",$res);
		}
		$tpl_file = "announce.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save'])) {
	if (!empty($_POST['id'])) {
		$result = $announce->save($_POST['data']['announcement'], "update", intval($_POST['id']));
	}else{
		$result = $announce->save($_POST['data']['announcement']);
	}
	if (!$result) {
		flash();
	}else{
		$announce->updateCache();
	}
}
$amount = $announce->findCount(null, "id");
$page->setPagenav($amount);
$fields = "id,announcetype_id,announcetype_id as typeid,subject,message,subject AS title,message AS content,created,created as pubdate";
setvar("ByPages", $page->pagenav);
setvar("Items",$announce->findAll($fields, null, null, "id DESC", $page->firstcount, $page->displaypg));
template($tpl_file);
?>
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
 * @version $Id: tag.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("tag");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require("session_cp.inc.php");
require(CACHE_PATH. "type_common_status.php");
$tag = new Tags();
$conditions = null;
$tpl_file = "tag";
$joins = array();
$page = new Pages();
setvar("Status", $_PB_CACHE['common_status']);
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit") {
		if ($id) {
			setvar("item", $tag->read("*", $id));
		}
		$tpl_file = "tag.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "search" && !empty($_GET['q'])) {
		$conditions[]= "Tag.name like '%".trim($_GET['q'])."%'";
	}
	if ($do == "del" && !empty($id)) {
		$tag->del($id);
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$tag->del($_POST['id']);
}
if (isset($_POST['save']) && !empty($_POST['data']['tag'])) {
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	if ($id) {
		$tag->save($_POST['data']['tag'], "update", $id);
	}else{
		$tag->save($_POST['data']['tag']);
	}
}
$amount = $tag->findCount(null, $conditions);
$page = new Pages();
$page->setPagenav($amount);
$joins[] = "LEFT JOIN {$tb_prefix}members m ON m.id=Tag.member_id";
$result = $tag->findAll("Tag.id,m.username,m.space_name,Tag.member_id,Tag.name,Tag.numbers,Tag.closed", $joins, $conditions, "Tag.id DESC ", $page->firstcount, $page->displaypg);
setvar("Items", $result);
setvar("ByPages", $page->getPagenav());
template($tpl_file);
?>
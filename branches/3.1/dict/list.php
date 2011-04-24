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
 * @version $Id: list.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("../share.inc.php");
require(PHPB2B_ROOT.'libraries/page.class.php');
uses("dicttype","dict");
$dict = new Dicts();
$page = new Pages();
$dicttype = new Dicttypes();
$conditions = array();
$viewhelper->setPosition(L("dictionary", "tpl"), "dict/");
$viewhelper->setTitle(L("dictionary", "tpl"));
if (isset($_GET['typeid'])) {
	$type_id = intval($_GET['typeid']);
	$conditions[] = "Dicts.dicttype_id='".$type_id."'";
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "search") {
		if (!empty($_GET['q'])) {
			$conditions[] = "Dicts.word like '%".$_GET['q']."%'";
		}
	}
}
$amount = $dict->findCount(null, $conditions);
$page->setPagenav($amount);
$result = $dict->findAll("Dicts.*,dp.name AS typename", array("LEFT JOIN {$tb_prefix}dicttypes dp ON dp.id=Dicts.dicttype_id"), $conditions, "Dicts.id DESC", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	setvar("Items", $result);
	setvar("ByPages",$page->pagenav);
}
render("dict.list");
?>
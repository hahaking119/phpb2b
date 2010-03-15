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
uses("dicttype","dict");
$dict = new Dicts();
$dicttype = new Dicttypes();
$id = $wd = '';
$viewhelper->setPosition(L("dictionary", "tpl"), "dict/");
$viewhelper->setTitle(L("dictionary", "tpl"));
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}
if (isset($_GET['wd'])) {
	$wd = trim($_GET['wd']);
}
$result = $dict->getInfo($id, $wd);
if (!empty($result)) {
	$viewhelper->setPosition($result['typename'], "dict/list.php?typeid=".$result['dicttype_id']);
	$viewhelper->setTitle($result['word']);
	setvar("item", $result);
	$pdb->Execute("UPDATE {$tb_prefix}dicts SET hits=hits+1 WHERE id='".$id."'");
	render("dict.detail");
}else{
	flash("data_not_exists");
}
?>
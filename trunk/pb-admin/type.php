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
 * @version $Id: help.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
require(LIB_PATH. "cache.class.php");
$cache = new Caches();
$page = new Pages();
$tpl_file = "type";
$conditions = array();
if (isset($_POST['update']) && !empty($_POST['option_label'])) {
	for($i=0; $i<count($_POST['optid']); $i++){
		$pdb->Execute("UPDATE {$tb_prefix}typeoptions SET option_label='".$_POST['option_label'][$i]."',option_value='".$_POST['option_value'][$i]."' WHERE id='".$_POST['optid'][$i]."'");
	}
	flash("success");
}
if (isset($_GET['modelid'])) {
	$conditions[] = "typemodel_id='".$_GET['modelid']."'";
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "refresh") {
		$cache->updateTypevars();
	}
}
if (!empty($conditions) && is_array($conditions)) {
	$condition = " WHERE ".implode(" AND ", $conditions);
}
$amount = $pdb->GetOne("SELECT count(id) FROM ".$tb_prefix."typeoptions{$condition}");
$page->setPagenav($amount);
$result = $pdb->GetArray("SELECT tp.*,tm.title AS typename,tm.title FROM {$tb_prefix}typeoptions tp LEFT JOIN {$tb_prefix}typemodels tm ON tp.typemodel_id=tm.id {$condition} ORDER BY tm.id,tp.id DESC LIMIT {$page->firstcount},{$page->displaypg}");
setvar("Items", $result);
setvar("ByPages", $page->pagenav);
template($tpl_file);
?>
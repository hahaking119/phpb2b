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
 * @version $Id: index.php 443 2009-12-26 13:49:49Z cht117 $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("../share.inc.php");
require("common.inc.php");
$tpl_file = "help.index";
$viewhelper->setPosition(L("help_center", "tpl"), "help/index.php");
$viewhelper->setTitle(L("help_center", "tpl"));
if(isset($_GET['typeid'])) {
	$type_id = intval($_GET['typeid']);
	$conditions[] = "helptype_id=".$type_id;
	$type_name = $pdb->GetOne("SELECT title FROM {$tb_prefix}helptypes WHERE id='".$type_id."'");
	$viewhelper->setTitle($type_name);
	$viewhelper->setPosition($type_name, "help/index.php?typeid=".$type_id);
}
if (isset($_GET['search'])) {
	if (!empty($_GET['q'])) {
		$conditions[] = "title like '%".trim($_GET['q'])."%'";
	}
}
$result = $help->findAll("id,title", null, $conditions, "id DESC");
setvar("Items", $result);
render($tpl_file);
?>
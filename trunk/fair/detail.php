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
 * @version $Id: detail.php 444 2009-12-26 13:50:16Z cht117 $
 */
define('CURSCRIPT', 'detail');
require("../libraries/common.inc.php");
require("../share.inc.php");
require(CACHE_PATH. 'cache_expotype.php');
require(CACHE_PATH. 'cache_area.php');
require(CACHE_PATH. 'cache_industry.php');
uses("expo");
$fair = new Expoes();
if (!$fair->checkExist($_GET['id'], true)) {
	flash("data_not_exists");
}
$info = $fair->info;
if(!empty($info)){
	$info['typename'] = $_PB_CACHE['expotype'][$info['expotype_id']];
	$viewhelper->setTitle($info['typename']);
	$viewhelper->setPosition($info['typename'], 'fair/list.php?typeid='.$info['expotype_id']);
	$viewhelper->setTitle($info['name']);
	$viewhelper->setPosition($info['name']);
	$result = $pdb->GetArray("SELECT c.name,c.id,c.cache_spacename AS userid FROM {$tb_prefix}expomembers em LEFT JOIN {$tb_prefix}companies c ON c.id=em.company_id WHERE c.status=1");
	if (!empty($result)) {
		setvar("Items", $result);
	}
	setvar("item", $info);
}
render("fair.detail");
?>
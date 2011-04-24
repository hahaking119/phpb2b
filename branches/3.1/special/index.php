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
 * @version $Id: index.php 459 2009-12-27 03:07:23Z steven $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("../share.inc.php");
$viewhelper->setPosition(L("sub_special", "tpl"), "special/");
$viewhelper->setTitle(L("sub_special", "tpl"));
if (isset($_GET['type']) && in_array($_GET['type'], arraY("area", "industry"))) {
	switch ($_GET['type']) {
		case "area":
			setvar("special_name", L("sub_area", "tpl"));
			$viewhelper->setTitle(L("sub_area", "tpl"));
			break;
		case "industry":
			setvar("special_name", L("sub_industry", "tpl"));
			$viewhelper->setTitle(L("sub_industry", "tpl"));
			break;
		default:
			break;
	}
	$cache_id = $_GET['type'];
}
render("special.index");
?>
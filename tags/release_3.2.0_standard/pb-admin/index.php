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
 * @version $Id: index.php 456 2009-12-26 14:29:04Z steven $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
if(empty($_COOKIE[$cookiepre.'admin']) || !($_COOKIE[$cookiepre.'admin'])){
	pheader("location:login.php");
}
require("session_cp.inc.php");
require("menu.php");
require(LIB_PATH. "json_config.php");
$smarty->template_dir = "template/";
$smarty->assign("ActionMenus", json_encode($menus));
$tpl_file = "index";
template($tpl_file);
?>
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
 * @version $Id: product.php 525 2009-12-28 06:23:21Z cht117 $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(CACHE_PATH. "cache_markettype.php");
require(LIB_PATH. "cache.class.php");
$cache = new Caches();
$tpl_file = "markettype";
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if ($do == "save") {
		if($cache->updateTypes("markettype", $_POST['data']['sort'])){
			flash("success");
		}else{
			flash();
		}
	}
}
if (!empty($_PB_CACHE['markettype'])) {
	setvar("sorts", implode("\r\n", $_PB_CACHE['markettype']));
}
template($tpl_file);
?>
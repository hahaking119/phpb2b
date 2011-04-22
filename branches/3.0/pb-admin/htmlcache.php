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
 * @version $Id: htmlcache.php 473 2009-12-27 04:13:51Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. "file.class.php");
uses("htmlcache");
$htmlcache = new Htmlcaches();
require(LIB_PATH. "cache.class.php");
require(LIB_PATH. "json_config.php");
$cache = new Caches();
$tpl_file = "htmlcache";
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	switch ($do) {
		case "clear":
			$smarty->clear_all_cache();
			$smarty->clear_compiled_tpl();
			$file = new Files();
			$file->rmDirs(DATA_PATH. "templates_c".DS);
			flash("success", "htmlcache.php?do=clear");
			break;
		case "update":
			$cache->writeCache("area", "area");
			$cache->writeCache("industry", "industry");
			$cache->writeCache("setting", "setting");
			flash("success", "htmlcache.php?do=update");
			break;
		default:
			break;
	}
}
template($tpl_file);
?>
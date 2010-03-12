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
			if (in_array("membercache", $_POST['data']['type'])) {
				$pdb->Execute("TRUNCATE `{$tb_prefix}membercaches`");
			}
			if (in_array("smartycache", $_POST['data']['type'])) {
				$smarty->clear_all_cache();
			}
			if (in_array("smartycompile", $_POST['data']['type'])) {
				$smarty->clear_compiled_tpl();
				$file = new Files();
				$file->rmDirs(DATA_PATH. "templates_c".DS);
			}
			if (in_array("options", $_POST['data']['type'])) {
				$cache->updateTypevars();
			}
			flash("success", "htmlcache.php?do=clear");
			break;
		case "update":
			if (in_array("area", $_POST['data']['type'])) {
				$cache->writeCache("area", "area");
			}
			if (in_array("industry", $_POST['data']['type'])) {
				$cache->writeCache("industry", "industry");
			}
			if (in_array("setting", $_POST['data']['type'])) {
				$cache->writeCache("setting", "setting");
			}
			if (in_array("setting1", $_POST['data']['type'])) {
				$cache->writeCache("setting1", "setting1");
			}
			flash("success", "htmlcache.php?do=update");
			break;
		default:
			break;
	}
}
template($tpl_file);
?>
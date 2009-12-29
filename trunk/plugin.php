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
 * @version $Id: plugin.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'plugin');
require("libraries/common.inc.php");
if (isset($_GET['name'])) {
	$name = htmlspecialchars(trim($_GET['name']));
	$plugin_info = $pdb->GetRow("SELECT id FROM {$tb_prefix}plugins WHERE name='".$name."'");
	if (!$plugin_info OR empty($plugin_info)) {
		flash("plugin_not_exists", URL);
	}else{
		if (!class_exists("Plugin")) {
			uses("plugin");
			$plugin = new Plugin($name);
		}else{
		    $plugin = new Plugin($name);
		}		
		include(APP_PATH. "slug".DS."function.plugin.php");
		smarty_function_plugin(array("name"=>$name));
	}
}else{
	flash("plugin_not_exists", URL);
}
?>
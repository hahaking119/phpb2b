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
 * @version $Id: function.plugin.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_function_plugin($params){
	global $pdb, $tb_prefix;
	global $smarty, $time_stamp;
	extract($params);
	if (isset($name)) {
		$plugin_var = $pdb->GetOne("SELECT pluginvar FROM {$tb_prefix}plugins WHERE available=1 AND name='{$name}'");
		if (!empty($plugin_var)) {
			$plugin_var = unserialize($plugin_var);
			extract($plugin_var);
			$smarty->assign($plugin_var);
		}
		$pb_plugin_name = $name;
		if (!class_exists("Plugin")) {
			uses("plugin");
			$plugin = new Plugin($pb_plugin_name);
		}else{
			$plugin = new Plugin($pb_plugin_name);
		}
		include($plugin->plugin_path.$plugin->plugin_name.'/'.$plugin->plugin_name.'.php');
	}
}
?>
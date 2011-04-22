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
 * @version $Id: plugin.php 427 2009-12-26 13:45:47Z steven $
 */
define('CURSCRIPT', 'templet');
require("../libraries/common.inc.php");
uses("plugin");
require("session_cp.inc.php");
$plugin_model = new Plugins();
$plugin = new Plugin();
$conditions = null;
$tpl_file = "plugin";
if(isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "uninstall" && !empty($id)) {
		$plugin_model->del($id);
	}
	if ($do == "install" && !empty($_GET['entry'])) {
		$entry = trim($_GET['entry']);
		$plugin->install($entry);
		pheader("location:plugin.php");
	}
	if($do == "edit"){
		if (!empty($id)) {
			$row = $plugin_model->read("*", $id);
			if (!empty($row['pluginvar'])) {
				$plugin_var = unserialize($row['pluginvar']);
				unset($row['pluginvar']);
				$item = array_merge($row, $plugin_var);
			}else {
				$item = $row;
			}
			$plugin->plugin_name = $row['name'];
			require($plugin->plugin_path.$row['name'].DS.$row['name'].".php");
			$smarty->assign($item);
			formhash();
			template($plugin->plugin_path.$row['name'].DS."template".DS."admin");
			exit;
		}
	}
}
if (isset($_POST['save']) && !empty($_POST['pluginvar']) && !empty($_POST['entry'])) {
	$plugin_var = serialize($_POST['pluginvar']);
	$entry = trim($_POST['entry']);
	$plugin->plugin_name = $entry;
	require($plugin->plugin_path.$entry.DS.$entry.".php");
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
		$result = $pdb->Execute("UPDATE {$tb_prefix}plugins SET pluginvar='".$plugin_var."' WHERE id=".$id);
	}else{
		$result = $pdb->Execute("UPDATE {$tb_prefix}plugins SET pluginvar='".$plugin_var."' WHERE entry='".$entry."'");
	}
	if(!$result){
		flash();
	}
}
$result = $plugin->getPlugins();
setvar("Items", $result);
template($tpl_file);
?>
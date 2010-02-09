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
	$plugin_info = $pdb->GetRow("SELECT * FROM {$tb_prefix}plugins WHERE name='".$name."'");
	if (!$plugin_info OR empty($plugin_info)) {
		flash("plugin_not_exists", URL);
	}else{
		if (!class_exists("Plugin")) {
			uses("plugin");
			$plugin = new Plugin($name);
		}else{
		    $plugin = new Plugin($name);
		}
		/**
 * Sends http headers
 */
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // rfc2616 - Section 14.21
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
		header('Pragma: no-cache'); // HTTP/1.0
		if (!defined('IS_TRANSFORMATION_WRAPPER')) {
			// Define the charset to be used
			header('Content-Type: text/html; charset=' . $charset);
		}
		echo '<?xml version="1.0" encoding="'.$charset.'"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$app_lang.'" lang="'.$app_lang.'">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'" />
<meta name="keywords" content="" />
<meta name="description" content="'.utf_substr(htmlspecialchars($plugin_info['description']), 100).'" />
<title>'.implode(" - ", array($name, $plugin_info['title'])).'</title>
</head>
<body>';
		include(APP_PATH. "slug".DS."function.plugin.php");
		smarty_function_plugin(array("name"=>$name));
		echo '</body></html>';
	}
}else{
	flash("plugin_not_exists", URL);
}
?>
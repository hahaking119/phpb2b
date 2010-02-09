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
 * @version $Id$
 */
function smarty_function_editor($params){
	$output = null;
	if(!isset($params['path'])){
		$base_path = "../";
	}else{
		$base_path = $params['path'];
	}
	switch ($params['type']){
		case "ckeditor":
			$output.="<script type=\"text/javascript\" src=\"{$base_path}scripts/ckeditor/ckeditor.js\"></script>\n";
			if (isset($params['toolbar'])) {
				$toolbar = $params['toolbar'];
			}else{
				$toolbar = "Basic";
			}
			if(isset($params['element'])) {
				$output.="<script type=\"text/javascript\">
CKEDITOR.replace(\"".$params['element']."\", 
{
	toolbar : \"{$toolbar}\",
	skin: \"kama\", width:600, height:150
});
</script>
";
			}
			break;
		case "auto":
			break;
		case "tiny_mce":
			if (!isset($params['mode']) || empty($params['mode'])) {
				$mode = "mode : \"textareas\",";
			}else{
				$mode = "mode : \"specific_textareas\",
editor_selector : \"mceEditor\",
";
			}
			if (isset($params['theme'])) {
				$theme = trim($params['theme']);
			}else{
				$theme = "simple";
			}
			$output.="<script type=\"text/javascript\" src=\"{$base_path}scripts/tiny_mce/tiny_mce.js\"></script>\n";
			$output.="<script>
tinyMCE.init({
{$mode}
theme : \"{$theme}\",
theme_advanced_toolbar_location : \"top\",
theme_advanced_toolbar_align : \"left\"
});
</script>
";
			break;
		default:
			if (!isset($params['mode']) || empty($params['mode'])) {
				$mode = "mode : \"textareas\",";
			}else{
				$mode = "mode : \"specific_textareas\",
editor_selector : \"mceEditor\",
";
			}
			$output.="<script type=\"text/javascript\" src=\"{$base_path}scripts/tiny_mce/tiny_mce.js\"></script>\n";
			$output.="<script>
tinyMCE.init({
{$mode}
theme : \"simple\",
theme_advanced_toolbar_location : \"top\",
theme_advanced_toolbar_align : \"left\"
});
</script>
";
			break;
	}
	echo $output;
}
?>
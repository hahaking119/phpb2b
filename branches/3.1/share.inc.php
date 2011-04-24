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
 * @version $Id: share.inc.php 462 2009-12-27 03:20:41Z steven $
 */
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'template.site.inc.php');
if (!empty($_PB_CACHE['setting']['main_cache'])) {
	if ($_PB_CACHE['setting']['main_cache_lifetime']>0) {
		$smarty->caching = 2;
		$smarty->cache_lifetime = $_PB_CACHE['setting']['main_cache_lifetime'];
		if ($_PB_CACHE['setting']['main_cache_check']) {
			$smarty->compile_check = true;
		}
	}
}
$smarty->flash_layout = $theme_name."/flash";
$smarty->assign("theme_img_path", "templates/".$theme_name."/");
$smarty->assign('ThemeName', $theme_name);
$smarty->setCompileDir("template".DS.$theme_name.DS);
if (!empty($arrTemplate)) {
    $smarty->assign($arrTemplate);
}
?>
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
 * @version $Id: typemodel.inc.php 420 2009-12-26 13:37:06Z cht117 $
 */
function get_cache_key_unique($type_cachenames, $val)
{
	require(CACHE_PATH. "type_".$type_cachenames.".php");
	$tmp_keys = array_keys($_PB_CACHE[$type_cachenames]);
	return intval(array_search($val, $tmp_keys));
}

function get_cache_type($cache_name, $key = NULL, $addParams = '')
{
	require(CACHE_PATH. "type_".$cache_name.".php");
	if (!empty($addParams)) {
		if (is_array($addParams)) {
			foreach ($addParams as $val) {
				unset($_PB_CACHE[$cache_name][$val]);
			}
		}else{
			unset($_PB_CACHE[$cache_name][$addParams]);
		}
	}
	if (!is_null($key)) {
		return $_PB_CACHE[$cache_name][$key];
	}else{
		return $_PB_CACHE[$cache_name];
	}
}
?>
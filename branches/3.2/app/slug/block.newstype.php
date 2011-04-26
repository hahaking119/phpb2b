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
 * @version $Id: block.newstype.php 330 2010-02-09 07:50:47Z stevenchow811@163.com $
 */
function smarty_block_newstype($params, $content, &$smarty) {
	global $cookiepre;
	if ($content === null) return;
	require(CACHE_PATH. "cache_newstype.php");
	if(isset($params['id'])){
		$title = $_PB_CACHE['newstype'][$params['id']];
	}
	$return = null;
	if (!empty($title)) {
		$url = "news/list.php?typeid=".$params['id'];
		$return.= str_replace(array("[field:title]", "[field:id]", "[link:title]"), array($title, $params['id'], $url), $content);
	}else{
		$return.= L("unknown", "tpl");
	}
	return $return;
}
?>
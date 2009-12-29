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
 * @version $Id: block.userpage.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_block_userpage($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = array();
	if (!class_exists("Userpages")) {
		uses("userpage");
		$userpage = new Userpages();
	}else{
	    $userpage = new Userpages();
	}
	require(CACHE_PATH. "cache_userpage.php");
	$result = $_PB_CACHE['userpage'];
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$url = ($rewrite_able)? "page/".$result[$i]['name'].".html":$result[$i]['url'];			
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:tip]"), array($url, $result[$i]['title'], $result[$i]['digest']), $content);
		}
	}
	return $return;
}
?>
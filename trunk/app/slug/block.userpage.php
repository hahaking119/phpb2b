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
function smarty_block_userpage($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = array();
	if (!class_exists("Userpages")) {
		uses("userpage");
		$userpage = new Userpages();
		$userpage_controller = new Userpage();
	}else{
	    $userpage = new Userpages();
		$userpage_controller = new Userpage();
	}
	require(CACHE_PATH. "cache_userpage.php");
	$result = $_PB_CACHE['userpage'];
	if (isset($params['exclude'])) {
		if (strpos($params['exclude'], ",")>0) {
			$tmp_str = explode(",", $params['exclude']);
			if (!empty($tmp_str)) {
				foreach ($tmp_str as $id_val) {
					unset($result[$id_val]);
				}
			}
		}else{
			unset($params['exclude']);
		}
	}
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (!empty($result[$i]['url'])) {
				$url = $result[$i]['url'];
			}else{
				if ($rewrite_able) {
					$url = "page/".$result[$i]['name'].".html";
				}else{
					$url = "page.php?name=".$result[$i]['name'];
				}
			}
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:tip]"), array($url, $result[$i]['title'], $result[$i]['digest']), $content);
		}
	}
	return $return;
}
?>
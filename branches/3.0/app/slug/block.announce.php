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
 * @version $Id: block.announce.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_block_announce($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = array();
	$datas = require(CACHE_PATH. "announce.php");
	if (!class_exists("Announcements")) {
		uses("announcement");
		$announce = new Announcements();
	}else{
	    $announce = new Announcements();
	}
	$i_count = 1;
	if (isset($params['row'])) {
		$i_count = intval($params['row']);
	}
	if (isset($params['type'])) {
		if ($params['type']=="new") {
			$result = $announce->findAll("id,subject AS title,message AS content", null, null, "id DESC", 0, 1);
		}
	}else{
		$result = $datas;
	}
	$return = null;
	if (!empty($result)) {
		for ($i=0; $i<$i_count; $i++){
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}		
	    	if (isset($params['infolen'])) {
	    		$result[$i]['content'] = utf_substr($result[$i]['content'], $params['infolen']);
	    	}
			$url = ($rewrite_able)? "announce/detail/".$result[$i]['id'].".html":"announce.php?id=".$result[$i]['id'];	
			if(!empty($result[$i]['title'])) $return.= str_replace(array("[link:title]", "[field:title]", "[field:style]", "[field:content]"), array($url, $result[$i]['title'], $result[$i]['style'], $result[$i]['content']), $content);
		}
	}else{
		return;
	}
	return $return;
}
?>
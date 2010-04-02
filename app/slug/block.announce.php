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
 * @version $Id: block.announce.php 330 2010-02-09 07:50:47Z stevenchow811@163.com $
 */
function smarty_block_announce($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	$datas = require(CACHE_PATH. "announce.php");
	if (!class_exists("Announcements")) {
		uses("announcement");
		$announce = new Announcements();
		$announce_controller = new Announcement();
	}else{
	    $announce = new Announcements();
		$announce_controller = new Announcement();
	}
	$i_count = 1;
	if (isset($params['row'])) {
		$i_count = intval($params['row']);
	}
	if (isset($params['typeid'])) {
		$conditions[] = "announcetype_id=".$params['typeid'];
	}
	if (isset($params['type'])) {
		if ($params['type']=="new") {
			$result = $announce->findAll("id,subject AS title,message AS content", null, null, "id DESC", 0, 1);
		}else{
			$result = $datas;
		}
	}else{
		$result = $datas;
	}
	$return = $style = null;
	if (!empty($result)) {
		for ($i=0; $i<$i_count; $i++){
			$result[$i]['title'] = strip_tags($result[$i]['title']);
			$result[$i]['content'] = strip_tags($result[$i]['content']);
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}		
	    	if (isset($params['infolen'])) {
	    		$result[$i]['content'] = utf_substr($result[$i]['content'], $params['infolen']);
	    	}
			$url = $announce_controller->rewrite($result[$i]['id'], $result[$i]['title']);
			if(!empty($result[$i]['title'])) $return.= str_replace(array("[link:title]", "[field:title]", "[field:content]"), array($url, $result[$i]['title'], $result[$i]['content']), $content);
		}
	}else{
		return;
	}
	return $return;
}
?>
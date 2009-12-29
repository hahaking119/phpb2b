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
 * @version $Id: block.fair.php 472 2009-12-27 04:12:35Z steven $
 */
function smarty_block_fair($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = $orderby = array();
	require(CACHE_PATH."cache_expotype.php");
	require(CACHE_PATH."cache_area.php");
	if (class_exists("Expoes")) {
		$fair = new Expoes();
	}else{
		uses("expo");
		$fair = new Expoes();
	}
	$conditions[] = "status=1";
	if (isset($params['id'])) {
		$conditions[] = "id=".$params['id'];
	}
	if(isset($params['type'])) {
		$type = explode(",", $params['type']);
		$type = array_unique($type);
		foreach ($type as $val) {
			switch ($val) {
				case 'image':
					$conditions[] = "picture!=''";
					break;
				case 'commend':
					$conditions[] = "if_commend='1'";
					break;
				case 'hot':
					$orderby[] = "hits DESC";
				default:
					break;
			}
		}
	}
	if (isset($params['typeid'])) {
		$conditions[] = "expotype_id=".$params['typeid'];
	}
	if(isset($params['expday'])){
		$conditions[] = "end_time<'".($params['expday']*86400+$fair->time_stamp)."'";
	}
	if(isset($params['subday'])){
		$conditions[] = "begin_time>'".($fair->time_stamp-$params['subday']*86400)."'";
	}
	if (isset($params['orderby'])) {
		$orderby[] = trim($params['orderby']);
	}else{
		$orderby[] = "id DESC";
	}
	$fair->setOrderby($orderby);
	$fair->setCondition($conditions);
	$row = $col = 0;
	$orderby = null;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$fair->setLimitOffset($row, $col);
	$sql = "SELECT id,name,name as title,description,expotype_id,begin_time,end_time,area_id1,area_id2,area_id3 FROM {$fair->table_prefix}expoes ".$fair->getCondition().$fair->getOrderby().$fair->getLimitOffset();
	$result = $fair->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$url = ($rewrite_able)? "fair/detail/".$result[$i]['id'].".html":"fair/detail.php?id=".$result[$i]['id'];
			if (isset($params['titlelen'])) {
	    		$result[$i]['name'] = utf_substr($result[$i]['name'], $params['titlelen']);
	    	}
	    	$result[$i]['description'] = strip_tags($result[$i]['description']);		
	    	if (isset($params['infolen'])) {
	    		$result[$i]['description'] = utf_substr($result[$i]['description'], $params['infolen']);
	    	}
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:fulltitle]", "[field:id]", "[field:areaname]", "[field:areaid]", "[field:typename]", "[field:typeid]", "[field:pubdate]", "[field:content]"), array($url, $result[$i]['name'], $result[$i]['title'], $result[$i]['id'], $_PB_CACHE['area'][1][$result[$i]['area_id1']], $result[$i]['area_id1'], $_PB_CACHE['expotype'][$result[$i]['expotype_id']], $result[$i]['expotype_id'], @date("Y-m-d", $result[$i]['begin_time']), $result[$i]['description']), $content);
		}
	}
	return $return;
}
?>
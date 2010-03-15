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
 * @version $Id: block.fair.php 1037 2010-02-26 02:53:29Z steven $
 */
function smarty_block_fair($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = $orderby = array();
	require(CACHE_PATH."cache_expotype.php");
	require(CACHE_PATH."cache_area.php");
	if (class_exists("Expoes")) {
		$fair = new Expoes();
		$fair_controller = new Expo();
	}else{
		uses("expo");
		$fair_controller = new Expo();
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
	$sql = "SELECT *,name AS title FROM {$fair->table_prefix}expoes ".$fair->getCondition().$fair->getOrderby().$fair->getLimitOffset();
	$result = $fair->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$style = $h3_style = $area_name = $link_title = null;
			$url = $fair_controller->rewrite($result[$i]['id'], $result[$i]['title']);
			$link_title = "<a href='".$url."'>".$result[$i]['name']."</a>";
			if (isset($params['titlelen'])) {
	    		$result[$i]['name'] = utf_substr($result[$i]['name'], $params['titlelen']);
	    	}
	    	$result[$i]['description'] = strip_tags($result[$i]['description']);		
	    	if (isset($params['infolen'])) {
	    		$result[$i]['description'] = utf_substr($result[$i]['description'], $params['infolen']);
	    	}
	    	if (!$result[$i]['begin_time']) {
	    		$pubdate = L("invalid_datetime");
	    	}else{
	    		$pubdate = @date("Y-m-d", $result[$i]['begin_time']);
	    	}
	    	$img = (empty($result[$i]['picture']))?pb_get_attachmenturl('', '', 'small'):pb_get_attachmenturl($result[$i]['picture'], '', 'small');
	    	if (isset($params['magic']))  {
	    		if ($i==0) {
	    			if(!empty($result[$i]['picture'])){
	    				$style = " style=\"height:70px; background:url(".URL."attachment/".$result[$i]['picture'].".small.jpg".") no-repeat; padding:0 0 0 90px; overflow:hidden; width:120px;\"";
	    				$h3_style = " style=\"padding:0 0 0 5px;\"";
	    			}
	    			$link_title = "<h3".$h3_style."><a href='{$url}'>".$result[$i]['name']."</a></h3>".$result[$i]['description'];
	    		}
			}
			if (!empty($_PB_CACHE['area'][1][$result[$i]['area_id1']])) {
				$area_name = $_PB_CACHE['area'][1][$result[$i]['area_id1']];
			}
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:fulltitle]", "[field:id]", "[field:areaname]", "[field:areaid]", "[field:typename]", "[field:typeid]", "[field:pubdate]", "[field:content]","[field:style]", "[field:url]", "[img:src]"), array($url, $result[$i]['name'], $result[$i]['title'], $result[$i]['id'], $area_name, $result[$i]['area_id1'], $_PB_CACHE['expotype'][$result[$i]['expotype_id']], $result[$i]['expotype_id'], $pubdate, $result[$i]['description'],$style, $link_title, $img), $content);
		}
	}
	return $return;
}
?>
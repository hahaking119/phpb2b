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
function smarty_block_ads($params, $content, &$smarty){
	global $theme_name;
	if ($content === null) return;
	$conditions = array();
	extract($params);
	if (!class_exists("Adses")) {
		uses("ad");
		$ad = new Adses();
	}else{
		$ad = new Adses();
	}
	$conditions[] = "status='1' AND state='1'";
	if(isset($params['id'])){
		$result = $ad->read("*", intval($params['id']));
	}else{
		//如果不够广告位，并且参数中指定了default图片，则默认“rent”
		if (isset($params['typeid'])) {
			$typeid = intval($params['typeid']);
			$conditions[] = "adzone_id=".$typeid;
			$zone_res = $ad->dbstuff->GetRow("select * from {$ad->table_prefix}adzones where id=".$typeid);
			if ($zone_res['what']==2) {
				echo stripslashes($zone_res['additional_adwords']);
				return;
			}
			$adzone_name = $zone_res['name'];
			$max_width = intval($zone_res['width']);
			$max_height = intval($zone_res['height']);
			$max_ad = intval($zone_res['max_ad']);
			unset($zone_res);
		}
		if (isset($params['keyword'])) {
			$conditions[] = "title like '%".$params['keyword']."%'";
		}
		$row = $col = 0;
		$orderby = null;
		if (isset($params['row'])) {
			$row = $params['row'];
		}elseif ($max_ad){
			$row = $max_ad;
		}
		if (isset($params['col'])) {
			$col = $params['col'];
		}
		$ad->setLimitOffset($row, $col);
		if (isset($params['orderby'])) {
			$orderby = " ORDER BY ".trim($params['orderby']);
		}else{
			$orderby = " ORDER BY priority ASC";
		}
		$ad->setCondition($conditions);
		$sql = "SELECT * FROM {$ad->table_prefix}adses ".$ad->getCondition()."{$orderby}".$ad->getLimitOffset()."";
		$result = $ad->dbstuff->GetArray($sql);
	}
	$return = null;
	if(!empty($result)){
		$count = count($result);
		for($i=0; $i<$count; $i++) {
			$url = $result[$i]['target_url'];
			if (!empty($result[$i]['end_date']) && $result[$i]['end_date']<$ad->timestamp) {
				if (!empty($result[$i]['picture_replace'])) {
					$result[$i]['source_url'] = $result[$i]['picture_replace'];
					$result[$i]['title'] = L("ads_on_sale");
					$return .= str_replace(array("[link:url]", "[field:src]", "[field:title]"), array($url, $ad->getCode($result[$i], $max_width, $max_height), $result[$i]['title']), $content);
				}
			}else{
				$return .= str_replace(array("[link:url]", "[field:src]", "[field:title]"), array($url, $ad->getCode($result[$i], $max_width, $max_height), $result[$i]['title']), $content);
			}
		}
	}else{
		$return = $adzone_name;
	}
	return $return;
}
?>
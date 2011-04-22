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
 * @version $Id: block.offer.php 472 2009-12-27 04:12:35Z steven $
 */
function smarty_block_offer($params, $content, &$smarty, &$repeat) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions[] = "t.status='1'";
	if (!class_exists("Trades")) {
		uses("trade");
		$trade = new Trades();
		$trade_controller = new Trade();
	}else{
	    $trade = new Trades();
	    $trade_controller = new Trade();
	}
	if (isset($params['type'])) {
		$type = explode(",", $params['type']);
		$type = array_unique($type);
		foreach ($type as $val) {
			switch ($val) {
				case 'image':
					$conditions[] = "t.picture!=''";
					break;
				case 'buy':
					$offer_keys = $trade_controller->getTradeTypeKeys("buy");
					$conditions[] = "t.type_id in ".$offer_keys;
				case 'sell':
					$offer_keys = $trade_controller->getTradeTypeKeys("sell");
					$conditions[] = "t.type_id in ".$offer_keys;
				case 'urgent':
					$conditions[] = "t.if_urgent='1'";
					break;
				case 'company':
					$conditions[] = "t.company_id>0";
				case 'commend':
					$conditions[] = "t.if_commend=1";
					break;
				default:
					break;
			}
		}
	}
	if(isset($params['expday'])){
		$conditions[] = "t.expire_time<'".($params['expday']*86400+$trade->timestamp)."'";
	}
	if(isset($params['subday'])){
		$conditions[] = "t.submit_time>'".($trade->timestamp-$params['expireday']*86400)."'";
	}
	if (isset($params['typeid'])) {
		$conditions[] = "t.type_id='".$params['typeid']."'";
	}
	if (isset($params['urgent'])) {
		$conditions[] = "t.if_urgent='1'";
	}
	if (isset($params['memberid'])) {
		$conditions[] = "t.member_id='".$params['memberid']."'";
	}
	if (isset($params['cash'])) {
		$conditions[] = "t.require_point>0";
	}
	$trade->setCondition($conditions);
	$row = $col = 0;
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY modified DESC,id DESC ";
	}
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$trade->setLimitOffset($row, $col);
	$sql = "SELECT id,type_id,title as fulltitle,title,content,content as fullcontent,created,submit_time,picture FROM {$trade->table_prefix}trades t ".$trade->getCondition()."{$orderby}".$trade->getLimitOffset();
	$result = $trade->dbstuff->GetArray($sql);
	$return = null;
	$offer_typenames = $trade_controller->getTradeTypes();	
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$style = null;
			$dt = @getdate($result[$i]['created']);
			$url = ($rewrite_able)? "offer/detail/".$result[$i]['id'].".html":"offer/detail.php?id=".$result[$i]['id'];
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}		
	    	if (isset($params['infolen'])) {
	    		$result[$i]['content'] = utf_substr($result[$i]['content'], $params['infolen']);
	    	}
	    	if (isset($params['magic']))  {
	    		if ($i==0) {
	    			if(!empty($result[$i]['picture'])){
	    			$style = " style=\"height:70px; background:url(".URL."attachment/".$result[$i]['picture'].".small.jpg".") no-repeat; padding:0 0 0 90px; overflow:hidden; width:120px;\"";
	    			}
	    			$result[$i]['url'] = "<h3><a href='{$url}'>".$result[$i]['title']."</a></h3>
				   <p>".$result[$i]['content']."</p>";
	    		}else{
	    			$result[$i]['url'] = "<a href='{$url}'>".$result[$i]['title']."</a>";
	    		}
			}
			$return.= str_replace(array("[field:title]", "[field:fulltitle]","[field:typename]", "[link:title]", "[filed:id]", "[field:pubdate]", "[img:thumb]", "[img:src]", "[field:content]", "[field:style]", "[field:url]", "[field:typeid]"), array($result[$i]['title'], $result[$i]['fulltitle'],$offer_typenames[$result[$i]['type_id']], $url, $result[$i]['id'], @date("m/d", $result[$i]['submit_time']), "attachment/".$result[$i]['picture'].".small.jpg", "attachment/".$result[$i]['picture'], $result[$i]['content'], $style, $result[$i]['url'], $result[$i]['type_id']), $content);
		}
	}
	return $return;
}
?>
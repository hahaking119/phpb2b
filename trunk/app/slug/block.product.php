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
 * @version $Id: block.product.php 330 2010-02-09 07:50:47Z stevenchow811@163.com $
 */
function smarty_block_product($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (class_exists("Products")) {
		$product = new Products();
		$product_controller = new Product();
	}else{
		uses("product");
		$product = new Products();
		$product_controller = new Product();
	}
	$conditions[] = "p.status=1 AND p.state=1";
	if(isset($params['type'])) {
		$type = explode(",", $params['type']);
		$type = array_unique($type);
		foreach ($type as $val) {
			switch ($val) {
				case 'image':
					$conditions[] = "p.picture!=''";
					break;
				case 'commend':
					$conditions[] = "p.ifcommend='1'";
					break;
				default:
					break;
			}
		}
	}
	if (isset($params['state'])) {
		$conditions[] ="p.state='".intval($params['state'])."'";
	}
	if (isset($params['companyid'])) {
		$conditions[] = "p.company_id=".$params['companyid'];
	}
	if (isset($params['memberid'])) {
		$conditions[] = "p.member_id=".$params['memberid'];
	}
	if (isset($params['sortid'])) {
		$conditions[] = "p.sort_id='".$params['sortid']."'";
	}
	if (isset($params['typeid'])) {
		$conditions[] = "p.producttype_id=".$params['typeid'];
	}	
	if (!empty($params['industryid'])) {
		$conditions[] = "p.industry_id1='".$params['industryid']."' OR p.industry_id2='".$params['industryid']."' OR p.industry_id3='".$params['industryid']."'";
	}
	if (!empty($params['areaid'])) {
		$conditions[] = "p.area_id1='".$params['areaid']."' OR p.area_id2='".$params['areaid']."' OR p.area_id3='".$params['areaid']."'";
	}
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC ";
	}
	$product->setCondition($conditions);
	$row = $col = 0;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$product->setLimitOffset($row, $col);
	$sql = "SELECT p.id as productid,p.id,p.name as productname,p.name,price,picture,price,created,cache_companyname as companyname FROM {$product->table_prefix}products p ".$product->getCondition()."{$orderby}".$product->getLimitOffset();
	$result = $product->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$url = $product_controller->rewrite($result[$i]['productid'], $result[$i]['productname']);
			if (isset($params['titlelen'])) {
	    		$result[$i]['productname'] = utf_substr($result[$i]['productname'], $params['titlelen']);
	    		$result[$i]['companyname'] = utf_substr($result[$i]['companyname'], $params['titlelen']);
	    	}			
			$return.= str_replace(array("[link:title]", "[field:title]", "[img:src]", "[field:fulltitle]", "[field:pubdate]", "[field:id]", "[img:thumb]", "[field:company]"), array($url, $result[$i]['productname'], "attachment/".$result[$i]['picture'].".small.jpg", $result[$i]['productname'], @date("m/d", $result[$i]['created']), $result[$i]['productid'], "attachment/".$result[$i]['picture'].".small.jpg", $result[$i]['companyname']), $content);
			if (isset($params['col'])) {
				if ($i%$params['col']==0) {
					$return.="<br />";
				}
			}
		}
	}
	return $return;
}
?>
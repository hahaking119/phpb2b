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
 * @version $Id: block.product.php 472 2009-12-27 04:12:35Z steven $
 */
function smarty_block_product($params, $content, &$smarty) {
	if ($content === null) return;
	global $rewrite_able;
	$conditions = array();
	if (class_exists("Products")) {
		$product = new Products();
	}else{
		uses("product");
		$product = new Products();
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
	$sql = "SELECT p.id as productid,p.id,p.name as productname,p.name,picture,created,cache_companyname as companyname FROM {$product->table_prefix}products p ".$product->getCondition()."{$orderby}".$product->getLimitOffset();
	$result = $product->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$url = ($rewrite_able)? "product/detail/".$result[$i]['productid'].".html":"product/content.php?id=".$result[$i]['productid'];
			if (isset($params['titlelen'])) {
	    		$result[$i]['productname'] = utf_substr($result[$i]['productname'], $params['titlelen']);
	    		$result[$i]['companyname'] = utf_substr($result[$i]['companyname'], $params['titlelen']);
	    	}			
			$return.= str_replace(array("[link:title]", "[field:title]", "[img:src]", "[field:fulltitle]", "[field:pubdate]", "[field:id]", "[img:thumb]", "[field:company]"), array($url, $result[$i]['productname'], "attachment/".$result[$i]['picture'].".small.jpg", $result[$i]['productname'], @date("m/d", $result[$i]['created']), $result[$i]['productid'], "attachment/".$result[$i]['picture'].".small.jpg", $result[$i]['companyname']), $content);
		}
	}
	return $return;
}
?>
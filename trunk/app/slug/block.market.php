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
function smarty_block_market($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (class_exists("Markets")) {
		$market = new Markets();
		$market_controller = new Market();
	}else{
		uses("market");
		$market = new Markets();
		$market_controller = new Market();
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
					$conditions[] = "ifcommend='1'";
					break;
				default:
					break;
			}
		}
	}	
	if (isset($params['id'])) {
		$conditions[] = "id=".$params['id'];
	}
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC";
	}
	$market->setCondition($conditions);
	$row = $col = 0;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$market->setLimitOffset($row, $col);
	$sql = "SELECT id,name,name as fullname,picture FROM {$market->table_prefix}markets ".$market->getCondition()."{$orderby}".$market->getLimitOffset();
	$result = $market->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
	    	$url = $market_controller->rewrite($result[$i]['id'], $result[$i]['name']);
			if (isset($params['titlelen'])) {
	    		$result[$i]['name'] = utf_substr($result[$i]['name'], $params['titlelen']);
	    	}
			$return.= str_replace(array("[field:title]", "[field:fulltitle]", "[field:id]", "[link:title]", "[img:src]"), array($result[$i]['name'], $result[$i]['fullname'], $result[$i]['id'], $url, "attachment/".$result[$i]['picture'],), $content);
		}
	}
	return $return;
}
?>
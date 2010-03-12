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
function smarty_block_tag($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (!class_exists("Keywords")) {
		uses("keyword");
		$keyword = new Keywords();
		$keyword_controller = new Keyword();
	}else{
		$keyword = new Keywords();
		$keyword_controller = new Keyword();
	}
	$conditions[] = "status=1";
	if (isset($params['typeid'])) {
	        $conditions[] = "type='".intval($params['typeid'])."'";
	}
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC";
	}
	$keyword->setCondition($conditions);
	$row = $col = 0;
	$orderby = null;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$keyword->setLimitOffset($row, $col);
	$sql = "SELECT id,title,title as fulltitle FROM {$keyword->table_prefix}jobs ".$keyword->getCondition()."{$orderby}".$keyword->getLimitOffset();
	$result = $keyword->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}
	    	$url = $keyword_controller->rewrite($result[$i]['id'], $result[$i]['title']);
			$return.= str_replace(array("[field:title]", "[field:fulltitle]", "[field:id]", "[link:title]"), array($result[$i]['title'], $result[$i]['fulltitle'], $result[$i]['id'], $url), $content);
		}
	}
	return $return;
}
?>
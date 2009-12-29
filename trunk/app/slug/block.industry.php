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
 * @version $Id: block.industry.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_block_industry($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (class_exists("Industries")) {
		$industry = new Industries();
	}else{
		uses("industry");
		$industry = new Industries();
	}
	if(isset($params['typeid'])) {
		$conditions[] = "indusrytype_id=".$params['typeid'];
	}
	if (isset($params['id'])) {
		$conditions[] = "id=".$params['id'];
	}
	if (isset($params['topid'])) {
		$conditions[] = "top_parentid='".$params['topid']."'";
	}
	if (isset($params['level'])) {
		$conditions[] = "level=".$params['level'];
	}
	if (isset($params['parentid'])) {
		$conditions[] = "parent_id='".$params['parentid']."'";
	}
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY level ASC,id ASC";
	}
	$industry->setCondition($conditions);
	$row = $col = 0;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$limit = $industry->setLimitOffset($row, $col);
	if (!isset($params['row']) && !isset($params['col'])) {
		$limit = null;
	}
	$sql = "SELECT id,name,name as industryname,highlight FROM {$industry->table_prefix}industries i ".$industry->getCondition()."{$orderby}{$limit}";
	$result = $industry->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (isset($params['titlelen'])) {
	    		$result[$i]['name'] = utf_substr($result[$i]['name'], $params['titlelen']);
	    	}
			$return.= str_replace(array("[field:title]", "[field:fulltitle]", "[field:id]", "[field:style]"), array($result[$i]['name'], $result[$i]['industryname'], $result[$i]['id'], parse_highlight($result[$i]['highlight'])), $content);
		}
	}
	return $return;
}
?>
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
 * @version $Id: block.help.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_block_help($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (class_exists("Helps")) {
		$help = new Helps();
	}else{
		uses("help");
		$help = new Helps();
	}
	if(isset($params['typeid'])) {
		$conditions[] = "helptype_id=".$params['typeid'];
	}
	if (isset($params['id'])) {
		$conditions[] = "id=".$params['id'];
	}
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC";
	}
	$help->setCondition($conditions);
	$row = $col = 0;
	$orderby = null;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$help->setLimitOffset($row, $col);
	$sql = "SELECT id,title,title as fulltitle,highlight FROM {$help->table_prefix}helps ".$help->getCondition()."{$orderby}".$help->getLimitOffset()."";
	$result = $help->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}
			$return.= str_replace(array("[field:title]", "[field:fulltitle]", "[field:id]", "[field:style]"), array($result[$i]['title'], $result[$i]['fulltitle'], $result[$i]['id'], parse_highlight($result[$i]['highlight'])), $content);
		}
	}
	return $return;
}
?>
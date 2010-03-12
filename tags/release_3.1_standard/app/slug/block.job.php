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
function smarty_block_job($params, $content, &$smarty) {
	if ($content === null) return;
	$conditions = array();
	if (class_exists("Jobs")) {
		$job = new Jobs();
	}else{
		uses("job");
		$job = new Jobs();
	}
	if(isset($params['companyid'])) {
		$conditions[] = "company_id=".$params['companyid'];
	}
	if(isset($params['memberid'])) {
		$conditions[] = "member_id=".$params['memberid'];
	}	
	if (isset($params['id'])) {
		$conditions[] = "j.id=".$params['id'];
	}
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC";
	}
	$job->setCondition($conditions);
	$row = $col = 0;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$job->setLimitOffset($row, $col);
	$sql = "SELECT j.id,j.name,j.name as fullname,c.name AS companyname,c.cache_spacename AS userid FROM {$job->table_prefix}jobs j LEFT JOIN {$job->table_prefix}companies c ON c.id=j.company_id ".$job->getCondition()."{$orderby}".$job->getLimitOffset();
	$result = $job->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (isset($params['titlelen'])) {
	    		$result[$i]['name'] = utf_substr($result[$i]['name'], $params['titlelen']);
	    	}
	    	$url = "space.php?do=hr&userid=".$result[$i]['userid'];
			$return.= str_replace(array("[field:title]", "[field:fulltitle]", "[field:id]", "[field:companyname]", "[link:title]"), array($result[$i]['name'], $result[$i]['fullname'], $result[$i]['id'], $result[$i]['companyname'], $url), $content);
		}
	}
	return $return;
}
?>
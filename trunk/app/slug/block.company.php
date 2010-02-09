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
 * @version $Id: block.company.php 490 2009-12-28 02:06:51Z steven $
 */
function smarty_block_company($params, $content, &$smarty) {
	global $cookiepre, $theme_name, $subdomain_support, $rewrite_able;
	if ($content === null) return;
	$conditions = array();
	require(CACHE_PATH."cache_area.php");
	require(CACHE_PATH."cache_membergroup.php");
	if (class_exists("Companies")) {
		$company = new Companies();
		$company_controller = new Company();
	}else{
	    uses("company");
	    $company = new Companies();
		$company_controller = new Company();
	}
	if (class_exists("Members")) {
		$member = new Members();
	}else{
	    uses("member");
	    $member = new Members();
	}	
	$conditions[] = "c.status=1";
	if(isset($params['type'])) {
		$type = explode(",", $params['type']);
		$type = array_unique($type);
		foreach ($type as $val) {
			switch ($val) {
				case 'image':
					$conditions[] = "c.picture!=''";
					break;
				case 'commend':
					$conditions[] = "c.if_commend='1'";
					break;
				case 'hot':
					break;
				default:
					break;
			}
		}
	}
	if (isset($params['typeid'])) {
		$conditions[] = "c.type_id=".$params['typeid'];
	}
	if (isset($params['id'])) {
		$conditions[] = "c.id=".$params['id'];
	}
	if(isset($params['industryid'])){
		$industry_id = intval($params['industryid']);
		if($industry_id) $conditions[] = "c.industry_id1=".$industry_id;
	}
	if(isset($params['areaid'])){
		$area_id = intval($params['areaid']);
		if($area_id) $conditions[] = "c.area_id1=".$area_id;
	}
	if (isset($params['groupid'])) {
		$conditions[] = "c.cache_membergroup_id=".$params['groupid'];
	}
	$company->setCondition($conditions);
	$row = $col = 0;
	$orderby = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY id DESC ";
	}
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$company->setLimitOffset($row, $col);
	$sql = "SELECT c.id,c.id as companyid,c.name,c.name as companyname,cache_spacename as userid,area_id1,area_id2,area_id3,c.picture,c.created,c.description,c.cache_membergroupid FROM {$company->table_prefix}companies c ".$company->getCondition()."{$orderby}".$company->getLimitOffset()."";
	$result = $company->dbstuff->GetArray($sql);
	$return = $avatar = $logo = $area_name = $group_name = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			if (!empty($result[$i]['userid'])) {
				$url = $company_controller->rewrite($result[$i]['userid']);
			}else{
				$url = "###";
			}
			if (isset($params['titlelen'])) {
	    		$result[$i]['companyname'] = utf_substr($result[$i]['companyname'], $params['titlelen']);
	    	}
	    	if (!empty($result[$i]['cache_membergroupid'])) {
	    		$avatar = "images/group/".$_PB_CACHE['membergroup'][$result[$i]['cache_membergroupid']]['avatar'];
	    	}
	    	if (!empty($result[$i]['picture'])) {
				$logo = pb_get_attachmenturl($result[$i]['picture'], '', 'small');
	    	}
	    	if (!empty($_PB_CACHE['area'][2][$result[$i]['area_id2']])) {
	    		$area_name = $_PB_CACHE['area'][2][$result[$i]['area_id2']];
	    	}
	    	if (!empty($_PB_CACHE['membergroup'][$result[$i]['cache_membergroupid']]['name'])) {
	    		$group_name = $_PB_CACHE['membergroup'][$result[$i]['cache_membergroupid']]['name'];
	    	}
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:name]", "[field:fulltitle]", "[field:id]", "[field:area2]", "[field:areaid]", "[field:groupname]", "[field:groupavatar]", "[img:logo]"), array($url, $result[$i]['companyname'], $result[$i]['name'], $result[$i]['name'], $result[$i]['id'], $area_name, $result[$i]['area_id2'], $group_name, $avatar, $logo), $content);
		}
	}
	return $return;
}
?>
<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on 
 * the Program, and are irrevocable provided the stated conditions are met. This 
 * License explicitly affirms your unlimited permission to run the unmodified Program. 
 * The output from running a covered work is covered by this License only if the 
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:41:24 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.ul_get_company.php 426 2009-06-22 14:04:32Z stevenchow811 $
 */
function smarty_function_company($params){
	global $g_db, $subdomain_support, $config_subdomain;
	global $smarty, $theme_name, $cookiepre;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.default.html";
	extract($params);
	require(DATA_PATH.$cookiepre."area.inc.php");
	if (class_exists("Companies")) {
		$company = new Companies();
	}else{
	    uses("company");
	    $company = new Companies();
	}
	if (class_exists("Members")) {
		$member = new Members();
	}else{
	    uses("member");
	    $member = new Members();
	}
	$conditions[] = "Company.status=1";
	$fields = "Company.id as Id, Company.name as LinkTitle,Member.username as LinkId,Company.city_code_id as CityCodeId";
	if(isset($params['id'])){
		$result = $news->read($fields, intval($params['id']));
	}else{
		if (isset($params['type_id'])) {
			$conditions[] = "Company.type_id=".$params['type_id'];
		}
		if(isset($params['province_id'])){
			$conditions[] = "Company.province_code_id=".$params['province_id'];
		}
		if(isset($params['city_id'])){
			$conditions[] = "Company.city_code_id=".$params['city_id'];
		}
		if (isset($params['commend'])) {
			$conditions[] = "Company.if_commend=1";
		}
		if (isset($params['member_type'])) {
			$conditions[] = "Member.user_type=".$params['member_type'];
		}
		if (isset($params['orderby'])) {
			$orderby = " order by Company.".trim($params['orderby']);
		}else{
		    $orderby = " order by Company.id desc";
		}
		$company->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$company->getTable(true)." left join ".$member->getTable(true)." on Company.member_id=Member.id where ".$tmp_cond.$orderby.$company->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    if(!$subdomain_support){
			if(PRETEND_HTML_LEVEL==0){
		        $url = URL."space.php?userid=".$result[$i]['LinkId'];
			}else{
		        $url = URL."member/".$result[$i]['LinkId']."/";
			}
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = "http://".$result[$i]['LinkId'].$config_subdomain."/";
	    }
	    $area_name = "";
	    if (!isset($params['showarea'])) {
	        $area_name = "[".$UL_DBCACHE_AREAS[$result[$i]['CityCodeId']]."]";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:typename]"), array($url, utf_substr($result[$i]['LinkTitle'],24), $area_name), $op);
	    //$output.=$company->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>
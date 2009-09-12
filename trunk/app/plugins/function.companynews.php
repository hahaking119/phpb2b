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
 * @package phpb2b.app.plugins
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:42:01 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.news.php 8 2009-08-21 03:11:00Z stevenchow811@163.com $
 */
function smarty_function_companynews($params){
	global $g_db;
	global $smarty, $theme_name, $cookiepre, $tb_prefix;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"blocks/".$params['templet'].".html":"blocks/default.html";
	extract($params);
	if (class_exists("Companynews")) {
		$companynews = new Companynewses();
	}else{
	    uses("Companynews");
	    $companynews = new Companynewses();
	}
	$conditions[] = "Companynews.status='1'";
	$fields = "Companynews.id as LinkId,Companynews.company_id as CompanyId,Companynews.member_id as MemberId,title as LinkTitle";
	if(isset($params['id'])){
		$result = $companynews->read($fields, intval($params['id']));
	}else{
		if(isset($params['company_id'])){
			$conditions[] = "Companynews.company_id=".$params['company_id'];
		}
		if(isset($params['member_id'])){
			$conditions[] = "Companynews.member_id=".$params['member_id'];
		}
		if (isset($params['orderby'])) {
			$orderby = " order by ".trim($params['orderby']);
		}else{
		    $orderby = " order by Companynews.id desc";
		}
		$companynews->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields.",Company.name as CompanyName from ".$companynews->getTable(true)." left join {$tb_prefix}companies Company on Companynews.company_id=Company.id where ".$tmp_cond.$orderby.$companynews->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
		$url = URL."space.php?do=news&id=".$result[$i]['CompanyId'];
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:typename]"), array($url, utf_substr($result[$i]['LinkTitle'],24), $result[$i]['CompanyName']), $op);
	    //$output.=$company->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>
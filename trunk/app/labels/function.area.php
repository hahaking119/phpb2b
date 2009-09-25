<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 PHPB2B (http://www.phpb2b.com/)
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
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:41:17 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.area.php 106 2009-09-12 15:11:07Z stevenchow811@163.com $
 */
function smarty_function_area($params){
	global $g_db, $tb_prefix;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"blocks/".$params['templet'].".html":"blocks/area.html";
	extract($params);
	$fields = "name as LinkTitle,member_id as MemberId,company_id as CompanyId,id as LinkId,created as CreateDate";
	if(isset($params['id'])){
		$result = $job->read($fields, intval($params['id']));
	}else{
	    if (isset($params['member_id'])) {
	       $conditions[] = "Job.member_id=".$params['member_id'];
	    }
	    if (isset($params['company_id'])) {
	    	$conditions[] = "Job.company_id=".$params['company_id'];
	    }
		$job->setLimit($params['row'], $params['col'], $params['max']);
		if (isset($params['orderby'])) {
			$orderby = " order by Job.".trim($params['orderby']);
		}
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$job->getTable(true)." where ".$tmp_cond.$orderby.$job->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    if(PRETEND_HTML_LEVEL==0){
			$sql = "select m.username,c.name as companyname from {$tb_prefix}members m,{$tb_prefix}companies c where m.id=".$result[$i]['MemberId']." and m.id=c.member_id limit 1";
			$user_id = $g_db->GetRow($sql);
	        $url = URL."space.php?do=hr&userid=".$user_id['username'];
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."job/".$dt['year']."/".$dt['mon']."/".$dt['mday']."/".urlencode($result[$i]['LinkTitle'])."/";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:typename]"), array($url, $result[$i]['LinkTitle'], "<a href='".URL."space.php?userid=".urlencode($user_id['username'])."'>".utf_substr($user_id['companyname'], 12)."</a>"), $op);
	    //$output.=$job->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>
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
 * @created Mon Jun 22 16:42:22 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.ul_get_tag.php 426 2009-06-22 14:04:32Z stevenchow811 $
 */
function smarty_function_tag($params){
	global $g_db,$smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.tag.html";
	extract($params);
	if (!class_exists("Keywords")) {
		uses("keyword");
		$keyword = new Keywords();
	}else{
		$keyword = new Keywords();
	}
	$fields = "title as LinkTitle,id as LinkId,created as CreateDate,type as KeywordType";
	$conditions[] = "status=1";
	if(isset($params['id'])){
		$result = $keyword->read($fields, intval($params['id']));
	}else{
	    if (isset($params['type_id'])) {
	        $conditions[] = "type='".intval($params['type_id'])."'";
	    }
		$keyword->setLimit($params['row'], $params['col'], $params['max']);
		if (isset($params['orderby'])) {
			$orderby = " order by Keyword.".trim($params['orderby']);
		}else{
		    $orderby = " order by Keyword.id desc";
		}
		if(isset($params['max'])) {
			$limit = intval($params['max']);
			$limit = " limit ".$limit;
		}else{
			$limit = " limit 8";
		}
		if (!empty($conditions)) {
			$tmp_cond = implode(" and ", $conditions);
			$tmp_cond = " where ".$tmp_cond;
		}
		$sql = "select ".$fields." from ".$keyword->getTable(true).$tmp_cond.$orderby.$keyword->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL."tag.php?type=".$result[$i]['KeywordType']."&keyword=".urlencode($result[$i]['LinkTitle']);
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."tag/".urlencode($result[$i]['LinkTitle'])."/";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[style:class]"), array($url, utf_substr($result[$i]['LinkTitle'], 6, false), "linkwhite12"), $op);
	    $output.=$op;
	}
	echo $output;
}
?>
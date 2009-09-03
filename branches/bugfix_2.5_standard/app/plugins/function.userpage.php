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
 * @created Mon Jun 22 16:42:28 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_userpage($params){
	global $g_db, $li;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.friendlink.html";
	extract($params);
	$fields = "uf as LinkTitle,id as LinkId,ug as LinkUrl,ub as LinkName";
	if (!class_exists("Userpages")) {
		uses("userpage");
		$userpage = new Userpages();
	}else{
	    $userpage = new Userpages();
	}
	if(isset($params['id'])){
		$result = $userpage->read($fields, intval($params['id']));
	}else{
		if (isset($params['col'])) {
			$col = intval($params['col']);
		}
		if (isset($params['row'])) {
			$row = intval($params['row']);
		}
		if (isset($params['orderby'])) {
			$orderby = " order by Userpage.".trim($params['orderby']);
		}else{
		    $orderby = " order by Userpage.ud asc";
		}
		$userpage->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		if (!empty($tmp_cond)) {
			$tmp_cond = " where ".$tmp_cond;
		}
		$sql = "select ".$fields." from ".$userpage->getTable(true).$tmp_cond.$orderby.$userpage->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL."page.php?q=".$result[$i]['LinkName'];
	    }else{
	        $url = URL."page/".urlencode($result[$i]['LinkTitle'])."/";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:name]"), array($url, $result[$i]['LinkTitle'], $result[$i]['LinkName']), $op);
	    //$output.=$userpage->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>
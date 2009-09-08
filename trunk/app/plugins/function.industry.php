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
 * @created Mon Jun 22 16:41:41 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_industry($params){
	global $g_db;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.default.html";
	extract($params);
	if (!class_exists("Industries")) {
		uses("industry");
		$industry = new Industries();
	}else{
	    $industry = new Industries();
	}
	$fields = "id,name";
	if(isset($params['id'])){
		$result = $industry->read($fields, intval($params['id']));
	}else{
		if (isset($params['parent_id'])) {
			$conditions[] = "parentid='".$params['parent_id']."'";
		}
		if (isset($params['type'])) {
			$cat_name = trim($params['type']);
		}else{
			//submited by hg888
		    $cat_name = "offer";
		}
		if (isset($params['orderby'])) {
			$orderby = " order by ".trim($params['orderby']);
		}
		$industry->setLimit($params['row'], $params['col'], $params['max']);
		if(!empty($conditions)) $tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$industry->getTable()." where ".$tmp_cond.$orderby.$industry->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++){
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL.$cat_name."/list.php?sid=".$result[$i]['id'];
	    }else{
	        $url = URL.$cat_name."/industry/".urlencode($result[$i]['name'])."/";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]"), array($url, $result[$i]['name']), $op);
	    //$output.=$industry->checkTerminal($i);
	    $output.=$op;
	}
	unset($result);
	echo $output;
}
?>



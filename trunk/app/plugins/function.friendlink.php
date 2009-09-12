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
 * @created Mon Jun 22 16:41:34 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_friendlink($params){
	global $g_db, $li;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"blocks/".$params['templet'].".html":"blocks/friendlink.html";
	extract($params);
	if (!class_exists("Friendlinks")) {
		uses("friendlink");
		$friendlink = new Friendlinks();
	}else{
	    $friendlink = new Friendlinks();
	}
	$conditions[] = "status=1";
	$fields = "title as LinkTitle,logo as LinkLogo,url as LinkUrl";
	if(isset($params['id'])){
		$result = $friendlink->read($fields, intval($params['id']));
	}else{
	    if (isset($params['type'])) {
	    	if ($params['type']=="image") {
	    		//image friendlink
	    		$conditions[] = "Friendlink.logo!=''";
	    		$tpl_file = "blocks/friendlink.image.html";
	    	}
	    }
		$friendlink->setLimit($params['row'], $params['col'], $params['max']);
		if (isset($params['orderby'])) {
			$orderby = " order by Friendlink.".trim($params['orderby']);
		}else{
		    $orderby = " order by Friendlink.priority asc";
		}
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$friendlink->getTable(true)." where ".$tmp_cond.$orderby;
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:img]"), array($result[$i]["LinkUrl"], $result[$i]['LinkTitle'], $result[$i]['LinkLogo']), $op);
	    //$output.=$friendlink->checkTerminal($i);
	    $output.=$op;
	    if($row>=2){
	        if($row==$i+1) $output.="<br />";
	    }
	}
	echo $output;
}
?>
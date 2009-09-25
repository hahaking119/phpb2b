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
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:41:55 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.market.php 106 2009-09-12 15:11:07Z stevenchow811@163.com $
 */
function smarty_function_market($params){
	global $g_db;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"blocks/".$params['templet'].".html":"blocks/default.html";
	extract($params);
	if (class_exists("Markets")) {
		$market = new Markets();
	}else{
		uses("market");
		$market = new Markets();
	}
	$conditions[] = "status=1";
	$fields = "name as LinkTitle,id as LinkId,picture as LinkImage,created as CreateDate";
	if(isset($params['id'])){
		$result = $market->read($fields, intval($params['id']));
	}else{
	    if (isset($params['type'])) {
	    	if ($params['type']=="image") {
	    		//image Market
	    		$conditions[] = "Market.picture!=''";
	    		$tpl_file = "blocks/market.image.html";
	    	}
	    }

		if (isset($params['orderby'])) {
			$orderby = " order by Market.".trim($params['orderby']);
		}
		$market->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$market->getTable(true)." where ".$tmp_cond.$orderby.$market->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	for($i=0; $i<count($result); $i++) {
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL."market/detail.php?id=".$result[$i]['LinkId'];
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."market/".$dt['year']."/".$dt['mon']."/".$dt['mday']."/".urlencode($result[$i]['LinkTitle'])."/";
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:img]", "[field:typename]"), array($url, $result[$i]['LinkTitle'], $result[$i]['LinkImage'], ""), $op);
	    //$output.=$market->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>
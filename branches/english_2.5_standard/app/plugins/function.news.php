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
 * @created Mon Jun 22 16:42:01 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_news($params){
	global $g_db;
	global $smarty, $theme_name, $cookiepre;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.default.html";
	extract($params);
	if (class_exists("News")) {
		$info = new Newses();
	}else{
	    uses("news");
	    $info = new Newses();
	}
	require(DATA_PATH.$cookiepre."newstype.inc.php");
	$conditions[] = "News.status=1";
	$fields = "News.id AS LinkId,News.title as LinkTitle,News.html_file_id as NewsHtmlFileId,News.created as CreateDate,News.picture as LinkImage,News.type_id as TypeId,left(content,50) as NewsContent";
	$t_var = array("[link:title]", "[field:title]", "[img:src]", "[field:fulltitle]", "[field:typename]", "[field:pubdate]");
	if(isset($params['id'])){
		$result = $info->read($fields, intval($params['id']));
	}elseif(isset($params['ispro'])){
    	$output = $smarty->fetch($theme_name."/block.".$params['ispro'].".html", null, null, false);
    	echo $output;
	}else{
		if (isset($params['type'])) {
			if($params['type']=="image"){
				$conditions[] = "News.picture!=''";
				$tpl_file = "block.default.image.html";
			}
		}
		if (isset($params['type_id'])) {
			$conditions[] = "News.type_id=".$params['type_id'];
		}
		if(isset($params['date'])){
			//2008-09-23
			$e_dt = explode("-", $params['date']);
			//only year, or year-month, or year-month-day
			if(!empty($e_dt[2])){
			}elseif(!empty($e_dt[1])){
			}elseif(!empty($e_dt[0])){
			}
		}
		if (isset($params['orderby'])) {
			$orderby = " order by ".trim($params['orderby']);
		}else{
			$orderby = " order by News.id desc";
		}
		$info->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$info->getTable(true)." where ".$tmp_cond.$orderby.$info->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	if (isset($params['isbold']) && !empty($result)) {
	   $is_bold = true;
	   $first_res = array_shift($result);
	   $output.='				<div class="hyzx_c1">
					<a href="'.URL."news/detail.php?id=".$first_res['LinkId'].'"><img src="'.URL.'attachment/'.$first_res['LinkImage'].'" alt="'.$first_res['LinkTitle'].'" /></a>
					<p>
						<a href="'.$first_res['LinkTitle'].'" class="str title" title="">'.$first_res['LinkTitle'].'</a>
						<a href="'.URL."news/detail.php?id=".$first_res['LinkId'].'">'.strip_tags($first_res['NewsContent']).'</a>
					</p>
				</div>
				<ul class="ul21">
';
	}
	for($i=0; $i<count($result); $i++) {
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL."news/detail.php?id=".$result[$i]['LinkId'];
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."news/".$dt['year']."/".$dt['mon']."/".$dt['mday']."/".urlencode($result[$i]['LinkTitle'])."/";
	    }
		$fulltitle = $result[$i]['LinkTitle'];
	    if (isset($params['titlelen'])) {
	    	$result[$i]['LinkTitle'] = utf_substr($result[$i]['LinkTitle'], $params['titlelen']);
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $type_link = "";
	    if (!isset($params['showtypelink'])) {
	    	$type_link = "[<a href='".URL."news/list.php?type_id=".$result[$i]['TypeId']."'>".$UL_DBCACHE_NEWSTYPE[$result[$i]['TypeId']]."</a>]";
	    }
	    $f_var = array($url, $result[$i]['LinkTitle'], URL."attachment/".$result[$i]['LinkImage'].".small.jpg", $fulltitle, $type_link, date("m-d", $result[$i]['CreateDate']));
	    if($params['type']=="image"){
	        	$t_var[] = "[img:width]";
				$f_var[] = $params['imgwidth'];
				$t_var[] = "[img:height]";
				$f_var[] = $params['imgheight'];
	    }
	    $op = str_replace($t_var, $f_var, $op);
	    //$output.=$info->checkTerminal($i);
	    $output.=$op;
	}
	if ($is_bold) {
		$output.="</ul>";
	}
	echo $output;
}
?>
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
 * @created Mon Jun 22 16:42:06 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_announce($params){
	global $g_db;
	global $smarty, $theme_name, $tb_prefix, $cookiepre, $time_stamp;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.default.html";
	extract($params);
	require(DATA_PATH.$cookiepre."announce.inc.php");
	if (!class_exists("Announcements")) {
		uses("announcement");
		$announce = new Announcements();
	}else{
	    $announce = new Announcements();
	}
	if (isset($params['orderby'])) {
	    $orderby = " order by ".trim($params['orderby']);
	}else{
	    $orderby = " order by id desc";
	}
	$fields = "id as AnnouncementId,id_type,subject as LinkTitle,message,created  as CreateDate";
	if(isset($params['id'])){
	    $result = $announce->read($fields, intval($params['id']));
	}else{
	    $announce->setLimit($params['row'], $params['col'], $params['max']);
	    $tmp_cond = implode(" and ", $conditions);
	    if (!empty($tmp_cond)) {
	    	$tmp_cond.= "where ".$tmp_cond;
	    }
	    $sql = "select ".$fields." from ".$announce->getTable(true).$tmp_cond.$orderby.$announce->getLimit();
	    $result = $g_db->GetArray($sql);
	}
	$output = $format_date = null;
	for($i=0; $i<count($result); $i++) {
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $url = URL."announce.php?id=".$result[$i]['AnnouncementId'];
	    if (!empty($result[$i]['CreateDate'])) {
	        $a = $time_stamp-$result[$i]['CreateDate'];
	        if ($a < 40)
	        {
	            $format_date = "半分钟前";
	        }
	        elseif ($a < 60)
	        {
	            $format_date = "1分钟前";
	        }
	        elseif ($a < 3600)
	        {
	            $s = floor( $a / 60 );
	            $format_date = $s."分钟前";
	        }
	        elseif ($a < 86400)
	        {
	            $s = floor( $a / 3600 );
	            $format_date = $s."小时前";
	        }
	        elseif ($a < 86400*24*3)
	        {
	            $s = floor( $a / 86400 );
	            $format_date =  $s."天前";
	        } else {
	            $format_date = date("Y-m-d", $result[$i]['CreateDate']);
	        }
	        //结果:2分钟前
	    }
	    $op = str_replace(array("[link:title]", "[field:title]", "[field:typename]"), array($url, $result[$i]['LinkTitle'], $format_date), $op);
	    $output.=$op;
	}
	echo $output;
}
?>
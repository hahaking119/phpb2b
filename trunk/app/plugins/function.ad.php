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
 * @created Mon Jun 22 16:41:00 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.ul_get_ad.php 462 2009-07-19 14:12:14Z stevenchow811 $
 */
function smarty_function_ad($params){
	global $g_db, $tb_prefix;
	global $smarty, $theme_name;
	$conditions = array();
	$limit = null;
	$conditions[] = "status=1";
	//$tpl_file = (isset($params['templet']))?$params['templet']:"block.default.image.html";
	extract($params);
	if (!class_exists("Adses")) {
		uses("ad");
		$ad = new Adses();
	}else{
	    $ad = new Adses();
	}
	$fields = "id as AdsId,adzone_id as AdzoneId,title as LinkTitle,source_url as ItemPicture,id as LinkId,target_url as TargetUrl,alt_words as ImageAlert,source_type as SourceType";
	if(isset($params['id'])){
		$result = $ad->read($fields, intval($params['id']));
	}else{
	    if (isset($params['type_id'])) {
	       $conditions[] = "adzone_id=".$params['type_id'];
	       //取得该zone的高度和宽度。
	       $zone_res = $g_db->GetRow("select width,height from ".$tb_prefix."adzones where id=".$params['type_id']);
	       $max_width = "100%";
	       $max_height = $zone_res['height'];
	       unset($zone_res);
	    }
		$ad->setLimit($params['row'], $params['col'], $params['max']);
		if (isset($params['orderby'])) {
			$orderby = " order by ".trim($params['orderby']);
		}else{
		    $orderby = " order by priority desc,id desc";
		}
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$ad->getTable(true)." where ".$tmp_cond.$orderby.$ad->getLimit();
		$result = $g_db->GetArray($sql);
	}
	$output = null;
	if(!empty($result)){
	for($i=0; $i<count($result); $i++) {
	    $url = $result[$i]['TargetUrl'];
	    if ($result[$i]['SourceType']==2) {
	    	$tpl_file = 'block.default.swf.html';
	    }else{
	        $tpl_file = 'block.default.image.html';
	    }
	    $op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    if (empty($max_width)) {
	    $op = str_replace(array("[link:title]", "[field:title]", "[img:src]"), array($url, $result[$i]['LinkTitle'], $result[$i]['ItemPicture']), $op);
	    }else{
	    $op = str_replace(array("[link:title]", "[field:title]", "[img:src]", "[img:width]", "[img:height]"), array($url, $result[$i]['LinkTitle'], $result[$i]['ItemPicture'], $max_width, $max_height), $op);
	    }
	    $output.=$op;
	}
	}else{
	    $output = "<td>".sprintf(lgg("adzone_position"), $params['type_id'])."</td>";
	}
	echo $output;
}
?>
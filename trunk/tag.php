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
 * @package phpb2b
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:06:18 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
$inc_path = "./";
$li = 99;
require("global.php");
require(SITE_ROOT.'./libraries/page.php');
uses("trade","industry","company","product","keyword");
require(SITE_ROOT.'./libraries/page.php');
$industry = new Industries();
$keyword = new Keywords();
$trade = new Trades();
$tpl_file = "index";
$conditions = null;
if (isset($_GET['keyword'])) {
	$searchkeywords = urldecode($_GET['keyword']);
}

$tag_modules = array('index','trades','companies','newses','markets','expoes','products', 'jobs');
if(!empty($searchkeywords)) {
	$tpl_file = "search";
	if (isset($_GET['type'])) {
	    $tType = (in_array(trim($_GET['type']), $tag_modules))?trim($_GET['type']):false;
	}else{
		$tType = lgg("buy_and_sell");
	}
	$tExists = $g_db->GetArray("select id AS KeywordId,primary_id as ItemIds,type as ItemType,numbers from {$tb_prefix}keywords where title='".$searchkeywords."'");
	if(!empty($tExists)){
	       $keyword_res = $g_db->GetRow("select id AS KeywordId,primary_id as ItemIds,type as ItemType from {$tb_prefix}keywords where title='".$searchkeywords."' and type='$tType'");
		    switch ($keyword_res['ItemType']) {
	    	case "trades":
	    	    $fields = "id as ItemId,topic as ItemTitle,content as ItemInfo,submit_time as CreateDate,picture as ItemPicture";
	    	    $module_name = "offer/detail.php";
	    		break;
	    	case "companies":
	    	    $fields = "id as ItemId,name as ItemTitle,description as ItemInfo,created as CreateDate,picture as ItemPicture";
	    	    $module_name = "company/";
	    	    break;
	    	case "products":
	    	    $fields = "id as ItemId,name as ItemTitle,content as ItemInfo,created as CreateDate,picture as ItemPicture";
	    	    $module_name = "product/content.php";
	    	    break;
	    	case "newses":
	    	    $fields = "id as ItemId,title as ItemTitle,content as ItemInfo,created as CreateDate,picture as ItemPicture";
	    	    $module_name = "news/detail.php";
	    	    break;
	    	case "markets":
	    	    $fields = "id as ItemId,name as ItemTitle,content as ItemInfo,created as CreateDate,picture as ItemPicture";
	    	    $module_name = "market/detail.php";
	    	    break;
	    	default:
	    	    $fields = "id as ItemId,topic as ItemTitle,content as ItemInfo,submit_time as CreateDate,picture as ItemPicture";
	    	    $module_name = "offer/detail.php";
	    		break;
	    }
	    if (!empty($keyword_res['ItemIds'])) {
    	    $amount = substr_count($keyword_res['ItemIds'], ",");
    	    pageft($amount+1, 25);
    	    $sql = "select $fields from ".$tb_prefix.$tType." where id in (".$keyword_res['ItemIds'].") limit $firstcount,$displaypg";
    		$res = $g_db->GetArray($sql);
	    }
		uaAssign(array("ByPages"=>$pagenav, "KeyItems"=>$res, "DirName"=>$module_name));
		unset($keys,$res);
	}else{
		$res['title'] = $searchkeywords;
		$res['clicked'] = 1;
		$res['type'] = 0;
		$res['created'] = $time_stamp;
		$res['numbers'] = 1;
		$res['status'] = 0;
		$res['type'] = "index";
		$sql = "select id from {$tb_prefix}keywords where title='".$searchkeywords."'";
		$if_exists = $g_db->GetOne($sql);
		if(!$if_exists)
		$keyword->save($res);
	}
	uaAssign(array("titleKeyword"=>sprintf(lgg("search_additional"), $searchkeywords, $tType)));
}
template($theme_name."/tag_".$tpl_file);
?>
<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: list.php 429 2009-12-26 13:46:09Z cht117 $
 */
define('CURSCRIPT', 'list');
require("../libraries/common.inc.php");
require("../share.inc.php");
uses("news","newstype");
require(LIB_PATH. 'page.class.php');
require(CACHE_PATH. "cache_newstype.php");
$news = new Newses();
$newstype = new Newstypes();
$page = new Pages();
$page->pagetpl_dir = $theme_name;
$conditions = array();
$tpl_file = "news.list";
setvar("Newstypes", $newstype->getCacheTypes());
$orderby = null;
$viewhelper->setTitle(L("info", "tpl"));
$viewhelper->setPosition(L("info", "tpl"), "news/");
if(isset($_GET['q']) && !empty($_GET['q'])){
	$title = trim($_GET['q']);
	$conditions[] = "News.title like '%".$title."%'";
}
if (isset($_GET['topicid'])) {
	$topic_id = intval($_GET['topicid']);
	$topic_res = $pdb->GetRow("SELECT * FROM {$tb_prefix}topics WHERE id=".$topic_id);
	$viewhelper->setTitle(L("topic_news", "tpl"));
	$viewhelper->setPosition(L("topic_news", "tpl"));
	if(!empty($topic_res)){
		setvar("Items", $pdb->GetArray("SELECT n.*,n.created AS pubdate FROM {$tb_prefix}topicnews tn RIGHT JOIN {$tb_prefix}newses n ON tn.news_id=n.id WHERE tn.topic_id=".$topic_id));
		$viewhelper->setTitle($topic_res['title']);
		$viewhelper->setPosition($topic_res['title'], "news/list.php?topicid=".$topic_id);
		render($tpl_file);
		exit;
	}
}
if(isset($_GET['typeid'])){
	$newstype_id = intval($_GET['typeid']);
	if ($newstype_id) {
	$newstype_name = $_PB_CACHE['newstype'][$newstype_id];
	$conditions[] = "News.type_id=".$newstype_id;
	$viewhelper->setTitle($newstype_name);
	$viewhelper->setPosition($newstype_name, "news/list.php?typeid=".$newstype_id);
	}

}
if (isset($_GET['type'])) {
	$type = trim($_GET['type']);
	if ($type == "hot") {
		$orderby = "News.clicked DESC,";
	}
}
$amount = $news->findCount(null, $conditions);
$page->setPagenav($amount);
$result = $news->findAll("News.*,News.created AS pubdate", null, $conditions, $orderby."News.id DESC", $page->firstcount, $page->displaypg);
setvar("Items", $result);
setvar("ByPages", $page->pagenav);
render($tpl_file);
?>
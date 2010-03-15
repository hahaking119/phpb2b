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
 * @version $Id: detail.php 429 2009-12-26 13:46:09Z cht117 $
 */
define('CURSCRIPT', 'detail');
require("../libraries/common.inc.php");
require("../share.inc.php");
uses("news","tag");
$news = new Newses();
$tag = new Tags();
$conditions = array();
$viewhelper->setTitle(L("info", "tpl"));
$viewhelper->setPosition(L("info", "tpl"), "news/");
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}
if (!empty($id)) {
    require(CACHE_PATH."cache_newstype.php");
	$news->clicked($id);
	$info = $news->read("*",$id);
	if (empty($info) or !$info) {
		flash("data_not_exists", '', 0);
	}
	if(!empty($info['tag_ids'])){
    	$tag->getTagsByIds($info['tag_ids'], true);
    	$info['tag'] = $tag->tag;
	}
	if (!empty($info['picture'])) {
		$info['image'] = pb_get_attachmenturl($info['picture'], '', 'small');
	}
	$info['pubdate'] = date("Y-m-d", $info['created']);
	$info['typename'] = $_PB_CACHE['newstype'][$info['type_id']];
	$viewhelper->setTitle($info['typename']);
	$viewhelper->setPosition($info['typename'], "news/list.php?typeid=".$info['type_id']);
	$viewhelper->setTitle($info['title']);
	setvar("item",$info);
}else{
    flash();
}
setvar("Newstypes",$_PB_CACHE['newstype']);
render("news.detail");
?>
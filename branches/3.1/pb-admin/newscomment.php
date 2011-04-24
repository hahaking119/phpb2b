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
 * @version $Id: newscomment.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("newscomment");
require(LIB_PATH. 'page.class.php');
require("session_cp.inc.php");
$newscomment = new Newscomments();
$page = new Pages();
$conditions = array();
$tpl_file = "newscomment";
$amount = $newscomment->findCount(null, $conditions,"id");
$page->setPagenav($amount);
$joins[] = "LEFT JOIN {$tb_prefix}newses n ON n.id=Newscomment.news_id";
$newscomment_list = $newscomment->findAll("Newscomment.id,Newscomment.news_id,Newscomment.message,Newscomment.cache_username as username,Newscomment.date_line AS pubdate,n.title", $joins, $conditions, "id DESC", $page->firstcount, $page->displaypg);
setvar("Items",$newscomment_list);
uaAssign(array("ByPages"=>$page->pagenav));
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $newscomment->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
template($tpl_file);
?>
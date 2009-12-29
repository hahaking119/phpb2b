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
 * @version $Id: news.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
require(PHPB2B_ROOT.'libraries/page.class.php');
uses("companynews");
$page = new Pages();
$companynews = new Companynewses();
$conditions = "Companynews.company_id=".$company->info['id'];
if (isset($_GET['id'])) {
	$id = intval(($_GET['id']));
	if ($id) {
		$info = $companynews->read("*", intval($_GET['id'], $conditions));
		if (empty($info)) {
			flash('data_not_exists');
		}
		$tpl_file = "news_detail";
		setvar("item",$info);
		$space->render($tpl_file);
		exit;
	}
}
$amount = $companynews->findCount(null, $conditions,"Companynews.id");
$page->setPagenav($amount);
setvar("Items",$companynews->findAll("id,title,content,created,created AS pubdate",null, $conditions,"Companynews.id DESC",$page->firstcount,$page->displaypg));
setvar("ByPages",$page->pagenav);
$space->render("news");
?>
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
 * @created Mon Jun 22 16:05:37 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
$inc_path = "./";//windows should be 'empty';
$li = 0;
$module_id = 0;
require("global.php");
header("Content-Type: text/html; charset=".$charset);
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("trade","industry","memberlog","ad","htmlcache", "stat");
$stat = new Stats();
$htmlcache = new Htmlcaches();
$ads = new Adses();
$memberlog = new Memberlogs();
$trade = new Trades();
$industry = new Industries();
$smarty->register_function("format_amount","splitIndustryAmount");
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
setvar("TradeTypes", $trade->getTradeTypes());
/*xajax*/
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
/*end xajax*/
if (isset($searchkeywords)) {
	$action_page = strtolower($nav[$_GET['searchtype']]['ename'])."/list.php?keyword=".urlencode($_GET['keyword']);
	PB_goto($action_page);
}
if (!INSTALLED) {
	if(file_exists("./install/install.php")){
		header("Location: install/install.php?step=-1");
		exit;
	}else{
		die("<a href='install/install.php'>".L('please_reinstall_program')."</a>!");
	}
}
unset($industries,$res,$buys,$sells);
setvar("IndustryList", $industry->getIndustryPage(1,"buy"));
unset($tmp_count, $result);
if (!empty($_SETTINGS['sitedescription'])) {
		setvar("sitekeywords", strip_tags(str_replace(array("，", "、", " ", "。", "."), ",", $_SETTINGS['sitedescription'])));
}
template($theme_name."/index");
?>
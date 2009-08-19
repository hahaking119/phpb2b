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
require("global.php");
header("Content-Type: text/html; charset=".$charset);
require(INC_PATH .'xajax/xajaxAIO.inc.php');
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
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
function checkUserName($arg)
{
    $obj = new xajaxResponse();
    $newcontent = $arg;
    $obj->assign("checkusername","innerHTML", lgg('data_not_exists'));
    return $obj;
}

function addServiceQuestion($formData)
{
	global $time_stamp, $charset;
	$obj = new xajaxResponse();
	$record = array();
	$record['title'] = "Index";
	$record['type_id'] = 1;
	$record['content'] = ($charset=="utf-8")?$formData['content']:urlencode($formData['content']);
	$record['created'] = $time_stamp;
	$record['user_ip'] = uaGetClientIP();
	if (!empty($record['content'])) {
		uses("service");
		$service  = new Services();
		$update = $service->save($record);
	}
    $obj->assign("ServicePostDiv","innerHTML", '您提交的"<u>'.$record['content'].'</u>"已经交由我们的客服处理,非常感谢您的关注.');
	unset($record);
	return $obj;
}

$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('getIndustryList', 'ajax.php'), array(
        'callback' => 'myCallback'
));
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', 'ajax.php'));
$xajax->register(XAJAX_FUNCTION, "addServiceQuestion");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
if (STATIC_HTML_LEVEL>0 && (!isset($_GET['action']))) {
	//goto(URL."htmls/index.html");
}
if (isset($searchkeywords)) {
	$action_page = strtolower($nav[$_GET['searchtype']]['ename'])."/list.php?keyword=".urlencode($_GET['keyword']);
	goto($action_page);
}

unset($industries,$res,$buys,$sells);
$result = $stat->findAll("sb as CountType,sc as CountAmount,se as CountToday", "sa='total'");
$tmp_count = array();
foreach($result as $val){
    $tmp_i = "";
    $tmp_count[$val['CountType']] = $val['CountAmount'];
    for ($i=0; $i<strlen($val['CountAmount']); $i++){
        $tmp_i.= "<img src='".URL."images/".$theme_name."/digital".substr($val['CountAmount'], $i, 1).".gif' alt='".$val['CountAmount']."'>";
    }
    $tmp_count[$val['CountType']."_img"] = $tmp_i;
    unset($tmp_i);
}

setvar("InfoCount", $tmp_count);
setvar("IndustryList", $industry->getIndustryPage(1,"buy"));
if (isset($_GET['action']) && ($_GET['action'])=="html") {
	$cached = $smarty->MakeHtmlFile('htmls/index.html',$smarty->fetch($theme_name."/index.html"), true, "index.php");
}
unset($tmp_count, $result);
if (!empty($_SETTINGS['sitedescription'])) {
		setvar("sitekeywords", strip_tags(str_replace(array("，", "、", " ", "。", "."), ",", $_SETTINGS['sitedescription'])));
}
template($theme_name."/index");
?>
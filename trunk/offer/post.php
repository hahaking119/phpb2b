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
 * @created Mon Jun 22 16:05:56 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: post.php 119 2009-09-14 13:30:08Z stevenchow811@163.com $
 */
$inc_path = "../";
require("../global.php");
require_once(SITE_ROOT. './configs/db_session.php');
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
require(SITE_ROOT. './libraries/func.checksubmit.php');
uses("trade","industry","member", "setting", "htmlcache");
$industry = new Industries();
$htmlcache = new Htmlcaches();
$member = new Members();
$trade = new Trades();
$setting = new Settings();
$expires = $trade->offer_expires;
if (!isset($_COOKIE[session_name()])) {
	setcookie(session_name(), md5(pb_radom()), $time_stamp+3*86400);
}
$salt = substr($_COOKIE[session_name()], 0, 10);
setvar("TradeTypes",$trade->getTradeTypes());
setvar("Genders", $member->genders);
setvar("PhoneTypes", $member->phone_types);
setvar("ImTypes", $member->im_types);
$expires = $trade->offer_expires;
$xajax = new xajax();
$xajax->configure('javascript URI', URL."libraries/source/xajax/");
$if_visit_post = intval($setting->field("valued", "variable='vis_post'"));
$if_visitpost_auth = intval($setting->field("valued", "variable='vispost_auth'"));
if ($if_visitpost_auth) {
	$smarty->assign("IfVisPostPicture", true);
}
if(!$if_visit_post){
	//alert(sprintf(lgg('visitor_forbid'), $_SETTINGS['sitename']));
	alert(L('visitor_forbid', 'msg'));
}
if (isset($_POST['visit_post']) && isset($_POST['data']['offer']['link_man']) && isset($_POST['data']['trade'])) {
	if(empty($_POST['data']['offer']['prim_telnumber'])) exit;
	//to do test trade.php->Add
	$trade->Add();
	exit;
	if ($if_visitpost_auth) {
		$auth_check = pb_strcomp(strtolower($_POST['visit_auth_num']),strtolower($_SESSION['authnum_session']));
		if (!$auth_check) {
			session_destroy();
			alert(lgg('wrong_validate'));
		}else{
		    unset($_SESSION['authnum_session']);
		}
	}
	//check today
	$tVisitLogNum = $g_db->GetOne("select count(id) from {$tb_prefix}visitlogs where salt='$salt' and  date_line='".date("Ymd")."' and type_name='trades'");
	if ($tVisitLogNum>=3) {
		alert(sprintf(lgg('visit_limit'), 3));
	}
	$vals = array();
	$vals = $_POST['data']['trade'];
	$tmp_result = false;
	$vals['submit_time'] = $vals['created'] = $vals['modified'] = $time_stamp;
	$vals['area_id'] = $_POST['countryid'];
	$vals['province_id'] = $_POST['provinceid'];
	$vals['city_id'] = $_POST['cityid'];
	$vals['type_id'] = strval($_POST['data']['trade']['type_id']);
	$trade->setTradeCat($vals['type_id']);
	$vals['content'] = preg_replace("/(\r?\n)\\1+/","\\1",$vals['content']);
	$vals['ip_addr'] = pb_get_client_ip('str');
	$if_check = $setting->field("valued", "variable='vis_post_check'");
	$if_check = intval($if_check);
	$msg = null;
	if ($if_check) {
		$vals['status'] = 0;
		$msg = L('member_checking');
	}else{
		$vals['status'] = 1;
		$msg = L('action_successfully');
	}
	if (isset($_POST['cindustry'])) {
		$industryid = $_POST['cindustry'];
	}else if(isset($_POST['bindustry'])){
		$industryid = $_POST['bindustry'];
	}else if(isset($_POST['aindustry'])){
		$industryid = $_POST['aindustry'];
	}
	if(isset($industryid)) $vals['industry_id'] = $industryid;
	if (array_key_exists($_POST['expire_days'],$expires)) {
		$vals['expire_time'] = $time_stamp+(24*3600*$_POST['expire_days']);
		$vals['expire_days'] = $_POST['expire_days'];
	}else{
		$vals['expire_time'] = $time_stamp+(24*3600*10);
		$vals['expire_days'] = 10;
	}
	$tmp_keywords = preg_replace('#\s+#', ' ', trim($_POST['keywords']));
	$vals['keywords'] = pb_convert_comma($tmp_keywords);
	$result = $trade->save($vals);
	if ($result) {
		$last_trade_id = $trade->getMaxId();
		$o_vals = array();
		$o_vals = $_POST['data']['offer'];
		uses("offer", "area");
		$offer = new Offers();
		$area = new Areas();
		if(isset($vals['province_id'])) $o_vals['province_name'] = $area->field("name", "code_id=".$_POST['provinceid']);
		if(isset($vals['city_id'])) $o_vals['city_name'] = $area->field("name", "code_id=".$_POST['cityid']);
		if (isset($industryid)) {
			$o_vals['industry_name'] = $industry->field("name", "id=".$industryid);
		}
		$o_vals['trade_id'] = $last_trade_id;
		$tmp_result = $offer->save($o_vals);
		$g_db->Execute("insert into {$tb_prefix}visitlogs (salt,date_line,type_name) value ('".$salt."','".date("Ymd")."','trades');");
		uses("stat");
		$stat = new Stats();
		$stat->Add($trade->getTradeCat());
		$industry->updateModelAmount($industryid, $trade->industry_amount_name);
	}
	if ($tmp_result) {
		alert($msg);
	}
}

$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
setvar("OfferExpires",$expires);
template($theme_name."/trade_post");
?>
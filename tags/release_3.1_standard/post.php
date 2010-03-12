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
 * @version $Id: post.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'post');
require("libraries/common.inc.php");
require("share.inc.php");
if (session_id() == '' ) { 
	require_once(LIB_PATH. "session_php.class.php");
	$session = new PbSessions();
}
require(LIB_PATH. "typemodel.inc.php");
uses("trade","member","tradefield");
$offer = new Tradefields();
$member = new Members();
$trade = new Trades();
$trade_controller = new Trade();
$tradefield = new Tradefields();
$expires = $trade_controller->getOfferExpires();
setvar("TradeTypes",$trade_controller->getTradeTypes());
setvar("Genders", get_cache_type("gender",null,array("0", "-1")));
setvar("PhoneTypes", get_cache_type("phone_type"));
setvar("ImTypes", get_cache_type("im_type"));
$if_visit_post = $_PB_CACHE['setting']['vis_post'];
if(!$if_visit_post){
	$smarty->flash('visitor_forbid', URL, 0);
}
capt_check("capt_post_free");
if (isset($_POST['visit_post'])) {
	pb_submit_check('visit_post');
	$trade->setParams();
	$trade->params['expire_days'] = $_POST['expire_days'];
	$if_check = $_PB_CACHE['setting']['vis_post_check'];
	$msg = null;
	$words = $pdb->GetArray("SELECT * FROM {$tb_prefix}words");
	if (!empty($words)) {
		foreach ($words as $word_val) {
			if(!empty($word_val['title'])){
				str_replace($word_val['title'], "*", $trade->params['data']['trade']['title']);
				str_replace($word_val['title'], "*", $trade->params['data']['trade']['content']);
			}
		}
		$item['forbid_word'] = implode("\r\n", $tmp_str);
	}
	if ($if_check) {
		$trade->params['data']['trade']['status'] = 0;
		$msg = 'pls_wait_for_check';
	}else{
		$trade->params['data']['trade']['status'] = 1;
		$msg = 'success';
	}
	$result = $trade->Add();
	if ($result) {
		$smarty->flash($msg, URL);
	}else{
		$smarty->flash();
	}
}
formhash();
setvar("OfferExpires", $expires);
setvar("sid",md5(uniqid($time_stamp)));
render("offer.freepost");
?>
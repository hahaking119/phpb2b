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
 * @version $Id: inquery.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require(LIB_PATH. "typemodel.inc.php");
uses("inquery");
$inquery = new Inqueries();
$conditions = null;
$tpl_file = "inquery";
$im_types = get_cache_type("im_type");
$tel_types = get_cache_type("phone_type");
$page = new Pages();
$conditions = "to_member_id=".$_SESSION['MemberID'];
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do == "view" && !empty($id)){
		$result = $inquery->read(null, $id, null, " and ".$conditions);
		if(empty($result)){
			flash('data_not_exists');
		}else{
			$link_info = unserialize($result['content']);
			setvar("item",$link_info);
			$tpl_file = "inquery_detail";
			template($tpl_file);
			exit;
		}
	}
}
$amount = $inquery->findCount(null, $conditions);
$page->setPagenav($amount);
$res = $inquery->findAll("id as InqueryId,title as InqueryProduct,created as CreateDate", null, $conditions, "id desc", $page->firstcount, $page->displaypg);
setvar("Inqueries",$res);
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>
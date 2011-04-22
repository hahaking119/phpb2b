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
 * @version $Id: offer.php 560 2009-12-28 11:11:39Z steven $
 */
require("../libraries/common.inc.php");
require(LIB_PATH .'time.class.php');
uses("trade","tag","tradefield","attachment","segment");
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
$attachment = new Attachment('pic');
$offer = new Tradefields();
$tag = new Tags();
$keyword = new Segments();
$trade = new Trades();
$trade_controller = new Trade();
$tpl_file = "offer";
$conditions = array();
$page = new Pages();
setvar("TradeTypes", $trade_names = $trade_controller->getTradeTypes());
if (isset($_POST['refresh']) && !empty($_POST['id'])) {
	$result = $trade->refresh($_POST['id']);
	if (!$result) {
		flash();
	}
}
if (isset($_POST['commend'])) {
	$ids = implode(",",$_POST['id']);
	$result = $pdb->Execute($sql = "update ".$trade->getTable()." set if_commend=1 where id in (".$ids.")");
	if ($result) {
		flash("trade.php");
	}else{
		flash("trade.php");
	}
}
if(isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "refresh" && !empty($id)) {
		$trade->refresh($id);		
	}
	if ($do=="edit") {
		if (!empty($id)) {
			$sql = "SELECT t.*,tf.*,m.username,c.name as companyname FROM {$tb_prefix}trades t LEFT JOIN {$tb_prefix}tradefields tf ON t.id=tf.trade_id LEFT JOIN {$tb_prefix}members m ON t.member_id=m.id LEFT JOIN {$tb_prefix}companies c ON c.id=t.company_id WHERE t.id={$id}";
			$res = $pdb->GetRow($sql);
			if (isset($res['picture'])) {
				$res['image'] = pb_get_attachmenturl($res['picture'], '../', 'small');
			}
			$res['pubdate'] = @date("Y-m-d", $res['submit_time']);
			$res['enddate'] = @date("Y-m-d", $res['expire_time']);
			if (empty($res)) {
				flash();
			}else{
				$tag->getTagsByIds($res['tag_ids'], true);
				$res['tag'] = $tag->tag;
				setvar("item",$res);
			}
		}
		$tpl_file = "offer.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "search") {
		if (!empty($_GET['display_pg']) && in_array($_GET['display_pg'], $page->page_option)) {
			$page->displaypg = $_GET['display_pg'];
		}
		if (!empty($_GET['q'])) {
			$conditions[]= "Trade.title like '%".trim($_GET['q'])."%'";
		}
		if (!empty($_GET['companystatus']) && $_GET['companystatus']!="-1") {
			$conditions[]= "Trade.status='".$_GET['companystatus']."'";
		}
		if (!empty($_GET['username'])) {
			$conditions[] = "m.username like '%".$_GET['username']."%'";
		}
		if (isset($_GET['PubFromDate'])) {	
			if ($_GET['PubFromDate']!="None" && $_GET['PubToDate']!="None") {
				$condition= "Trade.created BETWEEN ";
				$condition.= Times::dateConvert($_GET['PubFromDate']);
				$condition.= " AND ";
				$condition.= Times::dateConvert($_GET['PubToDate']);
				$conditions[] = $condition;
			}
		}
		if (isset($_GET['ExpFromDate'])) {	
			if ($_GET['ExpFromDate']!="None" && $_GET['ExpToDate']!="None") {
				$condition= "Trade.expire_time BETWEEN ";
				$condition.= Times::dateConvert($_GET['ExpFromDate']);
				$condition.= " AND ";
				$condition.= Times::dateConvert($_GET['ExpToDate']);
				$conditions = $condition;
			}
		}
		if(!empty($_GET['ip'])){
			$conditions[]="Trade.ip_addr='".$_GET['ip']."'";
		}
	}
}
if (isset($_POST['urgent_batch'])) {
	$ids = implode(",",$_POST['id']);
	$result = $pdb->Execute("update ".$trade->getTable()." set if_urgent='1' where id in (".$ids.")");
	if (!$result) {
		flash();
	}
}
if(isset($_POST['del']) && !empty($_POST['id'])){
    foreach ($_POST['id'] as $val) {
    	$picture = $trade->field("picture", "id=".$val);
    	@unlink($media_paths['attachment_dir']."big/".$picture);
    	@unlink($media_paths['attachment_dir']."small/".$picture);
    }
	$result = $trade->Delete($_POST['id']);
	if (!$result) {
		flash();
	}
}
if(isset($_POST['up_batch'])) {
	$result = $trade->check($_POST['id'],1);
	if (!$result) {
		flash("trade.php");
	}
}
if(isset($_POST['down_batch'])) {
	$result = $trade->check($_POST['id'],0);
	if (!$result) {
		flash();
	}
}
if (isset($_POST['status_batch'])) {
	if(!empty($_POST['id'])){
		$tmp_to = intval($_POST['status_batch']);
		$result = $trade->check($_POST['id'], $tmp_to);
	}
}
if(isset($_POST['pass'])){
	$tid = (isset($_POST['id']))?$_POST['id']:null;
	$sql = "update ".$trade->getTable()." set status='1' where id=".$tid;
	$result = $pdb->Execute($sql);
	if (!$result) {
		flash();
	}
}
if(isset($_POST['forbid'])){
	$tid = (isset($_POST['id']))?$_POST['id']:null;
	$sql = "update ".$trade->getTable()." set status='0' where id=".$tid;
	$result = $pdb->Execute($sql);
	if (!$result) {
		flash("trade.php");
	}
}
if(isset($_POST['save'])){
	if(isset($_POST['id'])){
		$id = intval($_POST['id']);
	}
	$vals = $_POST['data']['trade'];
	if (isset($_POST['data']['company_name'])) {
		if (!pb_strcomp($_POST['data']['company_name'], $_POST['company_name'])) {
			$vals['company_id'] = $pdb->GetOne("SELECT id FROM {$tb_prefix}companies WHERE name='".$_POST['data']['company_name']."'");
		}
	}
	if (isset($_POST['data']['username'])) {
		if (!pb_strcomp($_POST['data']['username'], $_POST['username'])) {
			$vals['member_id'] = $pdb->GetOne("SELECT id FROM {$tb_prefix}members WHERE username='".$_POST['data']['username']."'");
		}
	}
	if(isset($_POST['submittime'])){
		if(!empty($_POST['submittime'])) {
		    $vals['submit_time'] = Times::dateConvert($_POST['submittime']);
		}
		if(!empty($_POST['expiretime'])) {
		    $vals['expire_time'] = Times::dateConvert($_POST['expiretime']);
		}
	}
	if (!empty($_FILES['pic']['name'])) {
		$attachment->rename_file = "offer-".$time_stamp;
		$attachment->upload_process();
		$vals['picture'] = $attachment->file_full_url;
	}
	if (!empty($vals['content'])) {
		$vals['content'] = stripcslashes($vals['content']);
	}
	$vals['tag_ids'] = $tag->setTagId($_POST['data']['tag']);
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$updated = $trade->save($vals, "update", $id);
	}else {
		$vals['submit_time'] = (empty($vals['submit_time']))?$time_stamp:$vals['submit_time'];
		$vals['expire_time'] = (empty($vals['expire_time']))?($time_stamp+60*60*24*30):$vals['expire_time'];
		$vals['created'] = $vals['modified'] = $time_stamp;
		$updated = $trade->save($vals);
		$last_insert_key = "{$tb_prefix}trades_id";
    	$id = $trade->$last_insert_key;
	}
	if (!$updated) {
		flash();
	}else{
		if($_PB_CACHE['setting']['keyword_bidding']) {
			$keyword->setIds($vals['title'].$vals['content'], 'trades', true, $id);
		}
		pheader("location:offer.php");
	}
}
setvar("CheckStatus", explode(",",L('product_status', 'tpl')));
$amount = $trade->findCount(null, $conditions,"Trade.id", null);
$page->setPagenav($amount);
$fields = "Trade.member_id,m.username,Trade.company_id,Trade.type_id,Trade.status,Trade.id,Trade.title,Trade.clicked,Trade.if_urgent,Trade.submit_time AS pubdate,Trade.expire_time AS expdate,Trade.picture as TradePicture,require_point,require_membertype,ip_addr as IP,Trade.if_commend";
$joins[] = "LEFT JOIN {$tb_prefix}members m ON m.id=Trade.member_id";
$all_trades = $trade->findAll($fields,$joins, $conditions,"Trade.id DESC",$page->firstcount,$page->displaypg);
setvar("Items",$all_trades);
setvar("ByPages", $page->getPagenav());
setvar("TradeNames", $trade_controller->getTradeTypeNames());
template($tpl_file);
?>
<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("trade", "member", "product", "access", "offer");
require(SITE_ROOT.'./app/include/page.php');
$tpl_file = "trade_list";
$offer = new Offers();
$access = new Accesses();
$product = new Products();
$trade = new Trades();
$conditions = null;
$conditions = " member_id = ".$_SESSION['MemberID'];
setvar("TradeTypes", $trade->getTradeTypes());
setvar("TradeNames", $trade->getTradeTypeNames());
if ($_POST['del'] && !empty($_POST['tradeid'])) {
	$tRes = $trade->del($_POST['tradeid'], "member_id = ".$_SESSION['MemberID']);
	if($tRes) $g_db->Execute("delete from ".$tb_prefix."offers where trade_id in (".implode(",",$_POST['tradeid']).")");
}
if ($_GET['action']=="update" && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
	$vals = array();
	$vals['modified'] = $time_stamp;
	$conditions.= " and status='1'";
	$tMaxHours = 24;
	$pre_update_time = $g_db->GetOne("select modified from ".$tb_prefix."trades where id=".$id." and member_id=".$_SESSION['MemberID']);
	if ($pre_update_time>($time_stamp-$tMaxHours*3600)) {
		flash("./tip.php", null, sprintf(lgg("allow_update_hours"), 24));
	}
	$result = $trade->save($vals, "update", $id, null, "and".$conditions);
	//24小时之内只能更新一次
	if (!$result) {
		flash("./tip.php", null, null, 0);
	}else{
		flash("./tip.php");
	}
}
$tMaxDay = 3;
if ($_GET['action']=="refresh" && !empty($_GET['id'])) {
	$id = intval($_GET['id']);
	$vals = array();
	$pre_submittime = $g_db->GetOne("select submit_time from ".$tb_prefix."trades where id=".$id." and member_id=".$_SESSION['MemberID']);
	if ($pre_submittime>($time_stamp-$tMaxDay*86400)) {
		flash("./tip.php", null, sprintf(lgg("allow_refresh_day"), $tMaxDay));
	}
	$vals['submit_time'] = $time_stamp;
	$vals['expire_days'] = 10;
	$vals['expire_time'] = $time_stamp+(24*3600*$vals['expire_days']);
	$vals['offer_expire'] = $vals['expire_time'];
	$conditions.= " and status='1'";
	$result = $trade->save($vals, "update", $id, null, "and".$conditions);
	$result = $g_db->Execute("update ".$offer->getTable()." set user_name='".$_SESSION['MemberName']."' where trade_id=".$id);
	if (!$result) {
		flash("./tip.php", null, null, 0);
	}else{
		flash("./tip.php");
	}
}
if(isset($_POST['refresh'])){
	if (!empty($_POST['refresh']) && !empty($_POST['tradeid'])) {
		$vals = array();
		$pre_submittime = $g_db->GetOne("select submit_time from ".$tb_prefix."trades where id=".$id." and member_id=".$_SESSION['MemberID']);
		if ($pre_submittime>($time_stamp-$tMaxDay*86400)) {
			flash("./tip.php", null, sprintf(lgg("allow_refresh_day"), $tMaxDay));
		}
		$vals['submit_time'] = $time_stamp;
		$vals['expire_days'] = 10;
		$vals['expire_time'] = $time_stamp+(24*3600*$vals['expire_days']);
		$conditions.= " and status='1'";
		$ids = implode(",", $_POST['tradeid']);
		$conditions.= " and id in (".$ids.")";
		$sql = "update ".$trade->getTable()." set submit_time=".$time_stamp.",expire_days=10,expire_time=".$vals['expire_time'].",offer_expire=".$vals['expire_time']." where ".$conditions;
		$result = $g_db->Execute($sql);
		if (!$result) {
			flash("./tip.php", null, null, 0);
		}else{
			flash("./tip.php");
		}
	}
}
if ($_GET['action'] == "stat"){
	$tpl_file = "tradestat";
	$amount = $trade->findAll("Trade.type_id AS TradeTypeId,COUNT(Trade.id) AS CountTrade",$conditions,"Trade.type_id",0,10,"Trade.type_id");
	foreach ($amount as $val) {
		$stats[$val['TradeTypeId']] = $val['CountTrade'];
	}
	setvar("UserTradeStat",$stats);
	setvar("ProductAmount",$product->findCount($conditions,"Product.id"));
}else{
	$tables = $trade->getTable(true);
	$amount = $trade->findCount($conditions);
	pageft($amount,12);
	setvar("tradelists",$trade->findAll($trade->mini_trade_cols, $conditions, "Trade.id DESC", $firstcount, $displaypg));
	uaAssign(array("Amount"=>$amount,"ByPages"=>$pagenav));
}
setvar("CheckStatus", explode(",",lgg('product_status')));
template($office_theme_name."/".$tpl_file);
?>
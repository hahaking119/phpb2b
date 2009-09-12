<?php
$inc_path = "../";
$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("trade");
$trade = new Trades();
if (isset($_POST['del']) && !empty($_POST['fid'])) {
	$ids = implode(",", $_POST['fid']);
	$ids = "(".$ids.")";
	$sql = "delete from {$tb_prefix}favorites where id in ".$ids." and member_id=".$ua_user['id'];
	$res = $g_db->Execute($sql);
	if (!$res) {
		flash("./tip.php", "./favor.php", null, 0);
	}
}
$tpl_file = "favor";
$sql = "select Favorite.id as FavorId,Trade.id as TradeId,Trade.topic as Title,Trade.type_id as TradeType,Favorite.created as CreateDate from {$tb_prefix}trades as Trade,{$tb_prefix}favorites as Favorite where Favorite.member_id=".$ua_user['id']." and Favorite.target_id=Trade.id";
$result = $g_db->GetArray($sql);
setvar("favorlists", $result);
setvar("TradeTypes", $trade->getTradeTypes());
template($tpl_file);
?>
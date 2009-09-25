<?php
$inc_path = "../";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
uses("member","company","membertype");
$member = new Members();
$membertype = new Membertypes();
$company = new Companies();
$tpl_file = "upgrade";

if ($_POST['apply']) {
	uses("order");
	$order = new Orders();
	$vals = array();
	$vals['product_id'] = intval($_POST['order']['product_id']);
	$vals['member_id'] = $_POST['member']['id'];
	$vals['company_id'] = $_POST['company']['id'];
	if($_POST['member']['username']) {
		$tmp_memberid = $member->field("id","Member.username='".$_POST['member']['username']."'");
		if (empty($tmp_memberid)) {
			die(lgg('member_not_exists'));
		}else{
			$vals['member_id'] = $tmp_memberid;
		}
	}
	if($_POST['company']['name']) {
		$tmp_companyid = $company->field("id","Company.name='".$_POST['company']['name']."'");
		if (empty($tmp_companyid)) {
			$vals['company_id'] = $_POST['company']['name'];
			$company_info = array();
			$company_info['name'] = $_POST['company']['name'];
			$company_info['member_id'] = $vals['member_id'];
			$company_info['created'] = $time_stamp;
			$company->save($company_info);
		}else{
			$vals['company_id'] = $tmp_companyid;
		}
	}
	$vals['tel'] = $_POST['member']['tel'];
	$vals['email'] = $_POST['member']['email'];
	$vals['created'] = $time_stamp;
	$vals['year_option'] = intval($_POST['order']['year_option']);
	array_walk($vals, "uatrim");
	$result = $order->save($vals);
	$last_order_id = $g_db->Insert_ID();
	if ($result) {
		uses("setting");
		$setting = new Settings();
		$chinabank_account_id = $setting->field("valued","variable='chinabank_account'");
		$member_info = array();
		$member_info['tel'] = $vals['tel'];
		$member->save($member_info, "update", $vals['member_id']);
		$membertype_res = $membertype->read("name,price_every_year",intval($_POST['order']['product_id']));
		setvar("MembertypeName",$membertype_res['name']);
		$order_price = $_POST['order']['year_option']*$membertype_res['price_every_year'];
		$order_price = sprintf("%.2f",$order_price);
		if (strlen($last_order_id)<3) {
			$last_order_id = "00".$last_order_id;
		}
		$order_id = date('Ymd', $time_stamp)."-".$chinabank_account_id."-".$last_order_id;
		$v_moneytype = "CNY";
		$v_url = URL."redirect.php?r=1";
	    $text = $order_price.$v_moneytype.$order_id.$chinabank_account_id.$v_url.$key;
   		$v_md5info = strtoupper(md5($text));
   		setvar("md5info",$v_md5info);
   		setvar("v_url",$v_url);
		setvar("PayOrderId",$order_id);
		setvar("UaOrderId",$last_order_id);
		setvar("ChinaBankAccount",$chinabank_account_id);
		setvar("OrderPrice", $order_price);
		$tpl_file = "upgrade_done";
	}
}else{
	$fields = "Company.id as CompanyId,Company.name as CompanyName,Member.tel as Tel,Member.email as Email";
	$sql = "select ".$fields." from ".$member->getTable(true)." left join ".$company->getTable(true)." on Member.id=Company.member_id where Member.id=".$_SESSION['MemberID'];
	if ($_SESSION['MemberID']) {
		$result = $g_db->GetRow($sql);
		setvar("MemberInfo",$result);
	}
	$fields = "name as MembertypeName,id as MembertypeId";
	$result = $membertype->findAll($fields," status=1",null,0,10);
	setvar("Membertypes",$result);
}
template($theme_name."/user_".$tpl_file);
?>
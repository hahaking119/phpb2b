<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("member","membertype", "area", "company", "trade", "product", "access");
require(LIB_PATH .'time.class.php');
require(SITE_ROOT.'./libraries/page.php');
$access = new Accesses();
$member = new Members();
$area = new Areas();
$company = new Companies();
$trade = new Trades();
$product = new Products();
$membertype = new Membertypes();
require("session_cp.inc.php");
$tpl_file = "member_index";
$conditions = null;
$result = $membertype->findAll("id as MembertypeId,name as MembertypeName",$conditions, " id desc", 0,15);
$user_types = array();
foreach ($result as $key=>$val) {
	$user_types[$val['MembertypeId']] = $val['MembertypeName'];
}
setvar("UserTypes",$user_types);
$conditions = "1";
if (isset($_GET['search'])) {
	if($_GET['member']['name']) $conditions.=" and Member.username like '%".$_GET['member']['name']."%'";
	if($_GET['member']['status']>=0) $conditions.=" and Member.status='".$_GET['member']['status']."'";
	if($_GET['member']['user_type']>=0) $conditions.=" and Member.user_type=".$_GET['member']['user_type'];
}
if (isset($_POST['ua_action'])) {
	$actions = explode("_", $_POST['ua_action']);
	if($actions[0]=="status"){
		$member->updateUserStatus($_POST['id'],$actions[1]);
	}elseif($actions[0]=="membertype"){
		$ids = implode(",", $_POST['id']);
		//根据企业类型, 取得会员期限.
		$time_limits = $access->read("default_livetime,after_livetime", $actions[1]);
		$new_exp_time = $access->getExpireTime($time_limits['default_livetime']);
		$g_db->Execute("update ".$member->getTable()." set user_type='".$actions[1]."',service_end_date='".$new_exp_time."' where id in (".$ids.")");
	}
}
if (isset($_POST['del'])) {
	$ids = implode(",", $_POST['id']);
	//删除可能存在的企业
	$g_db->Execute("delete from ".$company->getTable()." where member_id in (".$ids.")");
	$g_db->Execute("delete from ".$trade->getTable()." where member_id in (".$ids.")");
	$g_db->Execute("delete from ".$product->getTable()." where member_id in (".$ids.")");
	//删除可能有的产品， 供求，
	$member->del($_POST['id']);
}
if ($_GET['action'] == "mod") {
	$vals = null;
	$member_id = empty($_GET['id'])?intval($_POST['id']):intval($_GET['id']);
	if (isset($_POST['check_in'])){
		$vals['status'] = 1;
		if($member->save($vals, "update", $member_id)){
			flash("./alert.php");
		}else {
			flash("./alert.php?r=2");
		}
	}
	if (isset($_POST['check_out'])){
		$vals['status'] = 0;
		if($member->save($vals, "update", $member_id)){
			flash("./alert.php");
		}else {
			flash("./alert.php","./member.php");
		}
	}
	if (isset($_POST['save'])) {
		$vals = $_POST['member'];
		if($_POST['ServiceFromDate']!="None") {
		    $vals['service_start_date'] = Times::dateConvert($_POST['ServiceFromDate']);
		}
		if($_POST['ServiceEndDate']!="None") {
		    $vals['service_end_date'] = Times::dateConvert($_POST['ServiceEndDate']);
		}
		if(!empty($_POST['countryid'])) $vals['province_code_id'] = $_POST['countryid'];
		if(!empty($_POST['provinceid'])) $vals['city_code_id'] = $_POST['provinceid'];
		if(!empty($_POST['member']['userpass'])) $vals['userpass'] = md5($_POST['member']['userpass']);else unset($vals['userpass']);

		array_walk($vals, "uatrim");
		if($member_id){
			$vals['modified'] = $time_stamp;
			$result = $member->save($vals, "update", $member_id);
		}else{
		    $vals['status'] = 1;
		    $vals['created'] = $time_stamp;
		    $result = $member->save($vals);
		}
		if($result){
			flash("./alert.php", null, null, 1, null, "./member.php?action=list", "./member.php?action=mod&id=".$member_id);
		}else {
			flash("./alert.php","./member.php",null,0);
		}
	}elseif ($member_id){
		$res = $member->read(null,$member_id);
		if (empty($res)) {
			flash("./alert.php",null, lgg("data_not_exists"));
		}
		$area_result = $g_db->GetArray("select name from ".$area->getTable()." where code_id in (".$res['MemberProvinceCodeId'].",".$res['MemberCityCodeId'].")");
		$res["ProvinceName"]=$area_result[0]['name'];
		$res['CityName'] = $area_result[1]['name'];
		setvar("m",$res);
	}
	uaAssign(array("WorkPosition"=>$member->ua_positions,"Genders"=>$member->genders));
	setvar("MemberStatus",$member->member_status);
	$tpl_file = "member_edit";
}
$fields = "Member.id AS MemberID,Member.username AS MemberName,CONCAT(Member.firstname,Member.lastname) AS NickName,Member.user_type AS MemberType,Member.status AS MemberStatus,Member.created AS CreateDate,Member.last_login AS LastLogin,Member.today_logins AS Logins ";
$amount = $member->findCount($conditions,"Member.id");
if (isset($_POST['gopage']) && intval($_POST['topage'])) {
	$page = intval($_POST['topage']);
}
pageft($amount,$display_eve_page);
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
setvar("MemberList",$member->findAll($fields, $conditions, "Member.id DESC ",$firstcount,$displaypg));
		uaAssign(array("MemberStatus"=>$member->member_status,"Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
template($tpl_file);
?>
<?php
$inc_path = "../";
$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uses("trade","member","membertype","access");
$membertype = new Membertypes();
$access = new Accesses();
$trade = new Trades();
$member = new Members();
$memberinfo = $member->read("firstname,lastname,gender,service_start_date,service_end_date,last_login",$_SESSION['MemberID']);

if (!empty($memberinfo)) {
uaAssign(array("UserName"=>$memberinfo['firstname'].$memberinfo['lastname'],"MemberGenger"=>$memberinfo['gender'],"LastLogin"=>date("Y-m-d",$memberinfo['last_login'])));
	$total_days = ($memberinfo['service_end_date']-$memberinfo['service_start_date']);
	if($total_days<=0) {
		$total_days=1;
		$service_interation = 1;
	}else{
	$service_interation = intval((($time_stamp-$memberinfo['service_start_date'])/$total_days)*100);
	}
	setvar("service_days",$service_interation);
	setvar("MemberInfo",$memberinfo);
	setvar("MembertypeName",$membertype->field("name", "id=".intval($ua_user['user_type'])));
	template("index");
}
?>
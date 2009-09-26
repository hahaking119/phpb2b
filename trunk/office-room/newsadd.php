<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("companynews", "company");
$company = new Companies();
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$companynew = new Companynewses();
if (!empty($_GET['id'])) {
	$res = $companynew->read("Companynewses.id as ID,title as Title,content as Content,created as CreateDate",$_GET['id']);
	setvar("NewsInfo",$res);
	setvar("ShowCaption","none");
}

if (isset($_POST['save'])) {
	$vals = null;
	$vals['title'] = $_POST['title'];
	$vals['content'] = $_POST['content'];
	function uatrim(&$val)
	{
		$val = strip_tags(trim($val));
	}
	array_walk($vals,"uatrim");
	$check_news_update = $access->field("check_news_update","membertype_id=".$ua_user['user_type']);
	if ($check_news_update=="0") {
		$vals['status'] = 1;
	}else {
		$vals['status'] = 0;
		$message_info = lgg('msg_wait_check');
	}
	if(!empty($_POST['newsid'])){
		$vals['modified'] = $time_stamp;
		$result = $companynew->save($vals, "update", $_POST['newsid'], null, " and member_id=".$_SESSION['MemberID']);
		flash("./tip.php", "./news.php", $message_info);
	}else {
		$vals['created'] = $time_stamp;
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['company_id'] = $company_id;
		$result = $companynew->save($vals);
		flash("./tip.php","./news.php",$message_info);
	}
}
template("news_add");
?>
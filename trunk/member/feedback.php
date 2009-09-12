<?php
if(!defined('IN_UALINK')) exit('Access Denied');
uses("companymessage");
$companymessage = new Companymessages();
$cid = intval($_GET['cid']);
if ($_POST['cid'] && !empty($_POST['feed'])) {
	$member_id = $company->field("member_id", "id=".intval($_POST['cid']));
	$vals = $_POST['feed'];
	$vals['title'] = 'A new feedback';
	$vals['created'] = $time_stamp;
	$vals['status'] = 0;

	if(!empty($_SESSION['MemberID'])) $vals['from_member_id'] = $_SESSION['MemberID'];
	$vals['to_member_id'] = $member_id;
	array_walk($vals,"uatrim");
	if($companymessage->save($vals)){
		PB_goto(URL."message.php?message=".urlencode(lgg("feedback_already_submit")));
	}else {
		PB_goto(URL."message.php?message=".urlencode(lgg('sys_error')));
	}
}
template($tplpath."feedback");
?>
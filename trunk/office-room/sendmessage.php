<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uses("member","company","companymessage");
$member = new Members();
$companymessage = new Companymessages();
$company = new Companies();
if (isset($_POST['save']) && !empty($_POST['companymessage'])) {
	$vals = array();
	$vals = $_POST['companymessage'];
	array_walk($vals, "uatrim");
	$t_to = intval($vals['to_member_id']);
	if($t_to>0){
	    $vals['to_member_id'] = $t_to;
	}else{
	    $t_to = $g_db->GetOne("select Member.id as MemberId from ".$member->getTable(true)." where username='".$vals['to_member_id']."'");
	    if (!empty($t_to)) {
	    	$vals['to_member_id'] = $t_to;
	    }else{
	        $vals['to_member_id'] = -1;
	    }
	}
	$vals['from_member_id'] = $_SESSION['MemberID'];
	$vals['created'] = $time_stamp;
	$result = $companymessage->save($vals);
	if ($result) {
		flash("./tip.php",null);
	}
}
template("send_message");
?>
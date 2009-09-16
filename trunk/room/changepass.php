<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("memberlog","member");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
$memberlog = new Memberlogs();
$member = new Members();
$memberinfo = $member->read("id,userpass,answer,question", $_SESSION['MemberID']);
$xajax = new xajax();
$xajax->configure('javascript URI', URL."libraries/source/xajax/");
function checkOldPassword($passwd)
{
	global $memberinfo;
    $obj = new xajaxResponse();
    $oldpassword = md5(trim($passwd));
    if (strcmp($oldpassword,$memberinfo['userpass'])!=0) {
    	$obj->assign("checkoldpwdDiv","innerHTML", "<img src='".URL."images/check_error.gif' />   ".lgg('old_pwd_error')."");
    	$obj->assign("BtnChangePwd","disabled",true);
    }else {
    	$obj->assign("checkoldpwdDiv","innerHTML", "<img src='".URL."images/check_right.gif' />");
    	$obj->assign("BtnChangePwd","disabled",false);
    }
    return $obj;
}
$xajax->register(XAJAX_FUNCTION, "checkOldPassword");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
if (isset($_POST['change']) && !empty($_POST['newpass'])) {
	$OldPassCheck = $member->checkUserLogin($_SESSION['MemberName'],$_POST['oldpass']);
	if ($OldPassCheck>0) {
		$vals = array();
		$vals['userpass'] = md5(trim($_POST['newpass']));
		if (!empty($_POST['question']) && !empty($_POST['answer'])) {
			$vals['question'] = $_POST['question'];
			$vals['answer'] = $_POST['answer'];
		}
		$result = $member->save($vals, "update", $_SESSION['MemberID']);
		flash("./tip.php");
	}else {
		flash("./tip.php", null, lgg('old_pwd_error'), 0);
	}
}
template("changepass");
?>
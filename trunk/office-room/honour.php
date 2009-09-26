<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("attachment", "company");
$attachment = new Attachments();
$company = new Companies();
require(SITE_ROOT.'./libraries/page.php');
$tpl_file = "honour_index";
if (isset($_GET['action'])){
	if($_GET['action']=="del" && !empty($_GET['id'])) {
		$result = $attachment->del(intval($_GET['id']), "member_id=".$_SESSION['MemberID']);
	}
}
if (isset($_POST['save'])) {

	$vals = array();
	$pid = intval($_POST['id']);
	$result = true;
	if (!empty($_FILES['pic']['name'])) {
	    include("../libraries/class.thumb.php");
	    $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
	    $attachment->out_file_name = $_SESSION['MemberID']."_".$pid."_".$time_stamp;
		$attach['title'] = $_POST['honour']['title'];
		$attach['description'] = $_POST['honour']['description'];
		$attach['company_id'] = $company->field("id", "member_id=".$_SESSION['MemberID']);
		$attach['type_id'] = 9;
	    $attachment->upload_process();
	    if ( $attachment->error_no )
	    {
	        flash("./tip.php","./honour.php", lgg("upload_error").$attachment->error_no,0);
	    }
	    $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
	    $img->Thumb();
		$attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
		//$vals['remote'] = URL."attachment/".$vals['file_name'];
	}
	if ($result) {
		flash("./tip.php", "./honour.php");
	}else{
		flash("./tip.php", "./honour.php", lgg('honour_false'), 0);
	}
}
if (isset($_GET['action']) && $_GET['action']=="mod") {
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$honour_info = $attachment->read($id);
		setvar("HonourInfo", $honour_info);
	}
	$tpl_file = "honour_edit";
}else{
	$fields = "id as AttachmentId,title as AttachmentTitle,description as AttachmentDescription,attachment as AttachmentFileName,created as AttachmentCreateDate";
	$result = $attachment->findAll($fields, "type_id=9 and status=1 and member_id=".$_SESSION['MemberID'], "id desc", 0, 15);
	setvar("Lists", $result);
}
template($tpl_file);
?>
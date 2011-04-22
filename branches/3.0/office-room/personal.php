<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: personal.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("attachment");
require(LIB_PATH. "typemodel.inc.php");
$attachment = new Attachment('photo');
$member = new Members();
$member_controller = new Member();
$conditions = null;
if (isset($_POST['save'])) {
	pb_submit_check('member');
	$vals['office_redirect'] = $_POST['member']['office_redirect'];
	if (!empty($_FILES['photo']['name'])) {
		$attachment->if_orignal = false;
		$attachment->if_watermark = false;
		$attachment->rename_file = "photo-".$_SESSION['MemberID'];
		$attachment->upload_process();
		$vals['photo'] = $attachment->file_full_url;
	}
	$result = $member->save($vals, "update", $_SESSION['MemberID']);
	$memberfield->primaryKey = "member_id";
	$result = $memberfield->save($_POST['memberfield'], "update", $_SESSION['MemberID']);
	if(isset($_POST['personal']['resume_status']))
	$pdb->Execute("REPLACE INTO {$tb_prefix}personals (member_id,resume_status,max_education) VALUE (".$_SESSION['MemberID'].",'".$_POST['personal']['resume_status']."','".$_POST['personal']['max_education']."')");
	if(!$result){
		flash('action_failed');
	}else{
		flash('success');
	}
}
setvar("Genders",get_cache_type('gender', '', array(-1)));
setvar("Educations",get_cache_type('education'));
setvar("OfficeRedirects", $member_controller->office_redirects);
if (!empty($memberinfo['photo'])) {
	$memberinfo['image'] = pb_get_attachmenturl($memberinfo['photo'], "../", "small");
}
setvar("item",$memberinfo);
template("personal");
?>
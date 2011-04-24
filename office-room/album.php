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
 * @version $Id: album.php 496 2009-12-28 03:23:20Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(LIB_PATH. 'page.class.php');
uses("attachment", "album");
check_permission("album");
$attachment = new Attachment('pic');
$album = new Albums();
$tpl_file = "album";
$page = new Pages();
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_POST['do'])) {
	pb_submit_check('album');
	$vals = $_POST['album'];
	$title = trim($vals['title']);
	$description = trim($vals['description']);
	$id = intval($_POST['id']);
	if (!empty($_FILES['pic']['name'])) {
		$attachment->title = $title;
		$attachment->description = $description;
		$attachment->rename_file = "album-".$time_stamp;
		$attachment->upload_process();
	}
	if (!empty($id)) {
		if (empty($attachment->id)) {
			$attachment_id = $pdb->GetOne("SELECT attachment_id FROM {$tb_prefix}albums WHERE id=".$id);
		}else{
			$attachment_id = $attachment->id;
		}
		$sql = "UPDATE {$tb_prefix}attachments a,{$tb_prefix}albums ab SET a.title='".$title."',a.description='".$description."',ab.attachment_id={$attachment_id} WHERE ab.id={$id} AND a.id=".$attachment_id;
	}else{
		$sql = "INSERT INTO {$tb_prefix}albums (member_id,attachment_id) VALUES (".$_SESSION['MemberID'].",".$attachment->id.")";
	}
	$result = $pdb->Execute($sql);
	if (!$result) {
		flash();
	}else{
		pheader("Location:album.php");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)) {
		$result = $album->del(intval($id), "member_id=".$_SESSION['MemberID']);
	}
	if ($do=="edit") {
		if (!empty($id)) {
			$album_info = $pdb->GetRow("SELECT a.title,a.description,ab.id,a.attachment FROM {$tb_prefix}albums ab LEFT JOIN {$tb_prefix}attachments a ON a.id=ab.attachment_id WHERE ab.member_id=".$_SESSION['MemberID']." AND ab.id={$id}");
			if (!empty($album_info['attachment'])) {
				$album_info['image'] = pb_get_attachmenturl($album_info['attachment'], "../");
			}
			setvar("item", $album_info);
		}
		$tpl_file = "album_edit";
		template($tpl_file);
		exit;
	}
}
$joins[] = "LEFT JOIN {$tb_prefix}attachments a ON a.id=Album.attachment_id";
$conditions[] = "Album.member_id=".$_SESSION['MemberID'];
$amount = $album->findCount($joins, $conditions, "Album.id");
$page->setPagenav($amount);
$result = $album->findAll("a.title,a.description,Album.id,a.attachment", $joins, $conditions, "Album.id DESC", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	for($i=0; $i<count($result); $i++){
		$result[$i]['image'] = pb_get_attachmenturl($result[$i]['attachment'], '../', "small");
	}
	setvar("Items", $result);
	setvar("ByPages", $page->pagenav);
}
template($tpl_file);
?>
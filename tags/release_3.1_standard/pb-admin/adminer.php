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
 * @version $Id: adminer.php 481 2009-12-28 01:05:06Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(PHPB2B_ROOT.'./libraries/page.class.php');
uses("member");
$member = new Members();
$tpl_file = "adminer";
$page = new Pages();
if (isset($_POST['changepass']) && !empty($_POST['data']['adminer'])) {
	$old_pass = trim($_POST['data']['old_pass']);
	if (!pb_strcomp($current_pass, md5($old_pass))) {
		flash();
	}
	$result = $adminer->updatePasswd($current_adminer_id, $_POST['data']['adminer']['user_pass']);
	if(!$result) {
		flash();
	}
}
   if(isset($_POST['del']) && !empty($_POST['id'])){
	    $ids = $_POST['id'];
	foreach($ids as $val){
	   if (pb_strcomp($val, $current_adminer_id)||pb_strcomp($val, $administrator_id)) {
			flash();
	   }else{
         $adminer->primaryKey = "member_id";
		 $result = $adminer->del(intval($val));
	    }
     }
   }
if (isset($_POST['save']) && !empty($_POST['data']['adminfield'])) {
	$vals = array();
	$vals = $_POST['data']['adminfield'];
	if (!empty($_POST['data']['adminer']['user_pass'])) {
		$vals['user_pass'] = $member->authPasswd($_POST['data']['adminer']['user_pass']);
	}
	$adminer->primaryKey = "member_id";
	if (!empty($_POST['data']['expired'])) {
		include(LIB_PATH. "time.class.php");
		$vals['expired'] = Times::dateConvert($_POST['data']['expired']);
	}
	if (!empty($_POST['member_id'])) {
		$member_id = intval($_POST['member_id']);
		$member->save($_POST['data']['member'], "update", $member_id);
		$result = $adminer->save($vals, "update", $member_id);
	}else{
		//search member_id
		if (!empty($_POST['data']['username'])) {
			$sql = "SELECT id FROM {$tb_prefix}members WHERE username='".$_POST['data']['username']."'";
			$member_id = $pdb->GetOne($sql);
			if ($member_id) {
				$vals['member_id'] = $member_id;
				$result = $adminer->save($vals);
			}else{
				flash("member_not_exists");
			}
		}else{
			flash();
		}
	}
	if(!$result){
		flash('', '', 0);
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	
	if ($do == "del" && !empty($id)) { 
		if (pb_strcomp($id, $current_adminer_id)||pb_strcomp($id,$administrator_id)) {
			flash();
		}else {
			$adminer->primaryKey = "member_id";
			$result = $adminer->del(intval($id));
		}
	}	
	if ($do == "profile") {
		$res = $pdb->GetRow("SELECT m.*,af.* FROM {$tb_prefix}adminfields af LEFT JOIN {$tb_prefix}members m ON m.id=af.member_id WHERE af.member_id={$current_adminer_id}");
		$res['member_id'] = $res['id'];
		setvar("item",$res);
		$tpl_file = "adminer.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "edit") {
		if(!empty($id)){
			$res = $pdb->GetRow("SELECT m.*,af.* FROM {$tb_prefix}adminfields af LEFT JOIN {$tb_prefix}members m ON m.id=af.member_id WHERE af.member_id={$id}");
			if($res['expired']) $res['expire_date'] = @date("Y-m-d", $res['expired']);
			setvar("item",$res);
		}
		$tpl_file = "adminer.edit";
		template($tpl_file);
		exit;
	}
	if($do=="password"){
		$tpl_file = "adminer.password";
		template($tpl_file);
		exit;
	}
}
setvar("Items", $result = $pdb->GetArray("SELECT m.username,af.first_name,af.last_login,af.last_ip,af.last_name,m.id,af.member_id FROM {$tb_prefix}adminfields af LEFT JOIN {$tb_prefix}members m ON m.id=af.member_id"));
template($tpl_file);
?>
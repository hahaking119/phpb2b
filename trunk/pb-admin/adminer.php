<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
require(SITE_ROOT.'./libraries/page.php');
$position_path = array(array("name"=>"Modify Password","url"=>"./admin.php"));
setvar("CurrentPos",pb_format_current_position($position_path));
uses("adminer","adminrole");
$adminer = new Adminers();
$adminrole = new Adminroles();
$tpl_file = "adminer_index";
if ($_GET['action'] == "logout") {
	unset($_SESSION['admin']);
	session_destroy();
	PB_goto("index.html");
}
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	if (uaStrCompare($_GET['id'],$current_adminer_id)) {
		PB_goto("./alert.php");
	}else {
		$result = $adminer->del(intval($_GET['id']));
	}
}
if (isset($_POST['changepass']) && !empty($_POST['adminer'])) {
	$vals['user_pass']	= md5(trim($_POST['adminer']['user_pass']));
	$tmp_userid = $adminer->find($current_adminer,"id","user_name");
	$result = $adminer->save($vals, "update", $tmp_userid, null, " AND user_name='".$current_adminer."'");
	if($result) {
		PB_goto("./alert.php");
	}else {
		PB_goto("./alert.php?r=2");
	}
}
if (isset($_POST['save']) && !empty($_POST['adminer'])) {
	$checked = false;
	$vals = array();
	$vals = $_POST['adminer'];
	if (!empty($_POST['adminer']['user_pass'])) {
		$vals['user_pass'] = md5($_POST['adminer']['user_pass']);
	}
	$result = $adminer->save($vals);
	if(!$result){
		PB_goto("./alert.php?r=3");
	}
}
if ($_GET['action'] == "mod") {
	$adminer->primaryKey = "user_name";
	$res = $adminer->read(null, $current_adminer);
	setvar("a",$res);
	$tpl_file = "adminer_edit";
}elseif($_GET['action']=="password"){
	$tpl_file = "adminer_password";
}else{
	
	$amount = $adminer->findCount();
	$joins = array(
	"Adminrole"=>array("fullTableName"=>$adminrole->getTable(true),"foreignKey"=>"depart_id","fields"=>"Adminrole.name as AdminroleName")
	);
	pageft($amount, $display_eve_page);
	setvar("AdminerList",$adminer->findAll("Adminer.id as AdminerId,user_name as AdminerUserName,first_name as AdminerFirstName,last_name as AdminerLastName,last_login as AdminerLastLogin", $conditions, "Adminer.id desc", $firstcount, $displaypg));
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}
template($tpl_file);
?>
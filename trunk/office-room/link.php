<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","companylink","company");
$company = new Companies();
$member = new Members();
$companylink = new Companylinks();
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$conditions = "Companylink.CompanyID1=".$company_id;
$tpl_file = "link";
if (isset($_POST['delete'])) {
	$deleted = false;
	if (is_array($_POST['frid'])) {
		$conditions = "CompanyID1=".$company_id;
		$deleted = $companylink->del($_POST['frid'], $conditions);
		if($deleted){
			flash("tip.php", "link.php", lgg("action_complete"));
		}else{
			flash("tip.php", "link.php", lgg("no_data_deleted"));
		}
	}else{
		$errmsg = lgg("no_data_deleted");
		echo $errmsg;
	}
}
if (isset($_POST['save'])) {
	$record = array();
	$record['friendlogo'] = $_POST['logo'];
	if (!empty($_POST['id'])) {
		if($companylink->checkID($_POST['id'],$_SESSION['MemberID'])){
			$companylink->update($record,"companylinks","update",$_POST['id']);
			PB_goto("./tip.php?id=1000");
		}else {
			PB_goto("./tip.php?id=1004");
		}
	}
}
if (isset($_GET['action'])){
	if($_GET['action'] == "edit" && !empty($_GET['id'])) {
		$linkinfo = $companylink->getLinkInfo($_GET['id']);
		setvar("LinkInfo",$linkinfo);
		$tpl_file = "link";
	}
}
$joins = array(
	$company->name=>array("fullTableName"=>$company->getTable(true),"foreignKey"=>"CompanyID2","conditions"=>null,"fields"=>"Company.name as CompanyName","dependent"=>null),
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","conditions"=>null,"fields"=>"Member.username as MemberUsername","dependent"=>null)
	);
setvar("FriendLinks",$companylink->findAll($companylink->common_cols,$conditions,"Companylink.id DESC",0,10));
unset($joins);
template($tpl_file);
?>
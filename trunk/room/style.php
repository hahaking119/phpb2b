<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("company","templet");
require(SITE_ROOT.'./app/include/page.php');
$templet = new Templets();
$company = new Companies();
uaCheckPermission(2);
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
if (isset($_POST['SelectStyle'])) {
	$vals = null;
	$vals['style_id'] = intval($_POST['styleid']);
	$style_name = $templet->find($vals['style_id'],"title");
	$data['Templet']['title'] = $style_name;
	$company->update($vals, "update", $company_id);
}
setvar("CompanyStyleId",$company->find($company_id,"style_id","id"));
$conditions = "status=1";
$amount = $templet->findCount($conditions);
pageft($amount,6);
$fields = "id as TempletId,title as TempletTitle,picture as TempletPicture";
$res = $templet->findAll($fields,null,"Templet.id desc",$firstcount,$displaypg);
uaAssign(array("Amount"=>$amount,"ByPages"=>$pagenav));
setvar("templets",$res);
template($office_theme_name."/"."style");
?>
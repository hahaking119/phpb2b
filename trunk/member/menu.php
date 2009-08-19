<?php
if(!defined('IN_UALINK')) exit('Access Denied');
uses("companylink","companyoutlink","templet","member","company","membertype");
$member = new Members();
$membertype= new Membertypes();
$company = new Companies();
$companylink = new Companylinks();
$companyoutlink = new Companyoutlinks();
$templet = new Templets();
$get_user_name = $userid;
$fields = null;
$fields.= "Company.id as ID,Company.style_id AS StyleId,Company.name AS CompanyName,Company.english_name AS CompanyEnglishName,configs,Company.member_id,Company.description AS CompanyDescription";
if (!empty($get_user_name)) {
	$sql = "select ".$fields." from ".$company->getTable(true)." left join ".$member->getTable(true)." on Member.id=Company.member_id where Company.status=1 and Member.username='$get_user_name'";
}elseif(!empty($_GET['id'])) {
	$sql = "select ".$fields." from ".$company->getTable(true)." where Company.status=1 and Company.id=".intval($_GET['id']);;
}
$companyinfo = $g_db->GetRow($sql);
setvar("cinfo",$companyinfo);
if (empty($companyinfo) || !$companyinfo) {
	alert(lgg('company_checking'));
}
$companystyle = $company->getTempletName($companyinfo['configs']);
$tplpath = (empty($companystyle) || !$companystyle)?"member/default/":"member/".$companystyle."/";
$space_imgurl = "templates/".$tplpath;
if(PRETEND_HTML_LEVEL>0){
	$space_imgurl = "../../templates/".$tplpath;
}
uaAssign(array("I_PATH"=>$space_imgurl, "TplPath"=>$tplpath));
$conditions = " and Companylink.companyid1=".intval($companyinfo['ID'])." and Company.id=Companylink.companyid2";
$link_sql = "(select Companylink.companyid2 AS FriendID,Company.name AS FriendName,null as CompanyoutlinkUrl,Companylink.user_name as UserName from ".$companylink->getTable(true).",".$company->getTable(true)." where 1 ".$conditions.")";
$link_sql.= "union all";
$link_sql.= "(select null as FriendID,Companyoutlink.name as FriendName,Companyoutlink.url as CompanyoutlinkUrl,null as UserName from ".$companyoutlink->getTable(true)." where Companyoutlink.company_id=".intval($companyinfo['ID']).")";
$result = $g_db->GetAll($link_sql);
unset($link_sql, $fields);
$company->setMenu(intval(PRETEND_HTML_LEVEL));
//取得会员类型,显示在企业主页
$membertype_id = $member->field("user_type", "username='$get_user_name'");
$membertype_name = $membertype->field("name", "id=".$membertype_id);
setvar("MembertypeName",$membertype_name);
setvar("Menus", $company->getMenu());
setvar("Friends", $result);
?>
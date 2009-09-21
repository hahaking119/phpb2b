<?php
$inc_path = "../";
$li = 3;
require("../global.php");
uses("product","industry","company","member");
include(SITE_ROOT.'./libraries/page.php');
include(SITE_ROOT."./data/cache/".$cookiepre."industry.inc.php");
include(SITE_ROOT."./data/cache/".$cookiepre."area.inc.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('loadDivSubIndustry'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
$member = new Members();
$industry = new Industries();
$company = new Companies();
$conditions = null;
$conditions = " Company.status=1 ";
$positions = array();
$_positions[] = lgg("company_center");
$subs = array();
if(isset($_GET['filter']) && !empty($_GET['id'])){
	$conditions.=" and Company.type_id=".intval($_GET['id']);
	$_positions[] = "<a href='#' title=''>".urldecode($_GET['name'])."</a>";
}
if(!empty($_GET['le'])){
	$conditions.=" and Company.first_letter='".strtolower($_GET['le'])."'";
	$_titles[] = sprintf(lgg("corp_by_letter"), $_GET['le']);
	$_positions[] = sprintf(lgg("corp_by_letter"), $_GET['le']);
}
if (isset($_GET['search_list'])) {
	if($_GET['province_id']) $conditions.= " AND Company.province_code_id=".$_GET['provinceid'];
	if($_GET['city_id']) $conditions.= " AND Company.city_code_id=".$_GET['cityid'];
	if($_GET['aindustry']) $conditions.= " AND Company.industry_id=".intval($_GET['aindustry']);
}
if(isset($_GET['skeyword'])) {
	$searchwords = strip_tags($_GET['skeyword']);
	$conditions.= " AND Company.name like '%".$searchwords."%'";
	setvar("searchwords","<font color=\"red\">".$searchwords."</font>");
}
$tpl_file = "list";
if (!empty($_GET['industryname'])) {
	$ind_res = $g_db->GetRow("select id,parentid,name from {$tb_prefix}industries where name='".urldecode($_GET['industryname'])."'");
	if(!empty($ind_res)){
	    if($ind_res['parentid']==0){
	        $conditions.= " and Company.industry_id in (".$ind_res['id'].",".$industry->getSubIndustries($ind_res['id']).")";
	    }else{
	        $conditions.= " and Company.industry_id=".$ind_res['id'];
	    }
	    $sid = $ind_res['id'];
	    setvar("IndsutryName", $industry_name = $ind_res['name']);
	    $_titles[] = $industry_name;
	    $_positions[] = $industry_name;
	}
}
if (isset($_GET['type'])) {
	if ($_GET['type']=="commend") {
		$_titles[] = lgg("recommend");
		$positions[] = lgg("recommend");
		$conditions.=" and Company.if_commend='1'";
	}
}
if (isset($_GET['province_id'])) {
	$conditions.=" and Company.province_code_id=".intval($_GET['province_id']);
}
if (isset($_GET['city_id'])) {
	$conditions.=" and Company.city_code_id=".intval($_GET['city_id']);
}
if(!empty($sid)){
	$joins = array(
		"Company"=>array("fullTableName"=>$company->getTable(true),"foreignKey"=>"company_id","fields"=>"Company.name as CompanyName, Company.id as CompanyId")
	);
	$subs = $industry->getAllIndustry("AND Industry.parentid=".$sid);
}

if(isset($_GET['page'])){
	$_titles[] = "Page".intval($_GET['page']);
}
$fields = "Company.id as ID,Member.user_type as MemberUserType,Company.name as Name,Company.member_id as MemberID,Company.created as CreateTime,Company.main_prod as MainProduct,Company.description as Description,Company.manage_type,Member.username as MemberUsername,Company.province_code_id as CompanyProvinceId,Company.picture as CompanyPicture,Company.city_code_id as CompanyCityId,Company.industry_id as IndustryId ";
if (!empty($_GET['type_id'])) {
	$conditions.=" and Member.user_type=".intval($_GET['type_id']);
	require(CACHE_PATH.$cookiepre."membertype.inc.php");
	$positions[] = $_titles[] = $UL_DBCACHE_MEMBERTYPES[intval($_GET['type_id'])];
}else {
    $positions[] = $_titles[] = lgg("corp_member");
}
unset($joins);
$joins["Member"] =array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id");
$ListAmount = $company->findCount($conditions, "Company.id");
pageft($ListAmount,10);
unset($joins);

$joins = array(
"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>null),
"Industry"=>array("fullTableName"=>$industry->getTable(true),"foreignKey"=>"industry_id","fields"=>null));
setvar("Lists", $lists = $company->findAll($fields.",Member.credit_level as MemberCreditLevel,Member.user_type as Memertype,Member.username as MemberUsername,Industry.name as IndustryName",$conditions,"Company.id desc",$firstcount,$displaypg));

uaAssign(array(
"ByPages"=>$pagenav,
"OtherIndustry"=>$subs,
"AllIndustry"=>$UL_DBCACHE_INDUSTRIES,
"AllArea"=>$UL_DBCACHE_AREAS,
"ManageTypes"=>$company->manage_type,
"Letters"=>range('A','Z')
));
unset($subs);
unset($UL_DBCACHE_INDUSTRIES, $UL_DBCACHE_AREAS);
$company->setPageTitle($_titles, $_positions);
uaAssign(array("pageTitle"=>$company->title, "pagePosition"=>$company->position));
template($theme_name."/company_".$tpl_file);
?>
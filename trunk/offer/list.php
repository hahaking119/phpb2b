<?php
$inc_path = "../";
$li = 0;
require($inc_path."global.php");
uses("trade","industry","company","area","member", "offer");
$member = new Members();
require(SITE_ROOT.'./app/include/page.php');
$area = new Areas();
$offer = new Offers();
$company = new Companies();
$industry = new Industries();
$trade = new Trades();
include(SITE_ROOT."./data/cache/".$cookiepre."industry.inc.php");
include(SITE_ROOT."./data/cache/".$cookiepre."area.inc.php");
$areas = $industrys = array();
foreach ($UL_DBCACHE_AREAS as $key=>$val){
    if ('0000' == substr($key, -4, 4)) {
        $areas[$key] = $val;
    }
}
foreach ($UL_DBCACHE_INDUSTRIES as $key=>$val){
    if ($key<100) {
    	$industrys[$key] = $val;
    }
}
$tpl_file = "list";
$conditions = null;
if (!empty($_GET['sid'])) {
	$sid = intval($_GET['sid']);
	$conditions.= " and Trade.industry_id=".$sid;
}
if (isset($_GET['areaid'])) {
	$conditions.= " and Trade.area_id =".intval($_GET['areaid']);
}
if (!empty($_GET['industryname'])) {
	$ind_res = $g_db->GetRow("select id,parentid,name from {$tb_prefix}industries where name='".urldecode($_GET['industryname'])."'");
	$_titles[] = $_positions[] = $ind_res['name'];
	if($ind_res['parentid']==0){
		$conditions = " and Trade.industry_id in (".$industry->getSubIndustries($ind_res['id']).")";
	}else{
	    $parent_name = $g_db->GetOne("select name from {$tb_prefix}industries where id=".$ind_res['parentid']);
	    $_titles[] = $_positions[] = $parent_name;
		$conditions = " and Trade.industry_id=".$ind_res['id'];
	}
	$sid = $ind_res['id'];
}
if (isset($_GET['skeyword'])) {
	$searchkeywords = $_GET['skeyword'];
	$conditions.= " and Trade.topic like '%".$searchkeywords."%'";
	setvar("searchwords","<font color=\"red\">".$searchkeywords."</font>");
	$_titles[] = $_positions[] = $searchkeywords;
}
if (isset($_GET['type'])) {
	if($_GET['type']=="urgent"){
		$conditions.=" and Trade.if_urgent='1'";
		$_titles[] = $_positions[] = lgg("urgent_offer");
	}
}
if (isset($_GET['filter'])) {
	$type_id = array_search($_GET['filter'], $trade->getTradeTypes());
	setvar("current_".$type_id, " id='current'");
	$conditions.= " and Trade.type_id='".intval($type_id)."'";
	$_positions[] = $_titles[] = urldecode($_GET['filter']);
}else{
    $_positions[] = $_titles[] = lgg("offer_center");
}

if (!empty($_GET['companytype'])) {
    uses("companytype");
    $companytype =  new Companytypes();
	$conditions.= " and Company.type_id=".intval($_GET['companytype']);
	$_titles[] = $_positions = $companytype->field("name", "id=".intval($_GET['companytype'])).lgg("offer_by_corp");
	$joins['Company']=array("fullTableName"=>$company->getTable(true),"foreignKey"=>"company_id","conditions"=>"Company.type_id=".intval($_GET['companytype']));
}
if (!empty($_GET['search_list'])) {
	if($_GET['provinceid']) $conditions.= " and Trade.province_id=".$_GET['provinceid'];
	if($_GET['cityid']) $conditions.= " and Trade.city_id=".$_GET['cityid'];
	if($_GET['aindustry']) $conditions.= " and Trade.industry_id=".$_GET['aindustry'];
}
if(!empty($sid)){
	$subs = $industry->getAllIndustry("and ParentID=".$sid);
}else{
	$subs = $industry->getAllIndustry("and ParentID=0");
}

$conditions.= " and Trade.status=1";
//$conditions.= " and Trade.status=1 and Trade.type_id in ".$trade_type."";
$tables = $trade->getTable(true);

$ListAmount = $trade->findCount(" 1 ".$conditions);
pageft($ListAmount,10);
$joins["Member"] =array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.user_type as Membertype,Member.username as MemberUsername");
$joins["Offer"] =array("fullTableName"=>$offer->getTable(true),"foreignKey"=>"id","PrimaryKey"=>"trade_id","fields"=>"prim_im,prim_imaccount,Offer.company_name as OfferCompanyName,prim_tel as PrimTel");
setvar("Lists",$trade->findAll($trade->mini_trade_cols," 1 ".$conditions,"Member.user_type desc,Trade.id desc",$firstcount,$displaypg));
$trade->setPageTitle($_titles, $_positions);
uaAssign(array("pageTitle"=>$trade->getTitle(), "pagePosition"=>$trade->getPosition()));

uaAssign(array("ByPages"=>$pagenav,"Li"=>$li, "OtherIndustry"=>$subs, "Industries"=>$industrys, "Areas"=>$areas));
unset($subs);
template($theme_name."/trade_".$tpl_file);
?>
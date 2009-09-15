<?php
$inc_path = "../";
$li = 4;
require($inc_path."global.php");
uses("company","industry","product","member");
require(SITE_ROOT.'./app/include/page.php');
$member = new Members();
$industry = new Industries();
$product = new Products();
$prod_conditions = " and Product.status=1 ";
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
if (!empty($_GET['industryname'])) {
	$sid = $industry->field("id", "name='".urldecode($_GET['industryname'])."'");
}
if (!empty($_GET['sid'])) {
	$sid = intval($_GET['sid']);
}
if (isset($_GET['areaid'])) {
	$prod_conditions.= " and Product.province_id =".intval($_GET['areaid']);
}
if (!empty($_GET['search_list'])) {
	if($_GET['provinceid']) $conditions.= " and Product.province_id=".$_GET['provinceid'];
	if($_GET['cityid']) $conditions.= " and Product.city_id=".$_GET['cityid'];
	if($_GET['aindustry']) $conditions.= " and Product.industry_id=".$_GET['aindustry'];
}
if (isset($_GET['type'])) {
	if($_GET['type']=="commend"){
	    $prod_conditions = " and Product.ifcommend='1'";
	    setvar("IndsutryName", lgg('commend_prod'));
	}
}

if(isset($_GET['skeyword'])) {
	$searchkeywords = strip_tags($_GET['skeyword']);
	setvar("searchwords","<font color=\"red\">".$searchkeywords."</font>");
	$prod_conditions.= " and Product.name like '%".$searchkeywords."%'";
}
$subs = array();
if(!empty($sid)){
	$subs = $industry->getAllIndustry("and Industry.parentid=".$sid);
	$ind_res = $industry->read("parentid,name", $sid);
	if($ind_res['parentid']==0){
		$prod_conditions = " and Product.industry_id in (".$industry->getSubIndustries($sid).")";
	}else{
		$prod_conditions = " and Product.industry_id=".$sid;
	}
	setvar("IndsutryName", $ind_res['name']);
}
$ListProductAmount = $product->findCount(" 1 ".$prod_conditions,"Product.id");
pageft($ListProductAmount,15);
$joins = array(
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username as UserName,Member.user_type as Membertype,Member.credit_level as CreditLevel")
	);
setvar("Lists",$product->findAll("Product.id AS ID,Product.member_id,Product.picture AS ProductPicture,Product.name AS Name,Product.content AS Description,html_file_id AS HtmlFileId", " 1 ".$prod_conditions." ", "Product.ifcommend desc,Member.user_type desc,Product.id desc", $firstcount, $displaypg));

uaAssign(array("ByPages"=>$pagenav,"OtherIndustry"=>$subs, "Industries"=>$industrys, "Areas"=>$areas));
unset($subs);
template($theme_name."/product_list");
?>
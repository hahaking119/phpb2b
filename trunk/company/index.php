<?php
$inc_path = "../";
$li = 3;
require("../global.php");
include(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("member","company","companytype", "htmlcache","industry");
$company = new Companies();
$industry = new Industries();
$htmlcache = new Htmlcaches();
$companytype = new Companytypes();
$member = new Members();
$tables = $company->getTable(true);
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$smarty->register_function("format_amount","splitIndustryAmount");
//检测企业视频展播xml文件
$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('getIndustryList', BASE_DIR.'ajax.php'));
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', BASE_DIR.'ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
$sql = null;
$res = null;
$res = $g_db->GetArray("select name from {$tb_prefix}companies where status='1' order by id desc limit 10");
foreach ($res as $val) {
	$c[] = $val['name'];
}
unset($res);
$smarty->assign("MetaLatestCompany", implode(",", $c));
$total_company = $company->findCount();
$arrCompanyStat = array();

$sql = "select type_id,count(id) as CurAmount from ".$tables." group by type_id";
$res = $g_db->GetArray($sql);
if (!empty($res)) {
    $tmpCompanyAmount = array();
    foreach($res as $key=>$val){
    	$tmpCompanyAmount[$val['type_id']] = $val['CurAmount'];
    }
    unset($res);
}
$result = $companytype->findAll("id,name",null,null,0,$total_company);

if (!empty($result)) {
    foreach($result as $key=>$val){
        $intThisAmount = (!empty($tmpCompanyAmount[$val['id']]))?intval($tmpCompanyAmount[$val['id']]):0;
    	$arrCompanyStat[] = "<a href='".URL."company/list.php?filter=type_id&id=".$val['id']."&name=".urlencode($val['name'])."' class='texta'>".$val['name']."</a><span class='company'> ".$intThisAmount." </span>.";
    }
}

setvar("CompanyAmounts", $total_company);
setvar("CompanyStat", implode(",", $arrCompanyStat));
unset($result, $sql);
setvar("IndustryList", $industry->getIndustryPage($li,"company","industry1"));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile(BASE_DIR.'htmls/company/index.html',$smarty->fetch($theme_name."/company_index.html"), true, "company/index.php");
}
template($theme_name."/company_index");
?>
<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("company","member","area","companytype", "attachment", "indreccompany", "membertype");
require(SITE_ROOT.'./app/include/page.php');
require($inc_path.APP_NAME.'include/class.DATA_XML.php');
require("session_cp.inc.php");
$membertype = new Membertypes();
$indreccompany = new Indreccompanies();
$attach = new Attachments();
$companytype = new Companytypes();
$member = new Members();
$company = new Companies();
$area = new Areas();
$conditions = "1";
$tpl_file = "company_index";
$result = $companytype->findAll("id as CompanytypeId,name as CompanytypeName",$conditions, " id desc", 0,15);
$company_types = array();
foreach ($result as $key=>$val) {
	$company_types[$val['CompanytypeId']] = $val['CompanytypeName'];
}
setvar("CompanyTypes",$company_types);
setvar("CompanyStatus",$member->member_status);
function getFileExt ($fStr) {
    $retval = false;
    $pt = strrpos($fStr, ".");
    if ($pt) $retval = substr($fStr, $pt+1, strlen($fStr) - $pt);
    return ($retval);
}
function showVideo($dir)
{
    $returns = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $child_dir = $dir."/".$file;
                if(getFileExt($file)=="flv"){
                    $returns[] = $file;
                }
            }
        }
        closedir($handle);
    }
    if(!empty($returns)) return $returns;
}
if (isset($_POST['refreshvideo_x'])) {
    header("Content-Type: text/html; charset=".$charset);
	$dir_name = "../data/video/";
	$file_name = "../data/xml/video.xml";
	$video_list = showVideo($dir_name);
	if (!empty($video_list)) {
		//写入文件
		$content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<vcaster>\n";
		foreach ($video_list as $key=>$val){
		    $content.="<item item_url=\"".URL."data/video/".$val."\" item_title=\"".$val."\" />\n";
		}
		$content.="</vcaster>\n";
		$fp = fopen($file_name,"w");
		if (!fwrite($fp, $content)) {
		    die("Error: when create area file.");
		}else{
		    echo lgg("action_complete");
		    fclose($fp);
		}

	}else{
	    //不做任何修改
	}
}
if ($_POST['del_x'] && !empty($_POST['cid'])) {
	$result = $company->del($_POST['cid']);
	if ($result) {
		flash("./alert.php");
	}else{
		flash("./alert.php","./company.php",null,0);
	}
}
if (isset($_POST['check'])){
	if (isset($_POST['check']['in'])) {
		$result = $company->check($_POST['cid'],1);
	}elseif (isset($_POST['check']['out'])){
		$result = $company->check($_POST['cid'],0);
	}
	if($result){
		flash("./alert.php");
	}else {
		flash("alert.php", $_SERVER['SCRIPT_NAME'], null, 0);
	}
}

if (isset($_POST['setvip_x']) && !empty($_POST['cid'])) {
	$default_index_id = $membertype->field("id"," if_index=1");
	$company_ids = implode(",", $_POST['cid']);
	//set company active
	$result = $g_db->Execute("update ".$company->getTable()." set status='1' where id in (".$company_ids.")");
	$member_ids = $company->findAll("member_id", "id in (".$company_ids.")", null);
	foreach ($member_ids as $val) {
		$tmp_ups[] = $val['member_id'];
	}
	$member_ids = null;
	$member_ids = implode(",", $tmp_ups);
	$result = $g_db->Execute("update ".$member->getTable()." set user_type=".$default_index_id." where id in (".$member_ids.")");
	if ($result) {
		flash("alert.php", "company.php", "Update successfully.");
	}
}
if (isset($_POST['recommend_x'])){
	foreach($_POST['cid'] as $val){
		$commend_now = $company->field("if_commend", "id=".$val);
		if($commend_now=="0"){
			$result = $company->saveField("if_commend", "1", intval($val));
		}else{
			$result = $company->saveField("if_commend", "0", intval($val));
		}
	}
	$company_ids = implode(",", $_POST['cid']);
	//set company active
	$result = $g_db->Execute("update ".$company->getTable()." set status='1' where id in (".$company_ids.")");
	if($result){
		flash("./alert.php");
	}else {
		flash("./alert.php",$_SERVER['SCRIPT_NAME']);
	}
}
if (isset($_POST['edit_company'])) {
	$company_id = $_POST['id'];
	$vals['name'] = $_POST['company']['name'];
	if ($_POST['cindustry']) {
		$industryid = $_POST['cindustry'];
	}else if($_POST['bindustry']){
		$industryid = $_POST['bindustry'];
	}else if($_POST['aindustry']){
		$industryid = $_POST['aindustry'];
	}
	if($industryid) $vals['industry_id'] = $industryid;
	$vals['employee_amount'] = $_POST['company']['employee_amount'];
	if($_POST['manage_type'])
	{
		$managetype = implode(",",$_POST['manage_type']);
		$vals['manage_type'] = $managetype;
	}
	$vals['type_id'] = $_POST['company']['type_id'];
	$vals['property'] 	= $_POST['company']['property'];
	$vals['year_annual'] = $_POST['company']['AnnualRevenue'];
	$vals['main_prod'] 	= $_POST['company']['main_prod'];
	$vals['reg_address'] = $_POST['company']['reg_address'];
	$vals['description'] = $_POST['company']['description'];
	$vals['main_brand'] = $_POST['company']['brand'];
	$vals['boss_name'] = $_POST['company']['boss_name'];
	$vals['reg_fund'] 	= $_POST['company']['reg_fund'];
	if ($_POST['FoundDate'] !="None") {
		$vals['found_date'] = uaDateConvert($_POST['FoundDate']);
	}
	$vals['main_customer'] = $_POST['company']['main_customer'];
	$vals['main_biz_place'] = $_POST['company']['main_biz_place'];
	$vals['link_man'] = $_POST['company']['link_man'];
	$vals['link_man_gender'] = $_POST['company']['link_man_gender'];
	$vals['position'] = $_POST['company']['position'];
	$vals['telcode'] = $_POST['tel']['code'];
	$vals['telzone'] = $_POST['tel']['zone'];
	$vals['tel'] = $_POST['tel']['number'];
	$vals['faxcode'] = $_POST['fax']['code'];
	$vals['faxzone'] = $_POST['fax']['zone'];
	$vals['fax'] = $_POST['fax']['number'];
	$vals['mobile'] = $_POST['company']['mobile'];
	$vals['address'] = $_POST['company']['address'];
	$vals['zipcode'] = $_POST['company']['zipcode'];
	$vals['site_url'] = $_POST['company']['site_url'];
	$vals['style_id'] = $_POST['company']['style_id'];
	$vals['email'] = $_POST['company']['email'];
	$vals['province_code_id'] = $_POST['countryid'];
	$vals['city_code_id'] = $_POST['provinceid'];
	if($_POST['company']['main_market']) $mainmarket = implode(",",$_POST['company']['main_market']);
	$vals['main_market'] = $mainmarket;
	array_walk($vals,"uatrim");
	if(!empty($_POST['member']['name'])){
		$username = trim($_POST['member']['name']);
		$userid = $g_db->GetOne("select id from ".$member->getTable()." where username='".$username."'");
		if(!empty($userid)){
			$vals['member_id'] = $userid;
		}
	}
	if($company_id){
		$result = $company->save($vals, "update", $company_id);
	}else{
		$vals['created'] = $time_stamp;
		$result = $company->save($vals);
	}
	if($result){
		flash("alert.php");
	}else {
		flash("alert.php",$_SERVER['SCRIPT_NAME'],null,0);
	}
}
if (isset($_GET['action'])) {
    if ($_GET['action'] == "mod") {
    	$company_id = intval($_GET['id']);
    	$vals = null;
    	if(!empty($company_id)){
    		$fields = "id as AttachmentId,title as AttachmentTitle,description as AttachmentDescription,attachment as AttachmentFileName,created as AttachmentCreateDate";
    		$honour_res = $attach->findAll($fields, "status=1 and company_id=".$company_id, "id desc", 0, 15);
    		setvar("HonourResult", $honour_res);
    		$sql = "SELECT Company.*,Member.username AS MemberUserName FROM ".$company->getTable(true)." LEFT JOIN ".$member->getTable(true)." ON Company.member_id=Member.id WHERE Company.id=".$company_id;
    		$res = $g_db->GetRow($sql);
    		setvar("CompanyInfo",$res);
    		$selected['properties'] = explode(",",$res['manage_type']);
    		setvar("SelectedManageType",$selected['properties']);
    		$selected['markets'] = explode(",",$res['main_market']);
    		setvar("SelectedMarket",$selected['markets']);
    		uses("industry");
    		$industry = new Industries();
    		$current_industry = $industry->searchParentIndustry(intval($res['industry_id']));
    		if (is_array($current_industry)) {
    			$search_industry_ids = implode(",",$current_industry);
    			setvar("CurrentIndustry",$g_db->GetArray("SELECT name AS IndustryName FROM ".$industry->getTable()." WHERE id in (".$search_industry_ids.")"));
    		}
    	}
    	uaAssign(array("CompanyProperty"=>$company->economic_type,"ManageTypes"=>$company->manage_type,"MainMarkets"=>$company->main_market,"CompanyFunds"=>$company->company_funds,"CompanyAnual"=>$company->year_annuals,"LinkmanPositions"=>$member->ua_positions,"EmployeeAmounts"=>$company->employee_amount,"Genders"=>$member->genders));
    	$tpl_file = "company_edit";
    }
    if ($_GET['action']=="vcr") {
        $xml = file_get_contents('../data/xml/video.xml');
        $data=XML_unserialize($xml);
    	$tpl_file = "company_video";
    }
}
$tables = $company->getTable(true);
$fields = "Company.id AS CompanyID,Member.id AS MemberID,Member.username AS MemberName,CONCAT(Member.firstname,Member.lastname) AS NickName,Company.name AS CompanyName,Company.status AS CompanyStatus,Member.user_type AS MemberType,Member.credit_level AS SuranceLevel,Company.created AS CreateDate,AreaProvince.name AS CompanyProvince,AreaCity.name AS CompanyCity,Company.if_commend as IfCommend";
if (isset($_POST['search'])) {

	if ($_POST['member']['username']) {
		$ujoins.=" left join ".$member->getTable(true)." on Member.id=Company.member_id";
		$conditions.= " AND Member.username like '%".$_POST['member']['username']."%'";
	}
	if ($_POST['company']['name']) $conditions.= " AND Company.name like '%".$_POST['company']['name']."%'";
	if ($_POST['membertype']) $conditions.= " AND Member.user_type =".$_POST['membertype'];
	if ($_POST['FromDate'] && $_POST['FromDate']!="None" && $_POST['ToDate'] && $_POST['ToDate']!="None") {
		$conditions.= " AND Member.created BETWEEN ";
		$conditions.= uaDateConvert($_POST['FromDate']);
		$conditions.= " AND ";
		$conditions.= uaDateConvert($_POST['ToDate']);
	}
	if ($_POST['industryid']) $conditions.= " AND Company.industry_id=".$_POST['industryid'];
	if ($_POST['companystatus']!="-1") $conditions.= " AND Company.status=".$_POST['companystatus'];
	if ($_POST['companytype']!="-1") $conditions.= " AND Company.type_id=".$_POST['companytype'];
}
$amount = $company->findCount($conditions,"Company.id", null, $ujoins);
if ($_POST['gopage'] && intval($_POST['topage'])) {
	$page = intval($_POST['topage']);
}
pageft($amount,$display_eve_page);
$joins = array(
"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>null),
"AreaProvince"=>array("fullTableName"=>$area->getTable()." as AreaProvince","foreignKey"=>"province_code_id","fields"=>null),
"AreaCity"=>array("fullTableName"=>$area->getTable()." as AreaCity","foreignKey"=>"city_code_id","fields"=>null)
);
if ($_GET['action']=="vcr") {
    if (!empty($data['vcaster']['item attr'])) {
    	$lists[0]['item_title'] = $data['vcaster']['item attr']['item_title'];
    	$lists[0]['item_url'] = $data['vcaster']['item attr']['item_url'];
    }elseif (!empty($data['vcaster']['item'])){
    	foreach ($data['vcaster']['item'] as $key=>$val) {
    	    $lists[] = $val;
    	}    	
    }
    $lists = array_filter($lists);
}else{
    $lists = $company->findAll($fields,$conditions,"Company.id DESC",$firstcount,$displaypg);
}
setvar("CompanyList", $lists);
setvar("UserTypes",$member->ua_member_types);
setvar("Status",$company->company_status);
uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
template("pb-admin/".$tpl_file);
?>
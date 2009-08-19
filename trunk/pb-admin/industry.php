<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
require(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("industry","area","product","company","trade");
require("session_cp.inc.php");
$trade = new Trades();
$company = new Companies();
$product = new Products();
$industry = new Industries();
$area = new Areas();
$tpl_file = "industry_index";
$show_index = explode(",",lgg('yes_no'));
if ($_GET['action'] == "mkstatic") {
	$tpl_file = "industry_static";
}
$fields = "id,name,buy_amount,sell_amount,product_amount,company_amount";
function uaIndustryMainXML()
{
    global $charset;
    $content = null;
    $return.= "<?xml version=\"1.0\" encoding=\"".$charset."\" standalone=\"no\"?>\n";
    $return.= "<TreeNodes>\n";
    $res = $GLOBALS['industry']->getAllIndustry(" AND Industry.parentid=0");
    foreach ($res as $key=>$val) {
        $return.= "<TreeNode Desc=\"".$val['Name']."\" Value=\"".$val['ID']."\">\n";
        $return.= uaIndustrySubXML($val['ID'],"		");
        $return.= "</TreeNode>\n";
    }
    $return.= "</TreeNodes>\n";
    return $return;
}

function uaIndustrySubXML($parentid,$strdis)
{
    $subs = $GLOBALS['industry']->getAllIndustry(" AND Industry.parentid=".$parentid);
    $sub_returns = null;
    foreach ($subs as $key2=>$val2) {
        $sub_returns.= $strdis."<TreeNode Desc=\"".$val2['Name']."\" Value=\"".$val2['ID']."\">";
        $sub_returns.= uaIndustrySubXML($val2['ID'],$strdis);
        $sub_returns.= "</TreeNode>\n";
    }
    return $sub_returns;
}
function generateIndustry($arr)
{
	global $fields;
	global $industry;
	$return = array();
	foreach ($arr as $val){
		$sub_industry = $industry->findAll($fields, "parentid=".$val['id']);
		$sub_industry_2 = generateIndustry($sub_industry);
		$return[$val['id']] = array("name"=>$val['name'], "amount"=>$val['buy_amount']."|".$val['sell_amount']."|".$val['company_amount']."|".$val['product_amount']);
	}
	return $return;
}
if ($_GET['action']=="recache") {
	$write_cache = $industry->recacheIndustryAmount();
	if($write_cache){
		flash("alert.php", "industry.php?action=list");
	}
}
if ($_GET['action'] == "truncate") {
	$result = $g_db->Execute("TRUNCATE TABLE ".$industry->getTable());
	if ($result) {
		flash("alert.php", "industry.php?action=list");
	}else {
		flash("alert.php", "industry.php", null, 0);
	}
}
if(isset($_POST['update_prior']) && !empty($_POST['id'])){
	$ids = $_POST['id'];
	$prs = $_POST['priority'];
	$show_s = $_POST['chk_id'];
	$name_s = $_POST['names'];
	if(!empty($show_s)) {
		$notshow_s = array_diff($ids, $show_s);
		$notshow_s = implode(",", $notshow_s);
		$notshow_s = "(".$notshow_s.")";
		$show_s = implode(",", $show_s);
		$show_s = "(".$show_s.")";
		$g_db->Execute("update ".$industry->getTable()." set ia=1 where id in ".$show_s);
		$g_db->Execute("update ".$industry->getTable()." set ia=0 where id in ".$notshow_s);
	}
	for($i=0; $i<count($ids); $i++){
		$g_db->Execute("update ".$industry->getTable()." set name='".$name_s[$i]."',priority=".$prs[$i]." where id=".$ids[$i]);

	}
	flash("alert.php", "./industry.php?action=list", null);
}
if($_GET['action']=="list"){
	$conditions = "parentid=0";
	$positions[0] = "<a href='industry.php?action=list'>".lgg('all_parent_ind')."</a>";
	if(!empty($_GET['pid'])){
		$conditions = "parentid=".$_GET['pid'];
		$_tmpres = $industry->read("id,parentid,name", $_GET['pid']);
		if(!empty($_tmpres['parentid'])){
			$positions[] = "<a href='industry.php?action=list&pid=".$_tmpres['parentid']."'>".$industry->field("name", "id=".$_tmpres['parentid'])."</a>";
		}
		$positions[] = "<a href='industry.php?action=list&pid=".$_GET['pid']."'>".$_tmpres['name']."</a>";
	}
	$result = $industry->findAll("id,name,priority,parentid,ia as ifshow", $conditions, "id asc");
	setvar("IndustryList", $result);
	setvar("IndustryPosition", implode(" > ", $positions));
}
if ($_GET['action'] == "del") {
	if (!empty($_GET['id'])) {
		$result = $industry->del($_GET['id']);
	}elseif (!empty($_GET['pid'])){
		$result = $g_db->Execute("delete from ".$industry->getTable()." where parentid=".$_GET['pid']);
	}
	if ($result) {
		flash("alert.php", "industry.php?action=list");
	}else{
		flash("alert.php", null, null, 0);
	}
}
if ($_GET['action'] == "update") {
	if(empty($_GET['type'])){
		echo "<a href='./industry.php?action=update&type=start'>".lgg('start_upd_ind')."</a>";
		exit;
	}else{
		$industry->updateCache(BASE_DIR."data/tmp/data/".$cookiepre."industry.inc.php");
		echo lgg("update_end");
		unset($table,$sql);
		exit;
	}
}
if($_GET['action'] == "mod"){
	if($_POST['save'] && $_POST['indname']){
		$vals = array();
		$vals['parentid'] = trim($_POST['parentid']);
		$vals['ia'] = trim($_POST['industry']['ia']);
		$vals['ib'] = trim($_POST['industry']['ib']);
		if (!empty($_POST['id'])) {
			$vals['name'] = trim($_POST['indname']);
			$vals['modified'] = $time_stamp;
			$result = $industry->save($vals, "update",intval($_POST['id']));
		}elseif(is_array($_POST['indname'])){
			foreach ($_POST['indname'] as $ind) {
				if(!empty($ind)) $ins[] = "('".$ind."',".$vals['parentid'].",".$vals['ia'].",".$vals['ib'].",".$time_stamp.")";
			}
			$ins = implode(",", $ins);
			$sql = "insert into ".$industry->getTable()." (name,parentid,ia,ib,created) values ".$ins;
			$result = $g_db->Execute($sql);
		}
	   if ($result) {
	    	$datas_options = uaIndustryMainXML();
	    	$fp = fopen("..".DS."media".DS."xml".DS."industry_option.xml","w");
	    	if (!fwrite($fp, $datas_options)) {
	    	    die("Error:when create industry select xml datas.");
	    	}else{
	    	    fclose($fp);
	    	}
			flash("alert.php");
		}else {
			flash("alert.php", null, null, 0);
		}
	}
	$tRes = $industry->getAllIndustry(" AND parentid='0'");
	if(!empty($tRes)){
		$pRes = null;
		foreach($tRes as $key=>$val){
			$pRes.="<option value=".$val['ID'].">".$val['Name']."</option>";
			$ttRes = $industry->getAllIndustry(" AND parentid=".$val['ID']);
			foreach($ttRes as $key2=>$val2){
				$pRes.="<option value=".$val2['ID'].">&nbsp;&nbsp;".$val2['Name']."</option>";
			}
		}
	}
	setvar("ParentIndustryOptions", $pRes);
	setvar("ShowIndex",$show_index);
	$action_type = $LanguageVars['add'];
	if(isset($_GET['id'])){
		$res = $industry->getAllIndustry(" AND Industry.id=".$_GET['id']);
		if (isset($_GET['pid'])){
			setvar("ShowIndustryMenu",true);
		}
		setvar("SortInfo",$res[0]);
		$action_type = $LanguageVars['mod'];
	}
	setvar("ActionType",$action_type);
	$tpl_file = "industry_edit";
}
if ($_GET['action'] == "industryxml") {
	$datas_options = uaIndustryMainXML();
	$fp = fopen("..".DS."media".DS."xml".DS."industry_option.xml","w");
	if (!fwrite($fp, $datas_options)) {
		die("Error:when create industry select xml datas.");
	}else{
		fclose($fp);
	}
	setvar("XMLDATA",$datas_options);
	setvar("XML_FILE_NAME","industry_option.xml");
	$tpl_file = "industry_xml";
}
if ($_GET['action'] == "listindustry"){
		$x = "<?xml version=\"1.0\" encoding=\"".$charset."\" standalone=\"no\"?>\n";
		$x.= "<root>\n";
		$sql = "SELECT id AS IndustryId,name AS Name,parentid AS IndustryParentId,buy_amount,product_amount,sell_amount,company_amount FROM ".$industry->getTable(true)." WHERE ia=1";
		$res = $GLOBALS['g_db']->GetAll($sql);
		foreach ($res as $key=>$val) {
			$x.= "<node id=\"".$val['IndustryId']."\" buy_amount=\"".$val['buy_amount']."\" sell_amount=\"".$val['sell_amount']."\" product_amount=\"".$val['product_amount']."\" company_amount=\"".$val['company_amount']."\"";
			if(!empty($val['IndustryParentId'])) $x.= " parentid=\"".$val['IndustryParentId']."\"";
			$x.= ">\n";
			$x.= "<name>".$val['Name']."</name>\n";
			$x.= "</node>\n";
		}
		$x.= "</root>\n";
		$fp = fopen("..".DS."media".DS."xml".DS."industry_list.xml","w");
		if (!fwrite($fp, $x)) {
			die("Error: when create industry xml file.");
		}else{
			fclose($fp);
		}
		setvar("XMLDATA",$x);
		$tpl_file = "industry_xml";
		setvar("XML_FILE_NAME","industry_list.xml");
}
if ($_GET['action'] == "areaxml") {
	function uaAreaMainXML()
	{
		global $area, $charset;
		$content = null;
		$content.= "<?xml version=\"1.0\" encoding=\"".$charset."\" standalone=\"no\"?>\n";
		$content.=  "<TreeNodes>\n";
		$res = $area->getAllArea(" AND RIGHT(Area.code_id,3) = '000'");
		foreach ($res as $key=>$val) {
			$content.=  "<TreeNode Desc=\"".$val['AreaName']."\" Value=\"".$val['AreaCodeId']."\">\n";
			$content.= uaAreaSubXML($val['AreaCodeId'],"		");
			$content.=  "</TreeNode>\n";
		}
		$content.=  "</TreeNodes>\n";
		return $content;
	}
	function uaAreaSubXML($parentid,$strdis)
	{
		global $area;
		$sub_areas = null;
		$subs = $area->getAllArea(" AND Area.id>=50 AND LEFT(Area.code_id,2)=".substr($parentid,0,2));
		foreach ($subs as $val2) {
			$sub_areas.= $strdis."<TreeNode Desc=\"".$val2['AreaName']."\" Value=\"".$val2['AreaCodeId']."\">";
			$sub_areas.= "</TreeNode>\n";
		}
		return $sub_areas;
	}
	$area_content = uaAreaMainXML();
	$fp = fopen("..".DS."media".DS."xml".DS."area.xml","w");
	if (!fwrite($fp, $area_content)) {
		die("Error: when create area file.");
	}else{
		fclose($fp);
	}
	setvar("XMLDATA",$area_content);
	setvar("XML_FILE_NAME","area.xml");
	$tpl_file = "industry_xml";
}
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
function updatePriority($industry_id, $priorities){
	global $g_db;
	global $industry;
	$obj = new xajaxResponse();
	$result = $g_db->Execute("update ".$industry->getTable()." set priority=".trim($priorities)." where id=".trim($industry_id));
	if($result) {
		$obj->assign("updateDIV", "innerHTML", "<img src='images/right.gif' border='0' /><strong>Update id ".$industry_id." priority to ".$priorities."</strong>");
	}
	return $obj;
}
$xajax->register(XAJAX_FUNCTION,  "updatePriority");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
template("pb-admin/".$tpl_file);
?>
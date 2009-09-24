<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require("session_cp.inc.php");
uses("area");
require(SITE_ROOT.'./libraries/page.php');
$tpl_file = "area_index";
$area = new Areas();
$conditions = null;

if (isset($_POST['update'])) {
	foreach ($_POST['id'] as $key=>$val) {
		$g_db->Execute("update ".$area->getTable()." set name='".$_POST['data']['area']['name'][$key]."',code_id=".$_POST['data']['area']['code_id'][$key]." where id=".$val);
	}
	flash("alert.php", $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $area->del($_POST['id']);
}
if (isset($_POST['save'])){
	$vals = null;
	$vals['name'] = $_POST['new']['data']['name'];
	$vals['code_id'] = $_POST['new']['data']['code_id'];
	$area->save($vals);
	flash("alert.php", $_SERVER['HTTP_REFERER']);
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$result = $area->del($_GET['id'])	;
}
if (isset($_GET['action'])) {
    if ($_GET['action']=="update") {
        $sql = "select Area.name as AreaName,code_id as AreaCodeId from ".$area->getTable(true);
        $result = $g_db->GetAll($sql);
        $str = "<?php
\$UL_DBCACHE_AREAS = array(\n";
        foreach ($result as $key=>$val) {
            $str.="\"".$val['AreaCodeId']."\"=>\"".$val['AreaName']."\",\n";
        }
        $str.=");\n?>";
        $area->writeCache(BASE_DIR."data/cache/".$cookiepre."area.inc.php", $str);
        flash("alert.php", "area.php?action=list");
    }
    if ($_GET['action'] == "mod") {
    	if (!empty($_GET['id'])) {
    		$result = $access->read("*", $_GET['id']);
    		setvar("a",$result);
    	}
    	$tpl_file = "area_edit";
    }
    if ($_GET['action'] == "list") {
    	$amount = $area->findCount();
    	pageft($amount,$display_eve_page);
    	$sql = "select Area.name as AreaName,Area.id as AreaId,code_id as AreaCodeId from ".$area->getTable(true)." order by Area.id desc limit $firstcount,$displaypg";
    	$result = $g_db->GetAll($sql);
    	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
    	setvar("Lists", $result);
    }
}

template($tpl_file);
?>
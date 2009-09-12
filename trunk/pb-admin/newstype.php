<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("newstype");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$newstype = new Newstypes();
$conditions = null;
$tpl_file = "newstype_index";
if (isset($_POST['save']) && !empty($_POST['newstype']['name'])) {
	$vals = array();
	$vals = $_POST['newstype'];
	if (!empty($_POST['id'])) {
		$result = $newstype->save($vals, "update", $_POST['id']);
	}else{
		$vals['created'] = $time_stamp;
		$result = $newstype->save($vals);
	}
	$sql = "select id,name from {$tb_prefix}newstypes";
	$result = $g_db->GetArray($sql);
	$str = "<?php
\$UL_DBCACHE_NEWSTYPE = array(\n";
	foreach ($result as $key=>$val) {
		$str.="\"".$val['id']."\"=>\"".$val['name']."\",\n";
	}
	$str.=");\n?>";
	$newstype->writeCache(BASE_DIR."data/tmp/data/".$cookiepre."newstype.inc.php", $str);
	if ($result) {
		flash("./alert.php");
	}else {
		flash("./alert.php", "./newstype.php", null, 0);
	}
}
if (isset($_POST['search'])) {
	if (isset($_POST['newstype']['name'])) $conditions.= " AND Newstype.name like '%".trim($_POST['newstype']['name'])."%'";
}
$yes_no = explode(",",lgg('yes_no'));
setvar("NavStatus", $yes_no);
setvar("FocusStatus", $yes_no);
if($_GET['action'] == "del" && !empty($_GET['id'])){
	$newstype->del($_GET['id']);
}
$parent_newstypes = $newstype->findAll("id AS NewstypeId,name AS NewstypeName", "parent_id=0", "id DESC", 0,100);
foreach ($parent_newstypes as $key=>$val) {
	$tmp_v[$val['NewstypeId']] = $val['NewstypeName'];
}
setvar("AllParents",$tmp_v);
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$res= $newstype->read(null,$nid);
		setvar("n",$res);
	}
	$tpl_file = "newstype_edit";
}else {

	$amount = $newstype->findCount($conditions,"id");
	pageft($amount,$display_eve_page);
	$fields = $newstype->getFieldAliasNames();
	$newstype_list = $newstype->findAll($fields, $conditions, "id DESC", $firstcount, $displaypg);
	setvar("NewstypeList",$newstype_list);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
if (isset($_POST['del']) && is_array($_POST['newstypeid'])) {
	$deleted = $newstype->del($_POST['newstypeid']);
	if ($deleted) {
		flash("./alert.php");
	}else {
		flash("./alert.php", "./newstype.php", null, 0);
	}
}
template($tpl_file);
?>
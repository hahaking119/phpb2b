<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("membertype","access");
require(SITE_ROOT.'./libraries/page.php');
$conditions = null;
$access = new Accesses();
$membertype = new Membertypes();
$tpl_file = "membertype_index";
setvar("MembertypeStatus", explode(",",lgg('yes_no')));
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $membertype->del($_POST['id']);
	//同时删除对应权限
	$access->primaryKey = "membertype_id";
	$result = $access->del($_POST['id']);
	if (!$result) {
		flash("./alert.php","./membertype.php",null,0);
	}
}
if(isset($_POST['save'])){
	$mtid = $_POST['id'];
	$vals = $_POST['t'];
	if(!empty($mtid)){
		$result = $membertype->save($vals, "update", $mtid);
	}else{
		$result = $membertype->save($vals);
	}
	$sql = "select id,name,picture from {$tb_prefix}membertypes";
	$result = $g_db->GetArray($sql);
	$str = "<?php
\$UL_DBCACHE_MEMBERTYPES = array(\n";
	foreach ($result as $key=>$val) {
		$str.="\"".$val['id']."\"=>\"".$val['name']."\",\n";
	}
	$str.=");\n?>";
	$membertype->writeCache(BASE_DIR."data/cache/".$cookiepre."membertype.inc.php", $str);
	if(!$result){
		flash("alert.php","membertype.php",null,0);
	}
}

if (isset($_POST['updateDefault']) && !empty($_POST['default_id'])) {
	$vals = array();
	$vals['if_default'] = 1;
	$g_db->Execute("update ".$membertype->getTable()." set if_default=0");
	$result = $g_db->Execute("update ".$membertype->getTable()." set if_default=1 where id=".intval($_POST['default_id']));
}
if (isset($_POST['putIndex']) && !empty($_POST['index_id'])) {
	$vals = array();
	$vals['if_index'] = 1;
	$g_db->Execute("update ".$membertype->getTable()." set if_index=0");
	$result = $g_db->Execute("update ".$membertype->getTable()." set if_index=1 where id=".intval($_POST['index_id']));
}
if (isset($_POST['quickadd']) && !empty($_POST['membertype']['name'])) {
	$vals = array();
	$vals = $_POST['membertype'];
	$result = $membertype->save($vals);
	if (!$result) {
		flash("./alert.php","./membertype.php",null,0);
	}
}
if ($_GET['action']=="mod") {
	$tpl_file = "membertype_edit";
	$result = $membertype->read("*",intval($_GET['id']));
	$accesses = $g_db->GetArray("select id,name from ".$access->getTable());
	setvar("AllAccesses", $accesses);
	//$result['access_name'] = $access->field("name", "id=".$result['access_id']);
	setvar("t",$result);
}else{
	$amount = $membertype->findCount();
	pageft($amount,$display_eve_page);
	$sql = "select Membertype.id as MembertypeId,Membertype.name as MembertypeName,Access.name as AccessName,if_default as MembertypeIfDefault,Membertype.created as MembertypeCreated,if_index as MembertypeIfIndex,access_id,picture from ".$membertype->getTable(true)." left join ".$access->getTable(true)." on Membertype.access_id=Access.id";
	$result = $g_db->GetArray($sql);
	setvar("Lists",$result);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
//:~
template($tpl_file);
?>
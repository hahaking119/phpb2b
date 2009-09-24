<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require("fckeditor/fckeditor.php") ;
require("session_cp.inc.php");
uses("setting");
$setting = new Settings();
$ua_sets = $setting->getValues();
$t = lgg("yes_no");
setvar("AskAction", explode(",", $t));
if (isset($_GET['action'])) {
    $strSiteDescription = isset($ua_sets['SITE_DESCRIPTION'])?$ua_sets['SITE_DESCRIPTION']:null;
	if ($_GET['action']=="basic") {
		editor("u[site_description]", $strSiteDescription, "FCK_SITE_DESCRIPTION");
		$tpl_file = "basic";
        $position_path = array(array("name"=>"Basic","url"=>"setting.php?action=basic"));
	}
	if ($_GET['action']=="permission") {
        $position_path = array(array("name"=>"Register","url"=>"setting.php?action=permission"));
		$tpl_file = "permission";
	}
	if ($_GET['action']=="mail") {
		$tpl_file = "mail";
        $position_path = array(array("name"=>"Mail","url"=>"setting.php?action=mail"));
	}
}
if (isset($_POST['savebasic'])) {
	$updated = false;
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","variable");
		if($exists){
			$sql = "update ".$setting->getTable()." set valued='$vval' where variable='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (variable,valued) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	if($updated){
        $str = "<?php
\$_SETTINGS = array(\n";
        $str.="\"sitename\"=>'".$_POST['u']['site_name']."',\n";
        $str.="\"sitetitle\"=>'".$_POST['u']['site_title']."',\n";
        $str.="\"companyname\"=>'".$_POST['u']['company_name']."',\n";
        $str.="\"icpnumber\"=>'".$_POST['u']['icp_number']."',\n";
        $str.="\"servicetel\"=>'".$_POST['u']['service_tel']."',\n";
        $str.="\"saletel\"=>'".$_POST['u']['sale_tel']."',\n";
        $str.="\"serviceqq\"=>'".$_POST['u']['service_qq']."',\n";
        $str.="\"servicemsn\"=>'".$_POST['u']['service_msn']."',\n";
        $str.="\"serviceemail\"=>'".$_POST['u']['service_email']."',\n";
        $str.="\"sitebannerword\"=>'".$_POST['u']['site_banner_word']."',\n";
        $str.="\"sitedescription\"=>'".$_POST['u']['site_description']."',\n";
        $str.=");\n?>";
        $setting->writeCache(BASE_DIR."data/cache/".$cookiepre."setting.inc.php", $str);
		flash("alert.php", "setting.php?action=basic");
	}
}
if (isset($_POST['savepermission'])) {
	$updated = false;
	if (!empty($_POST['u']['reg_filename'])) {
	    $renameResult = rename('../user/register.php', '../user/'.$_POST['u']['reg_filename']);
	}
	if (!empty($_POST['u']['post_filename'])) {
	    $renameResult = rename('../offer/post.php', '../offer/'.$_POST['u']['post_filename']);
	}
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","variable");
		if($exists){
			$sql = "update ".$setting->getTable()." set valued='$vval' where variable='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (variable,valued) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	if($updated){
		flash("alert.php", "setting.php?action=permission");
	}
}
if (isset($_POST['savemail'])) {
	$updated = false;
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","variable");
		if($exists){
			$sql = "update ".$setting->getTable()." set valued='$vval' where variable='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (variable,valued) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	if($updated){
		flash("alert.php", "setting.php?action=mail");
	}
}
setvar("CurrentPos",pb_format_current_position($position_path));
setvar("U",$ua_sets);
template($tpl_file);
?>
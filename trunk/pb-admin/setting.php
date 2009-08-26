<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("./fckeditor/fckeditor.php") ;
require("session_cp.inc.php");
uses("setting");
$setting = new Settings();
$ua_sets = $setting->getValues();
$t = lgg("yes_no");
setvar("AskAction", explode(",", $t));
if (isset($_GET['action'])) {
	if ($_GET['action']=="basic") {
		editor("u[site_description]", $ua_sets['SITE_DESCRIPTION'], "FCK_SITE_DESCRIPTION");
		$tpl_file = "basic";
        $position_path = array(array("name"=>"Basic","url"=>"setting.php?action=basic"));
	}
	if ($_GET['action']=="permission") {

        $position_path = array(array("name"=>"Register","url"=>"setting.php?action=permission"));
		$tpl_file = "permission";
	}
}
if ($_POST['savebasic']) {
	$updated = false;
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","aa");
		if($exists){
			$sql = "update ".$setting->getTable()." set ab='$vval' where aa='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (aa,ab) values ('$vname','$vval')";
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
        $setting->writeCache(BASE_DIR."data/tmp/data/".$cookiepre."setting.inc.php", $str);
		flash("alert.php", "setting.php?action=basic");
	}
}
if ($_POST['savepermission']) {
	$updated = false;
	if (!empty($_POST['u']['reg_filename'])) {
	    $renameResult = rename('../user/register.php', '../user/'.$_POST['u']['reg_filename']);
	}
	if (!empty($_POST['u']['post_filename'])) {
	    $renameResult = rename('../post.php', '../'.$_POST['u']['post_filename']);
	}
	foreach($_POST['u'] as $vname=>$vval){
		$exists = $setting->find($vname,"id","aa");
		if($exists){
			$sql = "update ".$setting->getTable()." set ab='$vval' where aa='$vname'";
		}else{
			$sql = "insert into ".$setting->getTable()." (aa,ab) values ('$vname','$vval')";
		}
		$g_db->Execute($sql);
		$updated = true;
	}
	if($updated){
		flash("alert.php", "setting.php?action=permission");
	}
}

setvar("CurrentPos",uaFormatPositionPath($position_path));
setvar("U",$ua_sets);
template("pb-admin/".$tpl_file);
?>
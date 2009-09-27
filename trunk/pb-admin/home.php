<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("setting");
$setting = new Settings();
$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
$dbversion = UaModel::getMysqlVersion();
setvar("PhpVersion",$serverinfo);
setvar("MysqlVersion",$dbversion);
$when_to_backup = $setting->field("ab", "aa='backup_type'");
setvar("LastBackupTime", $setting->field("ab", "aa='lastbackup'"));
function checkGDSupport(){
	if(!function_exists("gd_info")){
		return false;
	}else {
		if(function_exists("ImageCreateFromGIF")) $return[] = lgg('gif_ok');
		if(function_exists("ImageCreateFromJPEG")) $return[] = lgg('jpg_ok');
		if(function_exists("ImageCreateFromPNG")) $return[] = lgg('png_ok');
		if(function_exists("ImageCreateFromWBMP")) $return[] = lgg('wbmp_ok');
		return $return;
	}
}
$gd_s = checkGDSupport();
setvar("GDSupports", $gd_ss = (!$gd_s)?lgg('without_this_ext'):implode(",", $gd_s));
if ($when_to_backup == 2) {
	require_once($inc_path .APP_NAME. "include/db_mysql.inc.php");
	$db = new DB_Sql();
	$sqldump = null;
	$conn = $db->connect($db_links['dbname'],$db_links['dbhost'],$db_links['dbuser'],$db_links['dbpass']);
	if(mysql_get_server_info() > '4.1'){
		$db->query("set names 'utf8'");
	}
	$tables = $db->table_names();
	foreach ($tables as $names) {
		if(stripos($names['table_name'],$tb_prefix) ===0){
			$sqldump.=data2sql($names['table_name']);
		}
	}
	$file_path = "..".DS."data".DS."backup".DS;
	if(function_exists("gzwrite")){
		$zip_file_name = $file_path."db_".date("Ymd")."_".getRadomStr().".gz";
		$zip_fp = gzopen($zip_file_name, "w9");
		if($zip_fp){
			gzwrite($zip_fp, $sqldump);
			gzclose($zip_fp);
			$rightmsg = lgg('backup_to').$zip_file_name;
		}else{
			$errmsg[] = lgg('file_open_error');
		}
	}else{
		$file_name = $file_path."db_".date("Ymd").".sql";
		$fp = fopen($file_name, "w+");
		if($fp){
			flock($fp, 3);
			fwrite($fp, $sqldump);
			fclose($fp);
			$rightmsg = lgg('backup_to').$file_name."";
		}else{
			$errmsg[] = lgg('file_open_error');
		}
	}
	echo "<font color=red>".$rightmsg."</font><br>";
	echo $errmsg."<br>";
	$setting->setPrimaryKey("aa");
	$vals['ab'] = $time_stamp;
	$setting->save($vals, "update", "lastbackup");
}
function db_size_info($fileSize) {
	$size = sprintf("%u", $fileSize);
	if($size == 0) {
		return("0 Bytes");
	}
	$sizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
}
$rows = $g_db->Execute("SHOW TABLE STATUS");
$dbssize = 0;
foreach ($rows as $row) {
  $dbssize += $row['Data_length'] + $row['Index_length'];
}
//$userpage->setUalinkVersion("http://www.ualink.org/version.xml");
//$ua_version = PHPB2B_VERSION;
setvar("LatestVersion", PHPB2B_VERSION);
setvar("DatabaseSize",number_format($dbssize)." Bytes OR ".db_size_info($dbssize));
template("pb-admin/home");
?>
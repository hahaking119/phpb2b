<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("setting", "adminlog");
$setting = new Settings();
$adminlog = new Adminlogs();
$backup_types = array(1=>lgg('by_hand'),2=>lgg('by_auto'));
$backup_type = $setting->field("ab", "aa='backup_type'");
setvar("CurrentType",$backup_type);
if(isset($_POST['restore'])){
	if(file_exists($file_name = "../data/backup/".$_POST['sql_file_name'])){
		$fp = fopen($file_name, 'rb');
		if(!$fp){
			flash("./alert.php", null, lgg('action_false'), 0);
		}else{
			$sql = fread($fp, filesize($file_name));
			fclose($fp);
			run($sql);
		}
	}
	flash("./alert.php");
}
if ($_POST['save'] && !empty($_POST['u'])) {
	foreach ($_POST['u'] as $key=>$val) {
		$exists = $setting->find($key,"id","aa");
		if ($exists) {
			$sql = "UPDATE ".$setting->getTable()." SET ab='$val' WHERE aa='$key'";
		}else{
			$sql = "INSERT ".$setting->getTable()." (aa,ab) VALUE ('$key','$val')";
		}
		$result = $g_db->Execute($sql);
	}
	if ($result) {
		flash("./alert.php");
	}else {
		flash("./alert.php", null, lgg('action_false'), 0);
	}
}
if ($_GET['action'] == "backup_now") {
	require_once($inc_path .APP_NAME. "include/db_mysql.inc.php");
	$db = new DB_Sql();
	$sqldump = null;
	$conn = $db->connect($db_links['dbname'],$db_links['dbhost'],$db_links['dbuser'],$db_links['dbpass']);
	if(mysql_get_server_info() > '4.1'){
		$db->query("set names '".$dbcharset."'");
	}
	$tables = $db->table_names();
	foreach ($tables as $names) {
		if(function_exists("stripos")){
			if(stripos($names['table_name'],$tb_prefix) ===0){
				$sqldump.=data2sql($names['table_name']);
			}
		}else{
			if(strpos(strtolower($names['table_name']),strtolower($tb_prefix)) ===0){
				$sqldump.=data2sql($names['table_name']);
			}
		}
	}
	$file_path = "..".DS."data".DS."backup".DS;
	if(function_exists("gzwrite")){
		$file_name = "db_".date("Ymd")."_".getRadomStr().".gz";
		$zip_file_name = $file_path.$file_name;
		$zip_fp = gzopen($zip_file_name, "w9");
		if($zip_fp){
			gzwrite($zip_fp, $sqldump);
			gzclose($zip_fp);
			$rightmsg = lgg('backup_to').$file_name;
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
			$rightmsg = lgg('backup_to').$file_name;
		}else{
			$errmsg[] = lgg('file_open_error');
		}
	}
	echo $rightmsg."<br>";
	echo $errmsg."<br>";
	$setting->setPrimaryKey("aa");
	$vals['ab'] = $time_stamp;
	$setting->save($vals, "update", "lastbackup");
	$data['Adminlog']['action_description'] = lgg('backup_to').$file_name;
	logadmin();
	exit;
}
setvar("BackupTypes",$backup_types);
template("pb-admin/backup");
?>
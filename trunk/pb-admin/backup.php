<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
require(SITE_ROOT. './libraries/func.sql.php');
require("session_cp.inc.php");
uses("setting", "adminlog");
$setting = new Settings();
$adminlog = new Adminlogs();
$backup_types = array(1=>lgg('by_hand'),2=>lgg('by_auto'));
$backup_type = $setting->field("valued", "variable='backup_type'");
setvar("CurrentType",$backup_type);
if(isset($_POST['restore'])){
	if(file_exists($file_name = "../data/backup/".$_POST['sql_file_name'])){
		$fp = fopen($file_name, 'rb');
		if(!$fp){
			flash("./alert.php", null, lgg('action_false'), 0);
		}else{
			$sql = fread($fp, filesize($file_name));
			fclose($fp);
			sql_run($sql);
		}
	}
	flash("./alert.php");
}
if (isset($_POST['save']) && !empty($_POST['u'])) {
	foreach ($_POST['u'] as $key=>$val) {
		$exists = $setting->find($key,"id","variable");
		if ($exists) {
			$sql = "UPDATE ".$setting->getTable()." SET valued='$val' WHERE variable='$key'";
		}else{
			$sql = "INSERT ".$setting->getTable()." (variable,valued) VALUE ('$key','$val')";
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
	require_once(LIB_PATH."db_mysql.inc.php");
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
		$file_name = "db_".date("Ymd")."_".pb_radom().".gz";
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
	$setting->setPrimaryKey("variable");
	$vals['valued'] = $time_stamp;
	$setting->save($vals, "update", "lastbackup");
	$data['Adminlog']['action_description'] = lgg('backup_to').$file_name;
	$adminlog->add();
	exit;
}
setvar("BackupTypes",$backup_types);
template("backup");
?>
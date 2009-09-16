<?php
$charset = "utf-8";
$dbcharset = "utf8";
header("Content-Type: text/html; charset=".$charset);
define('INSTALL_ROOT', dirname(__FILE__)."/");
$lang_name = (!empty($_GET['language']))?trim($_GET['language']):"zh-cn";
$sqlfile = INSTALL_ROOT."./data/mysql.sql";

if(empty($_GET['language'])){
	if($_SERVER["HTTP_ACCEPT_LANGUAGE"]=="zh-cn"){
		$lang_name = "zh-cn";
	}elseif($_SERVER["HTTP_ACCEPT_LANGUAGE"]=="en"){
		$lang_name = "en";
	}else{
		$lang_name = "zh-cn";
	}
}else{
	$lang_name = trim($_GET['language']);
}
require(INSTALL_ROOT."./lang_".$lang_name.".php");
error_reporting(E_ERROR ^ E_WARNING);
@set_time_limit(600);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset;?>" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script language="javascript" src="../js/prototype.js"></script>
<script language="javascript">
<!--
function check_install(){
	if($F('forum_adminpass') == ""){
		alert("<?php echo $lang['not_empty_passwd'];?>");
		$('forum_adminpass').focus();
		return false;
	}else if($F('db_name') == ""){
		alert("<?php echo $lang['pls_select_db'];?>");
		$('db_name').focus();
		return false;
	}else{
		$('divProgress').innerHTML = "<img src='images/loading.gif' /><br><?php echo $lang['installing'];?>";
		return true;
	}
}
//-->
</script>
</head>
<body>
<?php
if (!("done"==trim($_GET['step']))) {
    if (file_exists("../data/install.lock")) {
    	die($lang['delete_and_install']);
    }
}
$UA_INSTALLING = true;
$rightmsg = null;
$errmsg = null;
if (!file_exists("./install.php")) {
	$errmsg[] = $lang['not_full_files'];
	$UA_INSTALLING = false;
}
$app_name = "../app/";
define('IN_UALINK', true);
require(INSTALL_ROOT.'../libraries/func.global.php');
require(INSTALL_ROOT.'../libraries/func.sql.php');
$core_sample_file = '../app/configs/core.php';
$db_sample_file	= '../app/configs/db.php';
$installfile = basename(__FILE__);
$ul_protocol = 'http';
if ( isset( $_SERVER['HTTPS'] ) && ( strtolower( $_SERVER['HTTPS'] ) != 'off' ) ) {
	$ul_protocol = 'https';
}
$local_url = $ul_protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
$local_url = substr($local_url,0,-(strlen($installfile)+8));
require($core_sample_file);
if (!defined('PHPB2B_VERSION')) {
	require("../phpb2b_version.php");
}
if(empty($dbcharset)){
	$dbcharset = "utf8";
}
if(empty($cookiepre)){
	$cookiepre = "EUA_";
}
$errmsg = null;
$right_files = array(
"media"=>"../data/",
"tmp"=>"../data/tmp/",
"cache"=>"../data/cache/",
"templates_cache"=>"../data/templates_cache/",
"templates_c"=>"../data/templates_c/",
"templates_c"=>"../data/templates_c/room/",
"templates_c"=>"../data/templates_c/pb-admin/",
"configs"=>$app_name."configs/",
"core.php"=>$core_sample_file,
"db.php"=>$db_sample_file,
"sitemap.xml"=>"../sitemap.xml",
"htmls"=>"../htmls/",
"media subdir"=>"../attachment/"
);
if (isset($_GET['action']) && ($_GET['action'] == "check_file_right")) {
	echo "<div class='emsg'>";
	foreach ($right_files as $val) {
		//$file_names = str_replace("/", "", $val);
		$rights = (is_dir($val))?dir_writeable($val):is_writable($val);
		if(!$rights) echo "<li style='color: red;'>".$val.$lang['dir_cant_write']."<img src='images/wrong.gif' /></li>";
		else echo "<li>".$val.$lang['right_ok']."<img src='images/right.gif' /></li>";
	}
	echo "</div>";
	exit;
}
if (empty($_REQUEST['step'])) {
	foreach ($right_files as $val) {
		//$file_names = str_replace("/", "", $val);
		$rights = (is_dir($fal))?dir_writeable($val):is_writable($val);
		if(!$rights) {
			$errmsg[] = "<li style='color: red;'>".$val.$lang['dir_cant_write']."<img src='images/wrong.gif' /></li>";
			$UA_INSTALLING = false;
		}
	}
}
if(isset($_POST['step']) && ($_POST['step']==1) && !empty($_POST['site'])){
	$COMPLETE_INSTALL = false;
	if($_POST['site']['forumtype']){
		if($_POST['forum']['admin'] == ""){
			$errmsg[] = $lang['pls_input_admin']."<br>";
			$UA_INSTALLING = false;
		}elseif ($_POST['forum']['adminpass'] == ""){
			$errmsg[] = $lang['pls_input_admin_passwd']."<br>";
			$UA_INSTALLING = false;
		}
	}

	if ($UA_INSTALLING) {
		$fp = fopen("core.sample.php", 'r');
		if (!$fp) {
			$errmsg[] = $lang['core_sample_not_exists'];
			$UA_INSTALLING = false;
		}else{
			$configfile = fread($fp, filesize("core.sample.php"));
			fclose($fp);
			$configfile = str_replace("%UALINK_SETUP_URL%",$_POST['site']['url'],$configfile);
			$ds = "/";
			if($_SERVER["WINDIR"] || strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"windows")){
				$ds = "\\";
			}
			$configfile = str_replace("%UALINK_SETUP_INSTALLED%",1,$configfile);
			$configfile = str_replace("%UALINK_AUTH_KEY%",getRadomStr(15), $configfile);
			if ($_POST['site']['forumtype']) {
				$configfile = str_replace("%FORUM_SWITCH%", 1,$configfile);
				$configfile = str_replace("%FORUM_URL%",$_POST['site']['forumurl'],$configfile);
			}else{
				$configfile = str_replace("%FORUM_SWITCH%", 0,$configfile);
				$configfile = str_replace("\"%FORUM_URL%\"", "null",$configfile);
			}
			$configfile = str_replace("%UALINK_SETUP_DATE%",date("Y-m-d H:i:s"),$configfile);
			$configfile = str_replace("%APPLICATION_LANGUAGE%", $lang_name,$configfile);
			switch ($_POST['site']['forumtype']){
				case 1:
					$configfile = str_replace("%FORUM_TYPE%", "discuz",$configfile);
					break;
				case 2:
					$configfile = str_replace("%FORUM_TYPE%", "phpwind",$configfile);
					break;
				default:
					$configfile = str_replace("\"%FORUM_TYPE%\"", "null",$configfile);
					break;
			}
			$fp_core = fopen($core_sample_file, 'w');
			if(!$fp_core){
				$errmsg[] = $language['not_enough_right'];
				$UA_INSTALLING = false;
			}
		}
	}
	if ($UA_INSTALLING) {
		$dbhost = htmlspecialchars(trim($_POST['db']['host']));
		$dbuser = htmlspecialchars(trim($_POST['db']['user']));
		$dbpw = htmlspecialchars(trim($_POST['db']['pass']));
		$dbname = htmlspecialchars(trim($_POST['db']['name']));
		$tb_prefix = htmlspecialchars(trim($_POST['db']['prefix']));
		if(empty($dbname)) {
			$errmsg[] = $lang['pls_select_db'];
			$UA_INSTALLING = false;
		} else {
			if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
				$COMPLETE_INSTALL = false;
				$errmsg[] = $lang['db_error'].mysql_error();
				$error_number = mysql_errno();
				switch ($error_number) {
					case 1049:
					    $db_err_info = $lang['db1049'];
						break;
					case 1045:
					    $db_err_info = $lang['db1045'];
					    break;
					default:
					    $db_err_info = mysql_error();
						break;
				}
				die("<font color=red>Error: ".$db_err_info."<a href='install.php?language=".$_GET['language']."'>".$lang['retry_install']."</a></font>");
				//这里如果出错,根据php的不同配置,有可能直接终止了,所以这里必须设置一个断点
			} else {
				$fp2 = fopen("db.sample.php", 'r');
				if (!$fp2) {
					$errmsg[] = $lang['db_sample_right'];
					$COMPLETE_INSTALL = false;
				}else{
					$dbfile = fread($fp2, filesize("db.sample.php"));
					fclose($fp2);
					$dbfile = str_replace("%UALINK_SETUP_DBHOST%",$dbhost,$dbfile);
					$dbfile = str_replace("%UALINK_SETUP_DBUSER%",$dbuser,$dbfile);
					$dbfile = str_replace("%UALINK_SETUP_DBPASS%",$dbpw,$dbfile);
					$dbfile = str_replace("%UALINK_SETUP_DBNAME%",$dbname,$dbfile);
					$dbfile = str_replace("%UALINK_SETUP_DBPREFIX%",
					$_POST['db']['prefix'],$dbfile);
					//$dbfile = str_replace("%UALINK_SETUP_DBSESSION%","session_start();",$dbfile);
					if(mysql_get_server_info() > '4.1'){
						$dbfile = str_replace("#%UALINK_SETUP_SETNAMES%",
						"\$g_db->Execute(\"set names '$dbcharset'\");",$dbfile);
					}
					$fp2 = fopen($db_sample_file, 'w');
					if(!$fp2){
						$errmsg[] = $lang['db_file_right'];
						$COMPLETE_INSTALL = false;
						$UA_INSTALLING = false;
					}elseif(empty($errmsg)){
						fwrite($fp2, trim($dbfile));
						fclose($fp2);
					}
				}
				if(isset($_POST['db']['create']) && $UA_INSTALLING){
					//mysql_query("DROP DATABASE `".$dbname."`;");
					if(mysql_get_server_info() > '4.1') {
						mysql_query("CREATE DATABASE IF NOT EXISTS"
						." $dbname DEFAULT CHARACTER SET $dbcharset;");
					} else {
						mysql_query("CREATE DATABASE IF NOT EXISTS $dbname;");
					}
				}else {
					$BACUP_DB = true;
				}
				$sql = file_get_contents($sqlfile);
				if(empty($sql)){
					$errmsg[] = $sqlfile.":".$lang['db_file_not_exists'];
					$COMPLETE_INSTALL = false;
					$UA_INSTALLING = false;
				}
				$conn = mysql_connect($dbhost,$dbuser,$dbpw);

				if($conn){
					$db = mysql_select_db($dbname);
					if($BACUP_DB){
						require_once(INSTALL_ROOT."../libraries/db_mysql.inc.php");
						$db = new DB_Sql();
						//$tb_prefix = $_POST['db']['prefix'];
						$sqldump = null;
						$conn = $db->connect($dbname,$dbhost,$dbuser,$dbpw);
						if(mysql_get_server_info() > '4.1'){
							$db->query("set names '$dbcharset'");
						}
						$tables = $db->table_names();
						if (!function_exists("stripos")) {
						  function stripos($str,$needle) {
						   return strpos(strtolower($str),strtolower($needle));
						  }
						}
						if(!empty($tables)){
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
						}
						$file_path = "../data/backup/";
						if(function_exists("gzwrite")){
							$zip_file_name = $file_path."db_".date("Ymd")."_".getRadomStr().".gz";
							$zip_fp = gzopen($zip_file_name, "w9");
							if($zip_fp){
								gzwrite($zip_fp, $sqldump);
								gzclose($zip_fp);
								$rightmsg = $lang['data_backuped']." ".$zip_file_name;
							}else{
								$errmsg[] = $lang['zip_open_error'];
							}
						}else{
							$file_name = $file_path."db_".date("Ymd").".sql";
							$fp = fopen($file_name, "w+");
							if($fp){
								flock($fp, 3);
								fwrite($fp, $sqldump);
								fclose($fp);
								$rightmsg = $lang['data_backuped']." ".$file_name;
							}else{
								$errmsg[] = $lang['sql_open_error'];
							}
						}
					}
					if(mysql_get_server_info() > '4.1'){
						mysql_query("set names '$dbcharset'");
					}
					sql_run($sql);
					$data_sql = file_get_contents("data/mysqldata.sql");
					sql_run($data_sql);
				}else{
					$errmsg[] = $lang['db_cn_error'];
					$COMPLETE_INSTALL = false;
					$UA_INSTALLING = false;
				}
				if (!empty($_POST['forum']['admin']) && !empty($_POST['forum']['adminpass']) && $UA_INSTALLING) {
					$nowtime = time();
					$exp_time = $nowtime+10*86400;

					$sql = "REPLACE INTO ".$_POST['db']['prefix']
					."members (username,userpass,user_level,status,created,email) values ('".$_POST['forum']['admin'].
					"','".md5($_POST['forum']['adminpass'])."',9,'1','$nowtime','admin@yourdomain.com')";
					mysql_query($sql);
					$sql = "REPLACE INTO ".$_POST['db']['prefix']
					."adminers (user_name,user_pass,level,last_name,created,email) values ('".$_POST['forum']['admin'].
					"','".md5($_POST['forum']['adminpass'])."',9,'".$lang['super_admin']."','$nowtime','admin@yourdomain.com')";
					mysql_query($sql);
					mysql_query("INSERT INTO ".$_POST['db']['prefix']
					."friendlinks (title,url) values ('".$lang['ualinkphp']."','http://www.phpb2b.com/'),('".$lang['ualinkb2b_demo']."','http://bbs.phpb2b.com/')");
					$sql = "INSERT INTO ".$_POST['db']['prefix']
					."trades (topic,content,type_id,status,created,if_urgent,submit_time,expire_time,expire_days,if_commend) values ('".$lang['first_sell']."','".$lang['first_sell'].",".$lang['first_del_content']."','2',1,'$nowtime','0','$nowtime','$exp_time',10,1),('".$lang['first_buy']."','".$lang['first_sell'].",".$lang['first_del_content']."','1',1,'$nowtime','1','$nowtime','$exp_time',10,1)";
					mysql_query($sql);
					mysql_query("INSERT INTO ".$_POST['db']['prefix']
					."companies (member_id,name,description,status,if_commend,province_code_id,city_code_id) values (1,'".$lang['ualink_b2b']."','".$lang['ualink_b2b_content']."',1,1,110000,110000)");
				}
				if(mysql_errno()) {
					$errmsg[] = $lang['db_error'].mysql_error();
					$COMPLETE_INSTALL = false;
					$UA_INSTALLING = false;
				}else{
					mysql_close();
    				@fwrite($fp_core, trim($configfile));
    				@fclose($fp_core);
				}
				if ($UA_INSTALLING) $COMPLETE_INSTALL = true;
			}
		}
	}
	if($UA_INSTALLING){
		$setting_cachfile = INSTALL_ROOT."../data/cache/".$cookiepre."setting.inc.php";
		require($setting_cachfile);
		        $str = "<?php
\$_SETTINGS = array(\n";
        $str.="\"sitename\"=>'".$_POST['site']['name']."',\n";
        $str.="\"sitetitle\"=>'".$_POST['site']['name']."',\n";
        $str.="\"companyname\"=>'请到控制台更新公司名称',\n";
        $str.="\"icpnumber\"=>'ICP备案中',\n";
        $str.="\"servicetel\"=>'12345678',\n";
        $str.="\"saletel\"=>'12345678',\n";
        $str.="\"serviceqq\"=>'12345678',\n";
        $str.="\"servicemsn\"=>'12345678@yourdomain.com',\n";
        $str.="\"serviceemail\"=>'12345678@yourdomain.com',\n";
        $str.="\"sitebannerword\"=>'A NEW B2B WEBSITE',\n";
        $str.=");\n?>";
			$fp = fopen($setting_cachfile, 'w');
			$fw = fwrite($fp, trim($str));
			if(!$fw) {
				$UA_INSTALLING = false;
				$errmsg[] = $lang['conf_write_false'];
			}
			fclose($fp);

	}
	if($COMPLETE_INSTALL){
		$fp = fopen(INSTALL_ROOT."../data/install.lock", 'w');
		$fw = fwrite($fp, " ");
		fclose($fp);
		PB_goto("install.php?step=done&adminer=".$_POST['forum']['admin']."&rightmsg=".urlencode($rightmsg));
	}else {
		$errmsg[] = $lang['install_false'];
	}
}
if ($_GET['step'] == "done") {
	echo "<div  class='emsg'><ul>";
	if (!empty($_GET['rightmsg'])) {
			echo "<li>" .urldecode($_GET['rightmsg'])."</li>";
	}
	echo "<li>安装完成，<font color=red>请务必删除 <strong>install</strong> 目录以及 <strong>install.php</strong></font>，你现在可以<a href='".URL."' target='_blank'>访问</a>你的网站了</li>";
	echo "<li>您可以用账户 <strong>".$_GET['adminer']."</strong> 进行<a href='../user/logging.php' target='_blank'>登陆</a>或者进入<a href='../pb-admin/' target='_blank'>控制台</a>了，请保管好您的管理员账户以及密码</li>";
	echo "</ul></div>";
	exit;
}
?>
<script language="javascript">
function suggestPassword() {
    var pwchars = "abcdefhjmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWYXZ!@#$%^&*()";
    var passwordlength = 12;    // do we want that to be dynamic?  no, keep it simple :)
    var passwd = document.getElementById('forum_adminpass');
    passwd.value = '';

    for ( i = 0; i < passwordlength; i++ ) {
        passwd.value += pwchars.charAt( Math.floor( Math.random() * pwchars.length ) )
    }
    return passwd.value;
}
function goUrl(language){
  location.href="install.php?language="+language.value;
}
</script>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <TBODY>
  <tr>
    <td height="5" colspan="3"><div id="errmsg" class="errmsg" align="left"><ul><?php
    if(!empty($errmsg)){
    	foreach ($errmsg as $err) {
    		echo "<li>".$err."</li>";
    	}
    }
    ?></ul></div></td>
  </tr>
    <TR>
      <TD width=15 height="18"><IMG height="18" src="images/table_up_left.gif" width=15></TD>
      <TD background="images/table_up_bg.gif"></TD>
      <TD width=13 height="18"><IMG height="18" src="images/table_up_right.gif" width=13></TD>
    </TR>
    <TR>
      <TD align="middle" background="./images/table_left_bg.gif"></TD>
      <TD align="center">
          <table border="0" cellpadding="0" cellspacing="0" background="<{$media_path}>images/bj0.jpg">
            <tr>
              <td>
              <form name='installfrm' method="post" action="./install.php?language=<?php echo $_GET['language'];?>"  onsubmit="this.submit.disabled=true;">
      <input type="hidden" name="step" value="1">
      <table width="100%">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $lang['pls_input_site_desc'];?></h4>&nbsp;</th>
          </tr>
        <tr>
          <th><?php echo $lang['pls_select_lang'];?></th>
          <td colspan="2"><div align="left">
            <select name="language" id="Language" onchange="goUrl(this.options[this.selectedIndex]);">   >
                <option value="zh-cn" <?php if($_GET['language']=="zh-cn") echo "selected";?>>简体中文</option>
                <option value="en" <?php if($_GET['language']=="en") echo "selected";?>>English</option>
            </select>
          </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['site_name'];?></th>
          <td colspan="2"><div align="left">
            <input name="site[name]" type="text" size="35" value="<?php echo $site_name = (empty($_POST['site']['name']))?($lang['a_new_b2b_site']." By ".$lang['ualinkphp'].PHPB2B_VERSION):($_POST['site']['name']);?>" class="input" onfocus="if(this.value == '<?php echo $lang['ualinkphp']." PHP B2B System_".PHPB2B_VERSION;?>'){this.value = ''}" onblur="if(this.value == ''){this.value = '<?php echo $lang['ualinkphp']." PHP B2B System_".PHPB2B_VERSION;?>'}" />
          </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['site_url'];?></th>
          <td colspan="2"><div align="left">
            <input name="site[url]" type="text" size="35" value="<?php echo $local_url;?>" class="input">
          </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['bbs_set'];?></th>
          <td colspan="2"><div align="left">
            <select name="site[forumtype]" id="site[forumtype]">
              <option value="0" selected="selected"><?php echo $lang['not_support'];?></option>
              <option value="1"><?php echo $lang['discuz_bbs'];?></option>
              <option value="2"><?php echo $lang['phpwind_bbs'];?></option>
            </select>
          </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['bbs_url'];?></th>
          <td colspan="2"><div align="left">
            <input name="site[forumurl]" type="text" id="site[forumurl]" value="<?php echo $site_forumurl = (empty($_POST['site']['forumurl']))?($local_url."bbs/"):$_POST['site']['forumurl'];?>" size="35"  class="input"/>
          </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['admin_account'];?></th>
          <td colspan="2"><div align="left">
            <input name="forum[admin]" type="text" id="forum[admin]" value="<?php echo $forum_admin = (empty($_POST['forum']['admin']))?"admin":($_POST['forum']['admin']);?>" size="15" class="input" /></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['admin_passwd'];?></th>
          <td colspan="2"><div align="left">
            <input name="forum[adminpass]" type="text" id="forum_adminpass" size="15" value="<?php echo $_POST['forum']['adminpass'];?>" class="input" />  <img src="./images/set.gif" id="button_generate_password" onclick="suggestPassword()" alt="<?php echo $lang['get_random_pwd'];?>" align="absmiddle" /><br><?php echo $lang['if_set_forum'];?>
          </div></td>
        </tr>
      </table>
      <hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted" color=#000000 size=1/>
      <table width="100%">
        <tr>
          <th colspan="2" align="left"><h4><?php echo $lang['pls_input_db_connect'];?></h4><br />
            <I><?php echo $lang['if_save_old_data'];?></I></th>
          </tr>
        <tr>
          <th><?php echo $lang['db_name'];?></th>
          <td ><div align="left">
            <input name="db[name]" id="db_name" type="text" size="15" value="<?php echo $db_name = (empty($_POST['db']['name']))?"ualink":($_POST['db']['name']);?>" class="input" onfocus="if(this.value == 'ualink'){this.value = ''}" onblur="if(this.value == ''){this.value = 'ualink'}" />
            MySQL <?php echo $lang['db_name'];?><!--检查，如果存在，就自动换其他名字-->
            <input name="db[create]" type="checkbox" id="db_create" />
            <label for="db_create"><?php echo $lang['if_create_new_db'];?></label></div></td>
          </tr>
            <tr>
          <th><?php echo $lang['db_user'];?></th>
          <td><div align="left">
            <input name="db[user]" type="text" size="15" value="<?php echo $db_user = (empty($_POST['db']['user']))?"root":($_POST['db']['user']);?>" class="input" />
            MySQL <?php echo $lang['db_user'];?></div></td>
          </tr>
            <tr>
          <th><?php echo $lang['db_pass'];?></th>
          <td><div align="left">
            <input name="db[pass]" type="password" size="15" value="<?php echo $_POST['db']['pass'];?>" class="input" />
            MySQL <?php echo $lang['db_pass'];?></div></td>
          </tr>
            <tr>
          <th><?php echo $lang['db_host'];?></th>
          <td><div align="left">
            <input name="db[host]" type="text" size="15" value="<?php echo $post_db_host = (empty($_POST['db']['host']))?"localhost":($_POST['db']['host']);?>" class="input" />
            <?php echo $lang['default_host'];?></div></td>
          </tr>
            <tr>
          <th><?php echo $lang['db_prefix'];?></th>
          <td><div align="left">
            <input name="db[prefix]" type="text" value="<?php echo $post_db_prefix = (empty($_POST['db']['prefix']))?"pb_":($_POST['db']['prefix']);?>" size="15" class="input" />
            <?php echo $lang['do_not_mod'];?></div></td>
          </tr>
      </table>
      <br />
      <div id="divProgress" align="center" style="display:block"></div>
        <h2 class="step">
      <input name="submit" type="submit" value="<?php echo $lang['start_install'];?>" onclick="return check_install();" class="btn" />
        </h2>
    </form><a href="install.php?action=check_file_right&language=<?php echo $lang_name;?>" target="_blank"><?php echo $lang['check_file_right'];?></a>&nbsp;<a href="http://www.ualink.org/docs/index.html#install_start" target="_blank"><?php echo $lang['view_help'];?></a></td>
            </tr>
            <tr>
              <td><div id="foot" class="ft" style="color:#FFFF99"><?php echo $lang['ualink_wel'];?></div></td>
            </tr>
          </table>
      </td>
            <TD align="middle" background="images/table_right_bg.gif"></TD>
  </tr>
  <tr>
        <TD align="middle" background="images/table_right_bg.gif"></TD>
    </TR>
    <TR>
      <TD width="15" height="12"><img src="images/table_down_left.gif" width="15" height="12"></TD>
      <TD background="./images/table_down_bg.gif"></TD>
      <TD width="13" height="12"><img src="images/table_down_right.gif" width="13" height="12"></TD>
    </TR>
  </TBODY>
</table>
</body>
</html>

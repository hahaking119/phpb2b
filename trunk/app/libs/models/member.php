<?php
 class Members extends UaModel {

 	var $name = "Member";
 	var $info = null;

 	var $mask_user_name = "admin";

 	function Members()
 	{

 	}

	function checkUserLogin($uname,$upass)
	{
		global $time_stamp, $g_db;
		global $memberlog, $tb_prefix;
		$sql = "SELECT id,username AS LoginName,userpass AS LoginPass,status AS MemberStatus,user_type,email,user_level,credit_point,service_end_date,office_redirect FROM {$tb_prefix}members WHERE username='$uname'";
		$tmpUser = $g_db->GetRow($sql);
		if ($tmpUser['service_end_date']<$time_stamp && $tmpUser['user_level']<9) {
			//get rights from access.
			$after_livetime = $g_db->GetOne("select after_livetime from {$tb_prefix}accesses where membertype_id=".$tmpUser['user_type']);
			$after_livetime = intval($after_livetime);
			switch ($after_livetime) {
				case 1:
					alert("本站提醒:你的会员服务期已经过期,请重新激活", true, URL."room/");
					break;
				case 2:
				    alert("本站提醒:由于会员有效期已过,被禁止登录", true, URL."user/logging.php");
				    session_destroy();
				    break;
				case 3:
					alert("本站提醒:你的会员服务期已经过期,禁止发布任何信息", true, URL."room/");
					break;
				case 4:
					uaMailTo($tmpUser['email'], $tmpUser['LoginName'], URL, "本站提醒:你的会员服务器已经到期,请尽快重新激活");
					break;
				default:
					continue;
			}
		}
		$true_pass = $tmpUser['LoginPass'];
		$loginip = uaIp2Long(uaGetClientIP());
		$sql = "insert into {$tb_prefix}memberlogs (member_id,login_time,login_ip) values (".$tmpUser['id'].",'$time_stamp','$loginip')";
		$g_db->Execute($sql);
		$g_db->Execute("UPDATE {$tb_prefix}members SET last_login=".$time_stamp." WHERE username='$uname'");
		if (empty($uname) || empty($upass)){
			return -1;
		}elseif(!$this->checkUserExist($uname)) {
			return -2;
		}elseif (strcmp($true_pass,md5($upass))!=0){
			return -3;
		}elseif ($tmpUser['MemberStatus'] !=1) {
			return -4;
		}else {
		    $this->info = $tmpUser;
			return true;
		}
	}

	function checkUserExist($uname)
	{
		$sql = "SELECT username FROM ".$GLOBALS['tb_prefix']."members WHERE username='$uname'";
		$tmp_exists = $GLOBALS['g_db']->GetOne($sql);
		if (!empty($tmp_exists) || $tmp_exists!='') {
			return true;
		}else {
			return false;
		}
	}

	function updateUserStatus($id_array, $status = 1)
	{
		global $g_db;
		if (is_array($id_array))
		{
			$tmp_ids = implode(",",$id_array);
			$sql = "update ".$this->getTable()." set status='$status' where id in (".$tmp_ids.")";
		}
		else
		{
			$sql = "update ".$this->getTable()." set status='$status'  WHERE id=".intval($id_array);
		}
		$result = $g_db->Execute($sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
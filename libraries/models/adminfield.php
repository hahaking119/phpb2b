<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id$
 */
class Adminfields extends PbModel {
 	var $name = "Adminfield";
 	var $userid;
 	var $username;
 	var $userpass;
 	var $error;

 	function Adminfields()
 	{
		parent::__construct();
 	}

	function checkUserLogin($uname, $upass, $set = true)
	{
		$uname = trim($uname);
		$upass = trim($upass);
		$_this = & Members::getInstance();
		if (empty($uname) || empty($upass)){
			return -1;
		}
		$sql = "SELECT m.id,m.username,m.userpass,af.first_name,af.last_name FROM {$this->table_prefix}adminfields af LEFT JOIN {$this->table_prefix}members m ON af.member_id=m.id WHERE m.username='$uname'";
		$tmpUser = $this->dbstuff->GetRow($sql);
		if(!$_this->checkUserExist($uname)) {
			$this->error = L("member_not_exists");
			return -2;
		}elseif (!pb_strcomp($tmpUser['userpass'],md5($upass))){
			$this->error = L("login_pwd_wrong");
			return -3;
		}else {
    		$tAuth = $tmpUser['id']."\n".$tmpUser['username']."\n".$tmpUser['userpass']."\n".pb_get_client_ip();
    		usetcookie("admin", authcode($tAuth, "ENCODE"));
			return true;
		}
	}
	
	function Add()
	{
		
	}
	
	function updatePasswd($user_id, $user_pass)
	{
		$result = false;
		$sql = "UPDATE {$this->table_prefix}members m,{$this->table_prefix}adminfields af SET m.userpass='".md5($user_pass)."',af.modified=".$this->timestamp." WHERE m.id=".$user_id." AND af.member_id=m.id";
		$result = $this->dbstuff->Execute($sql);
		return $result;
	}
}
?>
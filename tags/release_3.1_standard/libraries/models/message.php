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
class Messages extends PbModel  {
 	var $name = "Message";
 	
 	function Messages()
 	{
 		parent::__construct();
 	}
 	
 	function getReadStatus()
 	{
 		$tmp_status = explode(",", L("read_status", "tpl"));
 		return $tmp_status;
 	}
 	
 	function SendToUser($from_username, $to_username, $data)
 	{
 		$member_info = $this->dbstuff->GetRow("SELECT m.id,m.username FROM {$this->table_prefix}members m WHERE m.username ='".$to_username."'");
 			$from_memberinfo = $this->dbstuff->GetRow("SELECT m.id,m.username FROM {$this->table_prefix}members m WHERE m.username ='".$from_username."'");
 		if (!$member_info || empty($member_info) || !$from_memberinfo || empty($from_memberinfo)) {
 			return false;
 		}else{
 			if (empty($data['type'])) {
 				$data['type'] = 'user';
 			}
 			$sql = "INSERT INTO {$this->table_prefix}messages (title,content,from_member_id,cache_from_username,to_member_id,cache_to_username,created,type) VALUE ('".$data['title']."','".$data['content']."',".$from_memberinfo['id'].",'".$from_memberinfo['username']."',".$member_info['id'].",'".$member_info['username']."',{$this->timestamp},'".$data['type']."')";
 			return $this->dbstuff->Execute($sql);
 		}
 	}
 	
 	function SendToAdmin($from_username, $data)
 	{
 		global $administrator_id; 		
 		$member_info = $this->dbstuff->GetRow("SELECT m.id,m.username FROM {$this->table_prefix}members m WHERE m.id ='".$administrator_id."'");
 		$from_memberinfo = $this->dbstuff->GetRow("SELECT m.id,m.username FROM {$this->table_prefix}members m WHERE m.username ='".$from_username."'");
 		if (!$from_memberinfo || empty($from_memberinfo)) {
 			$from_memberinfo['id'] = -1;
 			$from_memberinfo['username'] = L("anonymous", "tpl");
 		}
 		$sql = "INSERT INTO {$this->table_prefix}messages (title,content,from_member_id,cache_from_username,to_member_id,cache_to_username,created) VALUE ('".$data['title']."','".$data['content']."',".$from_memberinfo['id'].",'".$from_memberinfo['username']."',".$administrator_id.",'".$member_info['username']."',{$this->timestamp})";
 		return $this->dbstuff->Execute($sql);
 	}
}
?>
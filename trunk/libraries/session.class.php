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
 * @since PHPB2B v 2.5.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: session.class.php 420 2009-12-26 13:37:06Z cht117 $
 */
class PbSessions {
	var $lifetime = 1440;
	var $sess_table;
	var $table_prefix;
	var $db;
	var $id;
	var $time;
	var $sesskey;
	var $expiry;
	var $last_activity;
	var $expireref;
	var $data;

    function PbSessions() {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
    }
    
    function __construct()
    {
    	$this->PbSessions();
    }

    function open($save_path, $session_name, $persist = null) {
		global $pdb, $tb_prefix, $time_stamp;
	    $this->time = $time_stamp;
		$this->table_prefix = $tb_prefix;
		$this->sess_table = $tb_prefix.'sessions';
		$this->db = &$pdb;
		return true;
    }

    function close() {
		$this->gc();
        return true;
    } 

    function read($sid) {
		$result = $this->db->GetRow("SELECT data FROM {$this->sess_table} WHERE sesskey='$sid'");
		return $result ? $result['data'] : null;
    } 

    function write($sid, $sess_data) {
		$sess_data = pb_addslashes($sess_data);
		$expiry = $this->time+$this->lifetime;
		$sql = "SELECT * FROM {$this->sess_table} WHERE sesskey='{$sid}'";
		$result = $this->db->GetRow($sql);
		if(!empty($result)){
			$sql = "UPDATE {$this->sess_table} SET data='$sess_data',expiry='$expiry',modified='$this->time' WHERE sesskey='{$sid}'";
			$this->db->Execute($sql);
		}else{
			$this->db->Execute("INSERT INTO {$this->sess_table} (sesskey,data,expiry,expireref,created,modified) VALUES('$sid', '$sess_data', '$expiry', '".pb_getenv('PHP_SELF')."', '$this->time', '$this->time')");
		}
		return true;
    } 

    function destroy($sid) { 
		$this->db->query("DELETE FROM {$this->sess_table} WHERE sesskey='$sid'");
		return true;
    } 

	function gc() {
		$expiretime = $this->time-$this->lifetime;
		$this->db->Execute("DELETE FROM {$this->sess_table} WHERE expiry<{$expiretime}");
		return true;
    }
}
?>
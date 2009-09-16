<?php
class PbSession {
	var $lifetime = 1800;
	var $pre;
	var $g_db;
	var $time;

    function PbSession() {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
    }

    function open($save_path, $session_name) {
		global $g_db, $tb_prefix, $time_stamp;
	    $this->time = $time_stamp;
		$this->pre = $tb_prefix;
		$this->db = &$g_db;
		return true;
    }

    function close() {
		$this->gc();
        return true;
    } 

    function read($sid) {
		$r = $this->db->get_one("SELECT data FROM {$this->pre}session WHERE sessionid='$sid'");
		return $r ? $r['data'] : '';
    } 

    function write($sid, $sess_data) {
		$sess_data = addslashes($sess_data);
        $this->db->query("REPLACE INTO {$this->pre}session (sessionid,data,lastvisit) VALUES('$sid', '$sess_data', '$this->time')");
		return true;
    } 

    function destroy($sid) { 
		$this->db->query("DELETE FROM {$this->pre}session WHERE sessionid='$sid'");
		return true;
    } 

	function gc() {
		$expiretime = $this->time-$this->lifetime;
		$this->db->query("DELETE FROM {$this->pre}session WHERE lastvisit<$expiretime");
		return true;
    }
}
?>
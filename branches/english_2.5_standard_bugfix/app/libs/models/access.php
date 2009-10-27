<?php
 class Accesses extends UaModel {
 	var $name = "Access";

 	function Accesses()
 	{

 	}

	function checkUserPush($access_col, $nowamount){
		global $ua_user;
		$usertype_id = $ua_user['user_type'];
		if(empty($usertype_id)) die("Wrong User Type.");
		$can_pushmax = intval($this->field($access_col, "membertype_id=".$usertype_id));
		if(($can_pushmax===0) || ($can_pushmax>$nowamount)) return true;
		else return false;
	}

	function getExpireTime($live_time = null)
	{
		global $time_stamp;
		$return = null;
		$live_time = empty($live_time)?1:intval($live_time);
		switch ($live_time) {
			case 1:
				$return = $time_stamp+86400*30;
				break;
			case 2:
				$return = $time_stamp+86400*90;break;
			case 3:
				$return = $time_stamp+86400*180;break;
			case 4:
				$return = $time_stamp+86400*365;break;
			case 5:
				$return = $time_stamp+86400*365*5;break;
			default:
				$return = $time_stamp+86400*30;
				break;
		}
		return $return;
	}
}
?>
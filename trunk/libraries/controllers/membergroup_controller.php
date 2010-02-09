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
 * @version $Id: membergroup_controller.php 426 2009-12-26 13:44:16Z cht117 $
 */
class Membergroup extends PbController {
	var $name = "Membergroup";
	
	function getUsergroups($type = 'all')
	{
		//system,special,define
		$return = array();
		require(CACHE_PATH. "cache_membergroup.php");
		$typeid = strval($type);
		foreach ($_PB_CACHE['membergroup'] as $key=>$val) {
			if($typeid == 'all'){
				$return[$key] = $val['name'];
			}else{
				if ($typeid==$val['type']) {
					$return[$key] = $val['name'];
				}
			}
		}
		ksort($return);
		return $return;
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
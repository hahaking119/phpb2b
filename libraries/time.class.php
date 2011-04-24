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
 * @version $Id: time.class.php 455 2009-12-26 14:26:35Z steven $
 */
class Times extends PbObject
{
    var $time_stamp;

	function getSepDays($date1,$date2)
	{
		$tmp = $date2 - $date1;
		$days = round($tmp/3600/24);
		return $days;
	}

	function dateChecker($ymd, $sep='-') {
		if(!empty($ymd)) {
			list($year, $month, $day) = explode($sep, $ymd);
			return checkdate($month, $day, $year);
		} else {
			return false;
		}
	}

	function dateConvert($access_date, $ds = "-")
	{
		$date_elements = explode($ds, $access_date);
		$s_time = @mktime(0, 0, 0, $date_elements [1], $date_elements[2], $date_elements [0]);
		return $s_time;
	}
}
?>
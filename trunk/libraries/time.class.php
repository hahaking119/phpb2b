<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Sat Sep 12 15:04:30 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
class Times extends UaObject
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
		$s_time = mktime (0, 0, 0, $date_elements [1], $date_elements[2], $date_elements [0]);
		return $s_time;
	}
}
?>
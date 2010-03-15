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
$codeset = "utf-8";
$text_dir = 'ltr'; // ('ltr' for left to right, 'rtl' for right to left)

/* Set locale to Dutch */
setlocale(LC_ALL, 'zh_CN');

$day_of_week = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
$month = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');

// variable below date
$datefmt = '%Y 年 %m 月 %d 日 %H:%M';

$timespanfmt = '%s 天 %s 小时，%s 分 %s 秒';
?>
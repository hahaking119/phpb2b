<?php
$codeset = "utf-8";
/* Set locale to Dutch */
setlocale(LC_ALL, 'zh_CN');

$day_of_week = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
$month = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%Y 年 %m 月 %d 日 %H:%M';

$timespanfmt = '%s 天 %s 小时，%s 分 %s 秒';

/* Output: vrijdag 22 december 1978 */
echo strftime("%A %e %B %Y", mktime(0, 0, 0, 12, 22, 1978));

/* try different possible locale names for german as of PHP 4.3.0 */
$loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
echo "Preferred locale for german on this system is '$loc_de'";
?>
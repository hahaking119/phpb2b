<?php
$codeset = "utf-8";
/* Set locale to Dutch */
setlocale(LC_ALL, 'zh_CN');

$day_of_week = array('����', '��һ', '�ܶ�', '����', '����', '����', '����');
$month = array('һ��', '����', '����', '����', '����', '����', '����', '����', '����', 'ʮ��', 'ʮһ��', 'ʮ����');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%Y �� %m �� %d �� %H:%M';

$timespanfmt = '%s �� %s Сʱ��%s �� %s ��';

/* Output: vrijdag 22 december 1978 */
echo strftime("%A %e %B %Y", mktime(0, 0, 0, 12, 22, 1978));

/* try different possible locale names for german as of PHP 4.3.0 */
$loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
echo "Preferred locale for german on this system is '$loc_de'";
?>
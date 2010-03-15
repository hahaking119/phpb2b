<?php
define('CURSCRIPT', 'checkversion');
require("../libraries/common.inc.php");
$support_url = "http://localhost/phpb2b.com/check_version.php?version=".PHPB2B_VERSION."&release=".PHPB2B_RELEASE."&charset={$charset}&dbcharset={$dbcharset}";
$fp = file_get_contents($support_url)
?>
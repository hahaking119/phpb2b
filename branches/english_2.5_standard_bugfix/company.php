<?php
$inc_path = "./";
$li = 3;
require("global.php");
$acs = array(
"home", "list", "index"
);
if(empty($_GET['ac']) || (!in_array($_GET['ac'], $acs))) {
	$ac = 'home';
} else {
	$ac = trim($_GET['ac']);
}
if($ac == 'index') {
	$acfile = 'home';
} else {
	$acfile = $ac;
}
include(BASE_DIR."./company/".$acfile.".php");
?>
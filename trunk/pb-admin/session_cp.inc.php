<?php
if(empty($_COOKIE[$cookiepre.'uladmin']) || !($_COOKIE[$cookiepre.'uladmin'])){
	PB_goto("login.php");
}else{
    $tAdminInfo = authcode($_COOKIE[$cookiepre.'uladmin'], "DECODE");
    $tAdminInfo = explode("|", $tAdminInfo);
    $current_adminer_id = $tAdminInfo[0];
    $current_adminer = $tAdminInfo[1];
    $current_pass = $tAdminInfo[2];
    $tPass = $g_db->GetOne("select user_pass from ".$tb_prefix."adminers where user_name='".$current_adminer."'");
    if (!uaStrCompare($current_pass, $tPass) || !uaStrCompare(uaIp2Long(uaGetClientIP()), $tAdminInfo[3])) {
    	PB_goto("login.php");
    }
}
$display_eve_page = 20;
?>
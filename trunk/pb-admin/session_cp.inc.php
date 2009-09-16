<?php
if(empty($_COOKIE[$cookiepre.'uladmin']) || !($_COOKIE[$cookiepre.'uladmin'])){
	PB_goto("login.php");
}else{
    $tAdminInfo = authcode($_COOKIE[$cookiepre.'uladmin'], "DECODE");
    $tAdminInfo = explode("|", $tAdminInfo);
    $current_adminer_id = $tAdminInfo[0];
    $current_adminer = $tAdminInfo[1];
    $current_pass = $tAdminInfo[2];
    $sql = "select user_pass from {$tb_prefix}adminers where user_name='".$current_adminer."'";
    $tPass = $g_db->GetOne($sql);
    uaAssign(array("current_adminer"=>$current_adminer, "current_adminer_id"=>$current_adminer_id));
	if (!pb_strcomp($current_pass, $tPass) || !uaStrCompare(pb_get_client_ip(), $tAdminInfo[3])) {
    	PB_goto("login.php");
    }
}
$display_eve_page = 20;
/**
 * reset template dir
 */
$smarty->template_dir = "template/";
?>
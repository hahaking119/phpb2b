<?php
$inc_path = "../";
require($inc_path."global.php");
uses("member");
$member = new Members();
$member_name = rawurldecode($_GET['name']);
setvar("NewMemberName",$member_name);
$ifNeedCheck = intval($_GET['check']);
if (isset($ifNeedCheck)) {
    switch ($ifNeedCheck) {
        case 1:
            $reg_tips = lgg("pls_active_your_account");
            break;
        case 2:
            $reg_tips = lgg("pls_wait_for_check");
        default:
            break;
    }
}
$smarty->assign("RegTips", $reg_tips);
template($theme_name."/user_regdone");
?>
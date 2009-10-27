<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("trade", "member", "company", "industry", "offer", "area", "product","keyword");
$offer = new Offers();
$keyword = new Keywords();
$area = new Areas();
$company = new Companies();
$industry = new Industries();
$member = new Members();
$trade = new Trades();
$tpl_file = "trade_edit";
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$company->primaryKey = "member_id";
setvar("ObjectParams", $trade->params);
if(!empty($company_id)) $company->checkStatus($company_id);
if (isset($_GET['do'])) {
    if ($_GET['do']=="delkeyword") {
        //取得原来primid对应的keyword字段
        $keyword_ids = $trade->field("keywords", "id=".$_GET['id']);
        $keyword_ids = explode(",", $keyword_ids);
        //array_unique
    }
}
function checkTradeTopic()
{
    return false;
}
$company_info = $company->read("province_code_id as AreaCode,id AS CompanyID,name AS CompanyName,tel as Tel,CONCAT(telcode,'-',telzone,'-',tel) AS CompanyTel,CONCAT(faxcode,faxzone,fax) AS CompanyFax,email AS ContactEmail,mobile AS MobilePhone,link_man as CompanyLinkMan",$_SESSION['MemberID']);
setvar("CompanyInfo",$company_info);
$tmp_personalinfo = $member->read("province_code_id as AreaCode,lastname AS MemberName,gender as MemberGender,tel as MemberTel,qq as MemberQQ,email as ContactEmail",$_SESSION['MemberID']);
if(!empty($company_info)){
    $tmp_personalinfo['MemberTel'] = $company_info['CompanyTel'];
    $tmp_personalinfo['ContactEmail'] = $company_info['ContactEmail']?$company_info['ContactEmail']:$tmp_personalinfo['ContactEmail'];
}
$prod_info = array();
//product2offer
if(isset($_GET['action'])){
    if($_GET['action']=="pro2offer" && !empty($_GET['proid'])){
        $product = new products();
        $fields = "2 as TradeTypeId,NAME as TradeTopic,content as TradeContent,KEYWORDS as TradeKeywords,picture as TradeRemotePicture";
        $prod_info = $product->read($fields, $_GET['proid'], null, " and member_id=".$_SESSION['MemberID']);
        $trade_info['TradeTypeId'] = $prod_info['TradeTypeId'];
        $trade_info['TradeTopic'] = $prod_info['TradeTopic'];
        $trade_info['TradeContent'] = $prod_info['TradeContent'];
        if(!empty($prod_info['TradeKeywords'])){
            $_k = $g_db->Execute("select title from ".$tb_prefix."keywords where id in (".$prod_info['TradeKeywords'].")");
            $trade_info['TradeKeywords'] = $_k;
        }
        $trade_info['TradeRemotePicture'] = $prod_info['TradeRemotePicture'];
    }
}
if($_GET['id']){
    $get_id = intval($_GET['id']);
    $trade_pri_info = $trade->read(null,$get_id,null," and member_id=".$_SESSION['MemberID']);
    $offer->primaryKey = "trade_id";
    $trade_ext_info = $offer->read(null, $get_id);
    $trade_ext_info['OfferParams'] = unserialize($trade_ext_info['OfferOa']);
    $trade_info = array_merge($trade_pri_info, $trade_ext_info);
    $tmp_personalinfo['MemberQQ'] = $trade_info['OfferPrimImaccount'];
    $tmp_personalinfo['MemberTel'] = $trade_info['OfferPrimTelnumber'];
    if(!empty($trade_info['TradeKeywords'])){
        $_k = $g_db->Execute("select title from ".$tb_prefix."keywords where id in (".$trade_info['TradeKeywords'].")");
        $trade_info['TradeKeywords'] = $_k;
    }
    if (empty($trade_info) || !$trade_info) {
        flash("./tip.php","./trade.php", lgg('data_not_exists'));
    }
    $current_industry = $industry->searchParentIndustry($trade_info['TradeIndustryId']);
    if (is_array($current_industry)) {
        $search_industry_ids = implode(",",$current_industry);
        setvar("CurrentIndustry",$g_db->GetArray("SELECT name AS IndustryName FROM ".$industry->getTable(true)." WHERE id in (".$search_industry_ids.")"));
    }
}
if (!empty($trade_info)) {
    setvar("row",$trade_info);
}
setvar("MemberInfo", $tmp_personalinfo);
$expires = $trade->offer_expires;
if (isset($_POST['edit_trade'])) {
    uses("setting","access","attachment");
    $res = array();
    $offer_res = array();
    $setting = new Settings();
    $access = new Accesses();
    $attachment = new Attachments();
    $tid = intval($_POST['id']);
    $res = array();
    if(!empty($_POST['topic'])) $res['topic'] = $_POST['topic'];
    if(!empty($_POST['type_id'])) $res['type_id'] = intval($_POST['type_id']);
    $res['area_id'] = $_POST['trade']['area_id'];
    $trade->setTradeCat($res['type_id']);
    $max_amount = intval($access->field("max_".$trade->getTradeCat(),"membertype_id=".$ua_user['user_type']));
    $if_can_push_today = $access->checkUserPush("max_".$trade->getTradeCat(), $trade->getTodayPushAmount($_POST['type_id']));
    if(!$if_can_push_today){
        flash("./tip.php","./trade.php", sprintf(lgg('off_trade_amount'), $max_amount), 0);
    }
    $res['content'] = preg_replace("/(\r?\n)\\1+/","\\1",$_POST['content']);
    //$res['keywords'] = uaConvertComma($_POST['keywords']);
    if($_POST['trade']['if_urgent'])
    $res['if_urgent'] = "1";
    if ($_POST['cindustry']) {
        $industryid = $_POST['cindustry'];
    }else if($_POST['bindustry']){
        $industryid = $_POST['bindustry'];
    }else if($_POST['aindustry']){
        $industryid = $_POST['aindustry'];
    }
    if(!$industryid || empty($industryid)) $industryid=1;
    $res['industry_id'] = $industryid;
    if (array_key_exists($_POST['expire_days'],$expires)) {
        $res['expire_time'] = $time_stamp+(24*3600*$_POST['expire_days']);
        $res['expire_days'] = $_POST['expire_days'];
    }else{
        $res['expire_days'] = 10;
        $res['expire_time'] = $time_stamp+(24*3600*$res['expire_days']);

    }
    $check_trade_update = $access->field("check_trade_update","membertype_id=".$ua_user['user_type']);
    if ($check_trade_update==0) {
        $res['status'] = 1;
        $message_info = lgg('action_complete');
    }else {
        $res['status'] = 0;
        $message_info = lgg('msg_wait_check');
    }
    if (!empty($_FILES['pic']['name'])) {
        include("../app/include/class.thumb.php");
        $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
        $attachment->out_file_name = $_SESSION['MemberID']."_".$tid."_".$time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./tip.php","./trade.php", lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb();
    	$attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $res['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
    }
    array_walk($res,"uatrim");
    $trade->setTradeCat($res['type_id']);
    $keyword_typeid = $trade->trade_type_sign_id;
    $res['ip_addr'] = uaGetClientIP();
    $offer_res = $_POST['offer'];
    $offer_res['oa'] = serialize($_POST['param']);
    $offer_res['industry_name'] = $industry->field("name", "id=".$industryid);
    $offer_res['company_name'] = $company_info['CompanyName'];
    $offer_res['user_name'] = $_SESSION['MemberName'];
    $offer_res['city_name'] = $_POST['offer']['city_name'];
    $offer_res['link_man'] = (isset($company_info['CompanyLinkMan']))?$company_info['CompanyLinkMan']:$tmp_personalinfo['MemberName'];
    $member_trade_condition = " and member_id=".$_SESSION['MemberID'];
    if (!empty($tid)) {
        $res['modified'] = $time_stamp;
        $res = $trade->save($res, "update", $tid, null, $member_trade_condition);
        $o_res = $offer->field("*", "trade_id=".$tid);
        if(!empty($o_res)){
            $offer->primaryKey = "trade_id";
            $offer->save($offer_res, "update", $tid, null);
        }else{
            $offer_res['trade_id'] = $tid;
            $offer->save($offer_res);
        }
    }else {
        $res['submit_time'] = $time_stamp;
        $res['member_id'] = $_SESSION['MemberID'];
        $res['company_id'] = $company_id;
        $res['created'] = $time_stamp;
        $res['modified'] = $time_stamp;
        $res = $trade->save($res);
        $new_id = $g_db->Insert_ID();
        $keyword->setKeywordId($_POST['keywords'], $new_id, 'trades');
        $g_db->Execute("update ".$tb_prefix."trades set keywords='".$keyword->getKeywordId()."' where id=".$new_id);
        if ($res) {
            uses("stat");
            $stat = new Stats();
            $stat->Add($trade->getTradeCat());
        }
        $last_trade_id = $trade->getMaxId();
        $offer_res['trade_id'] = $last_trade_id;
        $offer->save($offer_res);
        //update amount
        $industry->updateModelAmount($industryid, $trade->industry_amount_name);
    }
    if($res) {
        flash("./tip.php","trade.php",$message_info);
    }else{
        flash("./tip.php","trade.php",null,0);
    }
}
if (!empty($company_id)) {
    setvar("AreaName", $area->field("name", "code_id=".intval($company_info['AreaCode'])));
}else{
    setvar("AreaName", $area->field("name", "code_id=".intval($tmp_personalinfo['AreaCode'])));
}

setvar("TradeTypes",$trade->getTradeTypes());
setvar("PhoneTypes", $member->phone_types);
setvar("ImTypes", $member->im_types);
setvar("OfferExpires",$expires);
setvar("CompanyId", $company_id);
template($office_theme_name."/".$tpl_file);
?>
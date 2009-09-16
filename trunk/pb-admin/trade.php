<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(LIB_PATH .'time.class.php');
$position_path = array(array("name"=>"Offers","url"=>"./admin.php"));
setvar("CurrentPos",pb_format_current_position($position_path));
uses("trade","industry","company","member","area","offer","attachment");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$attachment = new Attachments();
$area = new Areas();
$offer = new Offers();
$member = new Members();
$company = new Companies();
$industry = new Industries();
$trade = new Trades();
$tplname = "trade_index";
$conditions = "1";
$ujoins = $j_field = null;
$colors = array(0=>"blue", 1=>"green", 2=>"red", 3=>"gray");
setvar("TradeTypes", $trade_names = $trade->getTradeTypes());
if (isset($_POST['refresh_x'])) {
	$ids = implode(",",$_POST['tradeid']);
	$result = $g_db->Execute($sql = "update ".$trade->getTable()." set expire_time=expire_days*86400+".$time_stamp.",submit_time=".$time_stamp." where id in (".$ids.")");
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}
if (isset($_POST['commend_x'])) {
	$ids = implode(",",$_POST['tradeid']);
	$result = $g_db->Execute($sql = "update ".$trade->getTable()." set if_commend=1 where id in (".$ids.")");
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}
if($_GET['action']=="stat"){
	$tplname = "stat";
	if($_GET['type']=="recall"){
		$xml_file = "../data/xml/ampie/ampie_data.xml";
		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>  \n<pie>  \n";
		$sql = "select type_id as TradeTypeId,count(type_id) as TypeAmount from ".$trade->getTable()." group by type_id";
		$result = $g_db->GetAll($sql);
		foreach($result as $val){
			$output.="<slice title=\"".$trade_names[$val['TradeTypeId']]."\"";
			if($val['TradeTypeId']==1) $output.=" pull_out=\"true\" color=\"#FCD202\"";
			$output.=">".$val['TypeAmount']."</slice>\n";
		}
		$output.= "</pie>";
		$fp = fopen($xml_file, "wb");
		if(function_exists("iconv")) $output = iconv("gb2312", "utf-8", $output);
		elseif(function_exists("mb_convert_encoding")) $output = mb_convert_encoding($output, "gb2312", "utf-8");
		if(!fwrite($fp, $output)){
			fclose($fp);
			die("File Write Error : ".$xml_file);
		}
		fclose($fp);
	}
}
if (isset($_POST['urgent_batch_x'])) {
	$ids = implode(",",$_POST['tradeid']);
	$result = $g_db->Execute("update ".$trade->getTable()." set if_urgent='1' where id in (".$ids.")");
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}
if(isset($_POST['del_x'])){
    foreach ($_POST['tradeid'] as $val) {
    	$picture = $trade->field("picture", "id=".$val);
    	@unlink($media_paths['attachment_dir']."big/".$picture);
    	@unlink($media_paths['attachment_dir']."small/".$picture);
    }
	$result = $trade->del($_POST['tradeid']);
	$offer->primaryKey = "trade_id";
	$offer->del(unserialize($trade->catchIds));
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}
if(isset($_POST['up_batch_x'])) {
	$result = $trade->check($_POST['tradeid'],1);
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}
if(isset($_POST['down_batch_x'])) {
	$result = $trade->check($_POST['tradeid'],0);
	if ($result) {
		flash("./alert.php", "trade.php");
	}else{
		flash("./alert.php","./trade.php",null,0);
	}
}

if(isset($_POST['save'])){
	$tid = (isset($_POST['id']))?$_POST['id']:null;
	$vals = array();
	$vals = $_POST['trade'];
	$offers = $_POST['offer'];
	if($_POST['submittime']){
		if($_POST['submittime']!="None") {
		    $vals['submit_time'] = Times::dateConvert($_POST['submittime']);
		}
		if($_POST['expiretime']!="None") {
		    $vals['expire_time'] = Times::dateConvert($_POST['expiretime']);
		}
	}
	if (!empty($_FILES['pic']['name'])) {
        include("../libraries/class.thumb.php");
        $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
        $attachment->out_file_name = $time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./alert.php","./trade.php?action=mod&id=".$tid, lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb();
        $attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}elseif(!empty($offers['picture_remote'])){
		$offers['picture_remote'] = trim($offers['picture_remote']);
	}
	//检查是否用户属于公司， 如果是， 则取得company_id后插入
	if (!empty($offers['user_name'])) {
		$user_type_res = intval($g_db->GetRow("select id as MemberId,user_type from ".$member->getTable()." where user_name='".trim($offers['user_name'])));
		if (($user_type_res['user_type']>2)) {
			$vals['company_id'] = $company->field("id", "member_id=".$user_type_res['MemberId']);
		}
	}
	array_walk($vals,"uatrim");
	if ($tid) {
		$r_up = $trade->save($vals, "update", $tid);
		$vals['modified'] = $time_stamp;
	}else {
		$vals['submit_time'] = (empty($vals['submit_time']))?time():$vals['submit_time'];
		$vals['expire_time'] = (empty($vals['expire_time']))?(time()+60*60*24*30):$vals['expire_time'];
		$vals['created'] = time();
		$r_up = $trade->save($vals);
	}
	if ($r_up) {
		flash("alert.php", "trade.php", null, 1, null, "trade.php");
	}else {
		flash("alert.php", "trade.php", null, 0, null, "trade.php");
	}
}
if ($_GET['action'] == "mod"){
	uses("membertype");
	$membertype = new Membertypes();
	$_mt1[] = array("OptionId"=>0, "OptionName"=>"All");
	$_mt2 = $membertype->findAll("id as OptionId, name as OptionName", "status=1");
	setvar("AllMembertypes", UaController::generateList(array_merge($_mt1,$_mt2)));
	if (!empty($_GET['id'])) {
			$fields = "Industry.name AS IndustryName,AreaProvince.name AS Province,AreaCity.name AS City,Trade.member_id,Trade.company_id,Member.username AS MemberName,Company.name AS CompanyName,Trade.if_urgent AS TradeIfUrgent,Trade.keywords AS Keywords,topic AS Topic,packing AS Package,price AS Price,quantity AS Quantity,spec AS Spec,sn AS SN,Trade.picture AS TradePicture,Trade.submit_time AS PublishDate,Trade.expire_time AS ExpireDate,Trade.clicked AS Click,Trade.content AS TradeDescription,Trade.product_id AS ProductID,Trade.type_id as TradeTypeId,Trade.require_point,Trade.require_membertype,Trade.require_freedate ";
			$sql = "select ".$fields." from ".$trade->getTable(true)." left join ".$company->getTable(true)." on Trade.company_id=Company.id left join ".$member->getTable(true)." on Trade.member_id=Member.id left join ".$area->getTable()." AreaProvince on Trade.province_id=AreaProvince.id left join ".$area->getTable()." AreaCity on Trade.city_id=AreaCity.id left join ".$industry->getTable(true)." on Trade.industry_id=Industry.id where Trade.id=".$_GET['id'];
			$res = $g_db->GetRow($sql);
			if (empty($res)) {

			}else{
				setvar("TradeInfo",$res);
			}
	}
	$tplname = "trade_edit";
}else{
	setvar("CheckStatus", explode(",",lgg('product_status')));
	if (isset($_POST['gopage']) && intval($_POST['topage'])) {
		$page = intval($_POST['topage']);
	}
	$conditions = "1";
	$j_set = false;
	if (isset($_POST['search'])) {

		if (isset($_POST['keywords'])) {
			$conditions.= " and Trade.topic like '%".trim($_POST['keywords'])."%'";
		}
		if ($_POST['companystatus']!="-1") {
			$conditions.= " and Trade.status='".$_POST['companystatus']."'";
		}
		if ($_POST['PubFromDate']!="None" && $_POST['PubToDate']!="None") {
			$conditions.= " and Trade.created between ";
			$conditions.= Times::dateConvert($_POST['PubFromDate']);
			$conditions.= " and ";
			$conditions.= Times::dateConvert($_POST['PubToDate']);
		}
		if ($_POST['ExpFromDate']!="None" && $_POST['ExpToDate']!="None") {
			$conditions.= " and Trade.expire_time between ";
			$conditions.= Times::dateConvert($_POST['ExpFromDate']);
			$conditions.= " and ";
			$conditions.= Times::dateConvert($_POST['ExpToDate']);
		}
		if(!empty($_POST['companyname'])) {
			$j_set = true;
			$j_field = ",Company.name AS CompanyName,Company.id AS CompanyID";
			$ujoins.=" left join ".$company->getTable(true)." on Company.id=Trade.company_id";
			$conditions.= " and Company.name like '%".trim($_POST['companyname'])."%'";
		}
		if($_POST['search_by']){
			if($_POST['search_by']==1){
				$j_set = true;
				$j_field = ",Company.name AS CompanyName,Company.id AS CompanyID";
			}
		}
		if($_POST['province_id']) $conditions.= " and Trade.province_id=".$_POST['province_id'];
		if($_POST['industry_id']) $conditions.= " and Trade.industry_id=".$_POST['industry_id'];
	}
	if(isset($_GET['search'])){
		if(isset($_GET['ip'])){
			$conditions.=" and Trade.ip_addr='".$_GET['ip']."'";
		}
	}
	$amount = $trade->findCount($conditions,"Trade.id", null, $ujoins);
	pageft($amount,$display_eve_page);
	$fields = "Trade.member_id as TradeMemberId,Trade.company_id,Trade.type_id AS OfferType,Trade.status AS TradeStatus,Trade.id AS TradeID,Trade.topic AS Topic,Trade.clicked AS Click,Trade.if_urgent as IfUrgent,Trade.submit_time AS PublishDate,Trade.expire_time AS ExpireDate,Trade.picture as TradePicture,require_point,require_membertype,ip_addr as IP,Trade.if_commend".$j_field;
	if($j_set){
	$joins = array(
		"Company"=>array("fullTableName"=>$company->getTable(true),"foreignKey"=>"company_id","fields"=>"Company.name AS CompanyName")
		);
	}
	$joins['Member'] = array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username AS MemberName");
	$all_trades = $trade->findAll($fields,$conditions,"Trade.id DESC",$firstcount,$displaypg);
	setvar("CompanyStatus",explode(",",lgg('product_status')));
	for($i=0; $i<count($all_trades); $i++) {
		if (!empty($all_trades[$i]['company_id'])) {
            $all_trades[$i]['CompanyName'] = $company->field("name", "id=".$all_trades[$i]['company_id']);
		}
	}
	setvar("TradeList",$all_trades);
	uaAssign(array("PageHeader"=>$page_header,"Amount"=>$amount,"ByPages"=>$pagenav));
}
setvar("Bg", $colors);
setvar("token", md5(AUTH_KEY));
setvar("ShowIndex", explode(",",lgg('yes_no')));
setvar("TradeNames", $trade->getTradeTypeNames());
setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
template($tplname);
?>
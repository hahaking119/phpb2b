<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
header("Content-Type: text/html; charset=".$charset);
require("session_cp.inc.php");
uses("product", "htmlcache");
$htmlcache = new Htmlcaches();
$product = new Products();
$conditions = null;
$tpl_file = "mkstatic";
$token = md5(AUTH_KEY);
if(isset($_GET['action'])){
	if($_GET['action'] == "clearcompile"){
		$result = $smarty->clear_compiled_tpl();
		if($result){
			flash("alert.php","mkstatic.php", lgg('compile_file_clear'), 1);
		}else{
			flash("alert.php","mkstatic.php", lgg('system_error'), 0);
		}
	}
	if($_GET['action'] == "clearhtmlcache"){
		$result = $g_db->Execute("truncate TABLE `{$tb_prefix}htmlcaches`");
		if($result){
			flash("alert.php","mkstatic.php",lgg('static_file_clear'),1);
		}else{
			flash("alert.php","mkstatic.php",lgg('system_error'),0);
		}
	}
    $fields =  "h_n as Name, h_l, h_r as Reset";
    $result  = $htmlcache->findAll($fields, null);
    for($i=0; $i<count($result); $i++){
        $tmp_time = $result[$i]['h_l']+$result[$i]['Reset'];
        $result[$i]['NextCreateTime'] = date("Y-m-d H:i:s", $tmp_time);
    }

    setvar("Htmlfiles", $result);
}
$smarty->register_function("format_keywords","pb_split_words");
if (isset($_POST['create'])) {
    //
	if (STATIC_HTML_LEVEL<=0) {
		flash("alert.php","mkstatic.php", lgg("change_static_file_first"),0);
		//die("请先打开静态文件设置,把 app/configs/core.php中的 STATIC_HTML_LEVEL 的值(原来为0) 改为1或2");
	}
	$media_paths = $smarty->getAbsolutePath();
	uaAssign($media_paths);
	$userpage->setUrlContainer(2);
	setvar("UrlContainer", $userpage->getUrlContainer());
	if($_POST['type']==1){
		uses("trade", "offer", "member");
		$trade = new Trades();
		$member = new Members();
		$offer = new Offers();
		$sql = "SELECT id FROM ".$trade->getTable(true)." limit 0,5000";
		$result = $g_db->GetArray($sql);
		foreach ($result as $key=>$val) {
		    setvar("ObjectParams", $trade->params);
		    setvar("Genders", $member->genders);
		    setvar("PhoneTypes", $member->phone_types);
		    $fields = "Offer.oa as TradeExtends,Offer.user_name as OfferUserName,Offer.company_name as CompanyName,Offer.province_name,Offer.industry_name as IndustryName, Offer.country_name,Offer.city_name,Offer.link_man as CompanyLinkMan,Offer.gender as OfferGender,Offer.prim_telnumber as CompTel,Offer.prim_tel as TelType,Trade.id AS TID,Trade.industry_id as IndustryId,Trade.id AS TradeId,topic AS Name,content AS Description,company_id AS CompanyID,Trade.member_id as MemberId,Trade.picture AS TradePicture,Trade.status AS TradeStatus,Trade.type_id AS trade_type,Trade.submit_time AS PublishDate,expire_time AS ExpireDate,require_membertype,require_point";
		    $sql = "select ".$fields." from ".$offer->getTable(true)." right join ".$trade->getTable(true)." on  Offer.trade_id=Trade.id where Trade.id=".$val['id'];
		    $res = $g_db->GetRow($sql);
		    $member_id = $res['MemberId'];
		    //$trade->checkAccess(serialize($res));
		    //$trade->clicked($pid);
		    require($inc_path."product/fineproducts.php");
		    //setvar("IfTradeOpen", intval($setting->field("valued","aa='buy_logincheck'")));
		    $res['TradeExtends'] = unserialize($res['TradeExtends']);
		    //$res['Description'] = preg_replace("/(\r?\n)\\1+/","\\1",$res['Description']);
		    setvar("tradeInfo",$res);
		    setvar("Li",$li);
		    //setvar("tradeInfo", $result[$key]);
		    if(empty($res['PublishDate'])) $file_path = 'htmls/offer/'.date("Y")."/".date("m")."/".date("d")."/";
		    else {
		        $tmp_date = $res['PublishDate'];
		        $file_path = "htmls/offer/".date("Y", $tmp_date)."/".date("m", $tmp_date)."/".date("d", $tmp_date)."/";
		    }
		    $html_file_name = $val['id'].'.html';
		    if(!file_exists($inc_path.$file_path)){
		        if(PHP_VERSION<5){
		            pb_create_folder($inc_path.$file_path,0666);
		        }else{
		            mkdir($inc_path.$file_path,0666,true);
		        }
		    }
		    $_GET['token'] = $token;
		    $smarty->MakeHtmlFile($inc_path.$file_path.$html_file_name,$smarty->fetch($theme_name."/trade_content.html"));
		    $g_db->Execute("update ".$trade->getTable()." set html_file_id='".$file_path.$html_file_name."' where id=".$val['id']);
		}
		flash("alert.php","mkstatic.php");
	}elseif ($_POST['type']==4){
	    //Product.
	    uses("member", "industry", "area", "company");
	    $member = new Members();
	    $company = new Companies();
	    $area = new Areas();
	    $industry = new Industries();
	    $fields = $product->industry_cols.",Product.status as ProductStatus,company_id";
	    $table['product'] = $product->getTable();
	    $table['area']	= $area->getTable();
	    $table['industry'] = $industry->getTable();
	    $sql = "select id from ".$product->getTable()." limit 0,5000";
	    $result = $g_db->GetArray($sql);
	    $fields = $product->industry_cols.",Product.status as ProductStatus,company_id";
	    $file_path = "htmls/product/".date("Y")."/".date("m")."/".date("d")."/";
	    $_GET['token'] = $token;
	    foreach ($result as $key=>$val) {
	        $res = $g_db->GetRow("select ".$fields." ,Member.username as MemberUsername from ".$product->getTable(true)." left join ".$table['industry']." as Industry on Product.industry_id=Industry.id left join ".$member->getTable(true)." on Product.member_id=Member.id  where Product.state=1 and Product.id=".$val['id']);
	        $html_file_name = $val['id'].'.html';
	        if(!file_exists($inc_path.$file_path)){
	            if(PHP_VERSION<5){
	                pb_create_folder($inc_path.$file_path,0666);
	            }else{
	                mkdir($inc_path.$file_path,0666,true);
	            }
	        }
	        $member_id = $res['MemberId'];
	        $sql = "SELECT Company.id AS CompanyId,Company.name AS CompanyName,Company.link_man AS CompanyLinkMan,CONCAT(telcode,'-',telzone,'-',tel) AS CompanyTel,AreaProvince.name as AreaProvinceName,AreaCity.name as AreaCityName FROM ".$company->getTable(true)." left join ".$table['area']." as AreaProvince on Company.province_code_id=AreaProvince.code_id left join ".$table['area']." as AreaCity on Company.city_code_id=AreaCity.code_id WHERE Company.id=".$res['company_id'];
	        $company_res = $g_db->GetRow($sql);
	        $trade_info['CompanyID'] = $company_res['CompanyId'];
	        $trade_info['CompanyName'] = $company_res['CompanyName'];
	        $trade_info['CompanyLinkMan'] = $company_res['CompanyLinkMan'];
            $trade_info['CompTel'] = $company_res['CompanyTel'];
            $trade_info['AreaZone'] = $company_res['AreaProvinceName'].$company_res['AreaCityName'];
            $trade_info['OfferUserName'] = $res['MemberUsername'];
            setvar("tradeInfo",$trade_info);
            require($inc_path."product/fineproducts.php");
            setvar("prodInfo",$res);
	        $smarty->MakeHtmlFile($inc_path.$file_path.$html_file_name,$smarty->fetch($theme_name."/product_content.html"));
	        $g_db->Execute("update ".$product->getTable()." set html_file_id='".$file_path.$html_file_name."' where id=".$val['id']);
	    }
	    flash("alert.php","mkstatic.php");
	}
}

if ($_GET['action']=="single") {
	switch ($_GET['id']) {
		case "index":
			$mk_file = "index";
			break;
		default:
			break;
	}

	$file_path = '..'.DS.'htmls'.DS;
}
setvar("TOKEN", $token);
template($tpl_file);
?>
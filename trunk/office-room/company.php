<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: company.php 564 2009-12-28 11:21:31Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
require(LIB_PATH .'time.class.php');
require(LIB_PATH .'typemodel.inc.php');
check_permission("company");
uses("industry","company","area", "attachment");
$attachment = new Attachment('pic');
$area = new Areas();
$industry = new Industries();
$company = new Companies();
$tpl_file = "company";
if (isset($_POST['do']) && !empty($_POST['data']['company'])) {
	pb_submit_check('data');
	$vals = $_POST['data']['company'];
	if (isset($companyinfo)) {
		if (empty($companyinfo)) {
			//convert space_name
			require(LIB_PATH. "chinese.inc.php");
			$py = new utf8pinyin();
			$space_name = $py->str2py($_POST['data']['company']['name'], true, false);
			$vals['cache_spacename'] = $space_name;
			$vals['first_letter'] = $py->first_letter;
			$member->updateSpaceName(array("id"=>$_SESSION['MemberID']), $space_name);
			if(isset($companyinfo['status']) && $companyinfo['status']==0){
				$vals['name'] = strip_tags($_POST['data']['company']['name']);
				$vals['english_name'] = strip_tags($vals['english_name']);
			}
		}
	}
	$vals['employee_amount'] = $vals['employee_amount'];
	if(!empty($vals['found_date'])) {
		$vals['found_date'] = Times::dateConvert($vals['found_date']);
	}
	if(!empty($_POST['manage_type']))
	{
		$managetype = implode(",",$vals['manage_type']);
		$vals['manage_type'] = $managetype;
	}
	$vals['property'] = $vals['property'];
	$vals['main_prod'] = strip_tags($vals['main_prod']);
	$vals['address'] = strip_tags($vals['address']);
	$vals['description'] = strip_tags(trim($vals['description']));
	$vals['boss_name'] = $vals['boss_name'];
	$vals['reg_address'] = $vals['reg_address'];
	$vals['reg_fund'] = $vals['reg_fund'];
	$vals['bank_from'] = $vals['bank_from'];
	$vals['bank_account'] = $vals['bank_account'];
	$vals['main_brand'] = $vals['main_brand'];
	$vals['year_annual'] = $vals['year_annual'];
	$vals['main_customer'] = $vals['main_customer'];
	$vals['main_biz_place'] = $vals['main_biz_place'];
	$vals['link_man'] = $vals['link_man'];
	$vals['position'] = $vals['position'];
	$vals['telcode'] = $vals['telcode'];
	$vals['telzone'] = $vals['telzone'];
	$vals['tel'] = $vals['tel'];
	$vals['faxcode'] = $vals['faxcode'];
	$vals['faxzone'] = $vals['faxzone'];
	$vals['fax'] = $vals['fax'];
	$vals['mobile'] = $vals['mobile'];
	$vals['site_url'] = $vals['site_url'];
	$vals['email'] = $vals['email'];
	if(!empty($vals['main_market'])) {
		$mainmarket = implode(",",$vals['main_market']);
		$vals['main_market'] = $mainmarket;
	}
	if (!empty($_FILES['pic']['name'])) {
		$attachment->if_watermark = false;
		$attachment->if_thumb_middle = false;
		$attachment->rename_file = "company-".$time_stamp;
		$attachment->upload_process();
		$vals['picture'] = $attachment->file_full_url;
	}
	if ($g['company_check']) {
		$vals['status'] = 0;
		$msg = "wait_for_check";
	}
	if(!empty($company_id)){
		$vals['modified'] = $time_stamp;
		$vals['cache_membergroupid'] = $memberinfo['membergroup_id'];
		$company->save($vals, "update", $company_id, null, "member_id=".$_SESSION['MemberID']);
		$company->updateCachename($company_id, $vals['name']);
	} else {
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['cache_membergroupid'] = $memberinfo['membergroup_id'];
		$vals['created'] = $vals['modified'] = $time_stamp;
		$member->updateSpaceName($memberinfo['id'], $vals['english_name']);
		$company->save($vals);
	}
	flash($msg?$msg:"success");
}
setvar("MainMarkets", get_cache_type("main_market"));
if(!empty($companyinfo)){
	$companyinfo["option_manage_type"] = get_cache_key_unique("manage_type", $companyinfo['manage_type']);
	$selected['markets'] = explode(",",$companyinfo['main_market']);
	setvar("SelectedMarket",$selected['markets']);
	$companyinfo["option_reg_fund"] = get_cache_key_unique("reg_fund", $companyinfo['reg_fund']);
	$companyinfo["option_year_annual"] = get_cache_key_unique("year_annual", $companyinfo['year_annual']);
	$companyinfo["option_position"] = get_cache_key_unique("position", $companyinfo['position']);
	$companyinfo["option_employee_amount"] = get_cache_key_unique("employee_amount", $companyinfo['employee_amount']);
	$companyinfo["option_economic_type"] = get_cache_key_unique("economic_type", $companyinfo['property']);
	if(!empty($companyinfo["picture"])) $companyinfo["logo"] = pb_get_attachmenturl($companyinfo["picture"], "../");
	setvar("item",$companyinfo);
	unset($selected,$companyinfo);
}
template($tpl_file);
?>
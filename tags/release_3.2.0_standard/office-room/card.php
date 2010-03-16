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
 * @version $Id: card.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("industry");
$industry = new Industries();
$tpl_file = "card";
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_POST['save'])) {
	pb_submit_check("company");
	$vals = array();
	$vals['link_man'] = $_POST['company']['link_man'];
	$vals['tel'] = $company->getPhone($_POST['data']['telcode'],$_POST['data']['telzone'],$_POST['data']['tel']);
	$vals['fax'] = $company->getPhone($_POST['data']['faxcode'],$_POST['data']['faxzone'],$_POST['data']['fax']);
	$vals['name'] = strip_tags($_POST['company']['name']);
	$vals['mobile'] = strip_tags($_POST['company']['mobile']);
	$vals['email'] = $_POST['company']['email'];
	$company->primaryKey = "id";
	$result = $company->save($vals, "update", $companyinfo['id']);
	if($result){
		flash("success");
	}else{
		flash("action_failed");
	}
}
if(!empty($companyinfo)){
	list(,$companyinfo['telcode'], $companyinfo['telzone'], $companyinfo['tel']) = $company->splitPhone($companyinfo['tel']);
	list(,$companyinfo['faxcode'], $companyinfo['faxzone'], $companyinfo['fax']) = $company->splitPhone($companyinfo['fax']);
}
setvar("item",$companyinfo);
template($tpl_file);
?>
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
 * @version $Id: common.inc.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
require(PHPB2B_ROOT.'languages/'.$app_lang.'/'.'template.site.inc.php');
require(CACHE_PATH. 'cache_membergroup.php');
uses("templet","member","company","membertype","space");
$member = new Members();
$space = new Space();
$membertype= new Membertypes();
$company = new Companies();
$templet = new Templets();
if (!empty($userid)) {
	$member->setInfoBySpaceName($userid);
	if(!empty($member->info['id'])) {
		$company->setInfoByMemberId($member->info['id']);
	}
}elseif(!empty($_GET['id'])) {
	$company->setId($_GET['id']);
	if (!empty($company->info['member_id'])) {
		$member->setId($company->info['member_id']);
	}
}
if (empty($company->info) || !$company->info) {
	$smarty->flash('data_not_exists', null, 0);
}elseif ($company->info['status']!=1) {
    $smarty->flash('company_checking', null, 0);
}
$product_types = $pdb->GetArray("SELECT id as typeid,name as typename,created,level FROM {$tb_prefix}producttypes WHERE company_id=".$company->info['id']);
setvar("ProductTypes",$product_types);
if (empty($company->info['email'])) {
	$company->info['email'] = $_PB_CACHE['setting']['service_email'];
}
if (empty($company->info['picture'])) {
	$company->info['logo'] = URL."images/nopic.large.gif";
}else{
	$company->info['logo'] = URL.$attachment_url.$company->info['picture'];
}
$company->info['fulltel'] = $company->info['telcode']."-".$company->info['telzone']."-".$company->info['tel'];
$company->info['fullfax'] = $company->info['faxcode']."-".$company->info['faxzone']."-".$company->info['fax'];
$company->info['description'] = nl2br(strip_tags($company->info['description']));
$skin_path_info = $pdb->GetRow("SELECT name,directory FROM {$tb_prefix}templets WHERE type='user' AND status='1' AND id=".$member->info['templet_id']);
if (empty($skin_path_info)) {
	$skin_path_info = $pdb->GetRow("SELECT name,directory FROM {$tb_prefix}templets WHERE type='user' AND status='1' AND is_default='1'");
}
list($skin_path, $skin_dir) = $skin_path_info;
uaAssign(array(
"SKIN_URL"=>$skin_dir,
"COMPANY"=>$company->info,
"MEMBER"=>$member->info,
));
$smarty->template_dir = PHPB2B_ROOT ."skins".DS.$skin_path.DS;
$smarty->setCompileDir("space".DS.$skin_path.DS);
$space->setLinks($member->info['id']);
$space->setMenu($member->info['space_name'], $space_actions);
setvar("GroupName", $_PB_CACHE['membergroup'][$member->info['membergroup_id']]['name']);
setvar("GroupImage", URL."images/group/".$_PB_CACHE['membergroup'][$member->info['membergroup_id']]['avatar']);
setvar("Menus", $space->getMenu());
setvar("Links", $space->getLinks());
setvar("BASEMAP", URL.$skin_dir);
formhash();
?>
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
 * @version $Id: intro.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
require(LIB_PATH. "typemodel.inc.php");
$manage_types = $main_markets = null;
if (!empty($company->info['main_market'])) {
	$main_market = get_cache_type("main_market");
	foreach (explode(",",$company->info['main_market']) as $market) {
		$main_markets .= $main_market[$market]."&nbsp;&nbsp;";
	}
}
if (!empty($company->info['manage_type'])) {
	$manage_type = get_cache_type("manage_type");
	foreach (explode(",",$company->info['manage_type']) as $m_type) {
		$manage_types .= $manage_type[$m_type]."&nbsp;&nbsp;";
	}
}
$company->info['found_year'] = (!empty($company->info['found_date']))?(date("Y", $company->info['found_date'])):'';
$company->info['manage_type'] = $manage_types;
$company->info['main_market'] = $main_markets;
$company->info['ecnomy'] = get_cache_type("economic_type", $company->info['property']);
$company->info['reg_fund'] = get_cache_type("reg_fund", $company->info['reg_fund']);
$company->info['year_annual'] = get_cache_type("year_annual", $company->info['year_annual']);
setvar("COMPANY", $company->info);
$space->render("intro");
?>
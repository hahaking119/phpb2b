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
 * @version $Id: style.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("templet");
check_permission("space");
$templet = new Templets();
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_POST['updateSpaceName']) && !empty($_POST['data']['space_name'])) {
	$space_name = trim($_POST['data']['space_name']);
	if ($templet->isChinese($space_name)) {
		require(LIB_PATH. "wordsconvert.class.php");
		$wd = new WordsConvert($space_name);
		$space_name = $wd->convert(null);
	}
	$result = $member->updateSpaceName(array("id"=>$_SESSION['MemberID']), $space_name);
	if ($result) {
		flash("success");
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['member']['styleid'])) {
	$templet_id = intval($_POST['data']['member']['styleid']);
	$pdb->Execute("UPDATE {$tb_prefix}members SET templet_id=".$templet_id." WHERE id=".$_SESSION['MemberID']);
	flash("success");
}
setvar("templet_id", $memberinfo['templet_id']);
$result = $templet->getInstalled();
setvar("Items", $result);
template("style");
?>
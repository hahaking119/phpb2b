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
 * @version $Id: add.php 433 2009-12-26 13:47:01Z cht117 $
 */
define('CURSCRIPT', 'add');
require("../libraries/common.inc.php");
uses("market");
$market = new Markets();
if (isset($_POST['do']) && !empty($_POST['data']['market']['name'])) {
	pb_submit_check("data");
	$market->setParams();
	$result = $market->Add();
	if ($result) {
		flash('thanks_for_adding_market');
	}else {
		pheader("location:add.php");
	}
}
formhash();
render("market.add");
?>
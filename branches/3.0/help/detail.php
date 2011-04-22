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
 * @version $Id: detail.php 443 2009-12-26 13:49:49Z cht117 $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("common.inc.php");
$tpl_file = "help.detail";
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$help_result = $pdb->GetRow("SELECT * FROM {$tb_prefix}helps WHERE id='".$id."'");
	if (!empty($help_result)) {
		setvar("item", $help_result);
	}
}
render($tpl_file);
?>
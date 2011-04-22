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
 * @version $Id: index.php 444 2009-12-26 13:50:16Z cht117 $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
uses("expo");
$fair = new Expoes();
require(CACHE_PATH."cache_area.php");
require(CACHE_PATH."cache_expotype.php");
setvar("today_timestamp", mktime(0,0,0,date("m") ,date("d"),date("Y")));
setvar("Expotypes", $_PB_CACHE['expotype']);
setvar("Area", $_PB_CACHE['area']);
render("fair.index");
?>
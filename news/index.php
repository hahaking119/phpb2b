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
 * @version $Id: index.php 458 2009-12-27 03:05:45Z steven $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("../share.inc.php");
require(LIB_PATH .'time.class.php');
require(CACHE_PATH. "cache_newstype.php");
uses("news","newstype");
$news = new Newses();
$newstype = new Newstypes();
require(CACHE_PATH. "cache_newstype.php");
setvar("Newstypes", $_PB_CACHE['newstype']);
render("news.index");
?>
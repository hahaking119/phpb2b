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
 * @version $Id: space.php 415 2009-12-26 13:30:30Z steven $
 */
define('CURSCRIPT', 'space');
require("libraries/common.inc.php");
$do = null;
$space_actions = array(
"intro", 
"home", 
"product", 
"offer", 
"hr", 
"news", 
"album", 
"index", 
"contact", 
"feedback"
);
$userid = 0;
if(isset($_GET['userid'])) {
	$userid = $_GET['userid'];
}
if ($subdomain_support) {
	$hosts = explode($subdomain_support, pb_getenv('HTTP_HOST'));
	if(($hosts[0]!="www")){
	    $userid = trim($hosts[0]);
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if($do=="" || $do=="index" || !in_array($do, $space_actions)) {
    	$do = "home";
	}
}else{
	$do = "home";
}
require("space/common.inc.php");
require("space/".$do.".php");
?>

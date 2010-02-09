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
 * @version $Id: company_controller.php 426 2009-12-26 13:44:16Z cht117 $
 */
class Company extends PbController {
	var $name = "Company";
	
	function rewrite($userid, $id = 0, $name = null)
	{
		global $subdomain_support, $topleveldomain_support, $rewrite_able;
		$userid = rawurlencode($userid);
		$url = ($rewrite_able)? URL."space/".$userid."/":URL."space.php?userid=".$userid;
		if($subdomain_support){
			$url = "http://".$userid.$subdomain_support."/";
		}
		return $url;
	}
}
?>
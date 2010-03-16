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
 * @version $Id: market_controller.php 426 2009-12-26 13:44:16Z cht117 $
 */
class Market extends PbController {
	var $name = "Market";

	function rewrite($id, $name = null)
	{
		$url = null;
		global $rewrite_able, $rewrite_compatible;
		if ($rewrite_able) {
			if ($rewrite_compatible && !empty($name)) {
				$url = "market/".rawurlencode($name)."/";
			}else{
				$url = "market/detail/".$id.".html";
			}
		}else{
			$url = "market/detail.php?id=".$id;
		}
		return $url;
	}
}
?>
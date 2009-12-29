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
 * @version $Id$
 */
class Markets extends PbModel {
 	var $name = "Market";

 	function Markets()
 	{
 		parent::__construct();
 	}
 	
 	function Add()
 	{
 		global $_PB_CACHE;
 		if (isset($this->params['data']['market']['name'])) {
 			$this->params['data']['market']['created'] = $this->params['data']['market']['modified'] = $this->timestamp;
 			$this->params['data']['market']['ip_address'] = pb_get_client_ip('str');
 			$this->params['data']['market']['status'] = 0;
 			return $this->save($this->params['data']['market']);
 		}
 		return false;
 	}
}
?>
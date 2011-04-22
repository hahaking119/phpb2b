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
class Logs extends PbModel {
 	var $name = "Log";

 	function Logs()
 	{
		parent::__construct();
 	}
 	
 	function Add($data)
 	{
 		return $this->dbstuff->Execute("INSERT INTO {$this->table_prefix}logs (handle_type,source_module,description,ip_address,created) VALUE ('".$data['handle_type']."','".$data['source_module']."','".$data['description']."','".pb_get_client_ip()."','".$this->timestamp."')");
 	}
}
?>
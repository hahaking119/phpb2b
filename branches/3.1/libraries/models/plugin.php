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
class Plugins extends PbModel {
 	var $name = "Plugin";

 	function Plugins()
 	{
 		parent::__construct();
 	}

	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Plugins();
		}
		return $instance[0];
	}
	
	function getInstalled(){
		$installed = array();
		$sql = "SELECT * FROM {$this->table_prefix}plugins GROUP BY name ORDER BY id DESC";
		$result = $this->dbstuff->GetArray($sql);
		if (!empty($result)) {
			$count = count($result);
			for($i=0; $i<$count; $i++){
				$result[$i]['available'] = 1;
			}
		}
		return $result;
	}	
}
?>
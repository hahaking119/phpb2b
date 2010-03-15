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
class Navs extends PbModel {
 	var $name = "Nav";

 	function Navs()
 	{
 		parent::__construct();
 	}
 	
 	function getNavs()
 	{
 		$sql = "SELECT id,name,description,url,target,display_order,highlight FROM {$this->table_prefix}navs WHERE status=1";
 		$result = $this->dbstuff->GetArray($sql);
 		if (!empty($result)) {
 			for ($i=0; $i<count($result); $i++) {
 				$result[$i]['style'] = parse_highlight($result[$i]['highlight']);
 			}
 		}
 		return $result;
 	}
}
?>
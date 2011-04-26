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
class Dicts extends PbModel {
 	
 	var $name = "Dicts";
 	var $info;

 	function Dicts()
 	{
 		parent::__construct();
 	}
 	
 	function getInfo($id, $name = null)
 	{
 		if (!empty($name)) {
 			$result = $this->dbstuff->GetRow("SELECT d.*,dp.name as typename FROM {$this->table_prefix}dicts d LEFT JOIN {$this->table_prefix}dicttypes dp ON d.dicttype_id=dp.id WHERE d.word='".$name."'");
 		}elseif(!empty($id)){
 			$result = $this->dbstuff->GetRow("SELECT d.*,dp.name as typename FROM {$this->table_prefix}dicts d LEFT JOIN {$this->table_prefix}dicttypes dp ON d.dicttype_id=dp.id WHERE d.id='".$id."'");
 		}else{
 			return false;
 		}
 		return $result;
 	}
}
?>
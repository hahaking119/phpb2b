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
class Expoes extends PbModel {
 	var $name = "Expo";
 	var $info;

 	function Expoes()
 	{
 		parent::__construct();
 	}
 	
 	function checkExist($id, $extra = false)
 	{
 		$id = intval($id);
 		$info = $this->dbstuff->GetRow("SELECT * FROM {$this->table_prefix}expoes WHERE id={$id}");
 		if (empty($info) or !$info) {
 			return false;
 		}else{
 			if ($extra) {
 				$info['begin_date'] = @date("Y-m-d", $info['begin_time']);
 				$info['end_date'] = @date("Y-m-d", $info['end_time']);
 				$this->info = $info;
 			}
 			return true;
 		}
 	}
}
?>
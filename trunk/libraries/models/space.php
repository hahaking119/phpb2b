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
class Spaces extends PbModel {
 	var $name = "Space";

 	function Spaces()
 	{
 		parent::__construct();
 	}
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Spaces();
		}
		return $instance[0];
	}
	
	function getSpaceLinks($member_id, $company_id = 0)
	{
		$result = array();
		$condition = null;
		if (!empty($company_id)) {
			$condition = "AND company_id='{$company_id}'";
		}
		$sql = "SELECT id,title,url,is_outlink,description,logo,highlight FROM {$this->table_prefix}spacelinks s WHERE member_id={$member_id} {$condition} ORDER BY s.display_order ASC";
		$result = $this->dbstuff->GetArray($sql);
		if (empty($result)) {
			return false;
		}else{
			for($i=0; $i<count($result); $i++){
				if (!$result[$i]['is_outlink']) {
					$result[$i]['url'] = URL.$result[$i]['url'];
				}
			}
		}
		return $result;
	}
}
?>
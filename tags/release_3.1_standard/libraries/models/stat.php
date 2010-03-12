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
class Stats extends PbModel {
 	var $name = "Stat";

 	function Stats()
 	{
		parent::__construct();
 	}

 	function Add($stat_name)
 	{
        $sql = "update {$this->table_prefix}stats set sc=sc+1 where sb='$stat_name'";
        $result = $this->dbstuff->Execute($sql);
 	}
}
?>
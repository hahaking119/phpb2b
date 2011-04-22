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
class Announcements extends PbModel {
 	var $name = "Announcement";
 	function Announcements()
 	{
		parent::__construct();
 	}
 	
 	function updateCache()
 	{
 		$return = array();
 		$op = null;
 		$op = "<?php\n";
 		$op.="return ";
 		$result = $this->findAll("*", null, null, "display_order ASC,id DESC");
 		if (!empty($result)) {
 			for($i=0; $i<count($result); $i++){
 				$return[$i]['id'] = $result[$i]['id'];
 				$return[$i]['title'] = $result[$i]['subject'];
 				$return[$i]['pubdate'] = @date("Y-m-d", $result[$i]['created']);
 			}
 			$op.= var_export($return, true);
 		}
 		$op.="\n?>";
 		file_put_contents(CACHE_PATH. "announce.php", $op);
 		return true;
 	}
}
?>
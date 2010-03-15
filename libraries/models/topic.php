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
class Topics extends PbModel {
 	var $name = "Topic";

 	function Topics()
 	{
 		parent::__construct();
 	}
 	
 	function addNews($topic_id, $data)
 	{
 		if (!empty($data)) {
	 		$news_ids = explode("\r\n", $data);
			if (!empty($news_ids)) {
				$tmp_str = array();
				foreach ($news_ids as $news_val) {
					if(!empty($news_val)) $tmp_str[] = "(".$topic_id.",".$news_val.")";
				}
				$in_str = implode(",", $tmp_str);
				return $this->dbstuff->Execute("REPLACE INTO {$this->table_prefix}topicnews VALUES {$in_str}");
			}else{
				return false;
			}
 		}else{
 			return false;
 		}
 	}
}
?>
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
 * @version $Id: space_controller.php 481 2009-12-28 01:05:06Z steven $
 */
class Space extends PbController {
	var $name = "Space";
	var $menu = null;
	var $links;
	var $member_id;
	var $company_id;
	
	function Space()
	{
		
	}
	
	function setLinks($memberid, $companyid = 0)
	{
		$_this =& Spaces::getInstance();
		$this->links = $_this->getSpaceLinks($memberid, $companyid = 0);
	}
	
	function getLinks()
	{
		return $this->links;
	}

	function setMenu($user_id, $space_actions){
		global $subdomain_support, $rewrite_able;
		$tmp_menus = array();
		if($subdomain_support){
			foreach ($space_actions as $key=>$val) {
				if($val=="index" || $val=="home"){
					$tmp_menus[$val] = "http://".$user_id.$subdomain_support."/";
				}else{
					$tmp_menus[$val] = "http://".$user_id.$subdomain_support."/".$val."/";
				}
			}
		}elseif($rewrite_able){
			foreach ($space_actions as $key=>$val) {
				if($val=="index" || $val=="home"){
					$tmp_menus[$val] = URL.$user_id."/";
				}else{
					$tmp_menus[$val] = URL.$user_id."/".$val."/";
				}
			}
		}else{
			foreach ($space_actions as $key=>$val) {
				$tmp_menus[$val] = URL."space.php?do=".$val."&userid=".$user_id;
			}
		}
		$this->menu = $tmp_menus;
	}

	function getMenu(){
		return $this->menu;
	}
	
	function render($tpl_file, $ext = ".html")
	{
		global $smarty;
		if(!file_exists($smarty->template_dir.$tpl_file.$ext)){
			$smarty->template_dir = PHPB2B_ROOT ."skins".DS."default".DS;
		}
		$smarty->display("{$tpl_file}{$ext}");
	}
}
?>
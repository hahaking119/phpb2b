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
class Adses extends PbModel {
 	var $name = "Ads";

 	function Ads()
 	{
		parent::__construct();
 	}
 	
 	function getCode($adv_params, $max_width, $max_height)
 	{
 		if ($adv_params['is_image']) {
 			return $this->getImageCode($adv_params, $max_width, $max_height);
 		}elseif ($adv_params['source_type']=="application/x-shockwave-flash"){
 			return $this->getFlashCode($adv_params, $max_width, $max_height);
 		}else{
 			return;
 		}
 	}
 	
 	function ife($condition, $val1 = null, $val2 = null) {
		if (!empty($condition)) {
			return $val1;
		}
		return $val2;
	}
 	
 	function getImageCode($adv_params, $max_width, $max_height)
 	{
 		$return = "<img border='0' ";
 		extract($adv_params); 		
 		if (empty($source_url)) {
 			return;
 		}
 		$return .= "src='{$source_url}' ";
 		if (!empty($width)) {
 			if($max_width>0){
 				$return.=$this->ife($width>$max_width, "width='{$max_width}' ", "width='{$width}' ");
 			}
 		}
 		if (!empty($height)) {
 			if($max_height>0){
 				$return.=$this->ife($height>$max_height, "height='{$max_height}' ", "height='{$height}' ");
 			}
 		}
 		$return .= !empty($title)?"alt='{$title}' ":null;
 		$return .= "/>";
 		return $return;
 	}
 	
 	function getFlvCode()
 	{
 		;
 	}
 	
 	function getFlashCode($adv_params, $max_width, $max_height)
 	{
 		extract($adv_params);
 		if (!empty($width)) {
 			if ($max_width>0) {
 				$width = $this->ife($width>$max_width, $max_width, $width);
 			}
 		}else{
 			if (!empty($max_width)) {
 				$width = $max_width;
 			}else{
 				$width = 100;
 			}
 		}
 		if (!empty($height)) {
 			if ($max_width>0) {
 				$height = $this->ife($height>$max_height, $max_height, $height);
 			}
 		}else{
 			if (!empty($max_height)) {
 				$height = $max_height;
 			}else{
	 			$height = 100;
	 		}
 		}
 		$id = empty($id)?pb_radom(3):"flash-".$id;
 		if (empty($source_url)) {
 			return 'This text is replaced by the Flash movie';
 		}
 		return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
   codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" 
   width="'.$width.'" height="'.$height.'" id="'.$$id.'" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="'.$source_url.'" />
<param name="wmode" value="default" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<param name="base" value="'.URL.'" />
<embed src="'.$source_url.'" quality="high" bgcolor="#ffffff" width="'.$width.'" 
   height="'.$height.'" name="mymovie" align="middle" allowScriptAccess="sameDomain" 
   type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
</object>';
 	}
}
?>
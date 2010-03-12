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
 * @version $Id: attachment_controller.php 481 2009-12-28 01:05:06Z steven $
 */
class Attachment extends PbController {
	var $name = "Attachment";
 	var $width = 0;
 	var $height = 0;
    var $upload_form_field = 'userfile';
   	var $allowed_file_ext = array('.jpg', '.jpeg', '.gif', '.png', '.bmp', '.swf', '.flv');
   	var $imgext  = array('.jpg', '.jpeg', '.gif', '.png', '.bmp');
    var $out_file_name;
    var $out_file_path;
    var $out_file_full_path;
    var $max_file_size    = 1024000;
    var $upload_url;
    var $file_full_url;
    var $upload_dir;
    var $file_size;
    var $if_watermark;
    var $is_water_image;
    var $is_water_text;
    var $water_text_color;
    var $if_thumb = true;
    var $if_thumb_middle = true;
    var $rename_file;
    var $if_orignal = true;
    var $orignal_file_ext = '.orignal';
    var $attachment_dir;
    var $insert_new = true;
    var $is_image = 0;
    var $title;
    var $description;
    var $id;
	
	function Attachment($user_file = '')
	{
		global $attachment_dir, $_PB_CACHE;
		if (!empty($user_file)) {
			$this->upload_form_field = $user_file;
		}
		$this->attachment_dir = $attachment_dir;
		$this->if_watermark = $_PB_CACHE['setting']['watermark'];
		$this->is_water_image = $_PB_CACHE['setting']['waterimage'];
		$this->is_water_text = $_PB_CACHE['setting']['watertext'];
		$this->water_text_color = $_PB_CACHE['setting']['watercolor'];
		$this->upload_dir = gmdate("Y").DS.gmdate("m").DS.gmdate("d");
		$this->out_file_path = PHPB2B_ROOT. $this->attachment_dir.DS.$this->upload_dir.DS;
		$this->upload_url = str_replace(array(DS, "\\", "\'"), "/", $this->upload_dir).'/'; 	
 	}
 	
 	function upload_process()
 	{
 		$attach_info = array();	
 		if (isset($_FILES) && $_FILES[$this->upload_form_field]['size']>0) {
 			require(LIB_PATH. "upload.class.php");
	 		$upload = new FileUploads;
			$upload->upload_dir = $this->out_file_path;
			$upload->extensions = $this->allowed_file_ext;
			$upload->max_file_size = $this->max_file_size;
			$upload->the_temp_file = $_FILES[$this->upload_form_field]['tmp_name'];
			$upload->the_file = $_FILES[$this->upload_form_field]['name'];
			$upload->http_error = $_FILES[$this->upload_form_field]['error'];
	 		if ($_FILES[$this->upload_form_field]['size']>$this->max_file_size) {
	 			flash(sprintf(L('file_too_big'), $upload->show_extensions()));
	 		}
			$isuploaded = $upload->upload($this->rename_file);
			//insert into db.
			$_this = & Attachments::getInstance();
			$this->file_full_url = $this->upload_url.$upload->file_copy;
			$this->file_size = $_FILES[$this->upload_form_field]['size'];
			$this->out_file_name = $upload->file_copy;
	        $this->out_file_full_path = $this->out_file_path.$this->out_file_name;
	        list($width, $height) = @getimagesize($this->out_file_full_path);
	        $this->width = intval($width);
	        $this->height = intval($height);
	        if (in_array(fileext($_FILES[$this->upload_form_field]['name']), $this->imgext)) {
				$this->is_image = 1;
			}
	        if ($this->if_orignal) {
	        	copy($this->out_file_full_path, $this->out_file_path.$this->rename_file.$this->orignal_file_ext.$upload->file_extension);
	        }
	        if($this->if_thumb){
		        require(LIB_PATH. "thumb.class.php");
		        $img = new Image($this->out_file_path.$this->rename_file.$this->orignal_file_ext.$upload->file_extension, $this->out_file_full_path);
		        if($this->if_thumb_middle) {
		        	$img->Thumb(220, 220, '.middle.jpg');
		        }
		        $img->Thumb(80, 80);
	        }
	        if($this->if_watermark){
	        	$this->imageWaterMark($this->out_file_path.$this->rename_file.$upload->file_extension);	        
	        }
	 		//save
	 		if ($this->insert_new) {
		 		$attach_info['attachment'] = $this->file_full_url;
		 		$attach_info['created'] = $attach_info['modified'] = $_this->timestamp;
		 		$attach_info['title'] = (empty($this->title))?reset(explode(".", $upload->the_file)):$this->title;
		 		$attach_info['description'] = $this->description;
		 		$attach_info['file_name'] = $upload->the_file;
		 		$attach_info['file_name'] = $this->is_image;
		 		$attach_info['file_size'] = $_FILES[$this->upload_form_field]['size'];
		 		$attach_info['file_type'] = $_FILES[$this->upload_form_field]['type'];
		 		if (isset($_SESSION['MemberID'])) {
		 			$attach_info['member_id'] = intval($_SESSION['MemberID']);
		 		}
	 			$this->id = $_this->Add($attach_info);
	 		}
 		}
 	}
 	
 	function deleteBySource($src)
 	{
 		@unlink(PHPB2B_ROOT. $this->attachment_dir.DS.$src);
 		@unlink(PHPB2B_ROOT. $this->attachment_dir.DS.$src.".middle.jpg");
 		@unlink(PHPB2B_ROOT. $this->attachment_dir.DS.$src.".small.jpg");
 		$file_ext = fileext($src);
 		$orignal_filename = str_replace($file_ext, ".orignal".$file_ext, $src);
 		@unlink(PHPB2B_ROOT. $this->attachment_dir.DS.$orignal_filename);
 	}
 	
 	function deleteById($attachment_id)
 	{
 		
 	}
	
	function imageWaterMark($groundImage, $waterImage="", $waterPos=9, $waterText='',
	$textFont=10, $textColor = '')
	{
		if ($this->is_water_image && empty($waterImage)) {
			$waterImage = PHPB2B_ROOT.'images/watermark.png';
		}
		$is_water_image = false;
		$formatMsg = L("format_not_support");
		if(!empty($waterImage))
		{ 
			if(!file_exists($waterImage)){
				flash("water_image_not_exists");
			}
			$is_water_image = TRUE;
			$water_info = getimagesize($waterImage);
			$water_w   = $water_info[0];
			$water_h   = $water_info[1];
			switch($water_info[2])
			{
				case 1:$water_im = imagecreatefromgif($waterImage);break;
				case 2:$water_im = imagecreatefromjpeg($waterImage);break;
				case 3:$water_im = imagecreatefrompng($waterImage);break;
				default:die($formatMsg);
			}
		}
		if(!empty($groundImage) && file_exists($groundImage))
		{
			$ground_info = getimagesize($groundImage);
			$ground_w   = $ground_info[0];
			$ground_h   = $ground_info[1];
			switch($ground_info[2])
			{
				case 1:$ground_im = imagecreatefromgif($groundImage);break;
				case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
				case 3:$ground_im = imagecreatefrompng($groundImage);break;
				default:die($formatMsg);
			}
		}
		if($is_water_image)
		{
			$w = $water_w;
			$h = $water_h;
		}
		else
		{
			if (empty($waterText)) {
				$waterText = (!empty($this->is_water_text))?$this->is_water_text:URL;
				$textColor = (!empty($this->water_text_color))?$this->water_text_color:'#FF0000';
			}
			$temp = imagettfbbox(ceil($textFont*5),0, $font_file = PHPB2B_ROOT."./data/fonts/incite.ttf",$waterText);
			$w = $temp[2] - $temp[6];
			$h = $temp[3] - $temp[7];
			unset($temp);
		}
		if( ($ground_w<=$w) || ($ground_h<=$h) )
		{
			return;
		}
		switch($waterPos)
		{
			case 0:
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
			case 1:
			$posX = 0;
			$posY = 0;
			break;
			case 2:
			$posX = ($ground_w - $w) / 2;
			$posY = 0;
			break;
			case 3:
			$posX = $ground_w - $w;
			$posY = 0;
			break;
			case 4:
			$posX = 0;
			$posY = ($ground_h - $h) / 2;
			break;
			case 5:
			$posX = ($ground_w - $w) / 2;
			$posY = ($ground_h - $h) / 2;
			break;
			case 6:
			$posX = $ground_w - $w;
			$posY = ($ground_h - $h) / 2;
			break;
			case 7:
			$posX = 0;
			$posY = $ground_h - $h;
			break;
			case 8:
			$posX = ($ground_w - $w) / 2;
			$posY = $ground_h - $h;
			break;
			case 9:
			$posX = $ground_w - $w;
			$posY = $ground_h - $h;
			break;
			default:
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
		}
		imagealphablending($ground_im, true);
		if($is_water_image)
		{
			imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);
		}
		else
		{
			if( !empty($textColor) && (strlen($textColor)==7) )
			{
				$R = hexdec(substr($textColor,1,2));
				$G = hexdec(substr($textColor,3,2));
				$B = hexdec(substr($textColor,5));
			}
			else
			{
				flash("watermark_word_error");
			}
			$font = 1;
			if (!empty($font_file)) {
				$font = @imageloadfont($font_file);
			}
			imagestring ( $ground_im, $font, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));
		}
		@unlink($groundImage);
		switch($ground_info[2])
		{
			case 1:imagegif($ground_im,$groundImage);break;
			case 2:imagejpeg($ground_im,$groundImage);break;
			case 3:imagepng($ground_im,$groundImage);break;
			default:die($errorMsg);
		}
		if(isset($water_info)) unset($water_info);
		if(isset($water_im)) imagedestroy($water_im);
		unset($ground_info);
		imagedestroy($ground_im);
	}
}
?>
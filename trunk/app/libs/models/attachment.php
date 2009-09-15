<?php
 class Attachments extends UaModel {
 	var $name = "Attachment";
 	var $module_id = 0;
    var $upload_form_field = 'pic';
    var $out_file_name    = '';
    var $out_file_dir     = './';
    var $max_file_size    = 1000000;
    var $make_script_safe = 1;
    var $force_data_ext   = '';
    var $allowed_file_ext = array( 'gif', 'jpg', 'jpeg', 'png', 'swf' );
    var $image_ext        = array( 'gif', 'jpeg', 'jpg', 'jpe', 'png' );
    var $image_check      = 1;
    var $file_extension   = '';
    var $real_file_extension = '';
    var $error_no         = 0;
    var $is_image         = 0;
    var $original_file_name = "";
    var $parsed_file_name = "";
    var $saved_upload_name = "";

 	function Attachments()
 	{

 	}

    function upload_process()
    {
		global $attach;
        $this->_clean_paths();
        if ( ! function_exists( 'getimagesize' ) )
        {
            $this->image_check = 0;
        }
        if (!file_exists($this->out_file_dir)) {
            $created = mkdir($this->out_file_dir, 0777);
            if (!$created) {
                die(sprintf(lgg("picture_upload_error"), $this->out_file_dir));
            }
        }
        $FILE_NAME = isset($_FILES[ $this->upload_form_field ]['name']) ? $_FILES[ $this->upload_form_field ]['name'] : '';
        $FILE_SIZE = isset($_FILES[ $this->upload_form_field ]['size']) ? $_FILES[ $this->upload_form_field ]['size'] : '';
        $FILE_TYPE = isset($_FILES[ $this->upload_form_field ]['type']) ? $_FILES[ $this->upload_form_field ]['type'] : '';

        $FILE_TYPE = preg_replace( "/^(.+?);.*$/", "\\1", $FILE_TYPE );

        if ( !isset($_FILES[ $this->upload_form_field ]['name'])
        or $_FILES[ $this->upload_form_field ]['name'] == ""
        or !$_FILES[ $this->upload_form_field ]['name']
        or !$_FILES[ $this->upload_form_field ]['size']
        or ($_FILES[ $this->upload_form_field ]['name'] == "none") )
        {
            $this->error_no = 1;
            return;
        }

        if( !is_uploaded_file($_FILES[ $this->upload_form_field ]['tmp_name']) )
        {
            $this->error_no = 1;
            return;
        }
        if ( ! is_array( $this->allowed_file_ext ) or ! count( $this->allowed_file_ext ) )
        {
            $this->error_no = 2;
            return;
        }
        $this->file_extension = $this->_get_file_extension( $FILE_NAME );

        if ( ! $this->file_extension )
        {
            $this->error_no = 2;
            return;
        }

        $this->real_file_extension = $this->file_extension;

        if ( ! in_array( $this->file_extension, $this->allowed_file_ext ) )
        {
            $this->error_no = 2;
            return;
        }
        if ( ( $this->max_file_size ) and ( $FILE_SIZE > $this->max_file_size ) )
        {
            $this->error_no = 3;
            return;
        }
        $FILE_NAME = preg_replace( "/[^\w\.]/", "_", $FILE_NAME );

        $this->original_file_name = $FILE_NAME;
        if ( $this->out_file_name )
        {
            $this->parsed_file_name = $this->out_file_name;
        }
        else
        {
            $this->parsed_file_name = str_replace( '.'.$this->file_extension, "", $FILE_NAME );
        }
        $renamed = 0;

        if ( $this->make_script_safe )
        {
            if ( preg_match( "/\.(cgi|pl|js|asp|php|html|htm|jsp|jar)(\.|$)/i", $FILE_NAME ) )
            {
                $FILE_TYPE                 = 'text/plain';
                $this->file_extension      = 'txt';
                $this->parsed_file_name    = preg_replace( "/\.(cgi|pl|js|asp|php|html|htm|jsp|jar)(\.|$)/i", "$2", $this->parsed_file_name );

                $renamed = 1;
            }
        }
        if ( is_array( $this->image_ext ) and count( $this->image_ext ) )
        {
            if ( in_array( $this->file_extension, $this->image_ext ) )
            {
                $this->is_image = 1;
            }
        }
        if ( $this->force_data_ext and ! $this->is_image )
        {
            $this->file_extension = str_replace( ".", "", $this->force_data_ext );
        }

        $this->parsed_file_name .= '.'.$this->file_extension;

        $this->saved_upload_name = $this->out_file_dir.'/'.$this->parsed_file_name;

        if ( ! @move_uploaded_file( $_FILES[ $this->upload_form_field ]['tmp_name'], $this->saved_upload_name) )
        {
            $this->error_no = 4;
            return;
        }
        else
        {
            @chmod( $this->saved_upload_name, 0777 );
            //$attach = array();
            $attach['is_image'] = $this->is_image;
            if($this->module_id) $attach['type_id'] = $this->module_id;
            $attach['attachment'] = gmdate("Ym")."/".$this->parsed_file_name;
            $attach['remote'] = URL."attachment/".$attach['attachment'];
            $attach['created'] = $_SERVER['REQUEST_TIME'];
            $attach['modified'] = $_SERVER['REQUEST_TIME'];
            $attach['file_type'] = $FILE_TYPE;
            $attach['file_size'] = $_FILES[ $this->upload_form_field ]['size'];
            $attach['file_name'] = $_FILES[ $this->upload_form_field ]['name'];
            $attach['status'] = 1;
            if (isset($_SESSION['MemberID'])) {
            	$attach['member_id'] = $_SESSION['MemberID'];
            }
            $this->save($attach);
        }

        if( !$renamed )
        {
            $this->check_xss_infile();

            if( $this->error_no )
            {
                return;
            }
        }
        if ( $this->is_image )
        {
            if ( $this->image_check )
            {
                $img_attributes = @getimagesize( $this->saved_upload_name );

                if ( ! is_array( $img_attributes ) or ! count( $img_attributes ) )
                {
                    // Unlink the file first
                    @unlink( $this->saved_upload_name );
                    $this->error_no = 5;
                    return;
                }
                else if ( ! $img_attributes[2] )
                {
                    // Unlink the file first
                    @unlink( $this->saved_upload_name );
                    $this->error_no = 5;
                    return;
                }
                else if ( $img_attributes[2] == 1 AND ( $this->file_extension == 'jpg' OR $this->file_extension == 'jpeg' ) )
                {
                    // Potential XSS attack with a fake GIF header in a JPEG
                    @unlink( $this->saved_upload_name );
                    $this->error_no = 5;
                    return;
                }
            }
        }

        if( filesize($this->saved_upload_name) != $_FILES[ $this->upload_form_field ]['size'] )
        {
            @unlink( $this->saved_upload_name );

            $this->error_no = 1;
            return;
        }
    }

    function check_xss_infile()
    {
        $fh = fopen( $this->saved_upload_name, 'rb' );

        $file_check = fread( $fh, 512 );

        fclose( $fh );

        if( !$file_check )
        {
            @unlink( $this->saved_upload_name );
            $this->error_no = 5;
            return;
        }

        else if( preg_match( "#<scrīpt|<html|<head|<title|<body|<pre|<table|<a\s+href|<img|<plaintext#si", $file_check ) )
        {
            @unlink( $this->saved_upload_name );
            $this->error_no = 5;
            return;
        }
    }

    function _get_file_extension($file)
    {
        return strtolower( str_replace( ".", "", substr( $file, strrpos( $file, '.' ) ) ) );
    }

    function _clean_paths()
    {
        $this->out_file_dir = preg_replace( "#/$#", "", $this->out_file_dir );
    }

	function imageWaterMark($groundImage,$waterImage="",$waterPos=9,$waterText="COPYRIGHT",
	$textFont=5,$textColor ="#FF0000")
	{
	    global $tb_prefix, $g_db;
	    $if_watermark = true;
	    $if_watermark = $g_db->GetOne("select valued from {$tb_prefix}settings where variable='watermark'");
	    if (!$if_watermark) {
	    	return;
	    }
	  $isWaterImage = FALSE;
	  $formatMsg = lgg("format_not_support");
	  //读取水印文件
	  if(!empty($waterImage) && file_exists($waterImage))
	  {
		$isWaterImage = TRUE;
		$water_info = getimagesize($waterImage);
		$water_w   = $water_info[0];//取得水印图片的宽
		$water_h   = $water_info[1];//取得水印图片的高
		switch($water_info[2])//取得水印图片的格式
		{
			case 1:$water_im = imagecreatefromgif($waterImage);break;
			case 2:$water_im = imagecreatefromjpeg($waterImage);break;
			case 3:$water_im = imagecreatefrompng($waterImage);break;
			default:die($formatMsg);
		}
	  }
	  //读取背景图片
	  if(!empty($groundImage) && file_exists($groundImage))
	  {
		$ground_info = getimagesize($groundImage);
		$ground_w   = $ground_info[0];//取得背景图片的宽
		$ground_h   = $ground_info[1];//取得背景图片的高
		switch($ground_info[2])//取得背景图片的格式
		{
			case 1:$ground_im = imagecreatefromgif($groundImage);break;
			case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
			case 3:$ground_im = imagecreatefrompng($groundImage);break;
			default:die($formatMsg);
		}
	  }
	  else
	  {
		die(lgg("water_image_not_exists"));
	  }
	  //水印位置
	  if($isWaterImage)//图片水印
	  {
		$w = $water_w;
		$h = $water_h;
		$label = "图片的";
	  }
	  else//文字水印
	  {
		$temp = imagettfbbox(ceil($textFont*5),0, SITE_ROOT."./data/default/ACCELERA.TTF",$waterText);//取得使用 TrueType 字体的文本的范围
		$w = $temp[2] - $temp[6];
		$h = $temp[3] - $temp[7];
		unset($temp);
		$label = "文字的";
	  }
	  if( ($ground_w<=$w) || ($ground_h<=$h) )
	  {
		//echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！";
		return;
	  }
	  switch($waterPos)
	  {
		case 0://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
		case 1://1为顶端居左
			$posX = 0;
			$posY = 0;
			break;
		case 2://2为顶端居中
			$posX = ($ground_w - $w) / 2;
			$posY = 0;
			break;
		case 3://3为顶端居右
			$posX = $ground_w - $w;
			$posY = 0;
			break;
		case 4://4为中部居左
			$posX = 0;
			$posY = ($ground_h - $h) / 2;
			break;
		case 5://5为中部居中
			$posX = ($ground_w - $w) / 2;
			$posY = ($ground_h - $h) / 2;
			break;
		case 6://6为中部居右
			$posX = $ground_w - $w;
			$posY = ($ground_h - $h) / 2;
			break;
		case 7://7为底端居左
			$posX = 0;
			$posY = $ground_h - $h;
			break;
		case 8://8为底端居中
			$posX = ($ground_w - $w) / 2;
			$posY = $ground_h - $h;
			break;
		case 9://9为底端居右
			$posX = $ground_w - $w;
			$posY = $ground_h - $h;
			break;
		default://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
	  }
	  //设定图像的混色模式
	  imagealphablending($ground_im, true);
	  if($isWaterImage)//图片水印
	  {
		imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
	  }
	  else//文字水印
	  {
		if( !empty($textColor) && (strlen($textColor)==7) )
		{
			$R = hexdec(substr($textColor,1,2));
			$G = hexdec(substr($textColor,3,2));
			$B = hexdec(substr($textColor,5));
		}
		else
		{
			die("水印文字颜色格式不正确！");
		}
		imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));
	  }
	  //生成水印后的图片
	  @unlink($groundImage);
	  switch($ground_info[2])//取得背景图片的格式
	  {
		case 1:imagegif($ground_im,$groundImage);break;
		case 2:imagejpeg($ground_im,$groundImage);break;
		case 3:imagepng($ground_im,$groundImage);break;
		default:die($errorMsg);
	  }
	  //释放内存
	  if(isset($water_info)) unset($water_info);
	  if(isset($water_im)) imagedestroy($water_im);
	  unset($ground_info);
	  imagedestroy($ground_im);
	}

	function delete($attachments = null, $id = null)
	{
	    global $g_db;
	    $tmpIdCondition = $tmpAttachments = null;
	    if (!empty($attachments)) {
                $tmpIdCondition = " attachment = '".$attachments."'";
                @unlink(BASE_DIR."attachment/".$attachments);
                @unlink(BASE_DIR."attachment/".$attachments.".small.jpg");
	    }else{
    	    if ($id && is_array($id)) {
    	    	$tmpIdCondition = " id in (".implode(",", $id).")";

    	       $tmpAttachments = $g_db->GetArray("select attachment from ".$this->getTable()." where ".$tmpIdCondition);
    	    }
    	    if (!empty($tmpAttachments)) {
    	    	foreach ($tmpAttachments as $key=>$val){
    	    	    @unlink(BASE_DIR."attachment/".$val['attachment'].".small.jpg");
    	    	}
    	    }
	    }
	    $g_db->Execute("delete from ".$this->getTable()." where ".$tmpIdCondition);
	    return true;
	}
}
?>
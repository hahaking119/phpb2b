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
 * @version $Id: header.share.php 571 2009-12-28 12:00:59Z steven $
 */
$steps = array(
'1'=>'软件介绍',
'2'=>'软件许可协议',
'3'=>'运行环境检测',
'4'=>'文件权限检测',
'5'=>'数据库及管理员设置',
'6'=>'填写网站基本信息',
'7'=>'安装完成'
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset;?>">
<title><?php echo $steps[$step];?> - PHPB2B 安装向导</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../scripts/jquery.js"></script>
<script language="JavaScript" src="../scripts/install.js"></script>
<script language="JavaScript" src="../scripts/pngfix.js"></script>
<script>
jQuery(function($) {
    $("img[@src$=png], #image-one, #image-two").pngfix();
});
</script>
</head>
<body>
<div id="main">
<div id="ads">- 行业B2B电子商务网站管理系统</div>
<div id="top"><a href="http://www.phpb2b.com/" target="_blank">官方网站</a>　|　<a href="http://www.phpb2b.com/bbs/" target="_blank">官方论坛</a></div>
  <div id="left">
    <ul>
	<?php
	foreach($steps as $k=>$v)
	{
		$selected = $k == $step ? 'id="now"' : '';
	    echo "<li {$selected}>{$v}</li>";
	}
	?>
    </ul>
  </div>
  <div id="right">
    <h3><span><?php echo $step;?></span><?php echo $steps[$step];?></h3>
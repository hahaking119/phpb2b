<?php
$company_id = empty($_GET['id'])? 1:intval($_GET['id']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title><?php echo $company_id;?>_Flash��ҵ��Ƭ��ʾ</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="Flash,��ҵ��Ƭ,������Ƭ,������Ƭ">
  <meta name="Description" content="���ö�̬��Flash��ʽ��,���չ��������ҵ��ϵ��ʽ,������������ĺð���">
 </head>

 <body>
 �����ҵ�Flash��Ƭ:
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" id="FlashVars" width="460" height="250">  
    <param name="movie" value="http://<?php echo $_SERVER['HTTP_HOST'];?>/plugins/card/mycard.swf?instanceid=<?php echo $company_id;?>">  
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="FlashVars" value="" />
    <param name="quality" value="high">   
    <param name="bgcolor" value="#FFFFFF">
    <!--[if !IE]> <-->  
	<embed src="http://<?php echo $_SERVER['HTTP_HOST'];?>/plugins/card/mycard.swf?instanceid=<?php echo $company_id;?>" quality="high" bgcolor="#ffffff" width="550" height="400" name="FlashVars" align="middle" allowScriptAccess="sameDomain" FlashVars="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
     FAIL (the browser should render some flash content, not this).  
    </object>  
    <!--> <![endif]-->  
   </object>
 </body>
</html>

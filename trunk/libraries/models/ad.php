<?php
 class Adses extends PbModel {
 	var $name = "Ads";
 	var $types = array(1=>"图片(gif,jpg,png)",2=>"Flash(.swf)",3=>"多媒体",4=>"其他", 5=>".flv 格式视频");
 	var $pop_target = array("_blank"=>"_blank","_self"=>"_self","_parent"=>"_parent");

 	function Ads()
 	{

 	}
}
?>
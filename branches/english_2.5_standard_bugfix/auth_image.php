<?php
require("global.php");
require('app/configs/db_session.php');
Header("Content-type:image/png");
$check_code = getRadomStr(4);
$_SESSION['authnum_session'] = $check_code;
srand((double)microtime()*1000000);
$im = imagecreate(50,20);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200); 
imagefill($im,68,30,$gray);
$li = ImageColorAllocate($im, 220,220,220);
for($i=0;$i<3;$i++) 
{
	imageline($im,rand(0,30),rand(0,21),rand(20,40),rand(0,21),$li);
} 
imagestring($im, 5, 8, 2, $_SESSION['authnum_session'], $white);
for($i=0;$i<90;$i++)
{
	imagesetpixel($im, rand()%70 , rand()%30 , $gray);
}
ImagePNG($im);
ImageDestroy($im);
?>
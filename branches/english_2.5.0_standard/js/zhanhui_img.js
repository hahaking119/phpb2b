// JavaScript Document
var count = 1;
function showImg(n)
{
	for(var i=1; i<4; i++)
	{
		document.getElementById("zh_img" +　i).style.display = "none";
	}
	document.getElementById("zh_img" +　n).style.display = "block";
	document.getElementById("zh_p1").className = "over" + n;
	count = n;
}
function forshowImg(){
	if(count < 4)
	{
		showImg(count);
		count++;
	}
	else count = 1;
}
setInterval("forshowImg()",3000);
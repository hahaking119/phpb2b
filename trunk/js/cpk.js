// JavaScript Document
// 产品库 轮换图 jscode
var count = 0;
function showCpImg(n)
{
	for(var m=0; m<5; m++)
	{
		document.getElementById("cp_img" + m).style.display = "none";
		document.getElementById("cp_a" + m).className = "";
	}
	document.getElementById("cp_img" + n).style.display = "block";
	document.getElementById("cp_a" + n).className = "over";
	count = n;
}
function forshowCpImg(){
	if(count < 5)
	{
		showCpImg(count);
		count++;
	}
	else count = 0;
}
setInterval("forshowCpImg()",3000);
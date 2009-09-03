// JavaScript Document
// 焦点轮换图 js code
var count = 0;
function showImg(n)
{
	for(var i=0; i<4; i++)
	{
		document.getElementById("img_b" + i).style.display = "none";
		document.getElementById("img_s").getElementsByTagName("em")[i].className = "";
	}
	document.getElementById("img_b" + n).style.display = "block";
	document.getElementById("img_s").getElementsByTagName("em")[n].className = "over";
	count = n;
}
function forshowImg(){
	if(count < 4)
	{
		showImg(count);
		count++;
	}
	else count = 0;
}
//setInterval("forshowImg()",3000);


// 最新供求信息 js code
var qq_bt = document.getElementById("new_qg_bt");
var gqAR = qq_bt.getElementsByTagName("a");
function showGqxx(n,o)
{
	for(var i=0; i<gqAR.length; i++)
	{
		gqAR[i].className = "f";
		document.getElementById("new_gq" + i).style.display = "none";
	}
	o.className = "over";
	document.getElementById("new_gq" + n).style.display = "block";
}


//行业资讯 tab js code
function showZixun(num)
{
	for(var k=1; k<3; k++)
	{
		document.getElementById("zixun" + k).style.display = "none";
		document.getElementById("zx_bt" + k).className = "f12";
	}
	document.getElementById("zixun" + num).style.display = "block";
	document.getElementById("zx_bt" + num).className = "f12 over";
}

// 原料行情  社区焦点  js code
function showYlsq(num)
{
	for(var k=1; k<3; k++)
	{
		document.getElementById("ylsq_" + k).style.display = "none";
		document.getElementById("hqsq_bt" + k).className = "";
	}
	document.getElementById("ylsq_" + num).style.display = "block";
	document.getElementById("hqsq_bt" + num).className = "over";
}
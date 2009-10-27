// JavaScript Document

// 行业分类 拼音搜索js code
var result = document.getElementById("py_result");
function showResult(let)
{
	result.style.display = "block";
	var str = "<a href='#' title='' class='a f14'>" + let + "</a>";
	result.innerHTML = str;
}
function showME(o)
{
	o.style.display = "block";
}
function hideResult()
{
	result.style.display = "none";
}

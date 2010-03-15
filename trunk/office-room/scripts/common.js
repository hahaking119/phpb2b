<!--//
function checkInput(){
	if($('#oldpass').val() == ""){
		alert("请填写原来的密码！");
		$('#oldpass').focus();
		return false;
	}
	if($('#newpass').val() != $('#re_newpass').val()){
		alert("前后密码输入不一致");
		$('newpass').focus();
		return false;
	}
	if($('#newpass').val() == $('#oldpass').val()){
		alert("密码与原密码一致，无须修改");
		$('#newpass').focus();
		return false;
	}
	$("#BtnChangePwd").attr('disabled', false);
	document.changepassfrm.submit();
}
function update_checkoldpwdDiv (data)  //回传函数实体，参数为XMLhttpRequest.responseText
{
	var errorNumber = data.isError;
	if(errorNumber!=0)
	{
		$("#checkoldpwdDiv").html('<img src="images/check_error.gif" alt="验证失败" />');
		$("#BtnChangePwd").attr('disabled', true);
	}else{
		$("#checkoldpwdDiv").html('<img src="images/check_right.gif" alt="验证通过" />');
		$("#BtnChangePwd").attr('disabled', false);
	}
}
//-->
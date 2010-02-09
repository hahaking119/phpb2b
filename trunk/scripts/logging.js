<!--//
$(document).ready(function(){   
	//event: "keyup",
    $("#LoggingFrm").validate({
		rules: {
			"data[login_name]": { required: true},
			"data[login_pass]": { required: true}
		},
		messages: {
			"data[login_name]": "请输入正确的用户名",
			"data[login_pass]": "请输入密码"
		}
	});
});
function login(frm){
	if($('#LoginName').val() == ""){
			alert("请输入正确的用户名");
			$('#LoginName').focus();
			return false;
		}else if($('#UserEmail').val() == ""){
			alert("请输入Email地址");
			$('#UserEmail').focus();
			return false;
	}
}
function update_checkusernameDiv(data){
	var errorNumber = data.isError;
	if(errorNumber!=0)
	{
		$("#GoNext").attr('disabled', true);
		$("#checkusernameDiv").html('验证失败');
	}else{
		$("#GoNext").attr('disabled', false);
		$("#checkusernameDiv").html('');
	}
}
//-->
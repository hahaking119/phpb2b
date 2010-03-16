<!--//
$(document).ready(function(){   
    $("#PostFrm").validate({
		rules: {
			"data[trade][title]": { required: true,"minlength":4},
			"data[trade][content]": { required: true}
		},
		messages: {
			"data[trade][title]": "请输入供求标题",
			"data[trade][content]": "请输入供求详情"
		}
	});   
});
//-->
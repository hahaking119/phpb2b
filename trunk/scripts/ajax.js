<!--//
$(document).ready(function() {    
   $('#dataMemberUsername').blur(function (){
	 var params = $('#getPasswdFrm').serialize(); //���л�����ֵ
	 var action = "checkusername";
     $.ajax({
       url:'ajax.php?action='+action, //��̨�������
       type:'get',         //���ݷ��ͷ�ʽ
       dataType:'json',     //�������ݸ�ʽ
       data:params,         //Ҫ���ݵ�����
       success:update_checkusernameDiv  //�ش�����(�����Ǻ�����)
     });
   });
});
//-->
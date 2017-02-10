$(function(){
	$("#imgSubmit").click(function(){
		$.get('user.php?act=headimg',function(data){
			art.dialog({
				id:'img',
				title: '[ 更换头像 ]',
				content: data,
				fixed: true,
				lock: true,
				cancelValue: '关闭',
				cancel: function (){ 
					
					return true;
				}
			});
		});
	});
	
	//密码问题
	$("#questionid").change(function(){
		if($(this).val()!=0){
			$("input[name='password']").focus();
		}else{
			$("input[name='password']").val('');
		}
	});
});
$(function(){
	$("#smsbutton").click(function(){
		$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
		$.post('plugins.php?act=sendsmscode',function(data){
			$.dialog.get('ajaxStart').close();
			$.dialog({title: '提示',content: data.info,fixed: true,lock: true});
			var SysSecond = 180; 
			$("input[name='sms']").val('1');
			var tim = setInterval(function(){
				if(SysSecond > 0){ 
					SysSecond = SysSecond - 1; 
					var second = Math.floor(SysSecond);// 计算秒 
					$("#smsbutton").val(SysSecond+'秒后可再次发送'); 
				}else{
					clearInterval(tim);
					$("#smsbutton").val('短信获取'); 
				} 
			}, 1000);
		},'json');
	});

	$("#Safe_sub").click(function(){
		var smscode=$("input[name='safeCode']").val();
		var password=$("input[name='password']").val();
		var pass=$("input[name='pass']").val();
		if(smscode == ''){
				$.dialog({title: '提示',content: '请输入短信验证码~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(password == '' || pass == ''){
				$.dialog({title: '提示',content: '新操作码不能为空~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(password != pass){
				$.dialog({title: '提示',content: '新操作密码与确认密码不一致~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(/^[0-9a-zA-Z_]{6,20}$/.test(password) == false){
			$.dialog({title: '提示',content: '安全操作码格式错误(操作码由英文字母、数字(0-9)、下划线组成,长度在6-20个字符之间)',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
		$.post('user.php?act=userinfo&opt=setsafepass',{"smscode":smscode,"password":password,"pass":pass},function(data){
			$.dialog.get('ajaxStart').close();
			if(!data.status){
				$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
				return false;
			}
			$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () { location.reload() }});
		},'json');
	});

});
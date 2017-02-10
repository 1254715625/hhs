function check(){
	var safepass=$("input[name='safepass']").val();
	var password=$("input[name='password']").val();
	var pass=$("input[name='pass']").val();
	if(safepass==''){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>请输入安全验证码！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						return true;
					}
				});
		return false;
	}else if(password==''){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>请输入新登录密码！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						return true;
					}
				});
		return false;
	}else if(pass==''){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>请输入确认密码！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						return true;
					}
				});
		return false;
	}else if(password != pass){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>两次密码输入不一致！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						return true;
					}
				});
		return false;
	}else{
		$.post('user.php?act=userinfo',{'safepass':'safepass','pass':safepass},function(data){
			if(data.state!='ok'){
				$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>安全码验证失败！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						$("input[name='safepass']").focus();
						return true;
					}
				});
				return false; 
			}else{
				return true;
			}
	   });
	}
}
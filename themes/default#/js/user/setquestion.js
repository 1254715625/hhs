function check(){
	var question=$("#questionid").val();
	var password=$("input[name='password']").val();
	var safepass=$("input[name='safepass']").val();
	if(question > 0 && password == ''){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>请输入问题答案！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
						
					}
				});
		return false;
	}
	if(safepass==''){
		$.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>请输入安全码！</div>",
					fixed: true,
					okValue : "确定",
					ok: function (){ 
					}
				});
		return false;
	}
	/*$.get('http://member.haohuishua.com.cn/member.php?mod=userdata&getsafepass='+safepass,function(data,status){
					if(data=='ok'){
						return true;
					}else{
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
					}
			  });*/

}
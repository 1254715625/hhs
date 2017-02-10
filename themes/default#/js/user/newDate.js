function check(){
	var username=$("input[name='username']").val();
	var message=$("textarea[name='message']").val();
	var uid=$("input[name='uid']").val();
	if(username==''){
		$.dialog({
			title: '提示：',
			content: "<div style='width:150px;font-size:14px'>请输入用户名！</div>",
			fixed: true,
			lock:true,
			okValue : "确定",
			ok: function (){ 
				return true;
			}
		});
		return false;
	}else if(message==''){
		$.dialog({
			title: '提示：',
			content: "<div style='width:150px;font-size:14px'>请输入内容！</div>",
			fixed: true,
			okValue : "确定",
			lock:true,
			ok: function (){ 
				return true;
			}
		});
		return false;
	}
	else if(uid==''){
		$.dialog({
			title: '提示：',
			content: "<div style='width:150px;font-size:14px'>用户不存在！</div>",
			fixed: true,
			lock:true,
			okValue : "确定",
			ok: function (){ 
				return true;
			}
		});
		return false;
	}
	else{
		$.post('user.php?act=personal&opt=newDate',{'set':'newDate','username':username,'message':message},function(data){
			$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {if(data.state){location.href='user.php?act=personal&opt=myRest';} return true;}});return false;
		},'json');
		return false;
	}

}
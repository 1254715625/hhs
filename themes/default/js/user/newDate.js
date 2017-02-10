function check(){
	var username=$("input[name='username']").val();
	var message=$("textarea[name='message']").val();
	var uid=$("input[name='uid']").val();
	if(username==''){
		art.dialog({
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
		art.dialog({
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
	}else if(message.length>200){
		art.dialog({
			title: '提示：',
			content: "<div style='width:150px;font-size:14px'>您的消息过长，请不要超出200字~</div>",
			fixed: true,
			okValue : "确定",
			lock:true,
			ok: function (){ 
				return true;
			}
		});
		return false;
	}else if(uid==''){
		art.dialog({
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
			art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {if(data.state){location.href='user.php?act=personal&opt=myRest';} return true;}});return false;
		},'json');
		return false;
	}

}
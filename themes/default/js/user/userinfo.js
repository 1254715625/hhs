$(function(){
	$('#updatePhone').click(function(){
	var self= this;
	
	art.dialog({
		title: '修改手机操作',
		content: '<div id="sphone" style="width:525px;"><div class="send_img"></div><div class="send_cont"><span class="send_phone">手机号码：<input type="text" readonly style="border: none;" value="'+$("#mobile").text()+'"></span><span class="send_v">验证码：<input type="text" id="getCode"></span><span class="send_v">新号码：<input type="text" id="getPhone"></span></div><div class="getvcode"><input id="get_vcode" type="button" value="短信获取" ></div><p class="set_sub"><input type="submit" id="btn_submit" class="dxyz_qr" value=""></p></div>',
		fixed: true,
		lock: true
	})

	$(".d-buttons").hide();
		
	$("#get_vcode").click(function(){
	art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
	$.post('plugins.php?act=sendsmscode',function(data){
		art.dialog.get('ajaxStart').close();
		art.dialog({title: '提示',content: data.info,fixed: true,lock: true});
		var SysSecond = 180; 
		if(data.time){
			SysSecond=data.time;
		}
		var tim = setInterval(function(){
			if(SysSecond > 0){ 
				SysSecond = SysSecond - 1; 
				var second = Math.floor(SysSecond);// 计算秒 
				$(".getvcode").html('<input id="get_vcode" type="button" value="'+SysSecond+'秒后可再次发送">'); 
			}else{
				clearInterval(tim);
				$(".getvcode").html('<input id="get_vcode" type="button" value="短信获取">');
			} 
		}, 1000);
	},'json');
	});

	$("#btn_submit").click(function(){
		var code = $("#getCode").val();
		var phone = $("#getPhone").val();
		var datas = {code:code,phone:phone,action:1}
		art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
		$.post('user.php?act=userinfo',datas,function(data){
			art.dialog.get('ajaxStart').close();
			if(!data.status){
				art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
				return false;
			}
			art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () { location.reload() }});
		},'json');
	});
});
$(".colseAdd").click(function(){
		$(this).siblings('input[type="text"]').val('');
});
});
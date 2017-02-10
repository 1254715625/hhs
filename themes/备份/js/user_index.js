$(function(){
	$(".icotwe").click(function(){
		location.href = 'user.php?act=exam';
	});
	$(".bindPhone").click(function(){
		var mobile=$(this).attr('data');
		$.dialog({title: '认证 - 激活手机',content: '<div id="sphone"><p style="height: 30px;color: #E21;">注意：一个手机号码只能验证一次，验证通过的手机号将作为该账户的最终手机号</p><div class="send_img"></div><div class="send_cont"><span class="send_phone">手机号码：<input type="text" id="sendPhone" maxlength="11" value="'+mobile+'" readonly></span><span class="send_v">验证码：<input type="text" id="getCode"></span></div><div class="getvcode"><input id="get_vcode" type="button" value="短信获取" onclick="getSmsCode();"></div><div class="sountcode"><span onclick="getSoundCode();" id="yy">语音获取</span></div><p class="set_sub"><input type="submit" id="btn_submit" class="dxyz_qr" value="" onclick="checkSMS();"></p></div>', fixed:true, lock:true});
	});

	$(".examine").click(function(){
		$.dialog({title: '好会刷小调查',
				  content: '<div style="width:300px; line-height:26px;"><strong>您是通过哪里来到好会刷平台的？</strong><ul><li>1、搜索引擎</li><li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="source" value="baidu" /> 百度 <input type="radio" name="source" value="sougou" /> 搜狗 <input type="radio" name="source" value="360" /> 360 <input type="radio" name="source" value="google" /> Google</li><li>2、<input type="radio" name="source" value="firend" /> 朋友推荐</li><li>3、<input type="radio" name="source" value="guanggao" /> 广告图</li><li>4、<input type="radio" name="source" value="bbs" /> 论坛博客</li></ul></div>', 
				  okValue:'确定',
				  cancelValue:'取消',
				  ok : function(){
						var s = $("input[name=source]:checked").val();
						if(!s)
						{
							alert("请先选择项目~");
							return false;
						}

						$.post('plugins.php?act=exam', {item:s}, function(data){
							$.dialog({title: '提示',content:data+'感谢您的参与~', fixed: true,lock:true,cancelValue:'确定', cancel:function(){location.reload();}});
						});
					},
				  cancel : {},
				  fixed:true, lock:true});
	});
	$(".content .switch").mouseover(function(){
			$(this).children(".remone").html('<p><img src="themes/default/images/user/dsssss.png" /></p>');
	});
	$(".content .switch").mouseleave(function(){
			$(this).children(".remone").empty();
	});
	$('.switch .imgico').click(function(){
		if($(this).hasClass('dv_sp0'))
		{
			$.post('user.php?act=setotlog', {otlog:1}, function(data){
				if(parseInt(data) == 1)
				{
					$.dialog({title: '提示',content:'异地登陆验证已开启~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
					$('.switch .imgico').removeClass('dv_sp0').addClass('dv_sp1');
				}
			});
		}
		else
		{
			$.dialog({title : '提示', fixed : true, lock : true,
					content : '您如果关闭异地登录，账户就可能存在账号资金被盗的风险，确定要关闭吗？',
					okValue : '确定',
					ok : function(){
						$.post('user.php?act=setotlog', {otlog:0}, function(data){
							if(parseInt(data) == 1)
							{
								$.dialog({title: '提示',content:'异地登陆验证已关闭~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
								$('.switch .imgico').removeClass('dv_sp1').addClass('dv_sp0');
							}
						});					
					},
					cancelValue : '取消',
					cancel : {}
				});
			
		}
	});
})

function getSmsCode()
{
	var phone = $("#sendPhone");
	if(/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/.test(phone.val()) == false)
	{
		phone.css('border','1px solid red'); return false;
	}else{
		phone.css('border','1px solid #ddd');
	}

	$.dialog({id:"ajaxStart",title: '正在处理中...',fixed: true});
	$.post('plugins.php?act=sendsmscode', {phone:phone.val()}, function(data){
		$.dialog.get('ajaxStart').close();
		$.dialog({title:'提示', content:data.info, fixed:true, lock:true});
		var SysSecond = 180;
		
		var tim = setInterval(function(){
					if(SysSecond > 0){ 
						$("#yy").hide();
						SysSecond = SysSecond - 1; 
						var second = Math.floor(SysSecond);// 计算秒 
						$(".getvcode").html('<input id="get_vcode" type="button" value="'+SysSecond+'秒后重新获取">'); 
					}else{
						clearInterval(tim);
						$("#yy").show();
						$(".getvcode").html('<input id="get_vcode" type="button" value="短信获取" onclick="getSmsCode();">');
					} 
			  	}, 1000);	
	}, 'json');
}

function getSoundCode()
{
	var phone = $("#sendPhone");
	if(/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/.test(phone.val()) == false)
	{
		phone.css('border','1px solid red'); return false;
	}else{
		phone.css('border','1px solid #ddd');
	}
			
	$.dialog({
		title: '语音验证码',
		content: '您将收到语音电话，请根据语音提示输入验证码！',
		fixed: true,
		lock: true,
		okValue:'确定',
		cancelValue:'取消',
		ok : function(){
				$.dialog({id:"ajaxStart",title: '正在拨号中..',fixed: true});
				$.post('plugins.php?act=sendsoundcode', {phone:phone.val()}, function(data){
						$.dialog.get('ajaxStart').close();
						$.dialog({title: '提示',content: data.info,fixed: true,lock: true});
						var SysSecond = 180; 			    	
					  	var tim = setInterval(function(){
					  		if(SysSecond > 0){ 
								$("#get_vcode").hide();
								SysSecond = SysSecond - 1; 
								var second = Math.floor(SysSecond);// 计算秒 
								$(".sountcode").html('<span>'+SysSecond+'秒后重新获取</span>'); 
							}else{
								$("#get_vcode").show();
								clearInterval(tim);
								$(".sountcode").html('<span onclick="getSoundCode();">语音获取</span>');
							} 
					  	}, 1000);

					}, 'json');
			},
		cancel:function(){return true;}
	});
}

function checkSMS()
{
	var phone = $("#sendPhone");
	if(/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/.test(phone.val()) == false)
	{
		phone.css('border','1px solid red'); return false;
	}else{
		phone.css('border','1px solid #ddd');
	}

	var sms = $("#getCode");
	if(sms.val() == ""){
		sms.css('border','1px solid red');
		return false;
	}else{
		sms.css('border','1px solid #ddd');
	}

	$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});

	$.post('plugins.php?act=checkcode', {code:sms.val(), mod:'mprz'}, function(data){
			$.dialog.get('ajaxStart').close();
			$.dialog({title:'提示', content:data.info, fixed:true, lock:true, okValue:'确定', cancelValue:'取消',
					  ok : function(){location.reload();},
					  cancel : function(){return true;}
					});
		}, 'json');
}
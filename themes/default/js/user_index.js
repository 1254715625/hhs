$(function(){
	var fangpian_cookie = $.cookie('fangpian_cookie');
	if(!fangpian_cookie){
		var dfg = '<div id="userTishi"><img width="560" height="380" src="themes/default/images/user/tsback.png"><span class="xinshou">新手常见问题</span><span class="xiaotis">哪里不会点哪里</span><p class="lie"><a href="help.php?act=guide" class="hova a1"></a><a href="help.php?act=guide" class="hova a2"></a><a href="help.php?act=guide" class="hova a3"></a><a href="help.php?act=guide" class="hova a4"></a><a href="help.php?act=guide" class="hova a5"></a></p><p style="color: white;position: absolute;left: 33px;bottom: 12px;">对好会刷的小意见，请给我们留言。<a href="javascript:;" style="color: wheat;" id="djliu">点击留言</a></p></div>';
		art.dialog({
			id:'fpzn',
			title: false,
			content: dfg,
			fixed: true,
			lock: true,
			padding: 0,
			cancelValue: '关闭',
			cancel: function () { return true;}
		});
		$(".d-button").css({position:'absolute',bottom:'30px',right:'20px',border:'none'});
		$.cookie('fangpian_cookie', '1', { expires: 1 });
	}
	$("#djliu").click(function(){
		var self = this;
		art.dialog({
			title: '反馈意见',
			content: '<textarea class="textarea" id="translate_input" style="height: 180px;width:440px;" maxlength="510">请亲输入点文字吧，您的意见即为我们的前进动力！</textarea>',
			fixed: true,
			lock: true,
			padding: 0,
			cancelValue: '关闭',
			cancel: function () { return true;},
			okValue:'提交',
			ok:function(){
				var tex = $("#translate_input").val();
				if(tex.length==0||tex=='请亲输入点文字吧，您的意见即为我们的前进动力！'){
					$("#translate_input").focus();
					return false;
				}else if(tex.length>1000){
					art.dialog({title: '提示',content: '留言内容过长~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}})
				}else{
					$.post('user.php?act=message',{'tex':tex},function(data){
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
					},'json');
				}
			}
		});
		$("#translate_input").focus(function(){
			if($(this).val() == '请亲输入点文字吧，您的意见即为我们的前进动力！'){
				$(this).val('');
			}
		})
		$("#translate_input").focusout(function(){
			if($(this).val()==''){
				$(this).val('请亲输入点文字吧，您的意见即为我们的前进动力！');
			}
		});
	});
	window.mo=0;
	$(".icotwe").click(function(){
		location.href = 'user.php?act=exam';
	});
	$(".bindPhone").click(function(){
		var mobile=$(this).attr('data');
		var contents='<div id="sphone"><p style="height: 30px;color: #E21;">注意：一个手机号码只能验证一次，验证通过的手机号将作为该账户的最终手机号</p><div class="send_img"></div><div class="send_cont"><span class="send_phone">手机号码：<input type="text" id="sendPhone" maxlength="11" value="'+mobile+'"></span><span class="send_v">验证码：<input type="text" id="getCode"></span></div><div class="getvcode"><input id="get_vcode" type="button" value="短信获取" onclick="getSmsCode(this);"';
		if(window.mo==2){
			contents+=' style="display:none;"';
		}
		contents+='></div><div class="sountcode"><span onclick="getSoundCode(this);" id="yy"';
		if(window.mo==1){
			contents+=' style="display:none;"';
		}
		contents+='>语音获取</span></div><p class="set_sub"><input type="submit" id="btn_submit" class="dxyz_qr" value="" onclick="checkSMS();"></p></div>';

		art.dialog({title: '认证 - 激活手机',content: contents, fixed:true, lock:true});
	});

	$(".examine").click(function(){
		art.dialog({title: '好会刷小调查',
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
							art.dialog({title: '提示',content:data+'感谢您的参与~', fixed: true,lock:true,cancelValue:'确定', cancel:function(){location.reload();}});
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
					art.dialog({title: '提示',content:'异地登陆验证已开启~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
					$('.switch .imgico').removeClass('dv_sp0').addClass('dv_sp1');
				}
			});
		}
		else
		{
			art.dialog({title : '提示', fixed : true, lock : true,
					content : '您如果关闭异地登录，账户就可能存在账号资金被盗的风险，确定要关闭吗？',
					okValue : '确定',
					ok : function(){
						$.post('user.php?act=setotlog', {otlog:0}, function(data){
							if(parseInt(data) == 1)
							{
								art.dialog({title: '提示',content:'异地登陆验证已关闭~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
								$('.switch .imgico').removeClass('dv_sp1').addClass('dv_sp0');
							}
						});					
					},
					cancelValue : '取消',
					cancel : {}
				});
			
		}
	});
	var _wrap=$('.trends ul.line');
	var _interval=500;
	var _moving;
	_wrap.hover(function(){
		clearInterval(_moving);
	},function(){
		_moving=setInterval(function(){
			var _field=_wrap.find('li:first');
			var _h=_field.height();
			_field.animate({marginTop:-_h+'px'},600,function(){
				_field.css('marginTop',0).appendTo(_wrap);
			})
		},_interval)
	}).trigger('mouseleave');

})

var timer = null;
function getSmsCode(ele)
{
	var phone = $("#sendPhone");
	if(/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/.test(phone.val()) == false)
	{
		phone.css('border','1px solid red'); return false;
	}else{
		phone.css('border','1px solid #ddd');
	}
	$(ele).parent().next(".sountcode").find("span").attr("onclick","")
	//art.dialog({id:"ajaxStart",title: '正在处理中...',fixed: false,lock:true,time:2000,initFn:function(){this.lock().time(5); return false;}});
	$.post('user.php?act=mprz',{"phone":phone.val()},function(obj){
		//art.dialog.get('ajaxStart').close();
		if(obj.state){
			$.post('plugins.php?act=sendsmscode', {"phone":obj.info}, function(data){
				clearTimeout(timer);
				art.dialog({title:'提示', content:data.info, fixed:true, lock:true,time:2000});
				var SysSecond = 180;
				//if(data.time){
				//	SysSecond=data.time;
				//}
				var tim = setInterval(function(){
					if(SysSecond > 0){ 
						window.mo=1;
						$("#yy").hide();
						SysSecond = SysSecond - 1; 
						var second = Math.floor(SysSecond);// 计算秒 
						$(".getvcode").html('<input id="get_vcode" type="button" value="'+SysSecond+'秒后重新获取">');
					}else{
						window.mo=0;
						clearInterval(tim);
						$("#yy").show();
						$(".getvcode").html('<input id="get_vcode" type="button" value="短信获取" onclick="getSmsCode();">');
						setClick($(".sountcode span"),"getSoundCode(this);");
					} 
				}, 1000);	
			}, 'json');
		}else{
			art.dialog({title: '提示',content: obj.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
		}
	},'json');
}



function getSoundCode(ele)
{
	var phone = $("#sendPhone");
	if(/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/.test(phone.val()) == false)
	{
		phone.css('border','1px solid red'); return false;
	}else{
		phone.css('border','1px solid #ddd');
	}
	$(ele).parent().prev(".getvcode").find("input").attr("onclick","")
	//art.dialog({id:"ajaxStart",title: '正在处理中...',fixed: false,lock:true,time:2000,initFn:function(){this.lock().time(5); return false;}});
	$.post('user.php?act=mprz',{"phone":phone.val()},function(obj){
		clearTimeout(timer);
		if(obj.state){
		art.dialog({
		title: '语音验证码',
		content: '您将收到语音电话，请根据语音提示输入验证码！',
		fixed: true,
		lock: true,
		okValue:'确定',
		cancelValue:'取消',
		ok : function(){
				//art.dialog({id:"ajaxStart",title: '正在拨号中..',fixed: true});
				$.post('plugins.php?act=sendsoundcode', {"phone":obj.info}, function(data){
					//art.dialog.get('ajaxStart').close();
					art.dialog({title: '提示',content: data.info,fixed: true,lock: true});
					var SysSecond = 180;
                    var test = SysSecond;
					/*if(data.time){
						SysSecond=data.time;
					}*/
					var tim = setInterval(function(){
						if(SysSecond > 0){ 
							window.mo=2;
							$("#get_vcode").hide();
							SysSecond = SysSecond - 1; 
							var second = Math.floor(SysSecond);// 计算秒 
							$(".sountcode").html('<span>'+test+'秒后重新获取</span>');
						}else{
							window.mo=0;
							$("#get_vcode").show();
							clearInterval(tim);
							$(".sountcode").html('<span onclick="getSoundCode();">语音获取</span>');
							setClick($(".getvcode input"),"getSmsCode(this)");
						} 
					}, 1000);

				}, 'json');
				},
				cancel:function(){return true;}
			});
		}else{
			art.dialog({title: '提示',content: obj.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
		}
	},'json');
}

function setClick(ele,funStr){
	timer = setTimeout(function(){
		$(ele).attr("onclick",funStr);
	},500)
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
	$.post('user.php?act=mprz',{"phone":phone.val()},function(obj){
		if(obj.state){
			var sms = $("#getCode");
			if(sms.val() == ""){
				sms.css('border','1px solid red');
				return false;
			}else{
				sms.css('border','1px solid #ddd');
			}

			art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});

			$.post('plugins.php?act=checkcode', {code:sms.val(), mod:'mprz','phone':obj.info}, function(data){
				art.dialog.get('ajaxStart').close();
				art.dialog({title:'提示', content:data.info, fixed:true, lock:true, okValue:'确定', cancelValue:'取消',
						  ok : function(){location.reload();},
						  cancel : function(){return true;}
				});
			}, 'json');
		}else{
			art.dialog({title: '提示',content: obj.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
		}
	},'json');
}
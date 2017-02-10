function getSmsCode()
{
	art.dialog({id:"ajaxStart",title: '正在处理中...',fixed: true});

	$.post('plugins.php?act=sendsmscode', {}, function(data){
		art.dialog.get('ajaxStart').close();
		art.dialog({title:'提示', content:data.info, fixed:true, lock:true});

		var SysSecond = 180;
		var tim = setInterval(function(){
					if(SysSecond > 0){ 
						SysSecond = SysSecond - 1; 
						var second = Math.floor(SysSecond);// 计算秒 
						$("#getvcode").html('<input class="card_button" id="get_vcode" type="button" value="'+SysSecond+'秒后重新获取">'); 
					}else{
						clearInterval(tim);
						$("#getvcode").html('<input class="card_button" id="get_vcode" type="button" value="短信获取" onclick="getSmsCode();">');
					} 
			  	}, 1000);	
	}, 'json');
}

function getSoundCode()
{		
	art.dialog({
		title: '语音验证码',
		content: '您将收到语音电话，请根据语音提示输入验证码！',
		fixed: true,
		lock: true,
		okValue:'确定',
		cancelValue:'取消',
		ok : function(){
				art.dialog({id:"ajaxStart",title: '正在拨号中..',fixed: true});

				$.post('plugins.php?act=sendsoundcode', {}, function(data){
						art.dialog.get('ajaxStart').close();
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true});

						var SysSecond = 180; 			    	
					  	var tim = setInterval(function(){
					  		if(SysSecond > 0){ 
								SysSecond = SysSecond - 1; 
								var second = Math.floor(SysSecond);// 计算秒 
								$(".sountcode").html('<span>'+SysSecond+'秒后重新获取</span>'); 
							}else{
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

	art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});

	$.post('plugins.php?act=checkcode', {code:sms.val(), act:'mjh'}, function(data){
			art.dialog.get('ajaxStart').close();
			art.dialog({title:'提示', content:data.info, fixed:true, lock:true, okValue:'确定', cancelValue:'取消',
					  ok : function(){location.reload();},
					  cancel : function(){return true;}
					});
		}, 'json');
}
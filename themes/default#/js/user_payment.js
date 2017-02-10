$(function(){
	$("#add_bank_btn").click(function(){
		var data=$(this).attr('data');
		if(data==0){
			$.dialog({id:'payment', title:'温馨提示', lock:true,
				content : '请先在<a href="user.php" style="color:red">会员中心</a>激活手机~',
				ok : function(){
					location.href="user.php";
				},
				okValue : '确定',
				fixed:true}
			);
		}else{
			$.dialog({id:'payment', title:'添加提现卡号', lock:true,
				content : getTpl('user.php?act=addcard'),
				ok : function(){
				var bank_name = $('select option:selected').val();
				var bank_user = $('input[name=bank_user]').val();
				var bank_num = $('input[name=bank_num]').val();
				var smscode = $('input[name=vcode]').val();
				if(bank_user == ""){
					if(bank_name==13){alert("请填写支付宝名称");}else{alert("请填写真实姓名");} return false;
				}
				/*if(!/^[\u4e00-\u9fa5].+$/gi.test(bank_name)){
					$.dialog({title: '提示',content: '真实姓名含有非汉字字符',fixed: true,lock: true});return false;
				}*/
				if(bank_name==13){
					if(bank_num == ""){
						alert("请填写正确的支付宝账户"); return false;
					}
				}else{
					if(bank_num == "" || !(/\d{16,20}/.test(bank_num))){
						alert("请填写正确的银行帐号"); return false;
					}
				}
				if(smscode == ""){
					alert("请填写短信验证码"); return false;
				}

				$.post('user.php?act=addcard', {bank_name:bank_name, bank_user:bank_user, bank_num:bank_num, smscode:smscode}, function(data){
					if(data.code == 0){
						self.location.reload();
					}else{
						alert(data.info);
						return false;
					}							
				}, 'json');
				return false;
			},
			cancel : {},
			okValue : '确定',
			cancelValue : '取消',
			fixed:true
			});
		}
	});
	$('.js-bank-list').click(function(){
		if($(this).hasClass('check_xu')){
			var self = $(this);
			$.dialog({
				title: '提示',
				content: $("#cashss").html(),
				fixed: true,
				lock: true,
				okValue: '确定',
				cancelValue: '取消',
			    ok: function () {
					var c = $("input[name='radiobutton']:checked").attr('cdata');
					arr = c.split("|");
					$.post('user.php?act=payment&opt=state',{"bank":arr[0]},function(data){
						if(data.state){
							location.href="user.php?act=payment";
						}
					},'json');
			    },
			    cancel: function () { return true;}
			});
			$(".deleteCash").click(function(){
				var c = $(this).parent().parent().children("td:first").children("input[name='radiobutton']").attr('cdata');
				var t=$(this).parent().parent();
				arr = c.split("|");
				$.dialog({
					id : 'clear',
					title: '提示',
					content: '您确定要移除该提现卡号吗?',
					fixed: true,
					lock: true,
					okValue: '确定',
					cancelValue: '取消',
					ok: function () {
						$.post('user.php?act=payment&opt=del',{"bank":arr[0]},function(data){
							if(data.state){
								t.remove();
							}
						},'json');
					},
					cancel: function () { return true;}
				});
			});
			$(".xcont").click(function(){
				var c = $(this).parent().parent().children("td:first").children("input[name='radiobutton']").attr('cdata');
				arr = c.split("|");
				type = 0;
				if(type == 0){
					title = '银行卡号';
				}
				if(type == 2){
					title = '财付通账号';
				}
				if(type == 1){
					title = '淘宝提现地址';
				}
				$.dialog({
					title: '修改信息['+title+']',
					content: '<p>旧的'+title+'：'+arr[2]+'</p><p>新的'+title+'：<input name="Nroot" type="text" maxlength="100" size="50"></p>',
					fixed: true,
					lock: true,
					okValue: '确定',
					cancelValue: '取消',
					ok: function () {
						cont = $("input[name='Nroot']").val();
						if(arr[1]==13){
							if(cont == ''){ 
								$.dialog({id:'ts', title: '提示',content: '请填写正确的支付宝账户~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});
								return false;
							}
						}else{
							if(cont == '' || !(/\d{16,20}/.test(cont))){ 
								$.dialog({id:'ts', title: '提示',content: '请填写正确的银行帐号~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});
								return false;
							}
						}

						$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true,lock: true});
						$.post('user.php?act=payment&opt=xcont',{"bank":arr[0],"cont":cont,'type':arr[1]},function(data){
							$.dialog.get('ajaxStart').close();
							$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { location.reload(); }});
						},'json');
					},
					cancel: function () { return true;}
				});
			});
			$('.imgbak').click(function(){
				$(this).prev('input').attr('checked',true);
			});
		}
		else{
			$(".js-bank-list").removeClass('check_xu');
			$(this).addClass('check_xu');
			var type = $(this).attr('val');
			var ele1 = $(".ele1").html();
			if(type == 3 || type == 6){
				ele1 = ele1.replace("预计3小时内到账","预计5小时内到账");
				$(".ele1").html(ele1);
			}else{
				ele1 = ele1.replace("预计5小时内到账","预计3小时内到账");
				$(".ele1").html(ele1);
			}
		}
	});
		$('#amount').keyup(function(){
			var money = parseFloat($(this).val());
			var premium = 0;
			var count = parseInt($("#yesmoney").val());
			if(money){
	           	if(money < 100){
					var nc = '本次提现金额为：<b style="color:red;">'+money+'</b>元，手续费<b style="color:red;">2</b>元，实际到账<b style="color:red;">'+(money-2)+'</b>元。<a href="javascript:;" style="margin-left: 10px;color: red;text-decoration: underline;" id="shimoe" onclick="shimoe('+count+');">与实际余额不符？</a><br><span style="color:#B4B4B4;">（100元以上提现免手续费）</span>';
				}else{
					var nc = '本次提现金额为：<b style="color:red;">'+money+'</b>元，实际到账<b style="color:red;">'+money+'</b>元。<a href="javascript:;" style="margin-left: 10px;color: red;text-decoration: underline;" id="shimoe" onclick="shimoe('+count+');">与实际余额不符？</a><span style="color: #0078B6;margin-left: 15px;">预计3小时内到账</span><br><span style="color:#B4B4B4;">（100元以上提现免手续费）</span>';
				}
			}else{
				var nc = '可提现余额: <b style="color:red;">'+count+'</b> 元 <a href="javascript:;" style="margin-left: 10px;color: red;text-decoration: underline;" id="shimoe" onclick="shimoe('+count+');">与实际余额不符？</a><span style="color: #0078B6;margin-left: 15px;">预计3小时内到账</span>';
			}
           	$('.ele1').html(nc);
		});

		$('.tjsq_btn').click(function(){
			var oneSelf = this;
			var m = $("#amount").val();
			var s = $("input[name='payment_app_sms']:checked").val();
			var cont = $(".element .check_xu").attr('cdata');
			arr = cont.split("|");
			var sy = parseInt($("#yesmoney").val());
			if(m ==''){
				$.dialog({id:'mention', title: '提示',content: '提现金额不能为空~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
			}

			if(m > sy){
				$.dialog({id:'mention', title: '提示',content: '对不起，您填写的提现金额大于可提现余额~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
			}
			if(cont == undefined){
				$.dialog({
					id:'mention', 
					title: '提示',
					content: '请您先绑定提现卡号或者地址再申请提现~',
					fixed: true,
					lock: true,
					cancelValue: '确定',
					cancel: function () { 
						$("#add_bank_btn").click();
						return true;
					}
				});
				return false;
			}
			if(m < 100){
				var content = '您好，你提现的金额为 <b style="color:red;">￥'+m+'</b>，手续费<b style="color:red;">￥2</b> 元<hr></hr>普通用户提现金额低于100元，需要支付提现手续费2元。<br>商保用户、VIP用户 免手续费。<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>';
			}else{
				var content = '您好，你提现的金额为 <b style="color:red;">￥'+m+'</b><hr></hr>普通用户提现金额低于100元，需要支付提现手续费2元。<br>商保用户、VIP用户 免手续费。<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>';
			}
			
			$.dialog({
				title: '友情提示',
				content: content,
				fixed: true,
				lock: true,
				okValue: '确定',
				cancelValue: '取消',
			    ok: function () {
			    	if($("#safecode").val() ==''){
						$.dialog({id:'mention', title: '提示',content: '请输入安全码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
					}
					$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true,lock: true});

			    	$.post('user.php?act=payment&opt=mention',{"mo":m, "sms":s,"bank":arr[0],"safecode":$("#safecode").val()},function(data){
			    		$.dialog.get('ajaxStart').close();
			    		if(data.status == 1){
			    			$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { location.href="user.php?act=payment_list";}});
			    		}else{
			    			$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
			    		}
			    	},'json');
			    },
			    cancel: function () { return true;}
			});

		});
});


function getTpl(url)
{
	var re = null;
	$.ajax({url : url,
			success : function(data){re = data;},
			dataType : 'text',
			async : false});
	return re;
}
function shimoe(moneys){
	var money = parseInt(moneys);
	var tmoney = money;
	if(money - tmoney < 0){
		var  newMoney = parseFloat(money).toFixed(2);
		tmoney = money;
	}else{
		var  newMoney = parseFloat(money-tmoney).toFixed(2);
	}
	$.dialog({
		title: '充值存款不予提现',
		content: '您的存款总额：<span style="color:red;margin: 0 3px;">'+money+'</span>元中，<span style="color:red;margin: 0 3px;">'+newMoney+'</span>元属于充值存款，为避免平台套现嫌疑，请您通过发布任务进行提现。<br>您目前可提现金额为：<span style="color:green;margin: 0 3px;">'+parseInt(tmoney)+'</span>元，请修改后再进行提现。',
		fixed: true,
		lock: true,
		okValue: '确定',
		cancelValue: '取消',
		ok: function () {},
		cancel: function () { return true;}
	});
}
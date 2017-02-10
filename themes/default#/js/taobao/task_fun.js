function getTask(obj)//大厅刷新
{	
	$("#tloading").show();
	$.get("taobao.php?mod=gettask", obj, function(data, status){
		if(data){
			$("#tloading").hide();
		}
		$("#taskList").html(data);
	});
}

function getTasksearch(type)//大厅搜索
{	
	if(type){
		var search=$("#taskinfo").val();
		if(search){
			$("#tloading").show();
			$.get("taobao.php?mod="+type+"&search="+search,  function(data, status){
				if(data){
					$("#tloading").hide();
				}
				$("#taskList").html(data);
			});
		}
	}
}

function getTaska(a,id)
{	
	if(id==1){
		$("#rwdt_lx a").removeClass('nov');
		$(a).addClass('nov');
	}
	if(id==2){
		$("#rwdt_jg li a").removeClass('nov');
		$(a).addClass('nov');
	}
}

function getinTask(get)//已接刷新
{
	$("#tloading").show();
	$.get("taobao.php?mod=getinTask", get, function(data, status){
		
		if(data){
			$("#tloading").hide();
		}
		$("#taskList").html(data);
	});
}

function getinTaskb(obj)
{
	if(obj=='operat'){
		$(".btn_blue").show();
	}else{
		$(".btn_blue").hide();
	}
	$(".sbico").removeClass('active');
	$("."+obj).addClass('active');
	$(".sbicos").hide();
	$("#"+obj).show();
	if(obj=='operat'){
		$("input[name='process']").val('1');
	}
	if(obj=='complete'){
		$("input[name='process']").val('2');
	}
	if(obj=='all-task'){
		$("input[name='process']").val('3');
	}
	if(obj=='pause'){
		$("input[name='process']").val('4');
	}	
}


function getTasks(mod,obj){
	if($("input[name='desc']").val()=='desc'){
		$("input[name='desc']").val('asc');
	}else{
		$("input[name='desc']").val('desc');
	}
	var desc=$("input[name='desc']").val();
	$.get("taobao.php?mod="+mod+"&order="+obj+"&desc="+desc, function(data, status){
		$("#taskList").html(data);
	});
}
function getTasksa(mod,obj){
	if($("input[name='desc']").val()=='desc'){
		$("input[name='desc']").val('asc');
	}else{
		$("input[name='desc']").val('desc');
	}
	var desc=$("input[name='desc']").val();
	var process=$("input[name='process']").val();
	$.get("taobao.php?mod="+mod+"&order="+obj+"&desc="+desc+"&process="+process, function(data, status){
		$("#taskList").html(data);
	});
}


function getoutTask(get)//已发刷新
{	
	$("#tloading").show();
	$.get("taobao.php?mod=getoutTask", get, function(data, status){
		if(data){
			$("#tloading").hide();
		}
		$("#taskList").html(data);
	});
}

function qiang(id){//抢任务
	
	if(id){
		$.get("taobao.php?mod=qiang&id="+id, function(data, status){
			if(data=='no'){
				$.dialog({title : '请绑定买号',
				  content : '抱歉，您没有可以使用的买号',
				  okValue : "绑定买号",
				  ok : function(){
							location.href="taobao.php?mod=bindBuyer"
				  },
				cancelValue : "取消",
				cancel : {},
				 
				  lock : true});
			}else{
			var win = $.dialog({title : '请选择买号',
				  content : data,
				  okValue : "确定",
				  ok : function(){
					if(data!='不允许接自己发布的任务'){
							$.get("taobao.php?mod=qiang&id="+id+"&gid="+$("input[name='buyer']:checked").val(), function(data, status){
								if(data){
								$.dialog({
								id:'id-info',
								content:data,
								 lock:true,
								 title:'新手支付提醒',
								 button : [
									{id:"button-know",callback:{},value:'知道了 (5)',focus: true,disabled: true}
								 ],
								 ok : null
							});}

							var dialog = $.dialog.get('id-info');
							var i = 5;
							var timer = setInterval(function () {
							    i--;
							    dialog.button({
							        id: 'button-know',
							        value: '知道了 (' + i + ')',
							        disabled: true
							    });
							    
							    if (i === 0) {
							        clearInterval(timer);
							        dialog.button({
							            id: 'button-know',
							            value: '知道了',
							            disabled: false
							        });
									dialog.ok(location.href="taobao.php?mod=inTask");
							    };
							}, 1000);
							});}
						},
				cancelValue : "取消",
				cancel : {},
				 
				  lock : true});
			}
		});	
	}
}
function payment(id){//已付款
	if(id){
			$.get("taobao.php?mod=getinTask&payment="+id,function(data,status){
				var con="<p style='color:red;'>【注意】该任务为立即好评任务</p><p>请确保淘宝上已经支付货款后，才进行平台确认，否则一经投诉，将做封号处理！</p>";
				if(data=='need'){
					con+="<p style='margin-top: 10px;'><span style='color:#fe5500;'>此任务需要上传商品浏览底图</span></p><iframe src='upload.php?payment="+id+"' width='350' height='120' frameborder='0' name='frm'></iframe>";
				}
				$.dialog({title : '温馨提示',
				  content : con,
				  okValue : "确定",
				  ok : function(){
						if(data=='need'){
							var has=$(window.frames["frm"].document).find("#has").val();
							if(has==1){
								$.get("taobao.php?mod=getinTask&payment="+id+"&f=1", function(data, status){
									getinTask();
								});
							}else{
								$.dialog({title : '温馨提示',
								  content : "此任务需要上传商品浏览截图",
								  okValue : "确定",
								  ok : function(){
										return true;
								},
								lock : true});
							}
						}else{
							$.get("taobao.php?mod=getinTask&payment="+id+"&f=1", function(data, status){
								if(data=='ok'){
									getinTask();
								}
							});
						}
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
			});
	}
}
function nopayment(id){//取消已付款
	if(id){
			$.dialog({title : '温馨提示',
				  content : "您确认要选择未支付吗？",
				  okValue : "确定",
				  ok : function(){
					$.get("taobao.php?mod=getinTask&nopayment="+id, function(data, status){
								getinTask();
					});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}
function task_out(obj,id){//任务退出
	if(id){
			$.dialog({title : '温馨提示',
				  content : "确认要退出该任务吗",
				  okValue : "确定",
				  ok : function(){
					$.get("taobao.php?mod=task_out&id="+id, function(data, status){
						getinTask();
					});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}
function getTaobaourl(id){//查看商品地址
	if(id){
			$.get("taobao.php?mod=getTaobaourl&id="+id, function(data, status){
				$.dialog({title : '温馨提示',
				  content : data,
				  okValue : "打开地址",
				  ok : function(){
						window.open(data);
					},
				cancelValue : "取消",
				cancel : {},
				lock : true});
				
			});
			
	}
}

function praise(id){//好评
	if(id){
			$.dialog({title : '温馨提示',
				  content : "您确认已好评该商品吗？",
				  okValue : "确定",
				  ok : function(){
				$.get("taobao.php?mod=getinTask&praise="+id, function(data, status){
							location.reload();
				});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}


function stop(id){//暂停
	if(id){
			$.dialog({title : '温馨提示',
				  content : "您确认要暂停此任务吗？",
				  okValue : "确定",
				  ok : function(){
						$.get("taobao.php?mod=getoutTask&stop="+id, function(data, status){
								getoutTask();
						});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}
function yifa(id,un){//已发货
	if(id){
			$.dialog({title : '温馨提示',
				  content : '<div style="width:420px"><p style="float: left;color: #000;font-size: 14px;">请确认买家账号：<a style=" font-size: 15px; font-weight: bold; color: #0085FF; " href="">'+un+'</a>  是否已经拍下付款，确认立即在网店发货吗？</p><p style="color: #888888; float: left; width: 100%;margin-top: 10px;">如果没有付款请勿发货，<span style=" color: #F33737;">要求您发货，索要账号密码、验证码的客服都属于假客服，切勿相信。</span>买家长时间不拍下付款请进行<a href="" style="font-size: 13px;font-weight: bold;color: #3995E9;">投诉处理</a>。</p></div>',
				  okValue : "确定",
				  ok : function(){
						$.get("taobao.php?mod=getoutTask&yifa="+id, function(data, status){
								$.dialog({title : '温馨提示',
								  content : "恭喜，您已发货成功！",
								  okValue : "确定",
								  ok : function(){
									return true;
								},
								lock : true});
								getoutTask();
						});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}

function queren(id){//确认收货
	if(id){
			$.dialog({title: false,
				  padding:0,
				  content : '<strong class="red"><img width="520" height="211" src="themes/default/images/head-loading.gif"></strong>',
				  okValue : "确定",
				  ok : function(){
						$.get("taobao.php?mod=getoutTask&queren="+id, function(data, status){
								getoutTask();
						});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}
function huifu(id){//恢复
	if(id){
			$.dialog({title : '温馨提示',
				  content : "您确认恢复此任务吗？",
				  okValue : "确定",
				  ok : function(){
						$.get("taobao.php?mod=getoutTask&huifu="+id, function(data, status){
								location.reload();
						});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}

function remarks(txt,id){//备注
	if(id){
		$.dialog({title : '备注（最多255个字）',
				  content : "<textarea id='txtremark' cols='50' rows='10'>"+txt+"</textarea>",
				  okValue : "确定",
				  ok : function(){
						var remarks=$("#txtremark").val();
						$.get("taobao.php?mod=remarks&id="+id+"&remarks="+remarks, function(data, status){
								$.dialog({title : '备注（最多255个字）',
								  content : "备注成功",
								  okValue : "确定",
								  ok : function(){
										location.reload();
								},
								lock : true});	
						});
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}
function copys(info){
	if(info){
		var win=$.dialog({title : '温馨提示',
				  content : info,
				  okValue : "确定",
				  ok : function(){
						win.close();
				},
				lock : true});
	}
}


    

/*
    function SetRemainTime(){
		$(".time").each(function(){
			var time=$(this).attr('time');
			var txt;
			if( time> 0){
				if (time < 60) {
					var s = time;
					txt = s + '秒';
				} else if (time > 60 && time < 3600) {
					var m = parseInt(time / 60);
					var s = parseInt(time % 60);
					txt = m + "分" + s + "秒";
				} else if (time >= 3600 && time < 86400) {
					var h = parseInt(time / 3600);
					var m = parseInt(time % 3600 / 60);
					var s = parseInt(time % 3600 % 60 % 60);
					txt = h + "时" + m + "分" + s + "秒";
				} else if (time >= 86400) {
					var d = parseInt(time / 86400);
					var h = parseInt(time % 86400 / 3600);
					var m = parseInt(time % 86400 % 3600 / 60)
					var s = parseInt(time % 86400 % 3600 % 60 % 60);
					txt = d + '天' + h + "时" + m + "分" + s + "秒";
				}
				$(this).html(txt);
				$(this).attr('time',time-1);
			}
			else{
				$(this).html('');
				clearInterval(InterValObj);
			}
		});
	}*/
	
    function SetRemainTime(){
		var nums=0;
		$(".time").each(function(){if($(this).attr('time')>0){nums++;}});
		var num=0;
		$(".time").each(function(){
			var time=$(this).attr('time');
			var txt;
			if( time> 0){
				if (time < 60) {
					var s = time;
					txt = s + '秒';
				} else if (time > 60 && time < 3600) {
					var m = parseInt(time / 60);
					var s = parseInt(time % 60);
					txt = m + "分" + s + "秒";
				} else if (time >= 3600 && time < 86400) {
					var h = parseInt(time / 3600);
					var m = parseInt(time % 3600 / 60);
					var s = parseInt(time % 3600 % 60 % 60);
					txt = h + "时" + m + "分" + s + "秒";
				} else if (time >= 86400) {
					var d = parseInt(time / 86400);
					var h = parseInt(time % 86400 / 3600);
					var m = parseInt(time % 86400 % 3600 / 60)
					var s = parseInt(time % 86400 % 3600 % 60 % 60);
					txt = d + '天' + h + "时" + m + "分" + s + "秒";
				}
				$(this).html(txt);
				var times=time-1;
				$(this).attr('time',times);
				
			}else{
				num++;
				$(this).html('');
				if(num==nums){clearInterval(InterValObj);}
			}
		});
	}
 function shenshu(id){//申诉
	if(id){
		var win=$.dialog({title : '任务申诉',
				  content : "<iframe src='taobao.php?mod=appeal&id="+id+"' width='550px' height='370px' frameborder='0' scrolling='no' name='con' id='con'></iframe>",
				  okValue : "确定",
				  ok : function(){
						var info=$(window.frames["con"].document).find("#explain-title").val();
						if(info==''){
							var x=$.dialog({title : '任务申诉',content : '请选择投诉类型',okValue : "确定",ok : function(){x.close();win.show();},lock : true});
							win.show();
						}
						else{
							var content=con.window.imgcheck();
							if(content==0){
								var y=$.dialog({title : '任务申诉',content : '投诉必须上传图片！',okValue : "确定",ok : function(){y.close();win.show();},lock : true});
								return false;
							}else{
								$.post('taobao.php?mod=appeal',{"id":id,"info":info,"content":content},function(data){
									if(data.state){
										$.dialog({title: '提示',content: data.info,fixed: true,lock: true,okValue:'确定',ok:function(){location.reload(); return true; }});
									}else{
										var aa=$.dialog({title: '提示',content: data.info,fixed: true,lock: true,okValue:'确定',ok:function(){aa.close();win.show();}});
									}
								},'json');
								win.show();
							}
						}
						
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
			
	}
 }

function cancel(id){//取消
	if(id){
		$.getJSON("?mod=task_cancel",{task_id:id},function(data,model){
			$.dialog({title : '温馨提示',
				  content : data.info,
				  okValue : "确定",
				  ok : function(){
						if(data.ok=='true'){
							location.href="?mod=outTask";
						}
						return true;
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
		});
	
	}
}

function zuijia(id){//追加
	if(id){
		$.dialog({title : '温馨提示',
				  content : '追加麦点：<input id="pointExt" type="text" size="8/"> 个麦点',
				  okValue : "确定",
				  ok : function(){
						var point = parseInt($("#pointExt").val());
						if(!point || point <=0 || point > 20 ){
							$.dialog({title : '温馨提示',
								id :'ts',
								width:240,
								content:'追加麦点不能小于1个或大于20个',
								ok:false,
								cancelValue:'关闭',
								cancel:function(){
									return true;
								}
							});	
							return false;
						}else{
							$.getJSON("?mod=task_addpay",{point:point,task_id:id},function(data,model){
										$.dialog({title : '温馨提示',
											  content : data.info,
											  okValue : "确定",
											  ok : function(){
													if(data.ok=='true'){
														location.href="?mod=outTask";
													}
													return true;
											},
											cancelValue : "取消",
											cancel : {},
											lock : true});
							});
						}
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});

		
	
	}
}

function news(id){//换接手方
	if(id){
		$.dialog({title : '温馨提示',
		  content : '你确认要换接手方吗？',
		  okValue : "确定",
		  ok : function(){
				$.get('?mod=substitution',{id:id},function(data,status){
					if(data=='ok'){
						location.href="?mod=outTask";
					}
					return true;
				});

		},
		cancelValue : "取消",
		cancel : {},
		lock : true});

	}
}
function shenhe(id){//审核
	if(id){
		$.dialog({title : '温馨提示',
		  content : '你确认要审核接手方吗？',
		  okValue : "确定",
		  ok : function(){
				$.get('?mod=examine',{id:id},function(data,status){
					if(data=='ok'){
						location.href="?mod=outTask";
					}
					return true;
				});

		},
		cancelValue : "取消",
		cancel : {},
		lock : true});

	}
}
function imgs(file){//查看图片
	if(file){
		$.dialog({title : '查看图片',
		  content : '<img src="'+ file +'">',
		  okValue : "确定",
		  ok : function(){
					return true;
		},
		lock : true});

	}
}

function haoimg(id){//好评图片
	if(id){
		$.dialog({title : '温馨提示',
		  content : '<div style="width:360px"><div class="up"><p style="line-height: 20px;">任务属性包含了上传好评截图(512KB以内)，请您用买号登陆淘宝：<br>我的淘宝——我是买家——评价管理——给他人评价——截取任务对应的好评内容，保存到桌面并上传！<br> <font color="#cccccc">（就是发布者要求你对他商品评价的内容）</font></p><p></p><br><div><span class="uploadImg"><iframe src="haoping.php?pid='+id+'" width="350" height="120" frameborder="0" name="frm"></iframe></span><span class="upload-info green" id="info-upfile-1"></span></div></div></div>',
		  okValue : "确定",
		  ok : function(){
				var has=$(window.frames["frm"].document).find("#has").val();
				if(has==1){
					$.get('?mod=getinTask&pinimage='+id,function(data,status){
						if(data=='ok'){
							$.dialog({title : '查看图片',
							  content : '恭喜，上传好评截图成功!',
							  okValue : "确定",
							  ok : function(){
								getinTask();
								return true;
							},
							lock : true});
						}
					});
				}else{
					$.dialog({title : '温馨提示',
					  content : "此任务需要上传好评图片",
					  okValue : "确定",
					  ok : function(){
							return true;
					},
					lock : true});
				}
			return true;
		},
		cancelValue : "取消",
		cancel : {},
		lock : true});
		
	}
}

function pingtu(id){//评图
	if(id){
		$.getJSON('?mod=getoutTask',{"pin":id,"opt":"h"},function(data,status){
			if(data){
			var win = $.dialog({title : '温馨提示',
				  content : '<img src="'+data.url+'">',
				  okValue : "通过",
				  ok : function(){
						$.get('?mod=getoutTask',{"pin":id,"opt":"y"},function(data,status){
							if(data=='ok'){
								$.dialog({title : '温馨提示',
								  content : '确认通过后，会自动确认任务完成，确定要继续执行吗？',
								  okValue : "确定",
								  ok : function(){
											queren(id);
											return true;
								},
								cancelValue : "取消",
								cancel : function(){location.href="?mod=outTask";},
								lock : true});

							}
							return true;
						});

				},
				lock : true});
				win.button({value:'不通过', callback:function(){$.get('?mod=getoutTask',{"pin":id,"opt":"n"},function(data,status){
						location.href="?mod=outTask";
						return true;
						});}});

			}
		});

	}
}

function pingjia(id){//评价
	if(id){
		$.get('?mod=pingjia&id='+id,function(data,status){
			$.dialog({title : '温馨提示',
			  content : data,
			  okValue : "确定",
			  ok : function(){
					var grade=$("input['name=grade']:checked").val();
					var remark=$("#remark").val();
					var isHide=0;
					if($("#isHide").is(':checked')){isHide=1;}
					
					$.post('?mod=pingjia&id='+id,{"grade":grade,"remark":remark,"isHide":isHide},function(data){
						alert(data);
						if(data=='ok'){
							$.dialog({title : '温馨提示',content : "恭喜，评论成功，谢谢您对好会刷平台所做的贡献",okValue : "确定",ok : function(){return true;},lock : true});	
						}
						return true;
					});
					
			},
			cancelValue : "取消",
			cancel : {},
			lock : true});
		
		});
	}
}

function qq(qq){
	if(qq){
		$.dialog({title : '温馨提示',
				  content : "对方的QQ号为："+qq+"<br>临时会话信息会经常接收不到，请尽量把对方QQ加为好友。点击确定后为您转向临时会话。",
				  okValue : "确定",
				  ok : function(){
						location.href="tencent://message/?uin="+qq;
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}

function didan(id){//申请底单
	if(id){
		var win=$.dialog({title : '温馨提示',
			padding:0,
				  content : '<div id="d-content-id-info" class="d-content" style="padding: 20px 25px;"><p style="color:#1996E6;font-size: 13px;">申请底单需要额外支付2元，确定申请吗？</p><table width="250" border="0" align="center" cellspacing="0" cellpadding="0"><tbody><tr><th style="color:red;">发件人信息</th></tr><tr><td>发货地址：</td><td><input type="text" name="address" maxlength="150"></td></tr><tr><td>发货人：</td><td><input type="text" name="add_uer" maxlength="16"></td></tr><tr><td>发货电话号码：</td><td><input type="text" name="add_phone" maxlength="11"></td></tr><tr><th style="color:red;">其他信息</th></tr><tr><td>寄件时间点：</td><td><input style="cursor: pointer;" type="text" name="add_time" readonly="readonly" onclick="WdatePicker({isShowClear:false,dateFmt:\'yyyy-MM-dd HH:mm\'})"></td></tr><tr><td>寄件付款方式：</td><td><input type="text" value="卖家支付/到付" name="add_pay" maxlength="20"></td></tr><tr><td>运费：</td><td><input type="text" name="money" maxlength="10"></td></tr></tbody></table></div>',
				  okValue : "确定",
				  ok : function(){
						var task_id=id;
						var address=$("input[name='address']").val();
						var add_uer=$("input[name='add_uer']").val();
						var	add_phone=$("input[name='add_phone']").val();
						var	add_time=$("input[name='add_time']").val();
						var	add_pay=$("input[name='add_pay']").val();
						var	money=$("input[name='money']").val();
						if(task_id=='' || address=='' || add_uer=='' || add_phone=='' || add_time=='' || add_pay=='' || money==''){
							$.dialog({title : '温馨提示',content : "底单信息填写不完整！",okValue : "确定",ok : function(){return true;},lock : true});	
						}else{
							
						}
				},
				cancelValue : "取消",
				cancel : {},
				lock : true});
	}
}

function seedidan(id){//查看底单
	if(id){
		$.get('',function(data,status){
			$.dialog({
				title:'查看底单',
				content:self.model.get('singleImg'),
				okValue: '确认',
				ok:function(){
					return true;
				},
				cancel:false
			});
			$(".d-buttons").prepend('<p style="float:left;color: #1996E6;margin: 5px;">请右击图片将图片另存为到桌面</p>');
		});
		
	}
}

function gmdh(id,name){//购买快递单号
	if(id){
		$.dialog({
				title:'温馨提示',
				content:'<div style="width:400px"><p style="float: left;color: #000;font-size: 14px;">请确认买家账号：<a style=" font-size: 15px; font-weight: bold; color: #0085FF; " href="">'+name+'</a>  是否已经拍下付款，确认立即在网店发货吗？</p><p style="color: #888888; float: left; width: 100%;margin-top: 10px;margin-bottom: 10px;">如果没有付款请勿发货，<span style=" color: #F33737;">要求您发货，索要账号密码、验证码的客服都属于假客服，切勿相信。</span>买家长时间不拍下付款请进行<a style="font-size: 13px;font-weight: bold;color: #3995E9;">投诉处理</a>。</p><p style="float: left;margin-top: 10px;font-size: 15px;margin-bottom: 10px;display:none;"><input id="isXitongdan" type="checkbox"><span style="vertical-align: baseline;color:#FF8F51;margin: 0 5px;">购买快递单号</span></p><p style="float: left; width: 100%;display:none;" class="xuanzdh" id="ksxz"></p><p style="height: 30px;float: left;width: 100%;" class="xuanzdh"><span style="width: 76px;float: left;text-align: right;">选择快递：</span><select id="nickname" name="wl"><option value="龙邦快递">龙邦快递[3~4天达](消耗4元)</option><option value="全峰快递">全峰快递[3~4天达](消耗3元)</option><option value="快捷快递">快捷快递[3~4天达](消耗3元)</option></select></p><p style="height: 30px;float: left; width: 100%;" class="xuanzdh c1"><span style="width: 76px;float: left;text-align: right;">发货人：</span><input name="addname" placeholder="如：李四" maxlength="5" type="text"></p><p style="height: 30px;float: left; width: 100%;" class="xuanzdh c2"><span style="width: 76px;float: left;text-align: right;">发货地址：</span><input name="send_add" type="text"></p><p style="height: 30px;float: left; width: 100%;" class="xuanzdh c7"><span style="width: 76px;float: left;text-align: right;">收货地址：</span><input name="to_add" type="text"></p><p style="height: 30px;float: left; width: 100%;" class="xuanzdh c8"><span style="width: 76px;float: left;text-align: right;">收货人：</span><input name="sendname" placeholder="如：张三" maxlength="5" type="text"></p><p style="height: 30px;float: left; width: 100%;" class="xuanzdh c9"><span style="width: 76px;float: left;text-align: right;">收货人手机：</span><input name="phone" maxlength="11" placeholder="如：13256541231" type="text"></p><p style="color:#999;float: left; width: 100%;" class="xuanzdh">单号信息不会立即显示，约每晚22点左右开始展现</p></div>',
				okValue: '确认',
				cancelValue : "取消",
				ok:function(){
					var wl=$("select[name='wl']").val();
					var addname=$("input[name='addname']").val();
					var send_add=$("input[name='send_add']").val();
					var to_add=$("input[name='to_add']").val();
					var sendname=$("input[name='sendname']").val();
					var phone=$("input[name='phone']").val();
					if(wl==''||addname==''||send_add==''||to_add==''||sendname==''||phone==''){
						$.dialog({title : '温馨提示',content : "购买底单信息填写不完整！",okValue : "确定",ok : function(){return true;},lock : true});	
					}else{
						$.get('?mod=gmdh',{"task_id":id,"wl":wl,"addname":addname,"send_add":send_add,"to_add":to_add,"sendname":sendname,"phone":phone},function(data,status){
							alert(data);
							location.href="?mod=outTask";
						});
					}

					return true;
				},
				cancel : {}
			});
	}
}

function hb(id){//货比三家
	if(id){
		$.post('?mod=hb',{'id':id},function(data,status){
			var win=$.dialog({
				id:'hb',
				title:'查看底单',
				content:data,
				okValue: '确认',
				ok:function(){	
					var n=0;
					var num=0;
					$(".url-upfile").each(function(){
						n=$(this).attr('alt');
						if($(this).val()==''){
							$.dialog({title : '温馨提示',content :'请上传货比第'+n+'家商品的截图！',okValue : "确定",ok : function(){return true;},lock : true});
							return false;
						}else{
							num+=1;
						}
						
					});
					if(num==n){
						$.dialog({id:'123',title : '温馨提示',content :'上传成功，请根据提示验证来路！',okValue : "确定",ok : function(){win.close();yz(id);return true;},lock : true});
						return false;
					}
					return false;
				},
				cancelValue : "取消",
				cancel:{}
			});
		});
	}
}

function addtime(id){//为对方加时间
if(id){
	$.dialog({
		title:'查看底单',
		content:'您确认要为买家加时间吗？每次操作增加10分钟!',
		okValue: '确认',
		ok:function(){
			$.post('?mod=getoutTask',{'addtime':id},function(data,status){
				if(data==1){
					getoutTask();
				}
			});
		},
		cancelValue : "取消",
		cancel:{},
		lock : true
	});
}}

function yz(id){//上传店内其他商品
	if(id){
		$.post('?mod=yz',{'id':id},function(data){
			$.dialog({
				title:'查看底单',
				content: data,
				okValue: '确认',
				ok:function(){	
					var goodsurl = $('#goodsurl').val();
					var img=0;
					if(ue){
						var expcont = ue.getContent();
						var expcontre = new RegExp("<img","g");
						var expcontarr = expcont.match(expcontre);
						var lxnum = $(".lxnum b").text();
						if(!expcontarr || expcontarr.length != lxnum){
							$.dialog({id:'temp-info',title : '温馨提示',content :'此任务需要额外上传该店内其他'+lxnum+'件商品的截图，才能验证商品！('+lxnum+'张截图)',okValue : "确定",ok : function(){return true;},lock : true});
							img=0;
							return false;
						}else{
							$.getJSON('taobao.php?mod=jt',{'shopBrGoods':expcont,'id':id},function(data){
								alert(data);
								if(data.error){
									$.dialog({id:'temp-infos',title : '温馨提示',content :data.error,okValue : "确定",ok : function(){return true;},lock : true});
								}else if(data.info){
									alert(data.info);
									img=1;
								}			
							});
						}
					}else{
						var expcont = "";
					}
					
					if (goodsurl==''){
						$.dialog({id:'temp-infos',title : '温馨提示',content :'商品URL不能为空',okValue : "确定",ok : function(){return true;},lock : true});
						return false;
					}
					var suess=$("#suess").html();
					if(suess=='商品地址验证成功！'&&img==1){
						return true;
					}else{
						$.dialog({id:'temp-infos',title : '温馨提示',content :'请验证商品地址',okValue : "确定",ok : function(){return true;},lock : true});
						return false;
					}

					return false;
				},
				cancelValue : "取消",
				cancel:{}
			});
		});
	}
}
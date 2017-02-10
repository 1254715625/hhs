$(function(){
	$("input[type='radio']").click(function(){
		 $(this).parents("div:first").find("input[type='checkbox']").attr("checked",true);
	});

	$(".addvalue input[type='text']").keydown(function(){
		 $(this).parents("div:first").find("input[type='checkbox']").attr("checked",true);
	}).blur(function(){
		if($(this).val()==''){
			$(this).parents("div:first").find("input[type='checkbox']").attr("checked",false);
		}
	});
	
	$("input[type='checkbox']").click(function(){
		if($(this).attr("checked")){
			if(!$(this).parents("div:first").find("input[type='radio']:checked").val()){
				$(this).parents("div:first").find("input[type='radio']:visible:first").attr("checked",true);
			}
		}else{
			$(this).parents("div:first").find("input[type='radio']").attr("checked",false);
		}
		 
		 //$(this).parents("div:first").find("input[type='checkbox']"ck).attr("checked",true);
	});

	$("#goodsurl").blur(function(){
		var url=$(this).val().replace(/&/gm,'@');
		$.get("taobao.php?mod=getgoodsprice&url="+url,function(data,status){
			if(data=='notfind'){
				$("#goodsurl").css({"border-color": "red", "color": "red"});
				$("#goodsurlexp").css({"color":"red"});
				$("#goodsurlexp").text('*请输入正确的URL商品地址');
				$("#goodsurl").val('');
				$("#goods_price").val('0');
			}
			else{
				var value=data;
				if(isNaN(value)||value==0){
					var win = $.dialog({title : '温馨提示',
					  content : '您的URL地址不正确！',
					  okValue : "确定",
					  ok : function(){
							$("#goodsurl").css({"border-color": "red", "color": "red"});
							$("#goodsurlexp").css({"color":"red"});
							$("#goodsurlexp").text('*请输入正确的URL商品地址');
							$("#goodsurl").val('');
							$("#goods_price").val('0');
							$("#txtMinMPrice").val('');
							if($("#txtMinMPrice").attr('space')==1){
								$("#txtMinMPrice").val('1');
							}
					  },
					  lock : true
					});
					
				}else{
					$("#goodsurl").css({"border-color": "#7C7C7C #C3C3C3 #C3C3C3 #9A9A9A", "color": "#FF5500"});
					$("#goodsurlexp").css({"color":"#999999"});
					$("#goodsurlexp").text('填写您要对方购买的商品地址，尽量使用不同商品来发布任务。');
					$("#goods_price").val(value);
					$("#txtMinMPrice").val(jiben($("#goods_price").val()));
					if($("#txtMinMPrice").attr('space')==1){
								$("#txtMinMPrice").val('1');
					}
				}
			}
		});
	})

	$("li.ligoods input[type='checkbox']").click(function(){
		$(".nyy-"+$(this).attr('show')).toggle(200);
	});

	$("li.ligoods a[name='delli']").click(function(){
		$(this).parents("li.ligoods").remove();
	});
			

	$("select#ddlOKDay").change(function(){
		var Additional = $(this).val();
		if(Additional>0)
		{
			$("#pOKDes").html("额外支出刷点<em>"+(Additional-1)+"</em>个");
		}
	});
	
	$("#isSign").click(function(){
			var selects=$("select#ddlOKDay option[value='0']");
			if(selects.val()==0){
				$("select#ddlOKDay option[value='0']").remove(); 
				$("select#ddlOKDay option[value='1']").remove(); 
			}
			else{
				$("select#ddlOKDay").prepend("<option value='1' selected='selected'>24小时好评实物任务(基本刷点×1.5+0)</option>");
				$("select#ddlOKDay").prepend("<option value='0' selected='selected'>马上好评（虚拟任务）</option>");
			}
	});

	$("input[name='Express']").click(function(){
		$("select#ddlOKDay option[value='0']").remove();
		$("select#ddlOKDay option[value='1']").remove();
	});

	$("#cbxIsTip").click(function(){
		$("#divTip").toggle(200);
	});

	$("#isZgh").click(function(){
		$("#guolv").toggle(200);
	});


	
	$("#txtTaoG").keyup(function(){  //keyup事件处理 
        var c=($(this).val().replace(/\D|^0/g,''));
		if(c!=$(this).val()){$(this).css({"border-color": "red", "color": "red","background-color":"#ff6699"});}
		$(this).val(c);
    }).bind("paste",function(){  //CTR+V事件处理 
        $(this).val($(this).val().replace(/\D|^0/g,''));  
    }).css("ime-mode", "disabled");  //CSS设置输入法不可用

	$("#txtSetTime").keyup(function(){  //keyup事件处理 
        var c=($(this).val().replace(/\D|^0/g,''));
		if(c!=$(this).val()){$(this).css({"border-color": "red", "color": "red","background-color":"#ff6699"});}
		else{$(this).css({"border-color": "#7C7C7C #C3C3C3 #C3C3C3 #9A9A9A", "color": "#FF5500","background-color":"#fff"});}
		$(this).val(c);
    }).bind("paste",function(){  //CTR+V事件处理 
        $(this).val($(this).val().replace(/\D|^0/g,''));  
    }).css("ime-mode", "disabled");  //CSS设置输入法不可用

	
	$("#txtTaoG").blur(function(){
		if($(this).val() % 10 != 0 || $(this).val() > 300){
			$(this).val('');
			$(this).css({"border-color": "red", "color": "red","background-color":"#ff6699"});
			$(this).focus();
		}
		else{
			$(this).css({"border-color": "#7C7C7C #C3C3C3 #C3C3C3 #9A9A9A", "color": "#FF5500","background-color":"#fff"});
		}
	});
	
	$("#txtMessage").click(function(){
		if($(this).val()=='此处填写您希望接手人对您的任务商品的评语内容，例如：“掌柜妹妹很热情，发货速度很快，商品拿到了,感觉比图片上还要漂亮”。请不要填写“请带字好评”等引导的文字'){
			$(this).val('');
		}
	}).keydown(function(){
		$(this).parents("div:first").find("input[type='checkbox']").attr("checked",true);
	}).blur(function(){
		if($(this).val()==''){
			$(this).val('此处填写您希望接手人对您的任务商品的评语内容，例如：“掌柜妹妹很热情，发货速度很快，商品拿到了,感觉比图片上还要漂亮”。请不要填写“请带字好评”等引导的文字');
			$(this).parents("div:first").find("input[type='checkbox']").attr("checked",false);
		}
		else{
			$(this).parents("div:first").find("input[type='checkbox']").attr("checked",true);
		}
	});

	$("#cbxAddress").click(function(){
		if($(this).val()=='此处填写您要求接手人的修改的收货地址，包含具体省、市、区及详细地址，请不要填写“请带字好评”等引导的文字。'){
			$(this).val('');
		}
	}).blur(function(){
		if($(this).val()==''){
			$(this).val('此处填写您要求接手人的修改的收货地址，包含具体省、市、区及详细地址，请不要填写“请带字好评”等引导的文字。');
		}
		else{
			$(this).parents("div:first").find("input[type='checkbox']").attr("checked",true);
		}
	});

	$("#cbxIsAddress").click(function(){
		$("#cbxTip").toggle(200);
		if($("#cbxTip").is(":visible")==true){
			$("#cbxAddress").val('此处填写您要求接手人的修改的收货地址，包含具体省、市、区及详细地址，请不要填写“请带字好评”等引导的文字。');
		}
	});

	$("#isMultiple").click(function(){
		if($("#Province").attr("multiple"))
		{
			$("#Province").removeAttr("multiple");
			$("#Province").removeAttr("size");
			$("#Province").removeAttr("style");
		}
		else{
			$("#Province").attr({"multiple":"multiple","size":"6"});
			$("#Province").css({"border": "1px inset gray","color": "black","cursor": "default"});
		}
	});

	$("#cbxIsMsg").click(function(){
		$("#txtMessage").click();
		$("#txtMessage").focus();
		if($("#isNoword").is(":checked")){
			var win = $.dialog({title : '温馨提示',
				  content : '对不起，不带字好评任务与规定好评内容不能同时选择！',
				  okValue : "确定",
				  ok : function(){
							$("#isNoword").attr("checked",false);
							$('body,html').animate({scrollTop:1017},500);
						},
				  lock : true});

		}
	});
	$("#isNoword").click(function(){
		if($("#cbxIsMsg").is(":checked")){
			var win = $.dialog({title : '温馨提示',
				  content : '对不起，不带字好评任务与规定好评内容不能同时选择！',
				  okValue : "确定",
				  ok : function(){
							$("#cbxIsMsg").attr("checked",false);
							$('body,html').animate({scrollTop:1617},500);
						},
				  lock : true});
			}
	});
	
	$("#goods_price").blur(function(){
		$("#txtMinMPrice").val(jiben($(this).val()));
		if($(this).val()>9000){
			alert("对不起，只能发布9000以下的商品！");
		}
	});
	$("#tmpname").change(function(){
		location.href=window.location.search+"&temid="+$(this).val();
	});

	$("#cbxIsSetTime1").click(function(){
		  if($(this).attr("checked")){
			  $.dialog({title : '温馨提示',content : '设置任务延迟发布后，不论您是否在线您的任务都将在大厅显示，系统自动取消审核',okValue : "确定",ok : function(){return true;},lock : true});
		}
		 $("#cbxIsSetTime2").attr("checked",false);
	});
	$("#cbxIsSetTime2").click(function(){
		 if($(this).attr("checked")){
			$.dialog({title : '温馨提示',content : '设置任务延迟发布后，不论您是否在线您的任务都将在大厅显示，系统自动取消审核',okValue : "确定",ok : function(){return true;},lock : true});
		 }
		 $("#cbxIsSetTime1").attr("checked",false);
	});

	$(".uploadImgs").wrap("<form class='myupload' action='taobao.php?mod=photourl' method='post' enctype='multipart/form-data'></form>");
    $(".file").change(function(){
		var self=$(this);
		var green=self.parents(".uploadImg").siblings('.green');
		self.parents(".myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		var percentVal = '0%';
        		green.html("上传中，已完成"+percentVal);
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		green.html("上传中，已完成"+percentComplete+"%");
    		},
			success: function(data){
				if(data&&data.pic!=''){
					var img = data.pic;
					$('.url-upfile').val(img);
					green.html("上传成功&nbsp;<a href='"+img+"' target='_blank'>查看</a>");
				}else{
					$('.url-upfile').val('');
					green.html(data);
				}
			},
			error:function(data){
				self.parents(".uploadImg").siblings('.url-upfile').val('');
				green.html("上传失败&nbsp;"+data.responseText);
			}
		});
	});
});

function jiben(num){
	if(num>0&&num<=40){return 1;}
	else if(num<=80){return 1.5;}
	else if(num<=120){return 2;}
	else if(num<=200){return 3;}
	else if(num<=500){return 4;}
	else if(num<=1000){return 5;}
	else if(num<=1500){return 6;}
	else if(num<=1999){return 7;}
	else if(num<=9000){return 7;}
}

function change(){

	var num=0;
	$(".txtprice").each(function(){
	   num=num+parseInt($(this).val());
	});
	$("#txtMinMPrice").val(jiben(num));
}
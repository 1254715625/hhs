function check(){
	if($("#txtFTime").val() < 0 || $("#txtFCount").val() < 1 || $("#txtFTime").val() == undefined){
		 art.dialog({id:'temp-info',title : '温馨提示',content:'发布任务数量最少1个或间隔时间不能小于0！',lock:true});
		 return false;
	}
	if(isNaN($("#txtFTime").val()) || isNaN($("#txtFCount").val())){
		 art.dialog({id:'temp-info',title : '温馨提示',content:'发布任务数量或间隔时间必须为数字！',lock:true});
		 return false;
	}
		if($("#goodsurl").val()==''){
			var win = art.dialog({title : '温馨提示',
			  content : '请输入商品链接地址！',
			  okValue : "确定",
			  ok : function(){
					$("#goodsurl").css({"border-color": "red", "color": "red"});
					$("#goodsurlexp").css({"color":"red"});
					$("#goodsurlexp").text('*请输入正确的URL商品地址');
					$('body,html').animate({scrollTop:617},500);
					$("#goodsurl").focus();
					
			  },
			  lock : true
			});
			return false;
		}
		if($("#goods_price").val()<=0){
			var win = art.dialog({title : '温馨提示',
			  content : '商品价格不能为'+$("#goods_price").val(),
			  okValue : "确定",
			  ok : function(){
					$("#goods_price").val();
					$('body,html').animate({scrollTop:617},500);
					$("#goods_price").focus();
					
			  },
			  lock : true
			});
			return false;
		}
		var x=$("#is_dp").val();
		if(x!=1){
			art.dialog({title : '温馨提示',
			  content : x,
			  okValue : "确定",
			  ok : function(){
				$('body,html').animate({scrollTop:617},500);
				return true;
			  },
			  lock : true
			});
			  return false;
		}else{
			return true;
		}
		
}
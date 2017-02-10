function check(){
		if($("#goodsurl").val()==''){
			var win = $.dialog({title : '温馨提示',
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
			var win = $.dialog({title : '温馨提示',
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

		var accid=$("#accid").val();
		var goodsurl=$("#goodsurl").val();
		var x=$.get('?mod=verification',{accid:accid,goodsurl:goodsurl},function(data,status){
			if(data){
				$.dialog({title : '温馨提示',
				  content : data,
				  okValue : "确定",
				  ok : function(){
					$('body,html').animate({scrollTop:617},500);
					return true;
				  },
				  lock : true
				});
				$("#is_dp").val('0');
			}else{
				$("#is_dp").val('1');
			}
		});
		if($("#is_dp").val()==1){return true;}
		return false;
}
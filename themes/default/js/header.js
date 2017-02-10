$(function(){
	$.ajaxSetup ({ 
		cache: false
	});
	document.onkeydown = function(e){
		var ev = document.all ? window.event : e;
		if(ev.keyCode==13) {
			vervlogin();
		}
	}
	$("#login_btn").click(function(){
		vervlogin();
		return false;
	});
	$("#service_qq").mouseleave(function(){
		$("#service_qq").hide();
	});
	$(".qq_help").mouseover(function(){
		$("#service_qq").show();
	});

	$(".newdh").mouseover(function(){
		$(this).children(".newdh_bor").show();
	});
	$(".newdh").mouseout(function(){
		$(this).children(".newdh_bor").hide();
	});

	$(".menu-item .menu-hd").hover(function(){
		$(this).next('.menu-0').show();
		$(this).children('b').css({ borderColor:'#666666 white white',transform:'rotate(180deg',transformOrigin:'50% 30% 0px'});
		$(this).parents(".menu-item").css({ background:'rgb(255, 255, 255)',border:'1px solid #a6d8f8'})
	});
	$(".menu-item .menud").mouseleave(function(){
		$(this).children('.menu-0').hide();
		$(this).children('.menu-hd').children('b').css({ borderColor:'#666666 #EFF6FE #EFF6FE',transform:'none',transformOrigin:'none'});
		$(this).parent(".menu-item").css({ background:'none',border:'1px solid #EFF6FE'})
	}); 

	/*客服QQ悬浮*/
	jQuery("#kuzhan").mouseover(function(){
		jQuery("#kuzhan .services").show();
	});
	jQuery("#kuzhan").mouseout(function(){
		jQuery("#kuzhan .services").hide();
	});
	jQuery(".yxiaoqq").live('click',function(){
		var i = $("#kuzhan").attr('cc');
		art.dialog({ 
            title: '提示',
            content: '确认打开QQ与营销QQ '+i+'对话？', 
            fixed: true,
            lock: true,
            okValue:'确定',
            ok:function(){
            	window.open("http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin="+i);
            },
            cancelValue: '取消',
            cancel: function () { }
        });
	});
	/*获取滚动条滚动驱使返回顶部出现*/
	jQuery(window).scroll( function() {
		if(jQuery(document).scrollTop() > 0){
			jQuery("#m_top .not_qq").height(152).find(".rtop").show();
		}else{
			jQuery("#m_top .not_qq").height(130).find(".rtop").hide();
		}
		src = jQuery(window).scrollTop()-300;
		$(".fabu_box2 .plnot").css('top',src+'px');
	});
	jQuery("#m_top .not_qq .rtop,#m_top .yes_qq .rtopnew").click(function(){
		jQuery("html, body").animate({ scrollTop: 0 }, 120);
	});
});
function colorToRGB(color){
	var reg = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/g;
	var sColor = color.toLowerCase();
	if(sColor && reg.test(sColor)){
	  if(sColor.length === 4){
		  var sColorNew = "#";
		  for(var i=1; i<4; i+=1){
			  sColorNew += sColor.slice(i,i+1).concat(sColor.slice(i,i+1));
		  }
		  sColor = sColorNew;
	  }
	  //处理六位的颜色值
	  var sColorChange = [];
	  for(var i=1; i<7; i+=2){
		  sColorChange.push(parseInt("0x"+sColor.slice(i,i+2)));
	  }
	  return sColorChange.join(",");
	}else{
	  return color;
	}
}
function setBakckgoundAndOpacity(obj,color){
	var opacity = 1.0;
	var inter = setInterval(function(){
		if (opacity > 0){
			opacity -= 0.05;
			var rgbaObj = colorToRGB(color);
			if($.browser.msie&&parseInt($.browser.version)<9){
			  // 针对ie 6，7，8 通过设置内部元素position:relative；可以避免被父节点的opacity影响
			  $(obj).children().each(function(){
				  if($(this).css('position') == 'static'){
					  $(this).css('position','relative');
				  }
			  });
			  $(obj).css({
				  'background':color,
				  'opacity':opacity
			  });
		   }else{
			  // 支持rgba颜色格式的浏览器用rgba设置透明背景色
			  
			  $(obj).css({
				  'background':'rgba('+colorToRGB(color)+','+opacity+')'
			  });
		  }
		}else{
			clearInterval(inter);
			$(cur).attr('style','');
		}
			
	},50);
}

function vervlogin(){
	var username = $("#lusername").val();
	var password = $("#lpassword").val();
	var question = $("#loginquestionid").val();
	var trouble  = $("#trouble").val();
	var magicmark = '';
	//基本验证
	if(username.length < 2){
		$("#lusername").css('border','1px solid #EE5F5B');
		$("#lusername").focus();
		$("#miaoname").html('用户名不能小于2个字符').css("color","red");return false;
	}else{
		$("#lusername").css('border','1px solid #ddd');
		$("#miaoname").html('');
	}

	if(password.length < 6){ 
		$("#lpassword").css('border','1px solid #EE5F5B');
		$("#lpassword").focus();
		$("#miaopwd").html('密码不能少于6个字符').css("color","red");return false;
	}else{
		$("#lpassword").css('border','1px solid #ddd');
		$("#miaopwd").html('');
	}
	//提交数据
	art.dialog({ id:"ajaxStart",title: '正在登录中..',fixed: true,lock: true});
	$.post("user.php?act=login",{"username":username,"password": password,"question":question,"trouble": trouble},function(data){
			art.dialog.get('ajaxStart').close();
			/*安全提问存在*/
			if(data.trouble == 1){
				$("#userentry").hide();
				$("#interlocution").show();
			}
			/*安全提问错误阶段返回*/
			if(data.status == 0){
				$("#userentry").show();
				$("#interlocution").hide();
				$("#miaoname").html(data.info).css("color","red");
			}
			/*安全错误*/
			if(data.status == -1){
				$("#userentry").hide();
				$("#interlocution").show();
				$("#usertourError").html(data.info);
			}
			/*冻结*/
			if(data.status == -2){
				art.dialog({title: '提示',content:data.info,fixed: true,lock: true});
			}
			/*成功跳转页面*/
			if(data.status == 1){
				url = 'user.php';
				setTimeout(function(){window.location.href = url},1000) 
				//window.location.href = url ;
			}
	   },'json');
}
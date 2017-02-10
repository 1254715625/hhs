<?php echo $this->fetch("common/header"); ?>
<style type="text/css">
#wrap {margin: 0 auto;position: relative;text-align: center;width: 100%;margin-bottom: -15px;float: left;}
#wrap .primg1{width: 100%;height: 435px;background:url(themes/default/images/spread/1.gif) #FFB500  no-repeat center;margin: 0 auto;}
#wrap .primg1 .direct{margin: 0 auto;width: 1000px;height: 425px;position: relative;}
#wrap .primg1 .direct .img1{ float: left;margin: 200px 0 0 125px;}
#wrap .primg1 .direct #copy{ width:212px;height:212px; float: left;margin: 215px 0 0 3px;background:url(themes/default/images/spread/XHxq1IhsV_src.jpg);text-indent: -9999px;cursor: pointer;}
#wrap .primg1 .direct #copy:hover{ background:url(themes/default/images/spread/XHxq1JLwN_src.png);}
#wrap .primg1 .direct .know{ width: 50px;height: 55px;background: url(themes/default/images/spread/XHxpZezsV_src.png);float: left;text-indent: -9999px;margin: 345px -20px;}
#wrap .primg1 .direct .know:hover{ background:url(themes/default/images/spread/XHxpZYXFn_src.png);}
#wrap .primg2{ width: 100%;height: 145px;background:url(themes/default/images/spread/2.gif) #FFB500 no-repeat center;margin: 0 auto;}
#wrap .primg3{ width: 100%;height: 325px;background:url(themes/default/images/spread/3.gif) #FFB500 no-repeat center;margin: 0 auto;}
#wrap .primg3 .centz{ margin: 0 auto;width: 1000px;height: 325px;}
#wrap .primg3 .url1{ float: left;margin: 81px 0 0 -332px;*margin:81px 0 0 112px;width: 146px;height: 147px;text-indent: -9999px;border: 1px solid #FFCC61;border-radius: 80px;display: inline;}
#wrap .primg3 .url2{ float: left;margin: 81px 0 0 -16px;*margin:81px 0 0 167px;width: 146px;height: 147px;text-indent: -9999px;border: 1px solid #FFCC61;border-radius: 80px;display: inline;}
#wrap .primg3 .url3{ float: left;margin: 81px 0 0 166px;width: 146px;height: 147px;text-indent: -9999px;border: 1px solid #FFCC61;border-radius: 80px;display: inline;}
#wrap .primg3 .centz a:hover{ background: url(themes/default/images/info/dsss.png) no-repeat -10px -4px;}
#wrap .primg4{ width: 100%;height: 122px;background:url(themes/default/images/spread/4.gif) #FFB500 no-repeat center;margin: 0 auto;}
#wrap .primg5{ width: 100%;height: 180px;background:url(themes/default/images/spread/5.gif) #FFB500 no-repeat center;margin: 0 auto;}
#wrap .primg6{ width: 100%;height: 375px;background:url(themes/default/images/spread/zfde.gif) #FF9c00 no-repeat top center;margin: 0 auto;}
#wrap .primg6 img{ margin:30px 0;cursor: pointer;}
</style>

<div id="wrap">
	<div class="primg1">
		<div class="direct">
			<img class="img1" src="themes/default/images/spread/XIPRGTjuJ_src.gif">
			<span id="copy" link="<?php echo $this->_var['link']; ?>" class="">开始赚钱</span>
			<a class="know" href="help.php" target="_blank">了解好会刷</a>
			<ul class="line" style="float: left;height: 25px;overflow: hidden;width: 200px;margin-top: 2px;position: absolute;bottom: -20px;right: 158px;color: white;">
				<?php if($this->_var['line'])foreach($this->_var['line'] as $this->_var['key'] => $this->_var['v']){ ?>
				<li style="margin-top: 0px;"><?php echo $this->_var['v']['user_name']; ?>获得推广用户购卡提成<?php echo $this->_var['v']['money']; ?>元</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="primg2"></div>
	<div class="primg3">
		<div class="centz">
			<a class="url1" href="user.php?act=spread" target="_blank">领取5元</a>
			<a class="url2" href="home.php?act=buypoint" target="_blank">消费购卡</a>
			<a class="url3" num="<?php echo $this->_var['num']; ?>" href="javascript:;" target="_blank">活跃奖金</a>
		</div>
	</div>
	<div class="primg4"></div>
	<div class="primg5"></div>
	<div class="primg6">
		<img id="copy1" style="margin-top:50px;" src="themes/default/images/spread/vtghb.gif">
		<img id="copy2" src="themes/default/images/spread/xtr.gif">
	</div>
</div>
<script>
$(function(){
		$("#copy").click(function(){
			var link = $("#copy").attr("link");
			if(link){
				art.dialog({ id:'m',title: '提示',content: '复制地址成功，推广地址：'+$("#copy").attr('link'),fixed: true});
			}
		});
		$("#copy1").click(function(){
			var link = $("#copy").attr("link");
			if(link){
				art.dialog({ id:'m',title: '提示',content: '复制地址成功，推广地址：'+$("#copy").attr('link'),fixed: true});
			}
		});
		$("#copy2").click(function(){
			var link = $("#copy").attr("link");
			if(link){
				art.dialog({ id:'m',title: '提示',content: '复制地址成功，推广地址：'+$("#copy").attr('link'),fixed: true});
			}
		});

		$(".centz .url3").click(function(){
			var num =  parseInt($(this).attr('num'));
			if(num == -1){
				art.dialog({ id:'sq',title: '提示',content: '登录后查看！',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;} });
				return false;
			}
			if(num < 50000){
				art.dialog({ id:'sq',title: '提示',content: '您的推广积分为'+num+',不满足条件！',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;} });
				return false;
			}
			art.dialog({ 
   				title: '提示',
   				content: "您的推广积分为"+num+"，申请后将扣除50000推广积分~",
   				fixed: true,
   				lock: true,
   				okValue: '确定',
   				ok: function(){
   					$.ajax({
					   type: "POST",
					   url: "user.php?act=popularize&applytmoney=1",
					   data: "sq=money",
					   success: function(data){
					   		obj = jQuery.parseJSON(data);
				   			art.dialog({ 
				   				title: '提示',
				   				content: obj.info,
				   				fixed: true,
				   				lock: true,
				   				cancelValue: '关闭',
				   				cancel: function () { 
				   					return true;
				   				} 
				   			});
					   }
					});
   				},
   				cancelValue: '关闭',
   				cancel: function () { return true;} 
   			});
		})

		var _wrap=$('ul.line');
		var _interval=500;
		var _moving;
		_wrap.hover(function(){
			clearInterval(_moving);
		},function(){
			_moving=setInterval(function(){
				var _field=_wrap.find('li:first');
				var _h=_field.height();
				_field.animate({ marginTop:-_h+'px'},1600,function(){
					_field.css('marginTop',0).appendTo(_wrap);
				})
			},_interval)
		}).trigger('mouseleave');
	});
</script>

<?php echo $this->fetch("common/footer"); ?>
<?php echo $this->fetch("common/header"); ?>

<div id="d_banner" action-index="home"> 
	<div class="main_visual">
		<div id="dmh-login"> 
			<?php if($_SESSION['user_id']){ ?>
			<div class="ilogData">
				<ul id="goone">
					<li><span>一个真实的淘宝信誉平台期待您的加入</span></li>
					<li class="li-a">用户名：<a href="info.php?act=info&uname=<?php echo $_SESSION['user_name']; ?>"><?php echo $_SESSION['user_name']; ?></a></li>
					<li class="li-b">存款：<a href="user.php?act=payde"><?php echo $this->_var['uinfo']['user_money']; ?></a></li>
					<li class="li-b">麦点：<a href="user.php?act=logpoint"><?php echo $this->_var['uinfo']['pay_money']; ?></a></li>
					<li class="li-b">经验：<a href="user.php?act=logcredit"><?php echo $this->_var['uinfo']['rank_points']; ?></a></li>
					<li class="li-b">登陆次数：<a href="user.php?act=logaccount"><?php echo $this->_var['uinfo']['log_count']; ?></a></li>
					<li class="li-b"><a href="http://hhs.lianmon.com/"><img width="275" height="49" src="themes/default/images/home/goone.png"></a></li>
					<div class="touimg">
						<a href="info.php?act=info&uname=<?php echo $_SESSION['user_name']; ?>">
						<img width="100" height="100" id="user_avatar" src="themes/default/images/user/headimg/<?php if($this->_var['uinfo']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['uinfo']['headimg']; ?><?php } ?>">
						</a>
					</div>
				</ul>
			</div>
			<?php }else{ ?>
			<div class="login">
				<form action="user.php?act=login" method="post" id="action">
				<div id="userentry">
					<p class="join">一站式威客服务平台期待您的加入！</p>
					<a class="reg-btn" href="user.php?act=reg"></a>
					<p class="ui-p">
						<label id="J-label-name" class="ui-label">
							<span class="ui-name-icon">用户名：</span>
		      			</label>
		     			<input type="text" maxlength="26" class="ui-input" id="lusername" name="username" autocomplete="off" tabindex="1" value="" placeholder="好会刷用户名">
					</p>
					<p style="height:50px;"></p> 
					<p class="ui-p">
						<label id="J-label-pass" class="ui-label">
							<span class="ui-pass-icon">密码：</span>
		      			</label>
		     			<input type="password" maxlength="16" class="ui-input" id="lpassword" name="password" autocomplete="off" tabindex="1" value="" placeholder="好会刷密码">
					</p>
					<p style="height:15px;"></p>
				</div>
				<ul id="interlocution" style="display:none;">
					<li class="usertour">您的账户设置了安全提问,请您验证安全问题。</li>
					<li id="usertourError"></li>
					<li>
						<span class="usertourText">安全提问：</span>
						<select id="loginquestionid" name="questionid" class="selectque">
						<option value="0">请选择问题</option>
						<option value="1">早上几点起床？</option>
						<option value="2">TA最爱吃的菜？</option>
						<option value="3">好朋友的名字？</option>
						<option value="4">你理想的体重？</option>
						<option value="5">爱人的生日？</option>
						</select>
					</li>
					<li>
						<span id="loginpwd" class="answer">问题答案：</span>
						<input type="text" maxlength="20" value="" id="trouble" class="input-answer">
					</li>
				</ul>
				<input type="submit" class="login-btn" id="login_btn" value="" />
				<ul>
					<li id="miaoname" class="fl"></li>
					<li id="miaopwd" class="fl"></li>
					<li class="fr" style="margin-right: 30px;">
						<a href="help.php?act=selfservice" target="_blank" style="color:#e5e5e5">忘记密码?</a>
					</li>
				</ul>
			</div>
			<?php } ?>
			<div class="bsicon">
				<a href="user.php?act=spread" target="_blank" class="a1">推广排名</a>
				<a href="single.php" target="_blank" class="a2">快递单号</a>
				<a href="home.php?act=tuoguan" target="_blank" class="a3">网店托管</a>
			</div>
		</div>
		
		<div class="flicking_con">
			<div class="flicking_inner">
				 <a href="javascript:;">1</a>
				 <a href="javascript:;">2</a>
				 <a href="javascript:;">3</a>
			</div>
		</div>
		<div class="main_image">
			<ul>					
				<li class="bannerbg1">
					<span class="banner-1">
						<div class="banner-button">
							<a class="button-1" target="_blank" href="user.php?act=reg"></a>
						</div>
						<img src="themes/default/images/home/banner-1.jpg" width="1000" height="406" alt="加入好会刷"/>
					</span>
				</li>
				<li class="bannerbg5">
					<span class="banner-5">
						<div class="banner-button">
							<a class="button-5" target="_blank" href="user.php?act=reg"></a>
						</div>
						<img src="themes/default/images/home/lb_4.jpg" width="1000" height="406" alt="用户注册"/>
					</span>
				</li>
				<!-- <li class="bannerbg2">
					<span class="banner-2"> 
						<div class="banner-button">
							<a class="button-2" href="javascript:;"></a>
						</div>
						<img src="themes/default/images/home/banner-2.jpg" width="1000" height="406" alt="立即注册"/>
					</span>
				</li> -->
				<li class="bannerbg3">
					<span class="banner-3">
						<div class="banner-button">
							<a class="button-3" target="_blank" href="javascript:alert('正在开发中...');"></a>
							<!-- <a class="button-4" target="_blank" href="javascript:alert('正在开发中...');"></a> -->
						</div>
						<img src="themes/default/images/home/1232a.jpg" width="1000" height="406" alt="免费试用"/>
					</span>
				</li>
			</ul>
			<a href="javascript:;" id="btn_prev"></a> 
			<a href="javascript:;" id="btn_next"></a>
		</div>

	</div>
</div>

<div id="content">
	
	<div id="course">
		<ul class="course-fbf">
			<li><a class="fbf-1" href="home.php?act=buypoint"></a></li>
			<li><a class="fbf-2" href="help.php" target="_blank"></a></li>
			<li><a class="fbf-3" href="help.php" target="_blank"></a></li>
		</ul>
		<p class="fbf-p"><a href="help.php" target="_blank"></a></p>
		<ul class="course-jsf">
			<li><a class="jsf-1" href="help.php" target="_blank"></a></li>
			<li><a class="jsf-2" href="help.php" target="_blank"></a></li>
			<li><a class="jsf-3" href="help.php" target="_blank"></a></li>
		</ul>
		<p class="jsf-p"><a href="help.php" target="_blank"></a></p>
	</div>
	<div id="guide_left">
		<a target="_blank" href="help.php?act=video">
			<span class="play"></span>
			<img width="405" height="239" class="image" src="themes/default/images/home/dmh-video.jpg" alt="视频操作指南">
		</a>
	</div>
	<div id="guide_right"> 
		<div class="notice">
			<ul>
			<h4 class="notice-t"></h4>
				<?php if($this->_var['artlist'])foreach($this->_var['artlist'] as $this->_var['key'] => $this->_var['item']){ ?>
				<li>
					<a target="_blank" href="bbs.php?act=view&id=<?php echo $this->_var['item']['id']; ?>">
					<?php if($this->_var['key'] == 0){ ?><strong><?php echo $this->_var['item']['title']; ?></strong><?php }else{ ?><?php echo $this->_var['item']['title']; ?><?php } ?></a>
					<span class="date"><?php echo $this->_var['item']['add_time']; ?></span>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="arises quctl" id="c_bk3">
			<ul class="ajax_i">
				<h4 class="arises-t"></h4>
				<?php if($this->_var['now'])foreach($this->_var['now'] as $this->_var['key'] => $this->_var['item']){ ?>
				<li>
				<div class="fl arises-d">
					<a target="_blank" style="color:#1996E6" href="info.php?act=info&uname=<?php echo $this->_var['item']['susername']; ?>"><?php echo $this->_var['item']['susername']; ?></a>
					<span>发布任务网店提升<b style="color:#ff7112">+1</b></span> 
				</div>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div id="fontImg">
		<div class="depict"><img src="themes/default/images/home/td-help.png" alt="服务指南"></div>
		<div class="bricks">
            <a class="itm1 itm-L" href="http://hhs.lianmon.com/" target="_blank">
            	<img src="themes/default/images/home/ban1.gif">
            </a>
            <a class="itm2 itm-S" href="http://hhs.lianmon.com/" target="_blank">
            	<img src="themes/default/images/home/ban2.gif">
            </a>
            <a class="itm3 itm-S" href="home.php?act=tuoguan" target="_blank">
            	<img src="themes/default/images/home/ban3.gif">
            </a>
            <a class="itm4 itm-S" href="home.php?act=tuoguan" target="_blank" style="left: 751px; top: 0px; height: 240px; width: 250px;">
            	<img src="themes/default/images/home/ban4.gif">
            </a>
        </div>
	</div>
	 
	<div class="choice">
		<ul class="yelkuang">
			<li class="li_first" style="background-color: rgb(113, 199, 250); background-position: initial initial; background-repeat: initial initial;"><span class="bgtxt0 allimg">好会刷的优势</span></li>
			<li><a href="help.php?act=newpeople"><span class="bgtxt1 allimg">领先的互动平台</span></a></li>

			<li><a href="help.php?act=newpeople"><span class="bgtxt2 allimg">精准的营销服务</span></a></li>
			<li class="li_first"><a href="help.php?act=newpeople"><span class="allimg bghide3 bgtxt3">超人气平台</span></a></li>
			<li><a href="help.php?act=newpeople"><span class="bgtxt4 allimg">完善的安全保证</span></a></li>
			<li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_var['cfg']['group_qq']['0']; ?>&amp;site=qq&amp;menu=yes" target="_blank">
				<span class="allimg bghide5 bgtxt5">企业QQ</span></a>
			</li>
		</ul>
		<div class="rigdata"> 
			<div class="namehead">
				<span class="left allimg">加入时间</span>
			</div>
			<ul class="zhanggui">
				<?php if($this->_var['newuser'])foreach($this->_var['newuser'] as $this->_var['key'] => $this->_var['item']){ ?>
				<li><a href="info.php?act=info&uname=<?php echo $this->_var['item']['user_name']; ?>"><?php echo $this->_var['item']['user_name']; ?></a><span>刚刚加入</span></li>
				<?php } ?>
			</ul>
			<div class="tuig allimg" style="background-position: -587px -56px;margin: 8px 0 0 10px;">
				<span>推荐一个会员就可以产生<b>5</b>元丰厚收入！做好会刷推广，轻松赚大钱！</span>
				<ul class="line" style="float: left;height: 25px;overflow: hidden;width: 208px;margin-top: 2px;text-align:center;">
				<?php if($this->_var['line'])foreach($this->_var['line'] as $this->_var['key'] => $this->_var['v']){ ?>
				<li><?php echo $this->_var['v']['user_name']; ?> 获得推广提成<?php echo $this->_var['v']['money']; ?>元</li>
				<?php } ?>
				</ul>
				<?php if($this->_var['lines'])foreach($this->_var['lines'] as $this->_var['key'] => $this->_var['v']){ ?>
				<a class="<?php echo $this->_var['v']['ph']; ?>" href="help.php"><?php echo $this->_var['v']['user_name']; ?></a>
				<?php } ?>
				<a href="home.php?act=popularize" class="tg_btn" title="加入好会刷推广" alt="加入好会刷推广"></a>
			</div>
		</div>
		<div class="whatdmh">
			<span class="txt allimg">为什么选择好会刷</span>
			<div class="xzthree">
				<a href="help.php?act=newpeople" class="allimg">担保交易</a>
				<a href="help.php?act=newpeople" class="noleft allimg">消费者保障</a>
				<a href="help.php?act=newpeople" class="noright allimg">威客认证</a>
			</div>
		</div>
	</div>

	
	
</div>

<div id="d-bottomBar" style="display: none;">
	<div class="d-bottomBar-wrap"> 
	   <a class="d-signin"> </a> 
	   <a class="d-signup" href="qqlogin.php" target="_blank"></a> 
	   <a class="d-signup1" href="user.php?act=reg"></a> 
	   <a class="d-signup1" href="home.php?act=tuoguan" style="margin-left: 32px;background-position: -287px -89px;width: 144px;"></a>
	</div>
	<span id="d-closeBottomBar">关闭</span> 
</div>

<script type="text/javascript">
if(!$.cookie('d-bottomBar')){
	var dhideFlag = true;
	$(window).scroll(function(){
		 if(dhideFlag) {
			 ($(this).scrollTop() > 200) ? $("#d-bottomBar").fadeIn() : $("#d-bottomBar").fadeOut();
		 }
	});
	$("#d-closeBottomBar").click(function(){
		 dhideFlag = false;
		 var offset = document.domain.indexOf('haohuisua'),
		 domain = document.domain.substr(offset);
		 $.cookie('d-bottomBar',1,{ domain:domain});
		 $("#d-bottomBar").fadeOut();
	});
}
	//3秒弹出数据
	function delayTime(i,data){
		if(data == ""){
			return false;
		}
		var n = i - 1;
		var cont = '<li style="display:none;">';
			cont +='<div class="fl arises-d"><a target="_blank" style="color:#1996E6" href="info.php?act=info&uname='+data[n]['susername']+'">'+data[n]['susername']+'</a>';
			cont +='<span>发布任务网店提升<b style="color:#ff7112">+1</b></span></div>';
			//cont +='<div class="fl"><span class="date">'+data[n]['complateTime']+'前</span></div>';
			//cont +='<div class="fl"><span class="date">'+data[n]['complateTime'].split("时")[1]+'前</span></div>';
			cont +='</li>';
		var lisize = $(".ajax_i li").length;
		if(lisize >= 7){
			$(".ajax_i li:gt(5)").fadeOut("slow");//.remove()
			$(".ajax_i li:gt(5)").hide();
		}
		$(".ajax_i .arises-t").after(cont);
		$(".ajax_i li:first").fadeIn("slow"); 
		if(n > 0){
			if(lisize < 7){
				setTimeout(function(){ delayTime(n,data);},1);
			}else{

				setTimeout(function(){ delayTime(n,data);},3000);
			}
		}else{
			$(".ajax_i li:hidden").remove();//删除不可见的。
		}
	}
	//读取成功的任务
	function getTaskOver(){
		$.ajax({
			type : 'GET',
			dataType : 'json',
			url : 'getTaskOver.php',
			success : function(data){
				var i = data.length;
				delayTime(i,data);
			}
		});
		setTimeout("getTaskOver()",3000);
	}
	//调调
	getTaskOver();
	$(".choice .yelkuang li").each(function(i){
	$(this).mouseover(function(){
		if(i != 0){
			$(".choice .yelkuang li:eq(0)").css("background","#71c7fa");
			$(this).children("a").children("span:first").removeClass("bghide"+i).addClass("bgshow"+i);
			$(this).children("a").children("span:last").removeClass("bgtxt"+i).addClass("bgtext"+i);
		}
	});
	$(this).mouseout(function(){
		if(i != 0){
			$(".choice .yelkuang li:eq(0)").css("background","#71c7fa");
			$(this).children("a").children("span:first").removeClass("bgshow"+i).addClass("bghide"+i);
			$(this).children("a").children("span:last").removeClass("bgtext"+i).addClass("bgtxt"+i);
		}
	})
});
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
</script>
<script type="text/javascript" src="themes/default/js/touchSlider.js"></script>
<script>
$(function(){
		$(".main_visual").hover(function(){
			$("#btn_prev,#btn_next").fadeIn();
		},function(){
			$("#btn_prev,#btn_next").fadeOut();
		});
		$dragBln = false;
		$(".main_image").touchSlider({
			flexible : true,
			speed : 400,
			btn_prev : $("#btn_prev"),
			btn_next : $("#btn_next"),
			paging : $(".flicking_con a"),
			counter : function (e) {
				$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
			}
		});
		$(".main_image").bind("mousedown", function() {
			$dragBln = false;
		})
		$(".main_image").bind("dragstart", function() {
			$dragBln = true;
		})
		$(".main_image a").click(function() {
			if($dragBln) {
				return false;
			}
		});
		var timer = setInterval(function() { $("#btn_next").click();}, 10000);
		$(".main_visual").hover(function() {
			clearInterval(timer);
		}, function() {
			timer = setInterval(function() { $("#btn_next").click();}, 10000);
		})
		$(".main_image").bind("touchstart", function() {
			clearInterval(timer);
		}).bind("touchend", function() {
			timer = setInterval(function() { $("#btn_next").click();}, 10000);
		});
		$("#guide_left").mouseover(function(){
			$("#guide_left .play").css('background-position','-72px 0');
		});
		$("#guide_left").mouseout(function(){
			$("#guide_left .play").css('background-position','0 0');
		});
		$("#fontImg .show li").mouseover(function(){
		 $("#fontImg .show li").css('zIndex','1');
		 $(this).css('zIndex','2');
		});
		
});
function hoverScale($items, rate) {
	$items.each(function () {
		var
			self = $(this),
			w = parseInt($(this).css('width')),
			h = parseInt($(this).css('height')),
			l = parseInt($(this).css('left')),
			t = parseInt($(this).css('top')),
			w2 = w * rate,
			h2 = h * rate,
			l2 = l - (w2 - w) / 2,
			t2 = t - (h2 - h) / 2;
		self.hover(function () {
			this.style.zIndex = '1';
			this.style.border = '1px solid #C0C0C0';
			self.stop(false, true).animate({
				'left': l2,
				'top': t2,
				'height': h2,
				'width': w2
			}, 100);
		}, function () {
			this.style.zIndex = '';
			this.style.border = '';
			self.stop(false, true).animate({
				'left': l,
				'top': t,
				'height': h,
				'width': w
			}, 50);
		});
	});
}
hoverScale($('.bricks a'), 1.2);
</script>
<?php echo $this->fetch("common/footer"); ?>
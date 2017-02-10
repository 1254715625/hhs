<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->_var['cfg']['site_title']; ?></title>
	<meta name="description" content="<?php echo $this->_var['cfg']['site_desc']; ?>">
	<meta name="keywords" content="<?php echo $this->_var['cfg']['site_keys']; ?>">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta property="qc:admins" content="144167071660170513516375" />
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="stylesheet" type="text/css" href="themes/default/css/main.css">
	<link rel="stylesheet" type="text/css" href="themes/default/css/index.css">
	<link rel="stylesheet" type="text/css" href="themes/default/css/dialog/twitter.css">

	<script type="text/javascript" src="themes/default/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="themes/default/js/artDialog.js"></script>
	<script type="text/javascript" src="themes/default/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="themes/default/js/json2.js"></script>
	<script type="text/javascript" src="themes/default/js/header.js"></script>
	<script type="text/javascript" src="themes/default/js/up/jquery.uploadify.min.js" type="text/javascript"></script>
</head>
<body>

<div id="m_top">
	<div class="TopBanner">
	 
	  <div class="TopBannerNotice">
	      <div id="closeTopBanner" title="关闭" style="position:absolute;top:5px;right:5px;width:23px;height:22px;background: url(themes/default/images/home/close_b.png) no-repeat;cursor:pointer">
	  </div>
	  </div>   
	</div>
	<div id="10mts" style="background: #F93414;height: 32px;line-height: 32px;display:none;">
		<div style="text-align:center;width:980px;margin:0 auto;color: #FFF;font-size:14px;font-weight:bold;">
			任何向您索要短信验证码的人都是骗子！认清主动联系您的客服真假！
		</div>
  	</div>
	<div class="kd">		
		<div class="kmain"> 
			<div class="hy">
				<div class="userdate">
					<a href="home.php" title="首页" style="margin: 4px;float:left;width:15px;height:15px;background:url(themes/default/images/ico/home.gif) no-repeat;"></a>
					<?php if($_SESSION['user_id']){ ?>					
					<a class="login-after username" target="_blank" href="info.php?act=info&uname=<?php echo $this->_var['uinfo']['user_name']; ?>" style="display: inline;"><?php echo $_SESSION['user_name']; ?></a>
					<img class="login-after exp" src="themes/default/images/ico/level/b_red_1.gif" title="经验：<?php echo $this->_var['uinfo']['rank_points']; ?>" style="display: inline;"> 　
					<a class="login-after" href="user.php?act=logout" style="display: inline;">退出</a>
					<?php }else{ ?>
					<a class="chengse login-before" href="user.php?act=login">亲，请登录</a>
					<!-- <img width="16" height="16" src="/static/images/ico/sina_1.png" class="hzhl login-before"> -->
					<a class="lvse login-before" href="user.php?act=reg">免费注册</a>
					<a class="login-before" id="toLogin" href="qqlogin.php" target="_blank">
						<img width="16" height="16" title="QQ登录" src="themes/default/images/ico/qq_1.png" class="hzhl login-before">
						QQ登录
					</a>
					<?php } ?>
				</div>
			</div>
			
			<div class="top_btn">
				<ul class="quick-menu">
					<?php if($_SESSION['user_id']){ ?>
					<li class="menu-item login-after" style="display: list-item;">
						<div class="menud">
							<a class="menu-hd" target="_blank" href="user.php?act=bank">存款 <span class="chengse moneyAll money" style="font-weight:700;"><?php echo $this->_var['uinfo']['user_money']; ?></span><b></b></a>
							<div class="menu-0" style="width: 90px;">
							  <div class="menu-bd-panel">
								  <a href="user.php?act=bank">账户充值</a>
								  <a href="user.php?act=payde">存款明细</a>
							  </div>
							</div>
						</div>
					</li>
					<li class="login-after" style="margin-top: -1px; display: list-item;">|</li>
					<li class="menu-item login-after" style="display: list-item;">
						<div class="menud">
							<a target="_blank" class="menu-hd" href="home.php?act=buypoint">麦点 <span class="chengse moneyAll maidian" style="font-weight:700;"><?php echo $this->_var['uinfo']['pay_money']; ?></span><b></b></a>
							<div class="menu-0" style="width: 90px;">
							  <div class="menu-bd-panel">
								  <a href="home.php?act=buypoint">购买麦点</a>
								  <a href="user.php?act=logpoint">麦点明细</a>
							  </div>
							</div>
						</div>
					</li>
					<li class="login-after" style="margin-top: -1px; display: list-item;">|</li>
					<li class="menu-item login-after" style="display: list-item;">
						<div class="menud">
							<a target="_blank" class="menu-hd" href="user.php?act=personal">信息 <span class="chengse moneyAll message" style="font-weight:700;"><?php echo $this->_var['uinfo']['read_num']; ?></span><b></b></a>
							<div class="menu-0" style="width: 90px;">
							  <div class="menu-bd-panel">
								  <a href="user.php?act=personal&opt=myRest">私人收件箱</a>
								  <a href="user.php?act=personal&opt=rootRest">官方收件箱</a>
								  <a href="user.php?act=personal&opt=newDate">发送短消息</a>
								  <a href="user.php?act=personal&opt=instation">提醒设置</a>
							  </div>
							</div>
						</div>
					</li>
					<?php } ?>
					<li class="menu-item newdh heimg">
						<a href="help.php">
							我是发布方
						</a>
						<span class="newdh_bor">
							<b class="heimg">向上</b>
							<ul>
								<li class="heimg lie lieimg1"><a href="help.php?act=guide">图文教程</a></li>
								<li class="heimg lie lieimg2"><a href="help.php?act=video">视频教程</a></li>
								<li class="heimg lie lieimg3"><a href="user.php?act=topup">帐号充值</a></li>
								<li class="heimg lie lieimg4"><a href="home.php?act=buypoint">购买麦点</a></li>
								<li class="heimg lie lieimg5"><a href="single.php">单号搜索</a></li>
								<li class="heimg lie lieimg6"><a href="info.php?act=rank">排行榜</a></li>
								<li class="heimg lie lieimg7"><a href="tencent://message/?uin=<?php echo $this->_var['cfg']['serv_qq']['0']; ?>">客服帮助</a></li>
							</ul>
						</span>
					</li>
					<li class="menu-item newdh heimg">
						<a href="help.php">
							我是接手方
						</a>
						<span class="newdh_bor">
							<b class="heimg">向上</b>
							<ul>
								<li class="heimg lie liejsf1"><a href="help.php?act=guide">图文教程</a></li>
								<li class="heimg lie liejsf2"><a href="help.php?act=video">视频教程</a></li>
								<li class="heimg lie liejsf3"><a href="user.php?act=payment">申请提现</a></li>
								<li class="heimg lie liejsf4"><a href="user.php?act=rechange">回收麦点</a></li>
								<li class="heimg lie liejsf5"><a href="home.php?act=soft">常用软件</a></li>
								<li class="heimg lie liejsf6"><a href="user.php?act=userjob">领取奖励</a></li>
								<li class="heimg lie liejsf7"><a href="info.php?act=rank">排行榜</a></li>
								<li class="heimg lie liejsf8"><a href="tencent://message/?uin=<?php echo $this->_var['cfg']['serv_qq']['0']; ?>">客服帮助</a></li>
							</ul>
						</span>
					</li>

				</ul>
			</div>
		</div>
		<div class="menu_qq">
			  <a class="qq_help" href="javascript:;">客服帮助</a>
		</div>
		<div style="display: none;" class="help_down" id="service_qq"><p class="up"><span class="kf2gre">值班时间：</span><span>　</span><span>8:30 - 12:00 ， 13:30 - 18:00 ， 19:00 - 21:00</span> (周日无晚班)</p><ul><li><span class="kf2gre">新手帮助：</span><div><?php if($this->_var['cfg']['serv_qq'])foreach($this->_var['cfg']['serv_qq'] as $this->_var['item']){ ?><a class="kf2gre yxiaoqq" href="tencent://message/?uin=<?php echo $this->_var['item']; ?>"><img src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['item']; ?>:17" border="0">多工号企业QQ</a><?php } ?></div></li><li><span class="kf2gre">充值提现：</span><div><?php if($this->_var['cfg']['pay_qq'])foreach($this->_var['cfg']['pay_qq'] as $this->_var['item']){ ?><a class="kf2gre" href="tencent://message/?uin=<?php echo $this->_var['item']; ?>"><img src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['item']; ?>:17" border="0">充值帮助</a><?php } ?></div></li><div class="cle">&nbsp;</div></ul><p class="down" style="height:30px;line-height:20px;padding-top: 5px;"><strong class="kf2gre">交流群：</strong><?php if($this->_var['cfg']['group_qq'])foreach($this->_var['cfg']['group_qq'] as $this->_var['item']){ ?><b><?php echo $this->_var['item']; ?></b><?php } ?><span style="margin-left:10px;">(注:客服不会要求您操作任务、充值，谨防受骗)</span></p></div>
		
		<div id="kuzhan" class="yes_qq" cc="<?php echo $this->_var['cfg']['serv_qq']['0']; ?>">
	  		<a class="pro_1" href="help.php" target="_blank"></a>
	  		<a class="pro_2 yxiaoqq" href="javascript:;"></a>
	  		<a class="pro_22 yxiaoqq" href="javascript:;"></a> 
	  		<a class="pro_3" href="javascript:;" target="_blank"><?php echo $this->_var['cfg']['group_qq']['0']; ?></a>
	  		<a class="pro_4 rtopnew" href="javascript:;"></a>
		</div>
		<div id="tirenwuinfo">
			<div class="tirenwu_bot">
				<ul class="tirenwu_cont">
					<li nov="0" style="margin-top: 37px;"><span class="span1"></span></li>
					<li nov="1"><span class="span1"></span></li>
					<li nov="2" style="margin-top: 2px;"><span class="span1"></span></li>
					<li nov="3" style="margin-top: 35px;"><span class="span1"></span></li>
					<li nov="4"><span class="span1"></span></li>
					<li nov="5" style="margin-top: 2px;"><span class="span1"></span></li>
				</ul>
			</div>
			<ul class="tirenwu_mis"></ul>
		</div>

	</div>
</div>

<div id="m_logo">
	<a href="http://www.haohuisua.com" class="logo">
		<img src="themes/default/images/public/head_logo.png" alt="好会刷_淘宝刷信誉">
	</a>

	<a class="gg" target="_blank" href="help.php">
		<img border="0" src="themes/default/images/public/3qq.png">
	</a>
</div>

<div id="m_menu">
  	<div class="menu_nav">
	  <div class="m_menu_nav">
		<ul>
			<li class="n-home" id="n-home">
				<a href="home.php">首页</a>
			</li>
			<!-- <li id="yi_fuwu" class="n-fuwu" style="position: relative; display: none;">
				<a href="http://fuwu.haohuisua.com">卖家服务</a>
			</li> -->
			<li class="n-taobao" <?php if($this->_var['model_type'] == 'taobao'){ ?>id="n-taobao"<?php } ?>>
				<a href="taobao.php">淘宝大厅</a>
			</li>
			<li class="n-weixin">
				<a href="taobao.php?mod=showweixin" <?php if($this->_var['model_type'] == 'showweixin'){ ?>id="n-weixin"<?php } ?>>微信大厅</a>
			</li>
			<style>
				.n-weixin{/*background-position: -470px -226px;*//*border: 1px solid #00F;*/background: url(themes/default/images/home/dmh-home-ico.png) no-repeat;background-position: -470px -226px;}
			</style>
			<!--li class="n-paipai" <?php if($this->_var['model_type'] == 'paipai'){ ?>id="n-paipai"<?php } ?>>
			
				<a href="paipai.php">拍拍大厅</a>
			</li-->
			
			<li class="n-wk" <?php if($this->_var['model_type'] == 'sou'){ ?>id="n-sou"<?php } ?>>
				<a href="sou.php">搜索大厅</a>
			</li>
			<li class="n-tuoguan" <?php if($this->_var['model_type'] == 'single'){ ?>id="n-tuoguan"<?php } ?>>
				<a href="single.php">快递单号</a>
			</li>
			<li id="er_fuwu" class="n-fuwu">
				<a href="home.php?act=soft">软件下载</a>
			</li>
			
			<li class="n-bbs">
				<a href="bbs.php" target="_blank">问答</a>
			</li>
			
			<li class="n-point">
				<a href="home.php?act=buypoint">购买麦点</a>
			</li>
			<li class="n-collect">
				<a href="home.php?act=tuoguan">网店托管</a>
			</li>
			<li class="n-member" <?php if($this->_var['model_type'] == 'user'){ ?>id="n-member"<?php } ?>>
				<a href="user.php">会员中心</a>
			</li>
		</ul>
		<a class="fplink" href="help.php?act=guide">
            <?php if($this->_var['public_right']['menu'] == 'public_right'){ ?><img src="/<?php echo $this->_var['public']['path']; ?>"><?php } ?>
           <!-- <img src="themes/default/images/home/text1.gif"> -->
		</a>
	   </div>
  	</div>
</div>
<script>
	alert('<?php echo $this->_var['model_type']; ?>');
</script>

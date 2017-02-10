<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<script type="text/javascript" src="themes/default/js/user_index.js"></script>

<div id="main">
		
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right"><style>
.help{overflow: hidden;background:white;position: relative;height:350px;}
.help ul {width: 723px;height: 245px;overflow: hidden;position: absolute;/*top: 50px;*/left: 0;}
.help .bannerbg1{background:#29233b;}
.help .bannerbg2{background:#140c3d;}
.help .bannerbg3{background:url(themes/default/images/home/bannerbg3.gif) repeat-x;height:406px;}
.help li {float:left; width:100%; height:245px;}
.help li span {display:block; width:723px;margin:0 auto; height:406px}
.help li span .sorttg{margin: auto;position: absolute;margin-left: 25px;top: 300px;color: white;}
.help li span .sorttg:hover{text-decoration: underline;}
.flicking_con{position: relative;width: 100%;height: 30px;float: left;}
.flicking_con .flicking_inner {position: absolute;top: 215px;left: 315px;z-index: 999;width: 300px;height: 20px;}
.flicking_con a {float:left; width:17px; height:17px; margin-left:15px; padding:0;background:url(themes/default/images/home/snavli.png) 0px -19px no-repeat; display:block; text-indent:-9999em;}
.flicking_con a.on {background-position:0 0;}
/*#btn_prev,#btn_next{z-index:11111;position:absolute;display:block;width:30px!important;height:70px!important;top:50%;margin-top:-37px;display:none;background:url(themes/default/images/home/dmh-home-ico.png) no-repeat;}*/
#btn_prev{background-position:-728px -85px;left:30px;display:none;}
#btn_next{background-position:-728px -156px;right:30px;display: none;}
.add .career2 .hrr{background:none;}
.add .career2 .hrr:hover{background: url(themes/default/images/user/ewrew.png) no-repeat 4px -75px;}
</style>

<div id="mid">
	<div class="top_gr">
		<div class="portrait">
			<div class="portrait_img"> 
				<img width="100" height="100" class="touxiang" src="themes/default/images/user/headimg/<?php if($this->_var['uinfo']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['uinfo']['headimg']; ?><?php } ?>">
			</div>
			<span title="到期时间：<?php echo $this->_var['rank_expiry']; ?>"><?php echo $this->_var['uinfo']['rank_name']; ?></span>
		</div>
		<div class="content">
			<ul>
				<li class="content_name" title="消费总金额：0.00元">
					<?php echo $this->_var['uinfo']['user_name']; ?>
					<?php if($this->_var['uinfo']['safepass'] == ''){ ?>
					<a style="font-size: 12px; margin-left: 10px; font-weight: normal; color: rgb(247, 84, 75);" href="user.php?act=operate">[设置安全码]</a>
					<?php } ?>
				</li>
				<li class="content_li1">
					<span class="imgico"></span>
					<p style="float: left; width: 150px;">存款: <font style="color: #FA5C12;"><?php echo $this->_var['uinfo']['user_money']; ?></font>元</p>
					<a href="user.php?act=topup">充值</a>  
					<a href="user.php?act=payment">提现</a> 
					<a href="user.php?act=payde">明细</a>
				</li>
				<li class="content_li2">
					<span class="imgico"></span>
					<p style="float: left; width: 150px;">麦点: <font style="color: #FA5C12;"><?php echo $this->_var['uinfo']['pay_money']; ?></font>个</p>
					<a href="home.php?act=buypoint">购买麦点</a>
					
				</li>
				<li class="content_li3">
					<span class="imgico"></span>本次登录：<?php echo $this->_var['ip_area']; ?>
					<a href="user.php?act=anquan" style="float: right;font-size: 12px;background: url(themes/default/images/user/aqbb.png) no-repeat;padding-left: 20px;line-height: 25px;">进入安全中心</a>
				</li>
				<li class="content_li4">
					<div class="progress">
						<div class="jindutiao">
							<b style="width:<?php echo $this->_var['jyt']; ?>%;"></b>
							<span title="经验条"><?php echo $this->_var['uinfo']['pay_points']; ?>/<?php echo $this->_var['uinfo']['max_points']; ?></span>
						</div>
					</div>
					<div class="switch">
						<span class="dv">异地登陆</span>
						<span class="imgico <?php if($this->_var['uinfo']['otlog']){ ?>dv_sp1<?php }else{ ?>dv_sp0<?php } ?>" title="异地登陆限制关闭"></span>
						<div class="remone"></div>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="center_gr" style="position: relative;">
		<div class="tweer">
			<div class="imgico <?php if($this->_var['uinfo']['mprz']){ ?>tweer_11<?php }else{ ?>tweer_10 bindPhone<?php } ?>" id="actphone" data="<?php echo $this->_var['uinfo']['mobile_phone']; ?>"></div>
			<font class="imgico <?php if($this->_var['uinfo']['mprz']){ ?>tweer_f11<?php }else{ ?>tweer_f10<?php } ?>"></font>
			<span><?php if($this->_var['uinfo']['mprz']){ ?>已完成<?php }else{ ?>送1个麦点<?php } ?></span>
		</div>

		<div class="tweer">
				
				<div class="imgico <?php if($this->_var['uinfo']['isem']){ ?>tweer_21<?php }else{ ?>tweer_20 icotwe<?php } ?>"></div>
				<font class="imgico <?php if($this->_var['uinfo']['isem']){ ?>tweer_f21<?php }else{ ?>tweer_f20<?php } ?>"></font>
				<span><?php if($this->_var['uinfo']['isem']){ ?>已完成<?php }else{ ?>送1个麦点<?php } ?></span>
		</div>
		<div class="tweer">
				<div class="imgico <?php if($this->_var['uinfo']['isdc']){ ?>tweer_31<?php }else{ ?>tweer_30 examine<?php } ?>"></div>
				<font class="imgico <?php if($this->_var['uinfo']['isdc']){ ?>tweer_f31<?php }else{ ?>tweer_f30<?php } ?>"></font>
				<span><?php if($this->_var['uinfo']['mprz']){ ?>已完成<?php }else{ ?>送1个麦点<?php } ?></span>
		</div>
	</div>
	
</div>

<div class="right_gr">
	<a class="rw" href="<?php echo $this->_var['goto']; ?>">
		<div class="right_gr_top">
			<div class="right_gr_icon">
				<div class="imgico renwu">
				<?php if($this->_var['canhandle']){ ?><div class="imgico renwu_icon"><span><?php echo $this->_var['canhandle']; ?></span></div><?php } ?>
				</div>
				<div class="imgico handle"></div>
			</div>
		</div>
		
	</a>
	<a href="?act=complaint">
		<div class="right_gr_bottom">
			<div class="right_gr_icon">
				<div class="imgico shensu">
					<?php if($this->_var['complaint']){ ?><div class="imgico shensu_icon"><span><?php echo $this->_var['complaint']; ?></span></div><?php } ?>
				</div>
				<div class="imgico appeal"></div>
			</div>
		</div>
	</a>
</div>


<div class="gonggao">
	<div class="imgico ico"></div>
	<?php if($this->_var['hot_bbs'])foreach($this->_var['hot_bbs'] as $this->_var['key'] => $this->_var['v']){ ?>
		<a title="<?php echo $this->_var['v']['title']; ?>" target="_blank" href="bbs.php?act=view&id=<?php echo $this->_var['v']['id']; ?>"><?php echo $this->_var['v']['title']; ?></a>
	<?php } ?>
</div>


<div class="add">
	<div class=" business" style="margin-left: 45px;">
		<div class="add_bw">
				<div class="imgico business_1"> </div>
				<div class="imgico business_2"> </div>
				<a class="imgico" href="user.php?act=ensure"></a>
		</div>
	</div>
	<div class="career1" style="margin-left: 60px;">
		<div class="add_bw">
				<div class="imgico career1_1"> </div>
				<div class="imgico career1_2"> </div>
				<a class="imgico" href="user.php?act=specialty"></a>
		</div>
	</div>
	<div class="career2" style="margin-left: 60px;">
		<div class="add_bw">
				<div class="imgico career2_1"> </div>
				<div class="imgico career2_2"> </div>
				<a class="imgico" href="user.php?act=vip"></a>
		</div>
	</div>
	<div class="career2" style="margin-left: 60px;background: url(themes/default/images/user/ewrew.png) no-repeat -130px 5px;">
		<div class="add_bw">
				<div class="imgico career2_1" style="background:none;"> </div>
				<div class="imgico career2_2" style="background:none;"> </div>
				<a class="imgico hrr" href="home.php?act=tuoguan"></a>
		</div>
	</div>
</div>

<div class="trends">
	<div class="imgico trends_img"></div>
	<ul class="line">
	<?php if($this->_var['dt']['0']['logtype']){ ?>
	<?php if($this->_var['dt'])foreach($this->_var['dt'] as $this->_var['key'] => $this->_var['v']){ ?>
		<li><a href="javascript:;"><?php echo $this->_var['v']['logtype']; ?></a> <?php echo $this->_var['v']['createtime']; ?></li>
	<?php } ?>
	<?php }else{ ?>
	<p>暂无动态信息!</p>
	<?php } ?>
	</ul>	
</div>

<div class="help">
	<div class="help_head">
		<div class="imgico help_head_img"></div>
		<div class="help_head_text">
			<span class="bangzu_link"><a target="_blank" href="help.php?act=guide">卖家帮助</a><a target="_blank" href="help.php?act=guide">买家帮助</a><a href="help.php?act=newpeople" target="_blank">常见问题</a></span>
		</div>
	</div>
	<div class="main_image">
		<ul style="overflow: visible; width: 723px;">					
			<li class="bannerbg1" style="height: 245px; float: none; display: block; position: absolute; top: 0px; left: -723px; width: 723px;">
				<span class="banner-1" style="height:245px;">
					<a href="home.php?act=tuoguan"><img src="themes/default/images/user/img21.jpg" width="723" height="245"></a>
				</span>
			</li>
			<li class="bannerbg2" style="height: 245px; float: none; display: block; position: absolute; top: 0px; left: 0px; width: 723px;">
				<span class="banner-2" style="height:245px;"> 
					<a href="help.php"><img src="themes/default/images/user/img3.jpg" width="723" height="245"></a>
				</span>
			</li>
			<li class="bannerbg3" style="height: 245px; float: none; display: block; position: absolute; top: 0px; left: -1446px; width: 723px;">
				<span class="banner-3" style="height:245px;">
					<a href="help.php"><img src="themes/default/images/user/img2.jpg" width="723" height="245"></a>
				</span>
			</li>
		</ul>
		<a href="javascript:;" id="btn_prev" style="width: 723px; overflow: visible;"></a> 
		<a href="javascript:;" id="btn_next" style="width: 723px; overflow: visible;"></a>
	</div>
	<div class="flicking_con main_visual">
		<div class="flicking_inner">
			 <a href="javascript:;" nav="1" class="">1</a>
			 <a href="javascript:;" nav="2" class="on">2</a>
			 <a href="javascript:;" nav="3" class="">3</a>
		</div>
	</div>
</div>
</div>
</div>

<?php echo $this->fetch("common/footer"); ?>
<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/login.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/kongbao.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/login_common.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/dropkick.css">
<style type="text/css">
#page {margin: 30px 10px 25px;padding: 0 15px;}
#page a:hover, .paydetails #page a.nov {background: none repeat scroll 0 0 #EAF4FD;border-color: #B0D0E9;}
#page a {background: none repeat scroll 0 0 #F8F8F8;border: 1px solid #E8E8E8;display: block;float: left;height: 25px;margin: 0 2px;text-align: center;width: 25px;}
#page .pr,.total {float: right;}
#page a:hover, #page a.now-page {background: #EAF4FD;border-color: #B0D0E9;}
.oranges{color:#f47c20}
.yellows{color:#FF9000}
</style>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css">
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>


<div style="width: 1000px;margin: 0 auto;"><div id="cengci">
	<div class="bwcont">
	<div class="pngimg">
	  <span class="over"></span>
	  <a class="tuoguan" href="home.php?act=tuoguan" target="_blank"></a>
	  <a class="renzheng" href="http://user.haohuisua.com" target="_blank"></a><i class="next"></i>
	  <i class="next"></i>
	</div>
	</div>
</div>
<p class="hdfot"></p>
<p class="hdfots" style="display:none;"></p>
<div class="bw" style="margin-bottom:0px;">
	<ul class="rwdt_info">
		<li>
		  <p class="fd">账户余额：<strong class="oranges"><?php echo $this->_var['uinfo']['user_money']; ?></strong> 元</p>
		<a title="将存款提取到我的网银或财付通上" target="_blank" href="user.php?act=payment" class="hico tx"></a></li>
		<div class="cle"></div>
		<li><p class="fd">麦点：<strong class="oranges"><?php echo $this->_var['uinfo']['pay_money']; ?></strong> 个</p><a href="user.php?act=rechange" title="将保证金兑换成能发布任务的麦点" target="_blank" class="hico hs"></a></li>
		<div class="cle"></div>
		<li><p>积分：<strong class="oranges"><?php echo $this->_var['uinfo']['rank_points']; ?></strong> 个</p></li>
		<li><p class="fd">属于：<?php echo $this->_var['uinfo']['rank_name']; ?></p>
			
			
		</li>
		<div class="cle"></div>
		<li>好评率：<strong class="green">100%</strong></li>
		<li>有效投诉：<strong class="oranges"><?php echo $this->_var['complaint']; ?></strong></li>
	</ul>
	<div class="rwdt_bk">
		<p class="sub_bt">
			<a href="javascript:;" val="1">网银充值</a>
			<a href="javascript:;" val="0">支付宝充值</a>
			<a href="javascript:;" val="2" class="">购买麦点</a>
			<a href="javascript:;" val="3" class="nov">财付通充值</a>
		</p>
		 <div id="buyboxcont">
			<div class="task_header" style="display: none; padding: 5px 10px;">
			
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:10px;">
						<tbody><tr><td>收款支付宝账号：<a target="_blank" href="user.php?act=topup">进入支付宝付款页面</a> </td></tr>
						<tr><td>转账时只能备注：<strong class="yellows">充值</strong></td></tr>
						<tr><td>(转账完毕后验证交易号，1分钟到账)</td></tr>
						<tr>
	                	   <td colspan="2"><a class="tc_b" href="bbs.php" target="_blank">查看充值教程</a><a class="tc_k" target="_blank" href="user.php?act=topup">验证订单号</a></td>
	                    </tr>
					</tbody></table>
			   
	       </div>
	       <div class="task_header" style="display: none;">
				<table width="90%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:10px;">
				  <tbody>
				  	<tr>
					<td width="35%" height="30" align="right" valign="top">充值用户名：</td>
					<td><input type="text" name="username" id="username" class="rwdt_inp" style="color:#666" value="<?php echo $this->_var['uinfo']['user_name']; ?>" disabled="disabled"></td>
				  </tr>
				  <tr>
					<td height="30" align="right" valign="top">充值金额：</td>
					<td><input type="text" name="money" id="money" class="rwdt_inp" style="color: #D9281E;font-weight: bold;" value="100"> 
					<!-- <span class="oranges">(0.5%手续费)</span> --><a href="user.php?act=vip" style="margin-left: 5px;">申请VIP只需0.2%</a></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td><a target="_blank" href="user.php?act=topup" class="tico cz"></a></td>
				  </tr>
			  </tbody></table>
	       </div>
		    <div class="task_header" style="display: none;">
						<form id="q_f_3" action="home.php" method="get" onsubmit="return checkForm3();">
						<input type="hidden" name="act" value="buypoint">
								<table width="90%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:10px;">
								<tbody><tr>
										<td width="35%" height="30" align="right" valign="middle">购买价格：</td>
										<td><span style="color:#D9281E; font-weight:bold;"><span id="jiage1">0.68</span>元=1个麦点</span></td>
									</tr>
								<tr>
										<td width="35%" height="30" align="right" valign="middle">购买数量：</td>
										<td><input name="nums" id="cardnums" value="20" type="text" size="10" maxlength="4">(最少购买1个)</td>
									</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type="submit" class="tico cz"></td>
								</tr>
							</tbody></table>
						</form>
	       </div>
		    <div class="task_header" style="">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
	              	<tbody>
	              	<tr style="height: 8px;float: left;"><td>&nbsp;</td></tr>
					<tr><td>收款财付通账号：<a target="_blank" href="user.php?act=topup">进入财付通付款页面</a> </td></tr>
					<tr><td>转账时只能备注：<strong class="yellows"><?php echo $this->_var['uinfo']['user_name']; ?></strong></td></tr>
					<tr><td>(转账完毕后验证交易号，1分钟到账)</td></tr>
	                <tr>
	                	<td colspan="2"><a class="tc_b" href="bbs.php" target="_blank">查看充值教程</a><a class="tc_k" target="_blank" href="user.php?act=topup">验证订单号</a></td>
	                </tr>
	              </tbody>
				</table>
	       </div>
	  </div>
	</div>
	<div class="rwdt_bk2">
		<span class="header-button">
			<a href="help.php" style="display: block; height: 36px; width: 110px; float: left;background:url(themes/default/images/taobao/rwdtnew.gif) no-repeat 0px -156px;" target="_blank"></a>
			<a style="display: block; height: 36px; width: 110px; float: left; margin-left: 22px;background:url(themes/default/images/taobao/rwdtnew.gif) no-repeat 0px -193px;" href="help.php" target="_blank"></a>
		</span>
		<p class="tico ts">接实物任务后立即收货好评将 <span class="oranges">- 20 </span>麦点</p>
		<p class="tico ts">任务过程中旺旺聊到刷信誉平台相关字眼 <span class="oranges">- 5 </span>麦点</p>
		<p class="tico ts">为了您资金安全，接手方淘宝支付后务必在<span class="blue">15</span>分钟内回到平台操作任务点击“已付款” </p>
	</div>
</div>


<div><div class="center">

<div class="project">
     
<style type="text/css">
	.MENU_nav ul li.nover{background-color: rgb(0, 153, 255);}
</style>
     <div class="MENU_nav">
         <ul id="leftmenu0">
             <a href="single.php"><li <?php if($this->_var['mod'] == 'single'){ ?>class="nover"<?php } ?>>单号大厅</li></a>
             <a href="single.php?mod=bag"><li <?php if($this->_var['mod'] == 'bag'){ ?>class="nover"<?php } ?>>空包中心</li></a>
             <!-- <a href="single.php?mod=deliver"><li <?php if($this->_var['mod'] == 'deliver'){ ?>class="nover"<?php } ?>>发货地址</li></a>
             <a href="single.php?mod=wait"><li <?php if($this->_var['mod'] == 'wait'){ ?>class="nover"<?php } ?>>等待发货</li></a>
             <a href="single.php?mod=already"><li <?php if($this->_var['mod'] == 'already'){ ?>class="nover"<?php } ?>>已经发货</li></a> -->
             <a href="single.php?mod=apply"><li <?php if($this->_var['mod'] == 'apply'){ ?>class="nover"<?php } ?>>已买单号</li></a>
         </ul>
      </div>   
     
     
    <div class="kongbao_list" style="display: block; height:<?php if($this->_var['mod'] == 'bag'){ ?>998<?php }else{ ?>530<?php } ?>px;">
		<?php if($this->_var['mod'] == 'single'){ ?><?php echo $this->fetch("single/single"); ?><?php } ?>
		<?php if($this->_var['mod'] == 'bag'){ ?><?php echo $this->fetch("single/bag"); ?><?php } ?>
		<?php if($this->_var['mod'] == 'deliver'){ ?><?php echo $this->fetch("single/deliver"); ?><?php } ?>
		<?php if($this->_var['mod'] == 'wait'){ ?><?php echo $this->fetch("single/wait"); ?><?php } ?>
		<?php if($this->_var['mod'] == 'already'){ ?><?php echo $this->fetch("single/already"); ?><?php } ?>
		<?php if($this->_var['mod'] == 'apply'){ ?><?php echo $this->fetch("single/apply"); ?><?php } ?>
 </div>
</div>
     <img src="themes/default/images/single/pic_01.jpg" width="998" height="25">
</div>
</div>
<?php echo $this->fetch("common/footer"); ?>
<div id="content"><div id="cengci">
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
		  <p class="fd">账户余额：<strong class="orange"><?php echo $this->_var['uinfo']['user_money']; ?></strong> 元</p>
		<a title="将存款提取到我的网银或财付通上" target="_blank" href="user.php?act=payment" class="hico tx"></a></li>
		<div class="cle"></div>
		<li><p class="fd">麦点：<strong class="orange"><?php echo $this->_var['uinfo']['pay_money']; ?></strong> 个</p><a href="user.php?act=rechange" title="将保证金兑换成能发布任务的麦点" target="_blank" class="hico hs"></a></li>
		<div class="cle"></div>
		<li><p>积分：<strong class="orange"><?php echo $this->_var['uinfo']['rank_points']; ?></strong> 个</p></li>
		<li><p class="fd">属于：<?php echo $this->_var['uinfo']['rank_name']; ?></p><?php if($this->_var['uinfo']['verify'] == 1){ ?><span style="margin: 5px 0 0 0px;background: url(themes/default/images/taobao/verify.png) no-repeat;float: left;width: 18px;height: 18px;" title="通过V实名认证用户"></span><?php } ?>
			
			
		</li>
		<div class="cle"></div>
		<li>好评率：<strong class="green">100%</strong></li>
		<li>有效投诉：<strong class="orange"><?php echo $this->_var['complaint']; ?></strong></li>
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
						<tr><td>转账时只能备注：<strong class="yellow">充值</strong></td></tr>
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
					<!-- <span class="orange">(0.5%手续费)</span> --><a href="user.php?act=vip" style="margin-left: 5px;">申请VIP只需0.2%</a></td>
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
					<tr><td>转账时只能备注：<strong class="yellow"><?php echo $this->_var['uinfo']['user_name']; ?></strong></td></tr>
					<tr><td>(转账完毕后验证交易号，1分钟到账)</td></tr>
	                <tr>
	                	<td colspan="2"><a class="tc_b" href="help.php" target="_blank">查看充值教程</a><a class="tc_k" target="_blank" href="user.php?act=topup">验证订单号</a></td>
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
		<p class="tico ts">接实物任务后立即收货好评将 <span class="orange">- 20 </span>麦点</p>
		<p class="tico ts">任务过程中旺旺聊到刷信誉平台相关字眼 <span class="orange">- 5 </span>麦点</p>
		<p class="tico ts">为了您资金安全，接手方淘宝支付后务必在<span class="blue">15</span>分钟内回到平台操作任务点击“已付款” </p>
	</div>
	<div class="rwdt_gg" style="margin-top: 12px;"><a href="help.php" target="_blank"><img src="themes/default/images/taobao/dil.jpg"></a></div>
	<div class="rwdt_gg2" style="margin-top: 12px;"><a href="help.php" target="_blank"><img src="themes/default/images/taobao/frw.gif"></a></div>
</div>
<div class="tico menu mesou">
	<a href="?mod=index" class="sou <?php if($this->_var['mod'] == 'index'){ ?>nov<?php } ?>" title="淘宝任务大厅">搜索任务大厅</a>
	<a href="?mod=inTask" class="sou <?php if($this->_var['mod'] == 'inTask'){ ?>nov<?php } ?>" title="已接任务">已接任务</a>
	<a href="?mod=outTask" class="sou <?php if($this->_var['mod'] == 'outTask'){ ?>nov<?php } ?>" title="已发任务">已发任务</a>
	<a href="?mod=bindBuyer" class="sou <?php if($this->_var['mod'] == 'bindBuyer'){ ?>nov<?php } ?>" title="绑定买号">绑定买号</a>
	<a href="?mod=bindseller" class="sou <?php if($this->_var['mod'] == 'bindseller'){ ?>nov<?php } ?>" title="绑定掌柜">绑定掌柜</a>
	<a href="taobao.php" title="淘宝任务大厅" style="color: rgb(29, 124, 185); background: url(themes/default/images/taobao/t.gif) 0px -1px no-repeat;" class="sou">淘宝任务大厅</a>
</div>
<style type="text/css">
	.tico.mesou{background: url(themes/default/images/taobao/rwdt_1.gif) repeat-x 0 -509px;}
.tico.menu .sou{background: url(themes/default/images/taobao/rwdt_1.gif) -1px -468px no-repeat;color:white;}
.tico.menu .sou:hover,.tico.menu .sou.nov{background:url(themes/default/images/taobao/rwdt_1.gif) -1px -422px no-repeat;
	color:#fff;}
</style>
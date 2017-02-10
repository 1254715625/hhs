<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_payment.css">
<script type="text/javascript" src="themes/default/js/sendsms.js"></script>
<script type="text/javascript" src="themes/default/js/user_payment.js"></script>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">
<style>
.withdraw-way {display: block;float: left;margin:0 20px 20px 20px;}
.withdraw-selection {width: 200px;height: 71px;float: left;margin: 0 0 0 -1px;border: 1px solid #DEDEDE;display: inline-block;background-color: #F7F7F7;cursor: pointer;}
.withdraw-normal-ico {background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat -51px 0;display: inline-block;overflow: hidden;font-size: 0px;width: 50px;height: 38px;margin: 17px 0 3px 34px;float: left;}
.withdraw-quick-ico {background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat -51px -39px;display: inline-block;overflow: hidden;font-size: 0px;width: 50px;height: 43px;margin: 12px 0 3px 34px;float: left;}
.withdraw-intime-ico {background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat -51px -83px;display: inline-block;overflow: hidden;font-size: 0px;width: 50px;height: 44px;margin: 11px 0 3px 34px;float: left;}
.withdraw-selection dl {width: 96px;display: inline-block;margin: 18px 0 0 0;padding: 0 0 0 12px;}
.withdraw-selection dl dt {font-family: "微软雅黑","宋体",Arial;font-size: 14px;color: #0078B6;line-height: 14px;}
.withdraw-selection dl dd {font-family: "宋体",Arial;font-size: 12px;color: #999;margin: 3px 0 0 0;}
.withdraw-dl-underline{background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat 0 -135px;overflow: hidden;font-size: 0px;width: 200px;height: 8px;margin: 14px 0 0 0;display: block;border-top: 2px solid #A3A3A3;}
.withdraw-way .on {background-color: #FFF;}
.add-card-tip1{margin:50px 68px;display: inline-block;}
.add-card-tip2{margin:10px 0 30px 20px;display: inline-block;}
.add-card-tip1 .add-card-text{background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat;overflow: hidden;font-size: 0px;width: 287px;height: 19px;background-position: 0 -181px;display: block;}
.add-card-tip1 .add-card-ico {background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat;display: inline-block;overflow: hidden;font-size: 0px;width: 126px;height: 88px;background-position: -258px 0;margin: 30px 0 0 75px;cursor: pointer;}
.add-card-tip1 .add-card-ico-hover{width:126px;height:88px;background-position:-258px -89px;text-decoration:none;margin:30px 0 0 230px;cursor:pointer;}
.add-card-tip1 .add-card-ico:hover{width:126px;height:88px;background-position:-258px -89px;text-decoration:none;}
.add-card-tip2 .label-bank{float: left;width: 90px;margin-left: -5px;padding-right: 5px;text-align: right;line-height: 55px;font-size: 14px;color: #000;}
.add-card-tip2 .element{float: left;min-height: 22px;padding-top: 13px;}
.add-card-tip2 .element .js-bank-list{float: left;margin: 0 8px 8px 0;border: 1px solid #D8D8D8;cursor: pointer;display: inline-block;width: 156px;height: 57px;overflow: hidden;}
.add-card-tip2 .element .check_xu{background: url(themes/default/images/user/withdraw_mgr_png24.png) -102px 0 no-repeat;border: 1px solid white;}
.add-card-tip2 .element .js-bank-list dl{padding: 1px 0 0 1px;overflow: hidden;margin: 0;}
.add-card-tip2 .element .js-bank-list dl dt{margin: 3px 0 0 0;position: relative;}
.add-card-tip2 .element .js-bank-list dl dt .ico{background: url(themes/default/images/user/bank.png) no-repeat;display: inline-block;position: relative;height: 33px;width: 153px;overflow: hidden;line-height: 999px;vertical-align: top;}
.add-card-tip2 .element .js-bank-list dl dt .bank-ccb{background-position: 0 -99px;}
.add-card-tip2 .element .js-bank-list dl dt .bank-last-num{font-family: Tahoma;font-size: 12px;position: absolute;z-index: 3;color: #333;right: 5px;top: 5px;}
.add-card-tip2 .element .js-bank-list dl .js-finish-time{font-family: "宋体",Arial;font-size: 12px;color: #999;margin: -2px 0 0 9px;}
.add-card-tip2 .element .add-other-bank{height: 55px;width: 60px;display: inline-block;float: left;margin: 5px 0 0 0;cursor: pointer;}
.add-card-tip2 .element .mini-add-bank-ico{background: url(themes/default/images/user/withdraw_mgr_png24.png) no-repeat;display: inline-block;overflow: hidden;font-size: 0px;width: 51px;height: 48px;background-position: -102px -58px;vertical-align: top;}
.add-card-tip2 .element .mini-add-bank-ico:hover{width:51px;height:48px;background-position:-154px -58px;}
.add-card-tip2 .element #amount{border: 1px solid #9AB2CA;border-right-color: #C3D3E3;border-bottom-color: #C3D3E3;background-color: #FFF;width: 141px;padding: 1px 1px 1px 6px;margin-right: 6px;height: 26px;line-height: 22px;font-size: 18px;}
.add-card-tip2 .element #submit_btn{background: url(themes/default/images/user/tx_btn.gif) no-repeat 0 -143px;height: 36px;padding: 0 118px 0 15px;border: 0;cursor: pointer;text-indent: -9999px;}
.addvip{color: #1996E6;}
.addvip:hover{color: #F30;}
</style>
<?php if($this->_var['uinfo']['rank_points'] < $this->_var['cfg']['integral_withdrawals'] && $this->_var['uinfo']['rank_expiry'] == 0 && $this->_var['uinfo']['business'] == 0){ ?>
<div id="tss" style="float: left; width: 663px; margin: 0px 35px; text-align: center; height: 308px; background: url('themes/default/images/user/shangb.jpg') no-repeat;"><a href="http://taobao.haohuisua.com" style="width: 165px;height: 45px;float: left;text-indent: -9999px;margin: 250px 0 0 242px;">继续完成任务</a></div>
<?php }else{ ?>
<div id="tss" style="float: left;  width: 750px;  margin-left: 10px;">
  	<div class="withdraw-way"><!-- 
	    <div class="withdraw-selection">
	        <span class="withdraw-normal-ico">普通提现</span>
	        <dl><dt>普通提现</dt><dd>1-3天内到账</dd></dl>
	    </div> -->
	    <div class="withdraw-selection on" jl="no">
	        <span class="withdraw-quick-ico">快速提现</span>
	        <dl><dt>快速提现</dt><dd>1-3小时到账</dd></dl>
	        <!-- <span class="withdraw-dl-underline"></span> -->
	    </div>
	    <div class="withdraw-selection " jl="yes">
	        <span class="withdraw-intime-ico">提现记录</span>
	        <dl><dt>提现记录</dt><dd>充值存款不予提现</dd></dl>
	        <!-- <span></span> -->
	    </div>
	</div>
	<script type="text/javascript">
	$(function(){
		$(".withdraw-selection").click(function(){
			var index=$(this).index();
			if(index==0){
				location.href="user.php?act=payment";
			}else{
				location.href="user.php?act=payment_list";
			}
		});
	});
	</script>
	<?php if($this->_var['banks']){ ?>
	<div class="add-card-tip2">
				<label class="label-bank">提现账户：</label>
				<div class="element" style=" width: 570px; ">
					<?php if($this->_var['banks'])foreach($this->_var['banks'] as $this->_var['key'] => $this->_var['item']){ ?>
					<div class="js-bank-list<?php if($this->_var['key'] == 0){ ?> check_xu<?php } ?>" val="0" cdata="<?php echo $this->_var['item']['id']; ?>|<?php echo $this->_var['item']['bank_name']; ?>|<?php echo $this->_var['item']['bank_num']; ?>|<?php echo $this->_var['item']['bank_user']; ?>">
						<dl>
						    <dt>
					          <span class="ico bank-ccb" style="background: url(themes/default/images/user/bank<?php echo $this->_var['item']['bank_name']; ?>.jpg) no-repeat 6px 3px;"></span>
					          <span class="bank-last-num ">
					            (<span class="js-card-tail"><?php echo $this->_var['item']['lastnum']; ?></span>)
					          </span>
						    </dt>
						    <dd class="js-finish-time">
						    	
						    	1-3小时到账
						    	
						    </dd>
						</dl>
					</div>
					<?php } ?>
					
					<input id='price' value="<?php echo $this->_var['txsxf']; ?>" type='hidden' />
					<script>
						$(function(){
							//alert($('#price').val())
						})
					</script>
					<div class="add-other-bank">
			            <span class="mini-add-bank-ico" id="add_bank_btn" data="<?php echo $this->_var['uinfo']['mprz']; ?>">添加</span>
			        </div>
				</div>
				<label class="label-bank">提现金额：</label>
				<div class="element" style="width: 380px;">
					<input name="amount" id="amount" type="text" maxlength="5">元
					<input type="hidden" name="yesmoney" id="yesmoney" value="<?php echo $this->_var['yesmoney']; ?>">
				</div>
				
				<div class="element ele1" style=" width: 640px; float: right; padding-top: 5px;">
			        可提现余额: <b style="color:red;"><?php echo $this->_var['yesmoney']; ?></b> 元
			        <span style="color: #0078B6;margin-left: 15px;">今日可提现 <b style="color:red;"><?php echo $this->_var['today_num']; ?></b> 次，预计3小时内到账。</span>
			    </div>
			    <div class="element dxcl" style=" width: 640px; float: right; padding-top: 5px;cursor: pointer;">
			        <input type="checkbox" value="1" name="payment_app_sms" id='payment_app_sms' style=" vertical-align: sub; "> 到帐后短信通知（免费）
			    </div>
				<div class="element" style="  width: 643px; float: right; padding-top: 15px;">
			        <button id="submit_btn" class="tjsq_btn" type="submit">申请提现</button>
			    </div>
			    <div class="element">
			    	<a href="https://www.taobao.com/"><span><img src="themes/default/images/user/50.png" alt=""></span></a>
			    	<a href="https://www.taobao.com/"><span><img src="themes/default/images/user/100.png" alt=""></span></a>
			    	<a href="https://www.taobao.com/"><span><img src="themes/default/images/user/500.png" alt=""></span></a>
			    	<a href="https://www.taobao.com/"><span><img src="themes/default/images/user/1000.png" alt=""></span></a>
			    </div>
	</div>
	<?php }else{ ?>
	<div class="add-card-tip1">
			<span class="add-card-text">添加账户开始提现吧</span>
			<span id="add_bank_btn" class="add-card-ico" data="<?php echo $this->_var['uinfo']['mprz']; ?>">添加账户</span>
	</div>	
	<?php } ?>
	
	
	<div id="cashss" style="display:none;">
		<table border="0" align="center" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>
				<td align="left" colspan="4">您的账户开户名：<?php echo $this->_var['banks']['0']['bank_user']; ?></td>
			</tr>
			<tr>
				<td align="left" colspan="4">当前提现账户号：<?php echo $this->_var['banks']['0']['bank_num']; ?></td>
			</tr>
			<tr>
				<th class="x_xian" style=" width: 150px; ">账户名称 </th>
				<th class="x_xian" style=" width: 90px; ">账户尾号</th>
				<th class="x_xian" style=" width: 90px; ">最低提现额度</th>
				<th class="x_xian" style=" width: 80px; ">操作</th>
			</tr>
			<?php if($this->_var['banks'])foreach($this->_var['banks'] as $this->_var['key'] => $this->_var['item']){ ?>
			<tr>
	            <td class="sjlb" style="height: 40px;">
	            	<input type="radio" name="radiobutton" cdata="<?php echo $this->_var['item']['id']; ?>|<?php echo $this->_var['item']['bank_name']; ?>|<?php echo $this->_var['item']['bank_num']; ?>|<?php echo $this->_var['item']['bank_user']; ?>" <?php if($this->_var['key'] == 0){ ?>checked="checked"<?php } ?>>
	            	<img src="themes/default/images/user/bank<?php echo $this->_var['item']['bank_name']; ?>.jpg" width="113" height="25" align="absmiddle" class="imgbak">
	            </td>
	            <td class="sjlb"><?php echo $this->_var['item']['lastnum']; ?></td>
	            <td class="sjlb">1元起</td>
				<td class="sjlb">
					<a href="javascript:;" cid="<?php echo $this->_var['item']['id']; ?>" class="deleteCash">删除</a>　
					<a href="javascript:;" class="xcont">修改</a>
				</td>
	        </tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
<script>
$(function(){

	//弹出提示框
	<?php echo $this->_var['score']; ?>
	{title: '提示',content:'<div style="background:url(themes/default/images/setwithdrow.png) left top no-repeat; width:600px; height:300px"><span style="position:absolute; left:40%; top:50%; font-size:26px; color:#fff">'+score+'</span></div>', fixed: true,lock:true,cancelValue:'确定', cancel:function(){}
})

</script>
	<div id="cashs">
		<div class="textxs" style=" float: left; margin-left: 20px;margin-top: 20px;">
			<ul style="margin-bottom: 10px;">
				<li class="lanses" style=" color: #0078B6; font-weight: bold; ">为什么提现说：信息不符？</li>
				<li style="padding-bottom:5px;">亲，这类情况一般是由于您填写的卡号，姓名与选择的银行不符造成的，请检查修改后再进行申请提现。</li>
				<li class="lanses" style=" color: #0078B6; font-weight: bold; ">处理提现时间与次数是怎么样的？</li>

				<li style="padding-bottom:5px;">平台VIP、职业接手方每日可提现3次，非VIP每日提现2次。 <a href="user.php?act=vip" class="addvip" target="_blank">申请加入VIP</a><br>平台为2小时内快速提现，处理时间为周一至周日9:00-21:00点，周日集中在12:00点处理一次，节假日另行通知。VIP免手续费，非VIP 100元以上也是免手续费的，100元以下按照2元/笔进行收取。</li>
				<li style=" color:#F00;">友情提醒：工作日内10:00-17:00点是处理时间最快速的时间段，最快1分钟内到账，请安排好提现时间哟。</li>
			</ul>
			<a href="javascript:;" target="_blank"><img src="themes/default/images/boss-1.jpg"></a>
		</div>
	</div>
</div>
<?php } ?>
</div>
</div>
<?php echo $this->fetch("common/footer"); ?>
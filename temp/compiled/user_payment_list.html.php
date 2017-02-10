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
<div id="tss" style="float: left;  width: 750px;  margin-left: 10px;">
  	<div class="withdraw-way"><!-- 
	    <div class="withdraw-selection">
	        <span class="withdraw-normal-ico">普通提现</span>
	        <dl><dt>普通提现</dt><dd>1-3天内到账</dd></dl>
	    </div> -->
	    <div class="withdraw-selection " jl="no">
	        <span class="withdraw-quick-ico">快速提现</span>
	        <dl><dt>快速提现</dt><dd>1-3小时到账</dd></dl>
	        <!-- <span class="withdraw-dl-underline"></span> -->
	    </div>
	    <div class="withdraw-selection on" jl="yes">
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
	
	<div id="cash">
			<table border="0" align="center" cellpadding="0" cellspacing="0">
		        <tbody><tr>
		            <td height="45" colspan="6"><p class="tx_jl">提现记录 已成功提现：<strong class="hongse"><?php echo $this->_var['money']; ?></strong> 元</p> </td>
		        </tr>
				<tr>
					<td class="txjl_bg1" colspan="2">流水号</td>
					<td class="txjl_bg2" colspan="2">创建时间</td>
					<td class="txjl_bg2">金额(元)</td>
					<td class="txjl_bg2" colspan="2">资金渠道</td>
					<td class="txjl_bg3" colspan="2">状态</td>
				</tr>
					
					
					<?php if($this->_var['num']){ ?>
					<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['v']){ ?>
					<tr>
						<td class="data_bg2" colspan="2"><?php echo $this->_var['v']['oid']; ?></td>
						<td class="data_bg2" colspan="2"><?php echo $this->_var['v']['createtime']; ?></td>
						<td class="data_bg2"><span class="hongse"><?php echo $this->_var['v']['user_money']; ?></span></td>
						<td class="data_bg2" colspan="2">
							<?php echo $this->_var['v']['from']; ?>
						</td>
						<td class="data_bg2" colspan="2">
							<span style="color:<?php echo $this->_var['v']['class']; ?>;"><?php echo $this->_var['v']['state']; ?></span>
						</td>
					</tr>
					<?php } ?>
					<?php }else{ ?>
					<tr><td class="data_bg2" colspan="8">无提现记录</td></tr>
					<?php } ?>
		    </tbody></table>
			<div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>
		    
		    
		
		<p style="height:35px;"></p>
	</div>
	
	
	<div id="cashss" style="display:none;">
	</div>
	
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

</div>
</div>
<?php echo $this->fetch("common/footer"); ?>
<?php echo $this->fetch("common/header"); ?>

<link rel="stylesheet" type="text/css" href="themes/default/css/user_topup.css">
<div id="main">
	<div class="user_left">
		<?php echo $this->fetch("user/leftmenu"); ?>
	</div>
	
	<div id="_right">
	<div id="topup">
	
	<div class="Top_h">
		<h2></h2>
	</div>
	
	<ul class="Top_list">
		<?php if($this->_var['results'] [ 0 ] [ 'value' ] == 1){ ?> 
		
		<a class="zhifu0 " href="javascript:;"><span class="Top_list_all"></span></a>
		<?php } ?>
		
		<?php if($this->_var['results'] [ 1 ] [ 'value' ] == 1){ ?> 
		<a class="zhifu1 " href="javascript:;" style="margin-left:10px;"><span class="Top_list_all alipay"></span></a>
		<?php } ?> 
		
		<?php if($this->_var['results'] [ 2 ] [ 'value' ] == 1){ ?> 
		<a class="zhifu2 " href="javascript:;"><span class="Top_list_all taobao"></span></a>
		<?php } ?> 
		
		<?php if($this->_var['results'] [ 3 ] [ 'value' ] == 1){ ?> 
		<a class="zhifu3 " href="javascript:;" style="margin-left:10px;"><span class="Top_list_all other"></span></a>
		
		<?php } ?>
	</ul>
	
	<div class="Top_cun_box">
		<p class="tstitle BankImg"></p>
		<ul class="bankList">
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="gs_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="js_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="ny_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="zg_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="zs_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="ms_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="jt_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="zx_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="gf_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="hz_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="nb_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="yz_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="sz_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="sh_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="pd_yh BankImg"></span></li>
			<li><input type="radio" value="radiobutton" name="radiobutton" class="inlineblock"><span class="xy_yh BankImg"></span></li>
		</ul>	
		<p class="rechargeMoney">
			<span style="float:left;">充值金额：</span>
			<input type="text" name="money" maxlength="5" value="100" class="Top_nums">
			<input type="button" class="Top_sub" value="">
		</p>
		<p class="depict1" style="color: #F00;">网银充值手续费1%，平台承担0.5%，普通用户0.5%手续费，VIP用户0.2~0.4%。
			<strong>
				<a href="home.php?act=buypoint" style="color:blue">立即申请加入VIP</a>
			</strong>
		</p>
		<p class="depict2">
			网银充值 -无需人工充值，自动到账，支持国内20余家银行，充值立即发布任务吧。<br>充值如有问题请联系充值帮助客服：
			<?php if($this->_var['bank'])foreach($this->_var['bank'] as $this->_var['key'] => $this->_var['val']){ ?>
			<img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['val']; ?>:17">
			<a style="color:#1f3415;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_var['val']; ?>&amp;site=qq&amp;menu=yes"><?php echo $this->_var['val']; ?></a>
			<?php } ?>
		</p>
	</div>
	
	
	
	<div class="Top_zhifubao" style="display:none;">
		<span class="zftitle">特别提醒：转账成功后，需要验证信息，一分钟到账。</span>
		<span class="prompt">
			<p id="zxinfo_1" style="font-size: 17px;">支付宝收款账号：<b style="font-weight:bold;color:black;margin-right:20px;cursor: text;" href="javascript:;" id="copylink" link="images/user/wuwenhui.jpg">kfcpay@163.com</b>姓名：<span id="alName">吴文辉</span> <a href="javascript:;" class="erweima" style="font-size: 13px;color: red;margin-left: 20px;text-decoration: underline;">二维码付款</a></p>
			本充值系统为自助入款，需要您在<b>转账成功后自助验证交易号，以及支付宝账号后</b>一分钟入款到平台，充值金额不限，您可以任意转账，手机支付宝转账免手续费。商户版无法验证，请用个人支付宝进行转账.
			<br>
			充值请备注： 
			<span style="font-weight:bold;color:black;">充值</span><br>
			<span style="font-size:12px;color:rgb(206,5,5);">
			如充值遇到问题，请联系充值客服：
			<?php if($this->_var['alipay'])foreach($this->_var['alipay'] as $this->_var['key'] => $this->_var['val']){ ?>
			<a style="color:#1f3415;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_var['val']; ?>&amp;site=qq&amp;menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['val']; ?>:17"><?php echo $this->_var['val']; ?></a>
			<?php } ?>
			</span><br>
			<span style="font-weight:bold;color:red;">为保障资金流动安全，支付宝充值款项无法发布虚拟任务。</span>
		</span>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_2">
			<span class="zh_tbcai"></span>
			<span class="Top_tit2">验证支付宝交易号：</span>
			<input type="text" class="Top_nums2" name="pay_order_sn" placeholder="付款成功后交易明细里一个32位数字编号">
			<a href="bbs.php" target="_blank" style="color: white;margin-left: 10px;font-size: 14px;line-height: 40px;height: 55px;float: left;">什么是交易号？</a>
		</p>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_3">
			<span class="zh_tbcai"></span>
			<span class="Top_tit2">付款的支付宝账号：</span>
			<input type="text" class="Top_nums2" name="pay_order_user" maxlength="30" placeholder="您的支付宝登录账号">
			<a href="bbs.php" target="_blank" style="color: white;margin-left: 10px;font-size: 14px;line-height: 40px;height: 55px;float: left;">什么是支付宝账号？</a>
		</p>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_4">
			<input type="button" class="Top_sub2" value="" style="margin-left: 154px;background:url(themes/default/images/user/alipysub.jpg) no-repeat;">
		</p>
		<!-- <a id="zzyz" href="javascript:;">备注错误了，我要自助验证充值</a> -->
		<!-- <a target="_blank" class="whatHelp" href="http://bbs.haohuisua.com.cn/forum.php?mod=viewthread&tid=1850">查看支付宝充值教程</a>
		<div style='float:left;margin:0 0 22px 22px;display: inline;'>
			<img src="/member/images/user/dsgf1.gif">
		</div> -->
		<!-- <p class="Msg_tip_box2">
			支付宝转账充值 - 自动充值，备注正确账户名验证交易号一分钟内自动到账。<br>
			充值如有问题请联系充值帮助客服：<img border="0" src="http://wpa.qq.com/pa?p=1:2850866329:17"> 
			<a style="color:#1f3415;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2850866329&amp;site=qq&amp;menu=yes">2850866329</a>
		</p> -->
	</div>
	<div class="Top_taobaos" style="display:none;background:#ffac90;">
		<span class="zftitle">特别提醒：转账成功后，需要验证信息，一分钟到账。</span>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_2">
			<span class="zh_tbcai"></span>
			<span class="Top_tit2">验证淘宝充值卡号：</span>
			<input type="text" class="Top_nums2 zh" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="淘宝充值卡的编号">
			<a href="bbs.php" target="_blank" style="color: white;margin-left: 10px;font-size: 14px;line-height: 40px;height: 55px;float: left;">什么是充值卡？</a>
		</p>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_3">
			<span class="zh_tbcai"></span>
			<span class="Top_tit2">验证淘宝充值卡密：</span>
			<input type="text" class="Top_nums2 mm" maxlength="30" placeholder="淘宝充值卡密码">
		</p>
		<p class="zfbmoney" style="margin:0 0 0 15px;" id="zxinfo_4">
			<input type="button" class="Top_sub2 tbqz" value="" style="margin-left: 154px;background:url(themes/default/images/user/alipysub.jpg) no-repeat;">
		</p>
	</div>
	
	<div class="Top_tenpay" style="display:none;">	
		<span class="tenpaytitle">财付通目前只接受直接转账，转账时请预留您的大麦户帐号名。</span>
		<span class="prompt">财付通收款帐号：
			<a target="_blank" style="z-index: 9999;cursor: text;">kfcpay@163.com</a><br>财付通收款姓名： 
			<span style="font-weight:bold;color:black;">刘杨</span><br>转账完毕后，在此页面验证财付通交易号，一分钟内自动到账。
		</span>
		<p class="tenpaymoney">
			<span class="zh_tbcai"></span>
			<span class="Top_tit4">提交财付通交易号:</span>
			<input type="text" class="Top_nums4" name="pay_tenpay_order_sn" maxlength="28">
			<input type="button" class="Top_sub4" value="">
		</p>
		<a id="tenpayyz"></a>
		<a target="_blank" class="whatHelp" href="bbs.php">如何获取财付通交易号？</a>
		<div style="float:left;margin:0 0 22px 22px;display: inline;">
			<img src="themes/default/images/user/pay-tenpay.gif">
		</div>
		<p class="Msg_tip_box4">
			财付通转账充值 - 自动充值，备注正确账户名验证交易号一分钟内自动到账。<br>
			充值如有问题请联系充值帮助客服：
			<?php if($this->_var['caifutong'])foreach($this->_var['caifutong'] as $this->_var['key'] => $this->_var['val']){ ?>
			<img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['val']; ?>:17"> 
			<a style="color:#1f3415;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_var['val']; ?>&amp;site=qq&amp;menu=yes"><?php echo $this->_var['val']; ?></a>
			<?php } ?>
		</p>
	</div>
	
	
	
	
	
</div>
</div>
</div>

<script type="text/javascript">
$(function(){
	$('.zhifu0').click(function(){
		clearZhifu();
		$(this).addClass('nov0');
		$('.Top_cun_box').show();
	});
	$('.zhifu1').click(function(){			
		clearZhifu();
		$(this).addClass('nov1');
		$('.Top_zhifubao').show();
	});
	$('.zhifu2').click(function(){
		clearZhifu();
		$(this).addClass('nov2');
		$('.Top_taobaos').show();
	});
	$('.zhifu3').click(function(){
		clearZhifu();
		$(this).addClass('nov3');
		$('.Top_tenpay').show();
	});
	$('.Top_sub').click(function(){
		var money = $('input[name=money]').val();
		if(isNaN(money)||money<=0){
			art.dialog({id:'money',title: '提示',content: '请输入要充值的金额~',fixed: true,lock: true,cancelValue: '确定',cancel:{}});
			return false;
		}
		if(money > 30000){
			art.dialog({id:'money',title: '提示',content: '单次充值金额不能超过30000~',fixed: true,lock: true,cancelValue: '确定',cancel:{}});
			return false;
		}
		art.dialog({id:'money', title: '提示', fixed: true, lock: true,
			content: '您即将充值金额：'+money+'元，手续费：'+(money * 0.005)+'元<br>点击确定后进入充值页面…',
			okValue:'确定',
			ok : function(){
				window.open("plugins.php?act=shengpay&m="+money);return false;
			},
			cancelValue:'取消',
			cancel:{}
		});		
	});	
	$(".tbqz").click(function(){
		var tid = $('.zh').val();
		var mm = $('.mm').val();
		if(/^[0-9]+$/.test(tid) == false){
			art.dialog({id:'m',title: '提示',content: '请输入请输入充值卡卡号，必须为数字~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(mm==''){
			art.dialog({id:'m',title: '提示',content: '请输入充值卡密码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		art.dialog({id:"ajaxStart",title: '正在加载中..',content:'系统正在处理您的请求，请稍候~',fixed: true,lock: true});

		$.post('user.php?act=topup&&action=taobao',{'tid':tid,'mm':mm},function(data){
			art.dialog.get('ajaxStart').close();
			art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { if(data.state){location.href="user.php?act=topup";}return true;}});
		},'json');
	});
});

function clearZhifu()
{
	$('.zhifu0').removeClass('nov0');
	$('.zhifu1').removeClass('nov1');
	$('.zhifu2').removeClass('nov2');
	$('.zhifu3').removeClass('nov3');
	
	$('.Top_cun_box').hide();
	$('.Top_zhifubao').hide();
	$('.Top_taobaos').hide();
	$('.Top_tenpay').hide();	
}
</script>


<?php echo $this->fetch("common/footer"); ?>
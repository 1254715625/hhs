<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css" />
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao_common.css" />
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript">
$(function(){
	$.get('?mod=getbuyaccount<?php if($this->_var['pages']){ ?>&page=<?php echo $this->_var['pages']; ?><?php } ?>', function(data, suatus){
		$('.sellerdiv').html(data);
	});
});	
</script>
<style type="text/css">
.gaveAddress {
display: block;
width: 52px;
height: 22px;
color: #a68d8b;
background: url('themes/default/images/taobao/buyers_btn.png') no-repeat;
margin-bottom: 2px;
}
.mico.mh_cz {
background-position: 0 -239px;
width: 53px;
height: 24px;
}
.mico {
background: url('themes/default/images/taobao/mhgl_btn.gif') no-repeat;
display: block;
border: none;
cursor: pointer;
overflow: hidden;
}
</style>
<?php echo $this->fetch("taobao/nav_up"); ?>
<div id="moveContent"><div class="cle"></div>
<div class="lst_info">
<div class="mh_tishi">
				1、该页面主要用来绑定和维护用来接任务，购买任务商品的淘宝买号；  <a href="help.php" class="orange">什么是买号？</a><br>
2、根据淘宝的最新安全策略，所有买号都要求必须是完整填写个人信息后才能进行绑定；为了您的买号与任务发布方网店安全请您先将买号信息完善； <a href="help.php" class="orange">如何更安全的使用买号?</a><br>
3、注册的淘宝买号请不要使用同一个开头，后面跟一串排号的数字，这种买号很容易被淘宝封(类似短命的买号就是 shua001，shua002，shua003......） <br>
4、一个买号一天只可以接手6个任务，接手高于6个任务，系统将挂起买号，第二天才进行继续接手任务<br>
			</div>
<div class="bq_menu">
	<a href="http://taobao.haohuisua.com/taobao.php?mod=bindBuyer" class="nov">绑定淘宝买号</a>
	<a href="http://paipai.haohuisua.com/paipai.php?mod=bindBuyer">绑定拍拍买号</a>
</div>
	
    <div>
    	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px;font-size:14px;">
              <tbody><tr>
                <td width="20%" height="30" align="left" valign="middle"><span class="mico taobao"></span></td>
              </tr>
			  <form name="myForm" method="post" id="myForm" onsubmit="return checkForm();"></form>
	          
              <tr>
                <td width="20%" height="40" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody><tr>
                    <td width="160" style="padding:0;">淘宝买家帐号：</td>
                    <td width="310" style="padding:0;"><input onclick="if(this.value.indexOf('输入旺旺名称进行绑定')>=0)this.value='';" value="输入旺旺名称进行绑定" name="nickname" type="text" class="mh_bk" id="nickName"></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody></table></td>
              </tr>
              <tr>
                <td height="60" align="left" valign="middle"><input type="submit" class="mico mh_bdbtn bindBuyer"></td>
              </tr>
			  
              <tr>
                <td width="20%" height="40" align="left" valign="middle" class="mh_xian">您目前是<?php echo $this->_var['uinfo']['rank_name']; ?>用户，可以绑定<?php echo $this->_var['uinfo']['params']['bdmhsl']; ?>个买号！ <a href="user.php?act=vip" class="red">申请VIP</a>最高可绑定<?php echo $this->_var['vipbd']['bdmhsl']; ?>个买号！ <a href="info.php?act=vip" target="_blank" class="blue">查看VIP限权</a></td>
              </tr>
            </tbody></table>

	<div class="sellerdiv"></div>   
	
	</div></div></div></div>
	<?php echo $this->fetch("common/footer"); ?>
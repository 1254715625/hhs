<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao_common.css">
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript">
$(function(){
	$.get('?mod=getaccount&type=seller', function(data, suatus){
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
		1、您目前是<span class="orange"><?php echo $this->_var['uinfo']['rank_name']; ?></span>用户，可以绑定<?php echo $this->_var['uinfo']['params']['bdzgsl']; ?>个掌柜！<br>
2、如果您的帐号还没有发布过任务，可以自己免费删除掌柜一次；发布过任务的帐号删除掌柜需要付费5元！
<br>

</div>
<div class="bq_menu">
	<a href="http://taobao.haohuisua.com/taobao.php?mod=bindseller" class="nov">绑定淘宝掌柜</a>
	<a href="http://paipai.haohuisua.com/paipai.php?mod=bindseller">绑定拍拍掌柜</a>
</div>
	
    <div>
    	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px;font-size:14px;background: url(themes/default/images/taobao/zhangguiname.png) no-repeat top right;" class="zg_tb">
      <tbody><tr>
        <td width="20%" height="30" align="left" valign="middle"><span class="mico taobao"></span></td>
      </tr>

      <tr>
        <td width="20%" height="40" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
          	<tr>
            <td width="23%" style="padding:0;">淘宝掌柜名（旺旺名）：</td>
            <td align="left" style="padding:0;"><input onclick="if(this.value.indexOf('输入旺旺名称') >= 0)this.value='';" value="输入旺旺名称进行绑定" type="text" name="nickName" id="nickName" class="mh_bk"></td>
         	 </tr>
        	</tbody></table>
    	</td>
      </tr>
	 
      <tr>
        <td height="60" align="left" valign="middle"><input type="button" id="addSeller" class="mico mh_bdbtn2"></td>
      </tr>
	   
      <tr>
        <td width="20%" height="40" align="left" valign="middle" class="mh_xian"><span class="orange">您目前是<?php echo $this->_var['uinfo']['rank_name']; ?>用户，可以绑定<?php echo $this->_var['uinfo']['params']['bdzgsl']; ?>个掌柜</span> <a href="user.php?act=vip" class="chengse2">申请VIP</a>最高可绑定<?php echo $this->_var['vipbd']['bdzgsl']; ?>个掌柜！ <a href="info.php?act=vip" target="_blank" class="lanse">查看VIP限权</a></td>
      </tr>
    </tbody>
</table>
	<div class="sellerdiv"></div>   
	
	</div></div></div></div>
	<?php echo $this->fetch("common/footer"); ?>
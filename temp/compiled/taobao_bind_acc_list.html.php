<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" id="sellerbox">
	<tr id="row-head">
		<td width="10" height="37" class="txjl_bg1"></td>
	    <td width="20%" height="37" align="center" valign="middle" class="txjl_bg2 black">淘宝掌柜帐号</td>
        <td width="30%" height="37" align="center" valign="middle" class="txjl_bg2 black">淘宝掌柜信用</td>
		<td width="10%" height="37" align="center" valign="middle" class="txjl_bg2 black">总发布任务</td>
	    <td width="15%" height="37" align="center" valign="middle" class="txjl_bg2 black">绑定时间</td>
	    <td width="15%" height="37" align="center" valign="middle" class="txjl_bg2 black">是否激活</td>
	    <td width="10%" height="37" align="center" valign="middle" class="txjl_bg2 black"></td>
	    <td width="10" height="37" class="txjl_bg3"></td>
      </tr>
			<?php if($this->_var['acclist'])foreach($this->_var['acclist'] as $this->_var['key'] => $this->_var['acc']){ ?>
	  <tr>
		<td></td>
	    <td height="35" align="center" valign="middle" class="mh_xxian">
		  <p class="mh_zg">
			<span class="mico zg_tbico"></span>
			<span><?php echo $this->_var['acc']['nickname']; ?></span>
			<span class="green">&nbsp;(已激活)</span>
		  </p>
		</td>
	    <td>
			<ul class="f-gray">
			<li><span class="other-i good"></span>好评<p style="color:red;">0</p></li>
			<li><span class="other-i normal"></span>好评<p style="color:#F5CC04;">0</p></li>
			<li><span class="other-i bad"></span>差评<p style="color:black;">0</p></li>
			<li><span class="other-i collect"></span>收藏<p style="color:#67bbfe;">0</p></li>
			</ul>
		</td>
	    <td>0</td>
	    <td><?php echo $this->_var['acc']['add_time']; ?></td>
	    <td><input class="active" type="checkbox" checked=""></td>
	    <td>
			<a href="javascript:;" class="gaveAddress">&nbsp;</a>
			<a href="javascript:;" class="mico mh_cz deleteBuyer"></a>
		</td>
	    <td></td>
      </tr>
	<tr>
		<td colspan="8" class="tdline"><hr /></td>	   
	</tr>
	<?php } ?>
</table>
<div class="rwdt_dlm">
	<div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>
</div>
<div class="cle"></div>
<script type="text/javascript">
$(function(){
	$('.active').click(function(){
		var status,obj = $(this),self = this;
		if (obj.attr('checked')=='checked'){
			status = 0;
		}else{
			status = 1;
		}
		var obj=$(this).parents('tr');
		setBakckgoundAndOpacity(obj,'#62c462');
	});
});
</script>
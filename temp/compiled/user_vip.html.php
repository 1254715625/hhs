<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_vip.css">
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right"><div id="vip">
	<div class="puy">
		<p class="vip_tit vip_ico"></p>
		<?php if($this->_var['vip'])foreach($this->_var['vip'] as $this->_var['key'] => $this->_var['v']){ ?>
		<ul class="vip_list vip_ico">
			<li class="vip_dj<?php echo $this->_var['v']['class']; ?> vip_ico"><?php echo $this->_var['v']['rank_name']; ?></li>
			<li class="vip_dj2">
				<select class="months">
					<?php if($this->_var['v']['months'])foreach($this->_var['v']['months'] as $this->_var['k'] => $this->_var['val']){ ?>
					<option value="<?php echo $this->_var['k']; ?>"><?php echo $this->_var['val']; ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
			  <input type="button" data="<?php echo $this->_var['v']['rank_id']; ?>" class="vip_dj3 vip_ico subVip">
			</li>
		</ul>
		<?php } ?>
	</div>
	<table width="505" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
			<td class="txjl_bg1"></td>
			<td width="63%" class="txjl_bg2">&nbsp; vip特权 </td>
			<td width="40%" style="text-align:center;" class="txjl_bg2"><a class="chengse2" target="_blank" href="info.php?act=vip">查看VIP特权表</a></td>
			<td class="txjl_bg3"></td>
		</tr>
		<tr>
			<td height="35">&nbsp;</td>
			<td valign="middle" align="left" colspan="2">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
					<td width="30%" height="55" class="vipsp_i1 vip_ico">&nbsp;</td>
					<td width="30%" class="vipsp_i2 vip_ico">&nbsp;</td>
					<td width="30%" class="vipsp_i3 vip_ico">&nbsp;</td>
				</tr>
				<tr>
					<td height="55" class="vipsp_i4 vip_ico">&nbsp;</td>
					<td class="vipsp_i5 vip_ico">&nbsp;</td>
					<td class="vipsp_i6 vip_ico">&nbsp;</td>
				</tr>
				<tr>
					<td height="55" class="vipsp_i7 vip_ico">&nbsp;</td>
					<td class="vipsp_i8 vip_ico">&nbsp;</td>
					<td class="vipsp_i9 vip_ico">&nbsp;</td>
				</tr>
				<tr>
					<td height="55" class="vipsp_i10 vip_ico">&nbsp;</td>
					<td class="vipsp_i11 vip_ico">&nbsp;</td>
					<td class="vipsp_i12 vip_ico">&nbsp;</td>
				</tr>
				<tr>
					<td height="55" class="vipsp_i13 vip_ico">&nbsp;</td>
					<td class="vipsp_i14 vip_ico">&nbsp;</td>
					<td class="vipsp_i15 vip_ico">&nbsp;</td>
				</tr>
				<tr>
					<td height="55" class="vipsp_i16 vip_ico">&nbsp;</td>
					<td class="vipsp_i17 vip_ico">&nbsp;</td>
					<td class="vipsp_i18 vip_ico">&nbsp;</td>
				</tr>
				</tbody></table>
			</td>
			<td>&nbsp;</td>
		</tr>
     </tbody></table>
     <table width="246" cellspacing="0" cellpadding="0" border="0" style="margin-left: 5px;">
        <tbody><tr><td class="vipsq_r1 vip_ico">最近加入VIP榜</td></tr>
        <tr>
	        <td valign="top" height="309" align="left" class="vipsq_r2 vip_ico">
	        	<?php if($this->_var['user'])foreach($this->_var['user'] as $this->_var['v']){ ?>
				<ul class="vipsq_user">
					<li><a class="vipsq_tx" href="javascript:;"><img width="50" height="50" src="themes/default/images/user/headimg/<?php if($this->_var['v']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['v']['headimg']; ?><?php } ?>"></a></li>
					<li><a class="lanse2" target="_blank" href="javascript:;"><?php echo $this->_var['v']['user_name']; ?></a></li>
					<li><span class="chengse2">购买VIP</span></li>
					<li>消费 <?php echo $this->_var['v']['price']; ?> 元存款</li>
				</ul>
				<?php } ?>
			</td>
        </tr>
    </tbody></table>
</div></div>
<script type="text/javascript">
$(function(){
	$('.subVip').click(function(){
		var brush="<?php echo $this->_var['uinfo']['brush_time']; ?>";
		var rank=$(this).attr('data');
		var user_rank=<?php echo $this->_var['uinfo']['user_rank']; ?>;
		var num=$(this).parents('ul.vip_list').find('select.months option:selected').val();
		if(brush>0){
			art.dialog({title: '提示',content: "对不起，您是职业刷客，必须到期后才能购买VIP特权~",fixed: true,lock: true});return false;
		}else if(rank>0&&num>0){
			if(user_rank>5){
				if(user_rank==rank){
				var cont = "您是<font color='red'> <?php echo $this->_var['uinfo']['rank_name']; ?> </font><br/>若购买则为您增加该VIP对应时间。<br/>您确定要购买吗？";
				}else{
					var cont = "您是<font color='red'> <?php echo $this->_var['uinfo']['rank_name']; ?> </font><br/>若购买则会替换原先特权。<br/>您确定要购买吗？";
				}
			}else{
				var cont = "您是<font color='red'> <?php echo $this->_var['uinfo']['rank_name']; ?> </font><br/>您确定要申请开通VIP吗？";
			}
			art.dialog({
				id:'buy',
				title: '提示',
				content: cont,
				fixed: true,
				lock: true,
				okValue: '确定',
				cancelValue: '取消',
				ok: function () {
					art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
					$.post('user.php?act=vip',{"rank":rank,"num":num},function(data){
						art.dialog.get('ajaxStart').close();
						art.dialog({title: '提示',id:'buys',content: data.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ art.dialog.get('buys').close();art.dialog.get('buy').close(); return true; }});
						return false;
					},'json');
					return false;
				},
				cancel: function () { return true;}
			});
		}
	});
});
</script>
<?php echo $this->fetch("common/footer"); ?>
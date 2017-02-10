<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" id="sellerbox">
	<tr id="row-head">
	  <!-- <td width="10" height="37" class="txjl_bg1"></td> -->
	  <td width="12%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">账号昵称</td>
<!-- 	  <td width="20%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">初始信誉-现信誉</td> -->
	  <td width="23%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">当日/本周/已完成任务数</td>
	  <td width="10%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">状 态</td>
	  <td width="10%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">排 序</td>
      <td width="10%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">是否启用</td>
      <td width="7%" height="37" align="center" valign="middle" class="txjl_bg2" style="color:#333;">操 作</td>
      <!-- <td width="10" height="37" class="txjl_bg3"></td> -->
    </tr>
	<?php if($this->_var['acclist'])foreach($this->_var['acclist'] as $this->_var['key'] => $this->_var['acc']){ ?>
	<tr>
		<!-- <td>&nbsp;</td> -->
		<td height="35" align="center" valign="middle" class="mh_xxian maihao">
			<span class="blue"><?php echo $this->_var['acc']['nickname']; ?></span> 
			<?php if($this->_var['acc']['sm']){ ?>
			<img src="themes/default/images/taobao/tx_ico_02.jpg" width="34" height="17" title="通过支付宝实名认证用户" align="absmiddle"><?php } ?>
			<img val="<?php echo $this->_var['acc']['nickname']; ?>" class="click-refresh" style="cursor: pointer; display: none;" title="点击刷新买号信息" src="themes/default/images/ico/loading-static.gif">
		</td>
		<!-- <td align="center" valign="middle" class="mh_xxian">
			<?php echo $this->_var['acc']['value']['seller_credit']; ?> / <?php echo $this->_var['acc']['value']['buyer_credit']; ?> <?php echo $this->_var['acc']['value']['seller_credit_img']; ?>
		</td> -->
		<td align="center" valign="middle" class="mh_xxian"><?php echo $this->_var['acc']['today']; ?> / <?php echo $this->_var['acc']['week']; ?> / <?php echo $this->_var['acc']['all']; ?></td>
		<td align="center" valign="middle" class="mh_xxian">
			<?php if($this->_var['acc']['state'] == 0){ ?><span class="orange">未启用</span><?php }elseif($this->_var['acc']['state'] == 1){ ?><span class="green">正常</span><?php }else{ ?><span style="color:#FF00B8;">删除</span><?php } ?>
		</td>
		<td align="center" valign="middle" class="mh_xxian">
			<input type="text" size="3" data="<?php echo $this->_var['acc']['id']; ?>" name="order" value="<?php echo $this->_var['acc']['shownum']; ?>" class="mh_bk2">
		</td>
		<td align="center" class="mh_xxian"><input type="checkbox" data="<?php echo $this->_var['acc']['id']; ?>" <?php if($this->_var['acc']['state'] == 1){ ?>checked=""<?php } ?> class="active" <?php if($this->_var['acc']['state'] == 2){ ?>style="display:none;"<?php } ?>>
			
		</td>
		<td align="center" class="mh_xxian">
				<?php if($this->_var['acc']['state'] == 2){ ?><a href="javascript:;" data="<?php echo $this->_var['acc']['id']; ?>" class="closehf">&nbsp;</a>
				<?php }else{ ?><!-- <a href="javascript:;" class="gaveAddress">&nbsp;</a> -->
				<a href="javascript:;" data="<?php echo $this->_var['acc']['id']; ?>" class="mico mh_cz deleteBuyer"></a>
				<?php } ?>
		</td>
		<!-- <td>&nbsp;</td> -->
	</tr>
	<?php } ?>
</table>
<div class="rwdt_dlm">
	<div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>
</div>
<div class="cle"></div>
<script type="text/javascript">
$(function(){
	state = ['<span class="orange">未启用</sapn>','<span class="green">正常</span>','<span style="color:#FF00B8;">删除</span>'];
	$('.active').click(function(){
		var status,obj = $(this),self = this;
		if (obj.attr('checked')=='checked'){
			status = 1;
			
		}else{
			status = 0;
		}
		$(this).parents('tr').find('td.mh_xxian:eq(3)').html(state[status]);
		$.post('taobao.php?mod=getbuyaccount&opt=state',{"bin":obj.attr('data'),"status":status});
		var obj=$(this).parents('tr');
		setBakckgoundAndOpacity(obj,'#62c462');
	});
	$(".maihao").mouseover(function(){
		$(this).find('.click-refresh').show();
	});
	$(".maihao").mouseout(function(){
		$(this).find('.click-refresh').hide();
	});
	$(".mh_bk2").change(function(){
		var order=$(this).val();
		if(order){
			$.post('taobao.php?mod=getbuyaccount&opt=order',{"bin":$(this).attr('data'),"order":order},function(){location.reload();});
		}
	});
	$('.click-refresh').click(function(){
		var val = $(this).attr('val');
		art.dialog({id:'temp', title:'温馨提示', lock:true,
			content : '<p>是否刷新买号: <font color="#1996e6">'+val+'</font> 的信息?</p>',
			ok : function(){
				art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
				setTimeout("clo()",1200);
			},
			okValue : '确定',
			cancel : {},
			cancelValue : '取消',
			fixed:true,
		});
	});
	$(".deleteBuyer").click(function(){
		var cur=$(this).parents('tr');
		var bin=$(this).attr('data');
		art.dialog({title:'温馨提示', lock:true,content:'你确定要删除此买号吗？<br/>删除后将无法重新绑定此买号，其他账号也无法绑定这个买号！',okValue : '确定',ok:function(){
			$.post('taobao.php?mod=getbuyaccount&opt=del',{"bin":bin});
			cur.addClass('success-del').fadeOut(1000,function(){
				cur.remove();
			});
		},cancel:{},cancelValue:'取消'});
	});
	$(".closehf").click(function(){
		var bin=$(this).attr('data');
		var obj=$(this).parents('tr');
		art.dialog({title:'温馨提示', lock:true,content:'你确定要恢复此买号吗？',okValue : '确定',ok:function(){
			$.post('taobao.php?mod=getbuyaccount&opt=hf',{"bin":bin});
			setBakckgoundAndOpacity(obj,'#62c462');
			location.reload();
		},cancel:{},cancelValue:'取消'});
	});
});
function clo(){
	art.dialog.get('ajaxStart').close();
	location.reload();
}
</script>
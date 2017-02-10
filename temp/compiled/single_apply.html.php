<script language="javascript" type="text/javascript" src="themes/default/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="themes/default/js/layer/layer.js"></script>
<style type="text/css">
.btn_jc {
margin: 5px 0;
padding: 3px 15px;
border: 1px solid #2fadcb;
border-top-right-radius: 4px;
border-bottom-right-radius: 4px;
border-bottom-left-radius: 4px;
border-top-left-radius: 4px;
color: #fff;
text-decoration: none;
cursor: pointer;
background:#13a7c7;
-webkit-transition: all 0.1s ease-in; -moz-transition: all 0.1s ease-in; -ms-transition: all 0.1s ease-in; -o-transition: all 0.3s ease-in; transition: all 0.3s ease-in;
}
.btn_jc:hover{color: #fff; background-color: #0799ff;}
.success-del{background:#bd362f;}
</style>
<form method="post" action="">
<ol id="topUpUL" class="block" style="height: 525px;">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="td-bak ta-align">添加时间</td>
			<td class="td-bak ta-align">物流公司</td>
			<td class="td-bak ta-align">快递单号</td>
			<td class="td-bak ta-align">收货地址</td>
			<td class="td-bak ta-align">操作</td>
			<!--td>查看</td-->
		</tr>
		<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
		<tr>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['addtime']; ?></td>
			<td class="ta-align td-bor">(<?php if($this->_var['val']['type'] == 0){ ?>虚拟<?php }else{ ?>真实<?php } ?>)<?php echo $this->_var['val']['wl']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['eid']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['to_adds']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['todo']; ?></td>
			<!--td><a href="single.php?mod=kuaidi&kd=<?php echo $this->_var['val']['kd']; ?>&eid=<?php echo $this->_var['val']['eid']; ?>">详情</a></td-->
		</tr>
	   <?php } ?>
	</table>
	<div id="page"><?php echo $this->_var['list']['pagestr']; ?></div>
</ol>	
</form>
<script type="text/javascript">
$(function(){
	$("a.see").click(function(){
		var pic=$(this).attr('pic');
		art.dialog({title: '友情提示',content: '<img src="'+pic+'">',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
	});
	$("a.jj").click(function(){
		var data=$(this).attr('data');
		art.dialog({title: '拒绝原因',content: '<span>'+data+'</span>',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
	});
	$("a.send").click(function(){
		var money=<?php echo $this->_var['uinfo']['user_money']; ?>;
		var mon=<?php echo $this->_var['uinfo']['params']['ddgm']; ?>;
		var express=$(this).attr('data');
		var buts=0;
		if(express){
			var str='';
			if(money<mon){
				str='底单购买价格为 <font color="#fe5500">'+mon+'元/个，您的余额不足~</font>';
				but='去充值';
				buts=1;
			}else{
				str='底单购买价格为 <font color="#fe5500">'+mon+'元/个</font>，点击立即购买~';
				but='购买 '+mon+'元/个';
			}
			art.dialog({
				title: '友情提示',
				content: '亲，您是 <font color="#fe5500"><?php echo $this->_var['uinfo']['rank_name']; ?></font> 会员，'+ str,
				fixed: true,
				lock: true,
				okValue: but,
				ok: function () {
					if(buts==1){
						location.href="user.php?act=topup";
					}else{
						$.post('single.php?mod=apply',{'sid': express},function(data){
							art.dialog({title: '提示',content: data.info,fixed: true,lock: true,lock: true,cancelValue: '确定',cancel: function () { if(data.state){location.reload();}return true;}});
						},'json');
					}
				},
				cancelValue: '取消',
				cancel: function () { return true;}
			});
		}else{
			art.dialog({id:'mention', title: '提示',content: '快递单不存在~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
	});
	/*$(".dress").hover(function(){
		var data=$(this).attr('data');
		if(data){
			layer.tips(data,$(this),{tips:[2,'#3595CC'],time:1000});
		}
	});*/
});
</script>
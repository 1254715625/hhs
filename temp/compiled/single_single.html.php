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
.btn_jc:hover{ color: #fff; background-color: #0799ff;}
.success-del{background:#bd362f}

#retForm{width:640px;line-height:22px;padding-bottom:10px;border-bottom:1px dotted #ccc;}
#retData{
background:#efefef;
padding:10px;
line-height:18px;
width: 96%;
border: 0;
}
.txtPartner{width:960px;margin:20px 10px;padding:10px 0 0 0;border-top:1px solid #dfdfdf;}
.txtPartner h1{font-size:14px;color:#FF5632;}
.txtPartner a{float:left;margin:0 10px 10px 0;}
.logo {
font-size: 18px;
font-weight: bold;
text-align: center;
padding: 10px;
font-family: "微软雅黑";
}
.txtURL {
font-size: 12px;
padding: 10px;
}
</style>
<form method="post" action="">
<ol id="topUpUL" class="block" style="height: 525px;">
	<div style="margin-left:20px; margin-top:-3px; height:50px;"> 
		发货地址：<input name="send" id="haveordnumber" style="color:#7e7e7e; background:#fff; height:22px; width:125px; border:1px solid #CCC" value="<?php echo $this->_var['send']; ?>" placeholder="请输入发货地址">
		收货地址：
		<input type="hidden" name="search" value="1">
		<input name="to" style="color:#7e7e7e; background:#fff; height:22px; width:125px; border:1px solid #CCC" placeholder="请输入收货地址" value="<?php echo $this->_var['to']; ?>"> 
		<!-- 发货时间：
		<input name="etime" id="d4312" style="height:20px;" placeholder="请输入日期" class="laydate-icon" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" readonly="readonly" highLineWeekDay="true" value="<?php echo $this->_var['etime']; ?>"> -->
		<input type="submit" value="开始查询" class="btn_jc" style="margin-top:14px;">
		<input type="reset" value="清空" class="btn_jc" style="margin-top:14px;" onclick="location.href='single.php'">
	</div>
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="td-bak ta-align">序号</td>
			<td class="td-bak ta-align">快递类型</td>
			<td class="td-bak ta-align">快递单号</td>
			<td class="td-bak ta-align">扫描记录</td>
			<td class="td-bak ta-align">发货地址</td>
			<td class="td-bak ta-align">收货地址</td>
			<td class="td-bak ta-align">操作</td>
		</tr>
		<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
		<tr>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['id']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['wl']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['eid']; ?></td>
			<td class="ta-align td-bor" align="center" valign="middle"><img src="themes/default/images/search.png" width="20" style="float:none;cursor: pointer;width:30px;" class="search" data="<?php echo $this->_var['val']['id']; ?>"></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['send_adds']; ?></td>
			<td class="ta-align td-bor"><?php echo $this->_var['val']['to_adds']; ?></td>
			<td class="ta-align td-bor"><a class="btn_jc gm" data="<?php echo $this->_var['val']['id']; ?>">购买</a></td>
		</tr>
	   <?php } ?>
	</table>
	<div id="page"><?php echo $this->_var['list']['pagestr']; ?></div>
</ol>	
</form>
<script type="text/javascript">
$(function(){
	var num=<?php echo $this->_var['num']; ?>;
	var money=<?php echo $this->_var['uinfo']['user_money']; ?>;
	var mon=<?php echo $this->_var['uinfo']['params']['kddhgm']; ?>;
	$(".gm").click(function(){
		var express=$(this).attr('data');
		if(express){
			var str='';
			if(num>0){
				str='今日还可免费获得<font color="#fe5500">'+num+'</font>个快递单，点击免费获取~';
				but='免费获取';
			}else{
				
				if(money<mon){
					str='快递单号购买价格为 <font color="#fe5500">'+mon+'元/个</font>，您的余额不足~';
				}else{
					str='快递单号购买价格为 <font color="#fe5500">'+mon+'元/个</font>，点击立即购买~';
				}
				but='购买 '+mon+'元/个';
			}
			var cur=$(this).parents('tr');
			art.dialog({
				title: '友情提示',
				content: '亲，您是 <font color="#fe5500"><?php echo $this->_var['uinfo']['rank_name']; ?></font> 会员，'+ str,
				fixed: true,
				lock: true,
				okValue: but,
				ok: function () {
					$.post('single.php?mod=single',{'express': express},function(data){
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true,lock: true,cancelValue: '确定',cancel: function () { if(data.state){cur.addClass('success-del').fadeOut(1000,function(){cur.remove();if(num==0){location.reload();}num--;money=money-mon;});	}return true;}});
					},'json');
				},
				cancelValue: '取消',
				cancel: function () { return true;}
			});
		}else{
			art.dialog({id:'mention', title: '提示',content: '快递单不存在~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
	});
	$(".search").click(function(){
		var data=$(this).attr('data');
		if(data){
			$.post('single.php?mod=search',{"data":data},function(data){
				if(data.state){
					art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
				}else{
					art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
				}
			},'json');
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
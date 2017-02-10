<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_autoam.css">
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">
<div id="taskDing">
	<div class="mh_tishi">
		<p>您当前任务定制 <?php if($this->_var['uinfo']['autoam']){ ?><b style="color:red;">开启</b> 中，到期时间 <b style="color:green;"><?php echo $this->_var['uinfo']['autoam_time']; ?></b><?php }else{ ?><b style="color:green;">关闭</b> 中，<a href="home.php?act=buypoint" style="color: #1996E6;margin-left:10px;">购买定制任务</a><?php } ?></p>
	<span>当您成功保存配置信息后，请返回淘宝接任务大厅按F5刷新页面，刷新后新的配置才会生效哟！</span>
	</div>
	<div class="bq_menu2">
		<a class="nov taobao" href="javascript:;">自动接淘宝任务</a>
		<a class="paipai" href="javascript:;">自动接拍拍任务</a>
	</div>
	<div class="forms">
	<form id="myformTB">
	<input type="hidden" name="istype" value="taobao">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody><tr style="font-weight: bold;">
	        <td height="50" align="left">任务类别：</td>
	        <td>
	        	<input type="radio" name="typeorder" value="0">全部
	            <input type="radio" name="typeorder" value="1">电脑端订单
	            <input type="radio" name="typeorder" value="2">移动端订单
	        </td>
	        <td valign="bottom" style="line-height: 34px;">系统将根据类别要求接收订单！</td>
	    </tr>
	    <tr>
	        <td align="left">价格区间：</td>
	        <td>
                <input type="text" value="0" style="width:40px;" maxlength="4" name="txtMinPrice" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                至
                <input type="text" value="50" style="width:40px;" maxlength="4" name="txtMaxPrice" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
	        </td>
	        <td>您期望所接任务的价格范围！注意：价格区间只支持整数。</td>
	    </tr>
	    <tr>
	        <td align="left">最少麦点：</td>
	        <td><input type="text" value="10" style="width:40px;" maxlength="4" name="txtMinpoint" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
	        <td>您期望所接任务的最低麦点奖励！注意：最少麦点只支持整数。</td>
	    </tr>
	    <tr>
	        <td align="left">过滤商保任务：</td>
	        <td><span><input type="checkbox" name="NoSB" value="1"></span> </td>
	        <td>选择后您将无法接商保任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤审核：</td>
	        <td><input type="checkbox" name="NoAudit" value="1"></td>
	        <td>选择后您将无法接需要审核的任务！</td>
	    </tr>

	    <tr>
	        <td align="left">是否过滤单号任务：</td>
	        <td><input type="checkbox" name="Notask1" value="1"></td>
	        <td>选择后您将无法接单号任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤浏览任务：</td>
	        <td><input type="checkbox" name="Notask2" value="1"></td>
	        <td>选择后您将无法接浏览任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤评图任务：</td>
	        <td><input type="checkbox" name="Notask3" value="1"></td>
	        <td>选择后您将无法接评图任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤底图任务：</td>
	        <td><input type="checkbox" name="Notask4" value="1"></td>
	        <td>选择后您将无法接底图任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤货比任务：</td>
	        <td><input type="checkbox" name="Notask5" value="1"></td>
	        <td>选择后您将无法接货比任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤停留任务：</td>
	        <td><input type="checkbox" name="Notask6" value="1"></td>
	        <td>选择后您将无法接停留任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤旺信任务：</td>
	        <td><input type="checkbox" name="Notask7" value="1"></td>
	        <td>选择后您将无法接旺信任务！</td>
	    </tr>

	    <tr>
	        <td align="left">是否过滤拍前聊：</td>
	        <td><input type="checkbox" name="NoWW" value="1"></td>
	        <td>选择后您将无法接需要拍前聊旺旺的任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤聊后收：</td>
	        <td> <input type="checkbox" name="NoLHS" value="1"> </td>
	        <td>选择后您将无法接需要聊旺旺确认收货的任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤购物车：</td>
	        <td><input type="checkbox" name="NoCart" value="1"></td>
	        <td>选择后将无法接到购物车任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤套餐：</td>
	        <td><input type="checkbox" name="NoMeal" value="1"></td>
	        <td>选择后将无法接到套餐任务！</td>
	    </tr>
	    <tr>
	        <td align="left">是否过滤来路：</td>
	        <td><input type="checkbox" name="NoLaiLu" value="1"></td>
	        <td>选择后将无法接来路任务！</td>
	    </tr>
		<tr>
	        <td align="left">是否过滤真实签收：</td>
	        <td><input type="checkbox" name="NoExpress" value="1"></td>
	        <td>选择后将无法接真实签收任务！</td>
	    </tr>
		
	    <tr>
	        <td align="left">是否过滤评图：</td>
	        <td><input type="checkbox" name="NoPinPic" value="1"></td>
	        <td>选择后将无法接需要好评截图的任务！</td>
	    </tr>

	    <tr>
	        <td align="left">是否过滤延时购买：</td>
	        <td><input type="checkbox" name="NoYanchi" value="1"></td>
	        <td>选择后将无法接需要延时购买的任务！</td>
	    </tr>

	    <tr>
	        <td align="left">过滤要求买号等级：</td>
	        <td><input type="checkbox" name="buyerDeng" value="1"></td>
	        <td>选择后将无法接需要买号等级的任务！</td>
	    </tr>
	    <tr>
	        <td align="left">好评确认时间：</td>
	        <td>
	            <select name="timesBegin" class="taskBegin">
					<option selected="selected" value="1">立即好评</option>
					<option value="2">24小时好评</option>
					<option value="3">48小时好评</option>
					<option value="4">72小时好评</option>
					<option value="5">96小时好评</option>
					<option value="6">120小时好评</option>
					<option value="7">144小时好评</option>
					<option value="8">168小时好评</option>
				</select>
				至
				<select name="timesEnd" class="taskEnd">
					<option selected="selected" value="1">立即好评</option>
					<option value="2">24小时好评</option>
					<option value="3">48小时好评</option>
					<option value="4">72小时好评</option>
					<option value="5">96小时好评</option>
					<option value="6">120小时好评</option>
					<option value="7">144小时好评</option>
					<option value="8">168小时好评</option>
				</select>
	        </td>
	        <td>您期望所接任务确认天数区间！</td>
	    </tr>
	     <tr>
	        <td align="left">只接购物车：</td>
	        <td><input type="checkbox" name="isCartOnly" value="1"> </td>
	        <td>选择后将只能接到购物车任务！</td>
	    </tr>
	     <tr>
	        <td align="left">只接套餐：</td>
	        <td><input type="checkbox" name="isMealOnly" value="1"></td>
	        <td>选择后将只能接到套餐任务！</td>
	    </tr>
	     <tr>
	        <td align="left">只接来路：</td>
	        <td><input type="checkbox" name="isLailuOnly" value="1"></td>
	        <td>选择后将只能接到来路任务！</td>
	    </tr>
		<tr>
	        <td align="left">只接真实签收：</td>
	        <td><input type="checkbox" name="isExOnly" value="1"></td>
	        <td>选择后将只能接到真实签收任务！</td>
	    </tr>
	    <tr>
	        <td align="left">只接商保任务：</td>
	        <td><span><input type="checkbox" name="isEnsureOnly" value="1"></span></td>
	        <td>选择后将只能接到商保任务！</td>
	    </tr>
	     <tr>
	        <td height="50" align="left">买号过滤：</td>
	        <td>
	            <input type="radio" name="isReal" value="1">普通买号
	            <input type="radio" name="isReal" value="2">实名买号
	        </td>
	        <td valign="bottom">系统将自动过滤任务要求的买号的任务！</td>
	    </tr>
	    <tr>
	        <td align="left" style="padding-top:20px;">&nbsp;</td>
	        <td style="padding-top:20px;" colspan="2">
	            <input type="submit" value="保存配置" name="submit" class="tbbcpz bcpz" data="1">
	        </td>
	    </tr>
    </tbody></table>
	</form>
	<form id="myformPP" style="display:none;">
	<input type="hidden" name="istype" value="paipai">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
        <td align="left">价格区间：</td>
        <td>
            <input type="text" value="0" style="width:40px;" maxlength="4" name="txtMinPrice" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
            至
            <input type="text" value="999" style="width:40px;" maxlength="4" name="txtMaxPrice" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
        </td>
        <td>您期望所接任务的价格范围！注意：价格区间只支持整数。</td>
    </tr>
    <tr>
        <td align="left">最少麦点：</td>
        <td> <input type="text" value="0" style="width:40px;" maxlength="4" name="txtMinpoint" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
        <td>您期望所接任务的最低麦点奖励！注意：最少麦点只支持整数。</td>
    </tr>
    <tr>
        <td align="left">过滤商保任务：</td>
        <td><span><input type="checkbox" name="NoSB" value="1"></span> </td>
        <td>选择后您将无法接商保任务！</td>
    </tr>
    <tr>
        <td align="left">是否过滤审核：</td>
        <td><input type="checkbox" name="NoAudit" value="1"> </td>
        <td>选择后您将无法接需要审核的任务！</td>
    </tr>
    <tr>
        <td align="left">是否过滤购物车：</td>
        <td><input type="checkbox" name="NoCart" value="1"> </td>
        <td>选择后将无法接到购物车任务！</td>
    </tr>
    <tr>
        <td align="left">是否过滤来路：</td>
        <td><input type="checkbox" name="NoLaiLu" value="1"></td>
        <td>选择后将无法接来路任务！</td>
    </tr>
	
    <tr>
        <td align="left">是否过滤评图：</td>
        <td><input type="checkbox" name="NoPinPic" value="1"></td>
        <td>选择后将无法接需要好评截图的任务！</td>
    </tr>
    <tr>
        <td align="left">好评确认时间：</td>
	        <td>
	            <select name="timesBegin" class="taskBegin">
					<option value="1">立即好评</option>
					<option value="2">24小时好评</option>
					<option value="3">48小时好评</option>
					<option value="4">72小时好评</option>
					<option value="5">96小时好评</option>
					<option value="6">120小时好评</option>
					<option value="7">144小时好评</option>
					<option value="8">168小时好评</option>
				</select>
				至
				<select name="timesEnd" class="taskEnd">
					<option value="1">立即好评</option>
					<option value="2">24小时好评</option>
					<option value="3">48小时好评</option>
					<option value="4">72小时好评</option>
					<option value="5">96小时好评</option>
					<option value="6">120小时好评</option>
					<option value="7">144小时好评</option>
					<option value="8">168小时好评</option>
				</select>
	        </td>
	    <td>您期望所接任务确认天数区间！</td>
    </tr>
     <tr>
        <td align="left">只接购物车：</td>
        <td><input type="checkbox" name="isCartOnly" value="1"></td>
        <td>选择后将只能接到购物车任务！</td>
    </tr>
    <tr>
        <td align="left">只接商保任务：</td>
        <td><span><input type="checkbox" name="isEnsureOnly" value="5"></span></td>
        <td>选择后将只能接到商保任务！</td>
    </tr>
    <tr>
        <td align="left" style="padding-top:20px;">&nbsp;</td>
        <td style="padding-top:20px;" colspan="2">
            <input type="submit" value="保存配置" name="submit" class="ppbcpz bcpz" data="2">
        </td>
    </tr>
    </tbody></table>
	</form>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$(".bq_menu2 a").click(function(){
		$(".bq_menu2 a").removeClass('nov');
		$(this).addClass('nov');
		var index=$(this).index();
		$(".forms form").hide();
		$(".forms form:eq("+index+")").show();
	});
	$(".taskBegin").click(function(){
		var val = $(this).val();
		$(".taskEnd option").show();
		$(".taskEnd").val(val);
		$(".taskEnd option:lt("+(val-1)+")").hide();
	});
	$(".bcpz").click(function(){
		var state=<?php echo $this->_var['uinfo']['autoam']; ?>;
		var data=$(this).attr('data');
		if(state == 0){
			art.dialog({ title: '提示',content: "对不起，您还没有开通任务定制~",fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(data==1||data==2){
			var obj=data==1?'#myformTB':'#myformPP';
			var formDate = $(obj).serializeArray();
			art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true,lock: true});
			$.post('user.php?act=autoam',formDate,function(data){
				art.dialog.get('ajaxStart').close();
				art.dialog({ title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
			},'json');
		}
		return false;
	});
	var obj=eval('(<?php echo $this->_var['data']; ?>)');
	for(var o in obj.taobao){
		if(o=='timesBegin'||o=='timesEnd'){
			$("#myformTB .taskBegin").find("option[value='"+obj.taobao['timesBegin']+"']").attr("selected",true);
			$("#myformTB .taskEnd").find("option[value='"+obj.taobao['timesEnd']+"']").attr("selected",true);
		}else{
			var ins=$("#myformTB input[name='"+o+"']");
			if(obj.taobao[o]!=''){
				switch(ins.attr('type')){
					case 'text':
						ins.val(obj.taobao[o]);
					break;
					case 'checkbox':
						ins.attr('checked','checked');
					break;
					case 'radio':
						$("#myformTB input[name='"+o+"'][value='"+obj.taobao[o]+"']").attr('checked','checked');
					break;	
				}
			}
		}
	} 
	for(var o in obj.paipai){
		if(o=='timesBegin'||o=='timesEnd'){
			$("#myformPP .taskBegin").find("option[value='"+obj.taobao['timesBegin']+"']").attr("selected",true);
			$("#myformPP .taskEnd").find("option[value='"+obj.taobao['timesEnd']+"']").attr("selected",true);
		}else{
			var ins=$("#myformPP input[name='"+o+"']");
			if(obj.taobao[o]!=''){
				switch(ins.attr('type')){
					case 'text':
						ins.val(obj.taobao[o]);
					break;
					case 'checkbox':
						ins.attr('checked','checked');
					break;
					case 'radio':
						$("#myformPP input[name='"+o+"'][value='"+obj.taobao[o]+"']").attr('checked','checked');
					break;	
				}
			}
		}
	} 
});
</script>
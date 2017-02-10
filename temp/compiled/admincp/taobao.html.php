<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/css/common.css">
<link rel="stylesheet" type="text/css" href="template/css/main.css">

<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/artDialog.js"></script>
<script type="text/javascript" src="template/js/layer/layer.js"></script>
</head>
<body>
	<div class="ur_here">首页 &raquo; 网站设置 &raquo; 充值卡管理</div>
    <div class="container">
		<div class="itemtitle">
			<h3>淘宝充值卡管理</h3>
		</div>
		<form enctype='multipart/form-data' action="taobao.php" method="POST">
			<div class="btnBox">
				<ul class="clearfix">
					<li><a href="javascript:;" id="save">自动生产</a></li>
					<li><a href="taobao.php">首页</a></li>
					<li><a href="taobao.php?type=yes">已经兑换</a></li>
					<li><a href="taobao.php?type=no">没有兑换</a></li>
					<li><a href="taobao.php?type=fei">作废</a></li>
				</ul>

				<!-- <input type="button" value="手动添加" class="btn_jcs">&nbsp;&nbsp; 
				<a href="javascript:;" class="file"> 批量添加
				    <input type="file" id="filess" name="file">
			    </a>
				<input type="submit" value="导入快递单" class="btn_jc" onclick="return confirm('是否确定导入，如遇相同订单，将会自动过滤！')">
				<span style="color:#ff0000;font-weight:bold;">
					(<a href="excel/express_topup.xls">请按照指定快递单下载，如未有，请先下载</a>)
				</span> -->
			</div>
			<table width="100%" id="listTb">
				<tr>
				    <th colspan="5">
				    	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['listnum']; ?></strong>条符合条件的信息
				    </th>
				</tr>
				<tr>
					<td>编号</td>
					<td>充值卡卡号</td>
					<td>充值卡密码</td>
					<td>充值卡金额</td>
					<td>操作</td>
				</tr>
				<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
				<tr>
				    <td><?php echo $this->_var['val']['id']; ?></td>
					<td><?php echo $this->_var['val']['name']; ?></td>
					<td><?php echo $this->_var['val']['pass']; ?></td>
					<td><?php echo $this->_var['val']['money']; ?></td>
					<td>
						<a href="taobao.php?del=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要删除此记录吗？')">删除</a>
				    </td>
				</tr>
				<?php } ?>
				<tr>
				    <td class="footer" colspan="5"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
				</tr> 
			</table>
		</form>
    </div>
	<script type="text/javascript">
		$(function(){
			$(".show").hover(function(){
				var data=$(this).attr('data');
				if(data){
					layer.tips(data,$(this),{tips:[1,'#3595CC'],time:1000});
				}
			});
			$("#filess").change(function(){
				$(".btn_jc").click();
			});
			
			$("#save").click(function(){
				window.top.art.dialog({
					title: '充值卡添加',
					/*content: '<style>#kslogin{width: 270px;padding: 10px 25px;}#userentry{width: 320px;height: 180px;float: left;}#userentry li.t1 {float: left;height: 25px;line-height: 25px;padding-right: 5px;text-align: right;}#kslogin .u_bk {background:#FFFFFF;border: 1px solid #D1D1D3;height: 25px;line-height: 25px;text-indent: 3px;width: 200px;}#userentry li.t2 {color: #999999;height: 30px;line-height: 24px;padding-left: 65px;}</style><div id="kslogin"><ul id="userentry"><li id="loginaccount" class="t1">充值卡号：</li><li><input type="text" class="u_bk" id="lusername"></li><li id="miaoname" class="t2">淘宝充值卡卡号</li><li id="loginpwd" class="t1">充值卡密：</li><li><input type="text" class="u_bk" id="lpassword"></li><li id="miaopwd" class="t2">淘宝充值卡密码</li><li id="loginmon" class="t1">充值金额：</li><li><input type="text" class="u_bk" id="lmoney" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"></li><li id="miaomon" class="t2">淘宝充值卡金额</li></ul></div>',*/
					content: '<style>#kslogin{width: 270px;padding: 10px 25px;}#userentry{width: 320px;height: 270px;float: left;}#userentry li.t1 {float: left;height: 25px;line-height: 25px;padding-right: 5px;text-align: right;}#kslogin .u_bk {background:#FFFFFF;border: 1px solid #D1D1D3;height: 25px;line-height: 25px;text-indent: 3px;width: 200px;}#userentry li.t2 {color: #999999;height: 30px;line-height: 24px;padding-left: 65px;}</style><div id="kslogin"><ul id="userentry"><li id="loginaccount" class="t1">充值卡号位数：</li><li><input type="text" class="u_bk" id="lusername"></li><li id="miaoname" class="t2">&nbsp;&nbsp;请输入具体位数</li><li id="loginpwd" class="t1">充值卡密位数：</li><li><input type="text" class="u_bk" id="lpassword"></li><li id="miaopwd" class="t2">&nbsp;&nbsp;请输入具体位数</li><li id="loginmon" class="t1">充值金额区间：</li><li><input type="text" class="u_bk" id="lmoney" onkeyup="" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"></li><li id="miaomon" class="t2">&nbsp;&nbsp;请输入具体位数</li><li id="loginmon" class="t1">有效期的时间：</li><li><input type="text" class="u_bk" id="time" onkeyup="" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"></li><li id="miaomon" class="t2">&nbsp;&nbsp;请输入具体天数</li><li id="loginmon" class="t1">生成的次数：&nbsp;</li><li><input type="text" class="u_bk" id="num" onkeyup="" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"></li><li id="miaomon" class="t2">&nbsp;&nbsp;请输入具体次数</li></ul></div>',
					fixed: true,
					lock: true,
					okValue: '确定',
					cancelValue: '取消',
					ok: function () {
						//有效期
						var time=$("#time",window.parent.document).val();		
						var num=$("#num",window.parent.document).val();
						var lusername=$("#lusername",window.parent.document).val();
						var lpassword=$("#lpassword",window.parent.document).val();
						var lmoney=$("#lmoney",window.parent.document).val();
						if(lusername==''){
							window.top.art.dialog({id:'mention', title: '提示',content: '请输入淘宝充值卡卡号~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
						}else if(lpassword==''){
							window.top.art.dialog({id:'mention', title: '提示',content: '请输入淘宝充值卡密码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
						}else if(lmoney==''){
							window.top.art.dialog({id:'mention', title: '提示',content: '请输入淘宝充值卡金额~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
						}else{
							$.post('taobao.php?act=change',{'user':lusername,'pass':lpassword,'money':lmoney,'time':time,'num':num,},function(data){
								console.log(data);
								if(data.info){
									window.top.art.dialog({id:'mention', title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
								}
								//$("#rightFrame",window.parent.document).attr('src','express_real.php');
							},'json');
						}
					},
					cancel: function () { return true;}
				});
			});
		});
	</script>
</body>
</html>
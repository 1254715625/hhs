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
	<div class="ur_here">首页 &raquo; 快递单号 &raquo; 真实快递管理</div>
    <div class="container">
		<div class="itemtitle">
			<h3>快递单号管理</h3>
		</div>
		<div class="btnBox">
			<ul class="clearfix">
				<li><a href="express_virtual.php">虚拟快递管理</a></li>
				<li class="current"><a href="express_real.php">真实快递管理</a></li>
				<li><a href="express_task.php">底单管理</a></li>
				<li><a href="express_set.php">快递类型设置</a></li>
			</ul>
		</div>
		<form action="express_real.php" method="POST">
			<table width="100%" id="listTb">
			    <tr>
			        <th colspan="7">
			        	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['listnum']; ?></strong>条符合条件的信息
			        </th>
			    </tr>
				<tr>
					<td>编号</td>
					<td>用户</td>
					<td>快递类型</td>
					<td>快递单号</td>
					<td>收货地址</td>
					<td>提交时间</td>
					<td>操作</td>
				</tr>
				<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
				<tr>
					<td><?php echo $this->_var['val']['id']; ?></td>
					<td><?php echo $this->_var['val']['user']; ?></td>
					<td><?php echo $this->_var['val']['wl']; ?></td>
					<td><?php echo $this->_var['val']['eid']; ?></td>
					<td><?php echo $this->_var['val']['to_adds']; ?></td>
					<td><?php echo $this->_var['val']['addtime']; ?></td>
					<td><?php echo $this->_var['val']['cz']; ?></td>
				</tr>
				<?php } ?>
			  <tr>
			    <td colspan="7" class="footer"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
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
			$(".xg").click(function(){
				var data=$(this).attr('data');
				var alt=$(this).attr('alt');
				if(data&&alt){
					window.top.art.dialog({
						title: '发货处理',
						content: '<p style="margin:10px 0;color:#EB0F0F;">请输入快递单号：<input style="border:1px solid #999;" type="text" id="safecode" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" value="'+alt+'"></p>',
						fixed: true,
						lock: true,
						okValue: '确定',
						cancelValue: '取消',
						ok: function () {
							var safecode=$("#safecode",window.parent.document).val();
							if(safecode ==''){
								window.top.art.dialog({id:'mention', title: '提示',content: '请输入快递单号~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
							}else if(alt==safecode){
								return true;
							}else{
								$.post('express_real.php?act=change',{'data':data,'safecode':safecode},function(data){
									 $("#rightFrame",window.parent.document).attr('src','express_real.php');
								});
							}
						},
						cancel: function () { return true;}
					});
				}
			});
			$(".fh").click(function(){
				var data=$(this).attr('data');
				if(data){
					window.top.art.dialog({
						title: '发货处理',
						content: '<p style="margin:10px 0;color:#EB0F0F;">请输入快递单号：<input style="border:1px solid #999;" type="text" id="safecode" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"></p>',
						fixed: true,
						lock: true,
						okValue: '确定',
						cancelValue: '取消',
						ok: function () {
							var safecode=$("#safecode",window.parent.document).val();
							if(safecode ==''){
								window.top.art.dialog({id:'mention', title: '提示',content: '请输入快递单号~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
							}else{
								$.post('express_real.php?act=deliver',{'data':data,'safecode':safecode},function(data){
									 $("#rightFrame",window.parent.document).attr('src','express_real.php');
								});
							}
						},
						cancel: function () { return true;}
					});
				}
			});
		});
	</script>
</body>
</html>
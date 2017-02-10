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
	<div class="ur_here">首页 &raquo; 快递单号 &raquo; 虚拟快递管理</div>
    <div class="container">
		<div class="itemtitle">
			<h3>快递单号管理</h3>
		</div>
		<form enctype='multipart/form-data' action="express_virtual.php" method="POST">
			<div class="btnBox">
				<ul class="clearfix">
					<li class="current"><a href="express_virtual.php">虚拟快递单号</a></li>
					<li><a href="express_real.php">真实快递单号</a></li>
					<li><a href="express_task.php">任务快递单号</a></li>
					<li><a href="express_set.php">快递单设置</a></li>
				</ul>
				<p class="m">
					<span>
						<a href="javascript:;" class="upload-btn">选择文件
							<input type="file" name="file" id="filess" />
						</a>
					</span>
					<span>
						<input type="submit" value="导入快递单" class="btn_jc" onclick="return confirm('是否确定导入，如遇相同订单，将会自动过滤！')">
					</span>
					<span><a href="excel/express_single.xls" style="color:#ff0000;">(请按照指定快递单下载，如未有，请点击下载)</a></span>
				</p>
			</div>
			<table width="100%" id="listTb">
			  <tr>
			    <th colspan="8">
			    	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['listnum']; ?></strong>条符合条件的信息
			    </th>
			  </tr>
			  <tr class="header">
				<td>编号</td>
				<td>快递单号</td>
				<td>添加时间</td>
				<td>快递类型</td>
				<td>发货地址</td>
				<td>收货地址</td>
				<td>使用次数</td>
				<td>操作</td>
			  </tr>
			  <?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
			  <tr>
			    <td><?php echo $this->_var['val']['id']; ?></td>
				<td><?php echo $this->_var['val']['eid']; ?></td>
				<td><?php echo $this->_var['val']['addtime']; ?></td>
				<td><?php echo $this->_var['val']['wl']; ?></td>	
				<td><?php echo $this->_var['val']['send_add']; ?></td>
				<td><?php echo $this->_var['val']['to_adds']; ?></td>
				<td><?php echo $this->_var['val']['num']; ?></td>
				<td>
					<a href="express_virtual.php?del=<?php echo $this->_var['val']['id']; ?>" style="color:red;" onclick="return confirm('您确定要删除此记录吗？')">删除</a>
				</td>
			  </tr>
			  <?php } ?>
			  <tr>
			    <td colspan="8" class="footer"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
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
		});
	</script>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 托管列表</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="">
		<table width="100%" id="listTb">
			<tr>
				<th>ID</th>
				<th>掌柜帐号</th>
				<th>订单号</th>
				<th>店铺地址</th>
				<th>商品地址</th>
				<th>QQ号码</th>
				<th>手机号码</th>
				<th>添加时间</th>
			</tr>
			<?php if($this->_var['data']['record'])foreach($this->_var['data']['record'] as $this->_var['key'] => $this->_var['v']){ ?>
			<tr>
				<td><?php echo $this->_var['v']['id']; ?></td>
				<td><?php echo $this->_var['v']['uid']; ?></td>
				<td><?php echo $this->_var['v']['oid']; ?></td>
				<td><?php echo $this->_var['v']['shopUrl']; ?></td>
				<td><?php echo $this->_var['v']['proUrl']; ?></td>
				<td><?php echo $this->_var['v']['QQ']; ?></td>
				<td><?php echo $this->_var['v']['phone']; ?></td>
				<td><?php echo $this->_var['v']['addtime']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="8" class="footer"><div class="page"><?php echo $this->_var['data']['pagestr']; ?></div></td>
			</tr>
		</table>
    </form>
</div>
</body>
</html>
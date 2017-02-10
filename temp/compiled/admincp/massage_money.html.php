<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo;  短信金额</div>
<div class="container">
	<table width="100%" id="listTb">
	  <tr>
		<th>ID</th>
		<th>会员类型</th>
		<th>短信金额</th>
		<th>操作</th>
	  </tr>
	  <?php if($this->_var['data'])foreach($this->_var['data'] as $this->_var['key'] => $this->_var['v']){ ?>
	  <tr>
		<td><?php echo $this->_var['v']['id']; ?></td>
		<td><?php echo $this->_var['v']['name']; ?></td>
		<td><?php echo $this->_var['v']['value']; ?>元</td>
		<td><a href='system.php?act=massage_money_save&id=<?php echo $this->_var['v']['id']; ?>'>修改</a></td>
	  </tr>
	  <?php } ?>
	</table>
</div>
</body>
</html>

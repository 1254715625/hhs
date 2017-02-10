<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 托管设置</div>
<div class="container">
	<div class="subnav">
		<a href="?act=info">新增套餐</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>套餐名称</th>
        <th>套餐价格</th>
        <th>完成周期</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['title']; ?></td>
        <td><?php echo $this->_var['item']['price']; ?></td>
        <td><?php echo $this->_var['item']['days']; ?></td>
        <td><a href="?act=info&id=<?php echo $this->_var['item']['id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要删除此信息吗？')">删除</a></td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
</body>
</html>

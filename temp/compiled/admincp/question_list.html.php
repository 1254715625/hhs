<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 新手考试</div>
<div class="container">
	<div class="subnav">
		<a href="user_question.php?act=info">新增试题</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>试题排序</th>
        <th>试题标题</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['ranks'])foreach($this->_var['ranks'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
		<td><?php echo $this->_var['item']['shownum']; ?></td>
        <td><?php echo $this->_var['item']['title']; ?></td>
        <td><a href="?act=info&rid=<?php echo $this->_var['item']['id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要删除此试题吗？')">删除</a></td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
</body>
</html>

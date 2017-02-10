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
<div class="ur_here">首页 &raquo; 论坛管理 &raquo; 论坛板块</div>
<div class="container">
	<div class="subnav">
		<a href="forum.php?act=info">新增板块</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" id="listTb">
        <tr>
          <th>序号</th>
          <th>板块名称</th>
          <th>操作</th>
        </tr>
  	    <?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['item']){ ?>
        <tr data="<?php echo $this->_var['item']['id']; ?>">
          <td><?php echo $this->_var['item']['sorting']; ?></td>
          <td><?php echo $this->_var['item']['forum_name']; ?></td>
          <td>
            <a href="forum.php?act=info&fid=<?php echo $this->_var['item']['id']; ?>">编辑</a>|<a href="forum.php?did=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要删除此板块吗？')">删除</a>
          </td>
        </tr>
  	    <?php } ?>
      </table>
    </form>
</div>
</body>
</html>
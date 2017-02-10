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
<div class="ur_here">首页 &raquo; 会员管理 &raquo;  操作记录</div>
<div class="container">
	<div class="subnav">
		<!--<a href="user_rank.php?act=info">新增等级</a>-->
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" cellspacing="1" id="listTb">
      <tr>
        <th>涉及金额</th>
        <th>交易描述</th>
       <!--  <th>刷点</th>
        <th>操作</th> -->
        <!-- <th>操作</th> -->
      </tr>
	  <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_money']; ?></td>
        <td><?php echo $this->_var['item']['info']; ?></td>
        <!-- <td><a href="?act=user&uid=<?php echo $this->_var['item']['user_id']; ?>">修改</a> <a href="?dropid=<?php echo $this->_var['item']['user_id']; ?>" ">删除</a></td> -->
        
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
</body>
</html>

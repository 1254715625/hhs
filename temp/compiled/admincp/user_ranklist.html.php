<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 会员等级</div>
<div class="container">
	<div class="subnav">
		<a href="user_rank.php?act=info">新增等级</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" id="listTb">
        <tr>
          <th>会员等级名称</th>
          <th>积分下限</th>
          <th>积分上限</th>
          <th>特殊会员组</th>
          <th>操作</th>
        </tr>
  	    <?php if($this->_var['ranks'])foreach($this->_var['ranks'] as $this->_var['key'] => $this->_var['item']){ ?>
        <tr>
          <td><?php echo $this->_var['item']['rank_name']; ?></td>
          <td><?php echo $this->_var['item']['min_points']; ?></td>
          <td><?php echo $this->_var['item']['max_points']; ?></td>
          <td>
            <?php if($this->_var['item']['special']){ ?>
            <img src="template/images/yes.gif"/>
            <?php }else{ ?>
            <img src="template/images/no.gif" />
            <?php } ?> 
          </td>
          <td><a href="?act=info&rid=<?php echo $this->_var['item']['rank_id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['rank_id']; ?>" onclick="return confirm('请谨慎删除!')">删除</a></td>
        </tr>
  	    <?php } ?>
      </table>
    </form>
</div>
</body>
</html>
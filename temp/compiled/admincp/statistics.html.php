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
<div class="ur_here">首页 &raquo; 财务管理 &raquo; 财务统计</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
          <th colspan="3">共计 <?php echo $this->_var['count']['allpoint']; ?> 刷点，总额：<?php echo $this->_var['count']['money']; ?> 用户存款：<?php echo $this->_var['moneys']; ?> &nbsp;&nbsp;今日交易: <?php echo $this->_var['data']['pointtoday']; ?>积分 <?php echo $this->_var['data']['moneytoday']; ?>存款 &nbsp;本月交易: <?php echo $this->_var['data']['pointthismonth']; ?> 积分 <?php echo $this->_var['data']['moneythismonth']; ?> 存款 周交易: <?php echo $this->_var['data']['pointweek']; ?>积分 <?php echo $this->_var['data']['moneythisweek']; ?>存款 年交易:<?php echo $this->_var['data']['pointyear']; ?>积分 <?php echo $this->_var['data']['moneythisyear']; ?>存款</th>
      </tr>
      <tr> 
        <td width="300px">任务ID</td>
        <td>任务金额</td>
        <td>任务刷点</td>
        <!-- <td>刷点</td>
        <td>操作</td> -->
      </tr>
	    <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['id']; ?></td>
        <td><?php echo $this->_var['item']['goods_price']; ?></td>
        <td><?php echo $this->_var['item']['total_points']; ?></td>
        <!-- <td><a href="?act=user&uid=<?php echo $this->_var['item']['user_id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['user_id']; ?>">删除</a></td> -->
        
      </tr>
	    <?php } ?>
    </table>
    </form>
</div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 会员留言</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" id="listTb">
        <tr>
          <th>会员名称</th>
          <th>留言时间</th>
          <th>留言内容</th>
        </tr>
  	    <?php if($this->_var['users'])foreach($this->_var['users'] as $this->_var['key'] => $this->_var['item']){ ?>
        <tr>
          <td><?php echo $this->_var['item']['user_name']; ?></td>
          <td><?php echo $this->_var['item']['addtime']; ?></td>
          <td style="width:70%;padding:0 10px;"><?php echo $this->_var['item']['message']; ?></td>
        </tr>
  	    <?php } ?>
      </table>
    </form>
</div>
</body>
</html>
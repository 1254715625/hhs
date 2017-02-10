<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 调查总计</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
	   <tr>
		    <th>调查方式</th>
		    <?php if($this->_var['data'])foreach($this->_var['data'] as $this->_var['key'] => $this->_var['v']){ ?>
        <th><?php echo $this->_var['v']['code']; ?></th>
		    <?php } ?>
      </tr>
      <tr>
        <td>总计</td>
        <?php if($this->_var['data'])foreach($this->_var['data'] as $this->_var['key'] => $this->_var['v']){ ?>
        <td><?php echo $this->_var['v']['num']; ?></td>
		    <?php } ?>
      </tr>
    </table>
    </form>
</div>
</body>
</html>
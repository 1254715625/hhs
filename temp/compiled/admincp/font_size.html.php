<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 快递单号 &raquo;  单号字体大小</div>
<div class="container">
	<div class="subnav">
		<a href="system.php?act=set_font_size">设置大小</a>
	</div>
    <table width="100%" id="listTb">
      <tr>
        <th>Id</th>
        <th>类别</th>
        <th>大小</th>
        <th>操作</th>
      </tr>
      <tr>
        <td><a href="express_info.php?eid=<?php echo $this->_var['item']['id']; ?>"><?php echo $this->_var['item']['pid']; ?></a></td>
        <td><?php echo $this->_var['item']['name']; ?></td>
        <td><?php echo $this->_var['item']['value']; ?></td>
        <td>
		      <a href="system.php?act=set_font_size">修改</a><!-- |<a href="express_set.php?act=stop&dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要暂停此快递吗？')">暂停</a> -->
		    </td>
      </tr>
    </table>
</div>
</body>
</html>

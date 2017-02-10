<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="ur_here">首页 &raquo; 快递单号 &raquo; 快递类型设置</div>
<div class="container">
	<div class="subnav">
		<a href="express_info.php">新增快递</a>
	</div>
    <table width="100%" id="listTb">
      <tr>
        <th>快递名称</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
      </tr>
	    <?php if($this->_var['params'])foreach($this->_var['params'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><a href="express_info.php?eid=<?php echo $this->_var['item']['id']; ?>"><?php echo $this->_var['item']['title']; ?></a></td>
        <td><?php echo $this->_var['item']['shownum']; ?></td>
        <td><?php if($this->_var['item']['state']){ ?><img src="template/images/yes.gif" /><?php }else{ ?><img src="template/images/no.gif" /><?php } ?></td>
        <td>
          <a href="express_info.php?eid=<?php echo $this->_var['item']['id']; ?>">修改</a>|<?php if($this->_var['item']['state']){ ?><a href="express_set.php?act=stop&dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要暂停此快递吗？')">暂停</a><?php }else{ ?><a href="express_set.php?act=start&dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要启用此快递吗？')">启用</a>
          <?php } ?>
        </td>
      </tr>
	    <?php } ?>
    </table>
</div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function checkForm(form)
{
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 盛付通设置</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">盛付通设置</th>
      </tr>
	  <?php if($this->_var['params'])foreach($this->_var['params'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td class="left"><?php echo $this->_var['item']['name']; ?></td>
        <td><input name="param[<?php echo $this->_var['key']; ?>]" type="text" value="<?php echo $this->_var['info'][$this->_var['key']]; ?>" size="<?php if($this->_var['item']['size']){ ?><?php echo $this->_var['item']['size']; ?><?php }else{ ?>45<?php } ?>" /> <?php echo $this->_var['item']['unit']; ?> <span><?php echo $this->_var['item']['note']; ?></span></td>
      </tr>
	  <?php } ?>
      <tr>
        <td colspan="2" class="footer">
			<input type="submit" class="submit" value="保存" />
			<input type="reset" class="reset" value="重填" />
		</td>
      </tr>
    </table>
    </form>
</div>
</body>
</html>

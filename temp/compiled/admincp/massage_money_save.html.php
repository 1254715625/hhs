<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function checkForm(form){
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 系统设置 &raquo; 短信金额修改</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
      <input name='id' value='<?php echo $this->_var['id']; ?>' type='hidden' />
      <table width="100%" id="editTb">
        <tr>
          <th colspan="2">短信金额修改</th>
        </tr>
        <tr>
          <td class="left">会员类型</td>
          <td>
  		      <input type="text" name="param[<?php echo $this->_var['item']['code']; ?>]" id="d4311" value="<?php echo $this->_var['params']['name']; ?>" readonly="readonly" />
  		    </td>
        </tr>
  	    <tr>
          <td class="left">短信金额</td>
          <td><input name="message" id="d4311" type="text" value="" /></td>
        </tr>
        <tr>
          <td colspan="2" class="footer">
      			<input type="submit" class="submit" value="保存" />
      		</td>
        </tr>
      </table>
    </form>
</div>
</body>
</html>
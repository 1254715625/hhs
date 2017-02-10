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
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 提现中心 &raquo; 修改</div>
<div class="container">
	<div class="subnav">
        <a href='system.php?act=tixian_center '>返回列表</a>
    </div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype="multipart/form-data">
    	<input name="id" type="hidden" value="<?php echo $this->_var['id']; ?>" size="10" />
	    <table width="100%" id="editTb">
			<tr>
				<th colspan="2">内容修改</th>
			</tr>
			<tr>
				<td class="left">名称</td>
				<td><input name="name" type="text" value="<?php echo $this->_var['result']['name']; ?>"/></td>
			</tr>
			<tr>
				<td class="left">是否可用</td>
				<td>
					<label>
						<input name="value" type="radio" value="1" checked='checked' />&nbsp;启用
					</label>
					<label>
						<input name="value" type="radio" value="0" />&nbsp;禁用
					</label>
				</td>
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
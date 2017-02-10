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
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 栏目公告 &raquo; 修改</div>
<div class="container">
	<div class="subnav">
        <a href='system.php?act=gonggao'>返回列表</a>
    </div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype="multipart/form-data">
    	<input name='id' value='<?php echo $this->_var['id']; ?>' type='hidden' >
	    <table width="100%" id="editTb">
			<tr>
				<th colspan="2">修改栏目公告</th>
			</tr>
			<tr>
				<td class="left">公告内容</td>
				<td><textarea name="content"></textarea></td>
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
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
	<div class="ur_here">首页 &raquo; 网站设置 &raquo; 提现QQ &raquo; 修改</div>
	<div class="container">
		<div class="subnav">
	        <a href='system.php?act=tixian_qq'>返回列表</a>
	    </div>
	    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype="multipart/form-data">
		    <table width="100%" id="editTb">
				<tr>
					<th colspan="2">内容修改</th>
				</tr>
				<tr>
					<td class="left">投放位置</td>
					<td>
						<select name='select'>
							<option value="<?php echo $this->_var['code']['type']; ?>"><?php echo $this->_var['code']['code']; ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="left">QQ名称</td>
					<td><input type="text" name="qq"/>(如多个用“，”号隔开)</td>
				</tr>
				<tr>
					<td colspan="2" class="footer">
					    <input type="submit" class="submit" value="保存" />
						<!-- <input type="reset" class="reset" value="" /> -->
					</td>
				</tr>
		    </table>
	    </form>
	</div>
</body>
</html>

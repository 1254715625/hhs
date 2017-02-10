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
function checkForm(form)
{
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 论坛图片设置</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">论坛图片设置</th>
      </tr>
      <tr>
        <td colspan="2">
        	<div style="padding-left:35px;">
        		<p class="p-m">
					允许上传的图片格式：
					<label><input type='checkbox' name='box[0]' />&nbsp;png</label>
					<label><input type='checkbox' name='box[1]' />&nbsp;jpg</label>
					<label><input type='checkbox' name='box[2]' />&nbsp;jpeg</label>
					<label><input type='checkbox' name='box[3]' />&nbsp;gif</label>
				</p>	
				<p class="p-m">
					允许上传的图片大小：
				    <input type="text" name="size" id="d4312" style="width:160px;"/>
				    单位是kb&nbsp;&nbsp;&nbsp;1M=1024kb
			    </p>
        	</div>
		</td>
      </tr>
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

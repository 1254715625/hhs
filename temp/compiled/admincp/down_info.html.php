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
	if(form.title.value == "")
	{
		alert("请填写文件名称");
		return false;
	}
	
	if(form.file_path.value == "")
	{
		alert("请填写文件地址");
		return false;
	}
	
	if(form.intro.value == "")
	{
		alert("请填写文件描述");
		return false;
	}
	if(form.img.value == "")
	{
		alert("请选择文件图片");
		return false;
	}
	
	
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 新增下载</div>
<div class="container">
	<div class="subnav">
		<a href="?act=list">返回列表</a>
	</div>
	
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype='multipart/form-data'>
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">下载信息</th>
      </tr>
      <tr>
        <td class="left">文件名称</td>
        <td><input name="title" type="text" value="" /></td>
      </tr>
      <tr>
        <td class="left">文件地址</td>   
        <td><input name="file_path" type="text" value="" /></td>
      </tr>
      <tr>
        <td class="left">文件描述</td>
        <td><textarea name="intro"></textarea></td>
      </tr>
	  <tr>
        <td class="left">板块图标</td>
        <td>
        	<a href="javascript:;" class="upload-btn">上传图片
				<input type="file" name="img" />
			</a>
			<span style="margin-left:5px;vertical-align:middle;">(请上传120*100大小图片)</span>
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

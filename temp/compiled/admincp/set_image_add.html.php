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
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 添加广告设置</div>
<div class="container">
	<div class="subnav">
        <a href='system.php?act=set_image'>返回列表</a>
    </div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype="multipart/form-data">
    <table width="100%" id="editTb">
		<tr>
			<th colspan="2">添加广告设置</th>
		</tr>
		<tr>
			<td class="left"></td>
			<td>
				<select name='select'>
					<option value='public_right' selected='selected'>公共菜单栏右侧</option>
					<option value='shouye_datu' selected='selected'>首页导航条大图</option>
					<option value='通用的图片'>通用的图片</option>
					<option value='问答'>问答</option>
					<option value='购买麦点'>购买麦点</option>
					<option value='网店托管'>网店托管</option>
					<option value='会员中心'>会员中心</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="left"><?php echo $this->_var['item']['name']; ?></td>
			<td><input type="text" name="link" size="10" />链接地址</td>
		</tr>
		<tr>
			<td class="left"><?php echo $this->_var['item']['name']; ?></td>
			<td>
				<a href="javascript:;" class="upload-btn">上传图片
					<input type="file" name="photo" id='file' />
				</a>
			</td>
		</tr>
		<tr>
			<td class="footer" colspan="2">
			    <input type="submit" class="submit" value="保存" />
				<!-- <input type="reset" class="reset" value="重置" /> -->
			</td>
		</tr>
    </table>
    </form>
</div>
<script>
	$(function(){
		$('#file').on('click',function(){
			$.ajax({
				type: "POST",
				url: "system.php?act=ajax_image",
				data: "name=John&location=Boston",
				dataType:"json",
				success: function(msg){
					console.log(msg);
				}
			})
		})
	})
</script>
</body>
</html>
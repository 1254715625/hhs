<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function checkForm(form){
	if(form.title.value == "")
	{
		alert("请填写快递名称");
		return false;
	}
	
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 快递单号 &raquo; 快递类型设置 &raquo; 编辑快递类型</div>
<div class="container">
	<div class="subnav">
		<a href="express_set.php">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="express_info.php" onsubmit="return checkForm(this);">
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">编辑快递类型</th>
      </tr>
      <tr>
        <td class="left">快递名称</td>
        <td><input name="title" type="text" value="<?php echo $this->_var['params']['title']; ?>" /></td>
      </tr>
      <tr>
        <td class="left">排序</td>
        <td><input name="shownum" type="text" value="<?php echo $this->_var['params']['shownum']; ?>" /></td>
      </tr>
      <tr>
        <td class="left">内容</td>
        <td style="padding:5px;">
			<input type="hidden" name="eid" value="<?php echo $this->_var['eid']; ?>">
			<textarea id="editor_id" name="content" style="width:700px;"><?php echo $this->_var['params']['content']; ?></textarea>
			<script charset="utf-8" src="template/js/kindeditor-4.1.10/kindeditor.js"></script>
			<script charset="utf-8" src="template/js/kindeditor-4.1.10/lang/zh_CN.js"></script>
			<script>
				KindEditor.ready(function(K) {
					window.editor = K.create('#editor_id');
				});
			</script>
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
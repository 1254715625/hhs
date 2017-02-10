<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function checkForm(form){
	if(form.name.value == ""){   
        form.name.focus();
		alert("请填写友情链接名称");
		return false;
	}
	if(form.link.value == ""){
        form.link.focus();
		alert("请填写友情链接地址");
		return false;
	}
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 编辑友情链接</div>
<div class="container">
	<div class="subnav">
		<a href="link.php?act=list">返回列表</a>
	</div>
  <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
  	  <input type="hidden" name="id" value="<?php echo $this->_var['info']['id']; ?>">
      <table width="100%" id="editTb">
        <tr>
            <th colspan="2">编辑友情链接</th>
        </tr>
        <tr>
            <td class="left">链接名称</td>
            <td><input name="name" type="text" value="<?php echo $this->_var['info']['name']; ?>" /></td>
        </tr>
        <tr>
            <td class="left">链接地址</td>
            <td><input name="link" type="text" value="<?php echo $this->_var['info']['link']; ?>" /></td>
        </tr>
        <tr>
            <td class="left">链接排序</td>
            <td><input name="shownum" type="text" value="<?php echo $this->_var['info']['shownum']; ?>" /></td>
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
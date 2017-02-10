<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
function checkForm(form){
	if(form.forum_name.value == "")
	{
		alert("请填写板块名词");
		return false;
	}
	if(form.sorting.value == "")
	{
		alert("请填写板块序号");
		return false;
	}
	
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 论坛管理 &raquo; 编辑论坛板块</div>
<div class="container">
	<div class="subnav">
		<a href="forum.php">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="forum.php?act=info" onsubmit="return checkForm(this);" enctype='multipart/form-data'>
	    <input type="hidden" name="id" value="<?php echo $this->_var['info']['id']; ?>">
      <table width="100%" id="editTb">
        <tr>
          <th colspan="2">编辑板块</th>
        </tr>
        <tr>
          <td class="left">板块名称</td>
          <td><input name="forum_name" type="text" value="<?php echo $this->_var['info']['forum_name']; ?>" /></td>
        </tr>
        <tr>
          <td class="left">板块排序</td>
          <td><input name="sorting" type="text" value="<?php echo $this->_var['info']['sorting']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" /></td>
        </tr>
  	    <tr>
          <td class="left">板块图标</td>
          <td>
            <a href="javascript:;" class="upload-btn">上传图片
              <input type="file" name="img" />
            </a>
            <span style="margin-left:5px;vertical-align:middle;">(请上传53*50大小图片)</span>
          </td>
        </tr>
  	  <?php if($this->_var['info']['img']){ ?>
  	    <tr>
          <td class="left">板块图标</td>
          <td>
            <p class="p-m"><img src="<?php echo $this->_var['info']['img']; ?>" style="width:53px;height:50px;"></p>
          </td>
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

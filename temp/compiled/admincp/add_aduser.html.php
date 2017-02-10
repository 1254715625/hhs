<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function checkForm(form){
	if(form.rank_name.value == "")
	{
		alert("请填写会员名称");
		return false;
	}
	
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 系统管理 &raquo; 添加管理员</div>
<div class="container">
	<div class="subnav">
		<a href="set_system.php?act=adminlist">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
    <table width="100%" id="editTb">
      <tr>
        <td class="left">管理员名称</td>
        <td><input name="admin_name" type="text" value="<?php echo $this->_var['data']['admin_name']; ?>" /></td>
      </tr>
	   <tr>
        <td class="left">密码</td>
        <td><input name="pwd" type="password" value="" /></td>
      </tr>
	   <tr>
        <td class="left">确认密码</td>
        <td><input name="repwd" type="password" value="" /></td>
      </tr>
	  <tr>
        <td class="left">管理员角色</td>
        <td>
			<select name="role">
				<option value="1">超级管理员</option>
				<option value="2">普通管理员</option>
			</select>
		</td>
      </tr>
	  <tr>
        <td class="left">手机</td>
        <td><input name="phone" type="text" value="<?php echo $this->_var['data']['phone']; ?>" /></td>
      </tr>
	  <tr>
        <td class="left">Email</td>
        <td><input name="email" type="text" value="<?php echo $this->_var['data']['email']; ?>" /></td>
      </tr>
	  <tr>
        <td class="left">账号状态</td>
        <td>
        	<label><input name="is_ok" type="radio" value="1" />&nbsp;屏蔽</label>
        	<label><input name="is_ok" type="radio" value="0" />&nbsp;正常</label>
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 任务奖励设置</div>
<div class="container">
	<div class="subnav">
		<a href="?act=list">返回列表</a>
	</div>
	
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
    <table width="100%" cellspacing="1" id="editTb">
      <tr>
        <th colspan="2">任务奖励设置</th>
      </tr>
      <tr>
        <td class="left">每天发布任务</td>
        <td><input name="releases" type="text" value="<?php echo $this->_var['info']['releases']; ?>" size="10" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="3"/>/个</td>
      </tr>
      <tr>
        <td class="left">每天接手任务</td>
        <td><input name="takeover" type="text" value="<?php echo $this->_var['info']['takeover']; ?>" size="10" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="3"/>/个</td>
      </tr>
      <tr>
        <td class="left">完成奖励刷点</td>
        <td><input name="reward" type="text" value="<?php echo $this->_var['info']['reward']; ?>" size="10" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="3"/>/点</td>
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

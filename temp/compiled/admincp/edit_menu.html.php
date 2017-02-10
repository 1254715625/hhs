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
<div class="ur_here">首页 &raquo; 系统管理 &raquo; 修改栏目</div>
<div class="container">
	<div class="subnav">
		<a href="set_system.php?act=menulist">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
	  <input type="hidden" value="<?php echo $this->_var['data']['id']; ?>" name="id" />
    	
	    <table width="100%" id="editTb">
	      <tr>
	        <td class="left">栏目名称</td>
	        <td><input name="name" type="text" value="<?php echo $this->_var['data']['name']; ?>" /></td>
	      </tr>
		  <tr>
	        <td class="left">顶部栏目</td>
	        <td>
	        	<input name="active" type="text" value="<?php echo $this->_var['data']['active']; ?>" />
	        	<font color="red">* 非顶部栏目时留空</font>
	        </td>
	      </tr>
		  <tr>
	        <td class="left">栏目所属</td>
	        <td>
				<select name="pid">
					<option value="--请选择--">--请选择--</option>
					<?php if($this->_var['data']['column'])foreach($this->_var['data']['column'] as $this->_var['k'] => $this->_var['v']){ ?>
					<option value="<?php echo $this->_var['v']['id']; ?>" <?php if($this->_var['data']['pid'] == $this->_var['v']['id']){ ?>selected<?php } ?>><?php echo $this->_var['v']['name']; ?></option>
					<?php } ?>
				</select>
				<font color="red">* 非顶部栏目时该项不选择</font>
			</td>
	      </tr>
		  <tr>
	        <td class="left">栏目方法</td>
	        <td>
	        	<input name="method" type="text" value="<?php echo $this->_var['data']['method']; ?>" />
	        	<font color="red">* 非顶部栏目时该项不选择</font>
	        </td>
	      </tr>
		    <!-- <tr>
		        <td class="left">账号状态</td>
		        <td>
		        	<label>
		        		<input name="is_ok" type="radio" value="1" <?php if($this->_var['data']['is_ok'] == 1){ ?> checked <?php } ?>/>&nbsp;冻结
		        	</label>
		        	<label>
		        		<input name="is_ok" type="radio" value="0" <?php if($this->_var['data']['is_ok'] == 0){ ?> checked <?php } ?>/>&nbsp;正常
		        	</label>
				</td>
		      </tr> -->
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 系统管理 &raquo; 角色管理 &raquo; 设置权限</div>
<div class="container">
	<div class="subnav">
		<a href="set_system.php?act=adminlist">返回列表</a>
	</div>
	<form method="post" action="" name="">
		<input type="hidden" name="admin_id" value="<?php echo $this->_var['admin_id']; ?>">
		<table width="100%" id="editTb">
			<?php if($this->_var['data'])foreach($this->_var['data'] as $this->_var['k'] => $this->_var['v']){ ?>
			<tr>
				<td style="padding-left:20px;">
					<label>
						<input type="checkbox" class="checkTotalItem"  name="ids[<?php echo $this->_var['v']['id']; ?>][]" value="<?php echo $this->_var['v']['id']; ?>"/>&nbsp;<?php echo $this->_var['v']['name']; ?>
					</label>
				</td>
			</tr>
			<tr>
				<td style="padding-left:40px;" class="sonRules">
					<?php if($this->_var['v']['column'])foreach($this->_var['v']['column'] as $this->_var['key'] => $this->_var['val']){ ?>
					<label>
						<input type="checkbox" name="ids[<?php echo $this->_var['v']['id']; ?>][]" value="<?php echo $this->_var['val']['id']; ?>" />&nbsp;<?php echo $this->_var['val']['name']; ?>
					</label>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			<tr>
		        <td class="footer" style="padding-left:40px;">
					<input type="submit" class="submit" value="保存" />
				</td>
		      </tr>
		</table>
	</form>
</div>
<script>
	$(function(){
		//全选
		$(".checkTotalItem").click(function(){
			var checkBoxs =  $(this).parents('tr').siblings().find(".sonRules input:checkbox");
			if(this.checked){
		        checkBoxs.each(function(index,ele){
		        	$(ele).prop("checked", true);
		        })
		   }else{   
		        checkBoxs.each(function(index,ele){
		        	$(ele).prop("checked", false);
		        })
		        
		    }   
		})
		$(".sonRules input:checkbox").click(function(){
			if($(this).is(":checked")){
				$(this).parent().prev().find(".checkTotalItem").prop("checked", true)
			}else{
				$(this).parent().prev().find(".checkTotalItem").prop("checked", false)
			}
		})
	})
	
</script>
</body>
</html>
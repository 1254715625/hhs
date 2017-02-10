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
<div class="ur_here">首页 &raquo; 系统管理 &raquo; 角色管理</div>
<div class="container">
	<!--form  method="post" action="" id="form1">
		<div class="subnav">
			<!--<a href="user_rank.php?act=info">新增等级</a>-->
			
			<!--手机号：<input type="text" name="phone" id="phone" value="<?php if($this->_var['phone']){ ?><?php echo $this->_var['phone']; ?><?php } ?>" placeholder="手机号" style="height:23px">
			<input type="submit" name="" value="检索" id="search">
		</div>
	</form-->
	<div class="subnav">
		<a href="set_system.php?act=add_aduser">添加管理员</a>
	</div>
	<table width="100%" id="listTb">
	  <tr>
		<th>ID</th>
		<th>管理员</th>
		<th>管理角色</th>
		<th>手机号</th>
		<th>Email</th>
		<th>最后登录</th>
		<th>账号状态</th>
		<th width="150px">操作</th>
	  </tr>
	  <?php if($this->_var['data']['record'])foreach($this->_var['data']['record'] as $this->_var['key'] => $this->_var['v']){ ?>
	  <tr>
		<td><?php echo $this->_var['v']['admin_id']; ?></td>
		<td><?php echo $this->_var['v']['admin_name']; ?></td>
		<td><?php echo $this->_var['v']['role']; ?></td>
		<td><?php echo $this->_var['v']['phone']; ?></td>
		<td><?php echo $this->_var['v']['email']; ?></td>
		<td><?php echo $this->_var['v']['last_login']; ?></td>
		<td><?php echo $this->_var['v']['is_ok']; ?></td>
		<?php if($this->_var['v']['admin_id'] == 1){ ?>
		<td><a href="set_system.php?act=edit_admin&id=<?php echo $this->_var['v']['admin_id']; ?>">修改</a></td> 
		<?php }else{ ?>
		<td>
			<a href="set_system.php?act=edit_admin&id=<?php echo $this->_var['v']['admin_id']; ?>">修改</a>|<a href="set_system.php?act=auth&id=<?php echo $this->_var['v']['admin_id']; ?>">设置权限</a>|<a href="set_system.php?act=del_admin&id=<?php echo $this->_var['v']['admin_id']; ?>" onclick="if(confirm('确定删除吗？')) return true; else return false;">删除</a>
		</td>
		<?php } ?>
	  </tr>
	  <?php } ?>
	  <tr>
		<td colspan="8" class="footer"><div class="page"><?php echo $this->_var['data']['pagestr']; ?></div></td>
	  </tr>
	</table>
<script>
$(function(){
	var phone = $("#phone").val();
	$("#search").click(function(){
		changeSearch()
	});
	if(phone != ""){
		changeSearch()
	}
	
})
function changeSearch(){
	$("#page a").each(function(index,ele){
		var yhref = $(ele).attr("href");
		$(ele).attr("href",yhref+"&phone="+phone);
	})
}
</script>
</div>
</body>
</html>
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
<div class="ur_here">首页 &raquo; 系统管理 &raquo;  栏目列表</div>
<div class="container">
	<!--form  method="post" action="" id="form1">
		<div class="subnav">
			<!--<a href="user_rank.php?act=info">新增等级</a>-->
			
			<!--手机号：<input type="text" name="phone" id="phone" value="<?php if($this->_var['phone']){ ?><?php echo $this->_var['phone']; ?><?php } ?>" placeholder="手机号" style="height:23px">
			<input type="submit" name="" value="检索" id="search">
		</div>
	</form-->

	<div class="subnav">
		<a href="set_system.php?act=addmenu">添加栏目</a>
	</div>
	<table width="100%" id="listTb">
	  <tr>
		<th>ID</th>
		<th>栏目名</th>
		<th>顶部栏目</th>
		<th style="width:300px;">右侧栏目</th>
		<th>操作</th>
	  </tr>
	   <?php if($this->_var['data'])foreach($this->_var['data'] as $this->_var['k'] => $this->_var['v']){ ?>
	  <tr>
		<td><?php echo $this->_var['v']['id']; ?></td>
		<td><?php echo $this->_var['v']['name']; ?></td>
		<td><?php echo $this->_var['v']['active']; ?></td>
		<td></td>
		<td><?php if($this->_var['v']['id'] == 7){ ?> <?php }else{ ?> <a href="set_system.php?act=edit_menu&id=<?php echo $this->_var['v']['id']; ?>">修改</a>|<a href="set_system.php?act=del_menu&id=<?php echo $this->_var['v']['id']; ?>">删除</a><?php } ?>
		</td>
	  </tr>
		<?php if($this->_var['v']['data']){ ?>
			<?php if($this->_var['v']['data'])foreach($this->_var['v']['data'] as $this->_var['key'] => $this->_var['val']){ ?>
			<tr>
				<td><?php echo $this->_var['val']['id']; ?></td>
				<td>∟<?php echo $this->_var['val']['name']; ?></td>
				<td></td>
				<td><?php echo $this->_var['val']['method']; ?></td>
				<td><a href="set_system.php?act=edit_menu&id=<?php echo $this->_var['val']['id']; ?>">修改</a>|<a href="set_system.php?act=del_menu&id=<?php echo $this->_var['val']['id']; ?>">删除</a></td>
			</tr>
			<?php } ?>
		<?php } ?>
	  <?php } ?>
	</table>
</div>
<script>
$(function(){
	var phone = $("#phone").val();
	$("#search").click(function(){
		changeSearch()
	})
	if(phone != ""){
		changeSearch()
	}
	function changeSearch(){
		$("#page a").each(function(index,ele){
			var yhref = $(ele).attr("href");
			$(ele).attr("href",yhref+"&phone="+phone);
		})
	}
})
</script>
</body>
</html>
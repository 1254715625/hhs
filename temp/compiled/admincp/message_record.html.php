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
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 短信记录</div>
<div class="container">
	<form  method="post" action="" id="form1">
		<div class="itemtitle">
			<span>手机号：</span>
			<span>
				<input type="text" name="phone" id="phone" value="<?php if($this->_var['phone']){ ?><?php echo $this->_var['phone']; ?><?php } ?>" placeholder="请输入手机号" />
			</span>
			<span><input type="submit" value="检索" id="search"></span>
		</div>
	</form>
	<table width="100%" id="listTb">
	  <tr>
		<th>ID</th>
		<th>用户会员</th>
		<th>发送手机</th>
		<th>短信类型</th>
		<th>内容</th>
		<th>发送时间</th>
		<th>发送状态</th>
	  </tr>
	  <?php if($this->_var['data']['record'])foreach($this->_var['data']['record'] as $this->_var['key'] => $this->_var['v']){ ?>
	  <tr>
		<td><?php echo $this->_var['v']['id']; ?></td>
		<td><?php echo $this->_var['v']['user_name']; ?></td>
		<td><?php echo $this->_var['v']['phone']; ?></td>
		<td><?php echo $this->_var['v']['type']; ?></td>
		<td><?php echo $this->_var['v']['code']; ?></td>
		<td><?php echo $this->_var['v']['sendtime']; ?></td>
		<td><?php echo $this->_var['v']['status']; ?></td>
	  </tr>
	  <?php } ?>
	  <tr>
		<td colspan="7" class="footer"><div class="page" id="page"><?php echo $this->_var['data']['pagestr']; ?></div></td>
	  </tr>
	</table>
</div>
<script>
	$(function(){
		var phone = $("#phone").val();
		$("#search").click(function(){
			changeSearch();
		});
		if(phone != ""){
			changeSearch();
		}
	})
	function changeSearch(){
		$("#page a").each(function(index,ele){
			var yhref = $(ele).attr("href");
			$(ele).attr("href",yhref+"&phone="+phone);
		})
	}
</script>
</body>
</html>

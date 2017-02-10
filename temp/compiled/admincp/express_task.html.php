<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/css/common.css">
<link rel="stylesheet" type="text/css" href="template/css/main.css">

<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/artDialog.js"></script>
<script type="text/javascript" src="template/js/layer/layer.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 快递单号 &raquo; 底单管理</div>
<div class="container">
	<div class="itemtitle">
		<h3>快递单号管理</h3>
	</div>
	<div class="btnBox">
		<ul class="clearfix">
			<li><a href="express_virtual.php">虚拟快递管理</a></li>
			<li><a href="express_real.php">真实快递管理</a></li>
			<li class="current"><a href="express_task.php">底单管理</a></li>
			<li><a href="express_set.php">快递类型设置</a></li>
		</ul>
	</div>
	<table width="100%" id="listTb">
	  <tr>
	    <th colspan="7">
	    	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['listnum']; ?></strong>条符合条件的信息
		</th>
	  </tr>
	  <tr>
	  	<td colspan="7">
	  		<div class="btnBox" style="margin-left:15px;">
				<ul class="clearfix">
					<li <?php if($this->_var['act'] != 'type'){ ?>class="current"<?php } ?>>
						<a href="express_task.php" style="padding:0 20px;">虚拟底单管理</a>
					</li>
				    <li <?php if($this->_var['act'] == 'type'){ ?>class="current"<?php } ?>>
				    	<a href="express_task.php?act=type" style="padding:0 20px;">真实底单管理</a>
				    </li>
				</ul>
			</div>
	  	</td>
	  </tr>
	  <tr>
		<td>编号</td>
		<td>快递单号</td>
		<td>快递类型</td>
		<td>添加时间</td>
		<td>物流公司</td>
		<td>收货地址</td>
		<td>操作</td>
	  </tr>
	  <?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
	  <tr>
	    <td><?php echo $this->_var['val']['id']; ?></td>
		<td><?php echo $this->_var['val']['eid']; ?></td>
		<td><?php echo $this->_var['val']['type']; ?></td>
		<td><?php echo $this->_var['val']['addtime']; ?></td>
		<td><?php echo $this->_var['val']['wl']; ?></td>	
		<td><?php echo $this->_var['val']['to_adds']; ?></td>
		<td>
			<?php if($this->_var['val']['info']){ ?>
			<font color="red">拒绝原因：</font><?php echo $this->_var['val']['info']; ?>
			<?php }else{ ?><?php if($this->_var['val']['pic']){ ?>
			<input type="submit" value="查看底单" class="btn_jc see" pic="../uploads/express/<?php echo $this->_var['val']['pic']; ?>">
			<?php }else{ ?>
			<form enctype='multipart/form-data' action="express_task.php?act=<?php echo $this->_var['act']; ?>" method="POST">
				<input type="hidden" name="id" value="<?php if($this->_var['val']['sid']){ ?><?php echo $this->_var['val']['sid']; ?><?php }else{ ?><?php echo $this->_var['val']['id']; ?><?php } ?>">
				<a href="javascript:;" class="upload-btn">选择文件
					<input type="file" name="files" class="files">
				</a>
				<a href="javascript:;" class="filea jj" data="<?php if($this->_var['val']['sid']){ ?><?php echo $this->_var['val']['sid']; ?><?php }else{ ?><?php echo $this->_var['val']['id']; ?><?php } ?>">拒绝</a>
				<?php } ?><?php } ?>
			</form>
		</td>
	  </tr>
	  <?php } ?>
	  <tr>
	    <td colspan="7" class="footer"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
	  </tr>
	</table>
</div>

<script type="text/javascript">
$(function(){
	$(".files").change(function(){
		$(this).parents('form').submit();
	});
	$("input.see").click(function(){
		var pic=$(this).attr('pic');
		window.top.art.dialog({title: '友情提示',content: '<img src="'+pic+'">',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
	});
	$(".show").hover(function(){
		var data=$(this).attr('data');
		if(data){
			layer.tips(data,$(this),{tips:[1,'#3595CC'],time:1000});
		}
	});
	$(".filea").click(function(){
		var data=$(this).attr('data');
		art.dialog({
			title: '友情提示',
			content: '请填写拒绝原因：<br><textarea id="ju" style="width:350px;height:150px;"></textarea>',
			fixed: true,
			lock: true,
			ok : function(){
				var ju=$("#ju").val();
				if(ju ==''){
					art.dialog({id:'mention', title: '提示',content: '请填写拒绝原因~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { $('#ju').focus();return true;}});return false;
				}
				$.post('express_task.php?type=con&act=<?php echo $this->_var['act']; ?>',{"data":data,"ju":ju},function(data){
						location.reload();
				});
			},
			okValue : '确定',
			cancelValue: '取消',
			cancel: function () { return true;}
		});
	});
});
</script>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="template/css/twitter.css">
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/artDialog.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 论坛管理 &raquo; 版主管理</div>
<div class="container">
	<div class="subnav">
		<a href="javascript:;" id="add">新增版主</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
	    <table width="100%" id="listTb">
	      <tr>
	        <th>版主ID</th>
	        <th>版主名称</th>
	        <th>版主等级</th>
	        <th style="width:290px;">注册时间</th>
	        <th>操作</th>
	      </tr>
		  <?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['item']){ ?>
	      <tr data="<?php echo $this->_var['item']['user_id']; ?>">
	        <td><?php echo $this->_var['item']['user_id']; ?></td>
	        <td><?php echo $this->_var['item']['user_name']; ?></td>
	        <td><?php echo $this->_var['item']['rank_name']; ?></td>
	        <td><?php echo $this->_var['item']['add_time']; ?></td>
	        <td>
	        	<a href="forum.php?act=moderator&did=<?php echo $this->_var['item']['user_id']; ?>" onclick="return confirm('您确定要移除此板主吗？')">移除</a>
	        </td>
	      </tr>
		  <?php } ?>
	    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$("#add").click(function(){
		$.post('forum.php?act=infoget',function(data){
			if(data){
				art.dialog({
					id:'as',
					title: '友情提示',
					content: data,
					fixed: true,
					lock: true,
					ok : function(){
						var select=new Array();
						$(".info").each(function(e){
							var t=$(this).is(':checked');
							var v=$(this).val();
							if(t){
								select[e]=v;
							}
						});
						if(select.length==0){
							art.dialog({title: '提示',content: '请选择版主',fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
							return false;
						}else{
							$.post('forum.php?act=moderator',{'select':select},function(data){
								location.reload();
							});
						}
					},
					okValue : '确定',
					cancelValue: '取消',
					cancel: function () { return true;}
				});
			}
		});
	});
});
</script>
</body>
</html>

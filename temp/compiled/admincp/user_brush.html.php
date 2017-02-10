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
<script type="text/javascript" src="template/js/layer/layer.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 职业刷客</div>
<div class="container">
	<div class="subnav">
		<a href="user_brush.php?act=info">刷客设置</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>会员名称</th>
        <th>申请时间</th>
        <th>到期时间</th>
        <th>本周完成接手任务</th>
        <th>本周有效完成接手任务</th>
        <th>本周单个掌柜虚拟任务</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['user'])foreach($this->_var['user'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_name']; ?></td>
        <td><?php echo $this->_var['item']['brush']; ?></td>
        <td><?php echo $this->_var['item']['brush_end']; ?></td>
        <td><?php echo $this->_var['item']['in_task']; ?></td>
        <td><?php echo $this->_var['item']['in_tasks']; ?></td>
        <td><?php echo $this->_var['item']['one_buy']; ?></td>
        <td><a href="javascript:;" class="ff" data="<?php echo $this->_var['item']['user_id']; ?>">发放奖励</a></td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$(".ff").click(function(){
		var data=$(this).attr('data');
		if(data){
			window.top.art.dialog({
				id:'mention',
				title: '温馨提示',
				content: '<font style="color:red;font-size:16px;" >职业刷客每周只能领取一次奖励，发放奖励后此用户本周任务结束，确认要给此用户发放奖励吗？</font>',
				fixed: true,
				lock: true,
				okValue: '确定',
				cancelValue: '取消',
				ok: function () {
					window.top.art.dialog({
						title: '发放奖励',
						content: '<p style="margin:10px 0;color:#EB0F0F;">请选择奖励形式：<select id="state"><option value="1" selected>刷点</option><option value="2">存款</option></select></p><p style="margin:10px 0;color:#EB0F0F;">请输入奖励金额：<input style="border:1px solid #999;" type="text" id="num" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" value=""></p>',
						fixed: true,
						lock: true,
						okValue: '确定',
						cancelValue: '取消',
						ok: function () {
							var state=$("#state",window.parent.document).val();
							var num=parseInt($("#num",window.parent.document).val());
							if(num =='' || isNaN(num)){
								window.top.art.dialog({id:'mention', title: '提示',content: '请输入奖励金额~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
							}else{
								$.post('user_brush.php?act=brush',{'data':data,'state':state,'num':num},function(data){
									$("#rightFrame",window.parent.document).attr('src','user_brush.php');
								});
							}
						},
						cancel: function () { return true;}
					});
				},
				cancel: function () { return true;}
			});
			return false;
		}
	});
});
</script>
</body>
</html>

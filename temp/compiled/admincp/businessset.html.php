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
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 退保设置</div>
<div class="container">
	<div class="subnav">
		<a href="task_business.php">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>等级代码</th>
        <th>等级名称</th>
        <th>冻结时间</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['id']; ?></td>
        <td class="rank_name"><?php echo $this->_var['item']['rank_name']; ?></td>
		<td class="freeze"><?php echo $this->_var['item']['freeze']; ?></td>
        <td><a class="update" href="javascript:void(0)">修改冻结时间</a></td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
</body>
<script>
	$('.freeze').each(function(){
		$(this).html(parseInt(parseInt($(this).html())/3600/24)+'天');
	});
	$('.update').click(function(){
		var thisname=$(this).parent().parent().find('.rank_name').html();
		var thisid=$(this).parent().parent().children(0).html();
		var data=prompt('修改'+thisname+'的时间(天)为:');
		var thisdom=$(this);
		if(data==''){
			alert('时间不能为空');
		}else if(data!=null){
			data=parseInt(data)*3600*24;
			$.post('?mod=update',{
				id:thisid,
				freeze:data
			},function(backdata){
				if(backdata==1){
					thisdom.parent().parent().find('.freeze').html(data/3600/24+'天');
					alert('修改成功');
				}
			});
		}
	});
</script>
</html>
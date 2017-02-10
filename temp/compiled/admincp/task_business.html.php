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
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 退保处理</div>
<div class="container">
	<div class="btnBox">
		<ul class="clearfix">
			<li><a href="task_business.php">可处理</a></li>
			<li><a href="task_business.php?show=1">冻结中</a></li>
			<li><a href="businessset.php">退保设置</a></li>
		</ul>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>会员名称</th>
        <th>手机号码</th>
        <th>商保金额</th>
        <?php if($this->_var['state']){ ?>
        <th>申请时间</th>
        <?php } ?>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_name']; ?></td>
        <td><?php echo $this->_var['item']['mobile_phone']; ?></td>
		<td><?php echo $this->_var['item']['business']; ?></td>
		<?php if($this->_var['state']){ ?>
        <td><?php echo $this->_var['item']['business_time']; ?></td>
        <?php } ?>
        <td><?php if($this->_var['state']){ ?>
            <a data="<?php echo $this->_var['item']['user_id']; ?>" class="unfreeze" href="JavaScript:;" style="color:red;">解冻</a><?php }else{ ?>
            <a href="JavaScript:;" style="color:green;" data="<?php echo $this->_var['item']['user_id']; ?>" class="tg">退款</a>
            <a href="businessset.php">退保设置</a>
            <a href="JavaScript:;" style="color:red;" data="<?php echo $this->_var['item']['user_id']; ?>" class="utg">拒绝申请</a><?php } ?>
        </td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$(".unfreeze").click(function(){
		var user=$(this).attr('data');
		var thisdom=$(this);
		$.post('task_business.php?act=unfreeze',{id:user},function(backdata){
			if(backdata==1){
				thisdom.parent().parent().remove();
			}else{
				alert('解冻失败');
			}
		});
	});
	$(".tg").click(function(){
		var user=$(this).attr('data');
		var t=$(this).parent().parent();
		dialog({
			title: '友情提示',
			content: '您确认要通过退保处理吗？',
			fixed: true,
			lock: true,
			ok : function(){
				$.post('task_business.php?act=tg',{"user":user},function(data){
					if(data.state){
						t.remove();
					}else{
						dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {}});
					}
				},'json');
			},
			okValue : '确定',
			cancelValue: '取消',
			cancel: function () { return true;}
		});
	});
	/*.tg 同意退款*/
	/*.utg 不同意退款*/
	$(".utg").click(function(){
		var user=$(this).attr('data');
		var t=$(this).parent().parent();
		var error=prompt("您的拒绝原因:","");
		error=prompts(error);
		if(error){
			$.post('task_business.php?act=utg',{"user":user,"ju":error},function(data){
				if(data.state){
					t.remove();
				}else{
					dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {}});
				}
			},'json');
		}
		function prompts(error){
			if(!error){
				if(confirm("拒绝原因没有填写，是否重新填写？")){
					error=prompt("您的拒绝原因:","");
					error=prompts(error);
					return error;
				}else{
					return error;
				}
			}else{
				return error;
			}
		}
	});
});
</script>
</body>
</html>
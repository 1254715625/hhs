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
<div class="ur_here">首页 &raquo; 任务管理 &raquo;  提现处理</div>
<div class="container">
	<div class="subnav">
		<a href="withdrawals.php">未处理</a>
		<a href="withdrawals.php?show=1">已处理</a>
		<a href="withdrawalset.php">提现设置</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" cellspacing="1" id="listTb">
      <tr>
        <th>会员等级</th>
        <th>提现额度(麦点)</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['rank_name']; ?></td>
        <td class="TXmin"><?php echo $this->_var['item']['TXmin']; ?></td>
        <td><a href="JavaScript:;" style="color:green" data="<?php echo $this->_var['item']['rank_id']; ?>" class="tg">修改</a></td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
<script type="text/javascript">
$(".tg").click(function(){
	var thisdom=$(this);
	var ids=parseInt(thisdom.attr('data'));
	var name=thisdom.parent().parent().children(0).html();
	// alert(thisdom.parent().parent().find(".TXmin").html());
	var content=prompt("您要修改"+name+"的提现限制(积分)为:");
	if(content==""){
		alert("积分数不正确");
	}else if(content!=null&&ids!=0&&content!=thisdom.parent().parent().find(".TXmin").html()){
		if(!parseInt(content)>1){ 
			alert("积分数不正确");
		}else{
			$.post('?act=update',{id:ids,data:content},function(backdata){
				if(backdata==1){
					thisdom.parent().parent().find('.TXmin').html(content);
					alert('修改成功');
				}else{
					alert("修改异常");
				}
			});
		}
	}
});
</script>
</body>
</html>

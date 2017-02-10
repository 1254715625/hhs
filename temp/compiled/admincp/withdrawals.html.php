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
	<div class="btnBox">
		<ul class="clearfix">
			<li class="<?php if($this->_var['opt'] == 'tbbuy'){ ?>current<?php } ?>"><a href="task_manager.php?act=tbbuy">淘宝买号管理</a></li>
			<li class="<?php if($this->_var['opt'] == 'tbsel'){ ?>current<?php } ?>"><a href="task_manager.php?act=tbsel">淘宝掌柜管理</a></li>

			<!--<li class="<?php if($this->_var['opt'] == 'ppbuy'){ ?>current<?php } ?>"><a href="task_manager.php?act=ppbuy">拍拍买号管理</a></li>
			<li class="<?php if($this->_var['opt'] == 'ppsel'){ ?>current<?php } ?>"><a href="task_manager.php?act=ppsel">拍拍掌柜管理</a></li>-->

			<li>
				<select class="bankSearch" name="bankSearch">
					<option value="中国银行">请选择银行</option>
					<option value="中国银行">中国银行</option>
					<option value="建设银行">建设银行</option>
					<option value="工商银行">工商银行</option>
					<option value="招商银行">招商银行</option>
					<option value="浦发银行">浦发银行</option>
				</select>
			</li>
		</ul>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>流水号</th>
        <th>会员名称</th>
        <th>银行账户</th>
        <th>提现银行</th>
        <th>银行卡号</th>
        <th>提现金额</th>
		<th>手机卡号</th>
        <th>申请时间</th>
        <th><?php if($this->_var['state']){ ?>结果<?php }else{ ?>操作<?php } ?></th>
      </tr>
	  <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['oid']; ?></td>
        <td><a href="aboutuser.php?uid=<?php echo $this->_var['item']['uid']; ?>"><?php echo $this->_var['item']['user_name']; ?></a></td>
        <td><?php echo $this->_var['item']['name']; ?></td>
        <td><?php echo $this->_var['item']['bank']; ?></td>
        <td><?php echo $this->_var['item']['bid']; ?></td>
        <td><?php echo $this->_var['item']['user_money']; ?></td>
        <td><?php if($this->_var['item']['is_show'] == 1){ ?><?php echo $this->_var['item']['mobile_phone']; ?> <?php }else{ ?> 没有填写<?php } ?></td>
        <td><?php echo $this->_var['item']['createtime']; ?></td>
		<?php if($this->_var['state']){ ?>
		<td><?php if($this->_var['item']['state'] == 1){ ?>已完成<?php }elseif($this->_var['item']['state'] == 2){ ?><font color="red">未通过:</font><?php echo $this->_var['item']['error']; ?><?php } ?></td>
		<?php }else{ ?>
        <td><a href="JavaScript:;" style="color:green;" data="<?php echo $this->_var['item']['id']; ?>" data_uid="<?php echo $this->_var['item']['uid']; ?>"  data_mobile="<?php if($this->_var['item']['is_show'] == 1){ ?><?php echo $this->_var['item']['mobile_phone']; ?> <?php }else{ ?>0<?php } ?>" class="tg" data_bank="<?php echo $this->_var['item']['bank']; ?>" data_dd="<?php echo $this->_var['item']['bid']; ?>" data_price="<?php echo $this->_var['item']['user_money']; ?>">通过</a>|<a href="JavaScript:;" style="color:red;" class="jj" data="<?php echo $this->_var['item']['id']; ?>">拒绝</a></td>
		<?php } ?>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	//关键词银行搜索
	$(".bankSearch").change(function(){
		var banks = $(this).val();
		window.location.href = "withdrawals.php?banks="+banks;
	})
	$(".tg").click(function(){
		var bank=$(this).attr('data');
		var data_uid=$(this).attr('data_uid');
		var data_bank=$(this).attr('data_bank');
		var data_dd=$(this).attr('data_dd');
		var mobile=$(this).attr('data_mobile');
		var data_price=$(this).attr('data_price');
		var t=$(this).parent().parent();

		art.dialog({
			title: '友情提示',
			content: '您确认要通过提现处理吗？',
			fixed: true,
			lock: true,
			ok : function(){
				$.post('withdrawals.php?act=tg',{"bank":bank,"uid":data_uid,"mobile":mobile,"data_bank":data_bank,"data_dd":data_dd,"data_price":data_price},function(data){
					if(data.state){
						t.remove();
					}else{
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {}});
					}
				},'json');
			},
			okValue : '确定',
			cancelValue: '取消',
			cancel: function () { return true;}
		});
	});
	$(".jj").click(function(){
		var bank=$(this).attr('data');
		var t=$(this).parent().parent();
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
				$.post('withdrawals.php?act=jj',{"bank":bank,"ju":ju},function(data){
					if(data.state){
						t.remove();
					}else{
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () {}});
					}
				},'json');
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

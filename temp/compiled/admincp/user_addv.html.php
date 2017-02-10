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
<style type="text/css">
	.img:hover{cursor:pointer;}
</style>
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo;  加V实名认证</div>
<div class="container">
	<div class="subnav">
		<a href="user_addv.php?see=1">查看结果</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>会员名称</th>
        <th>真实姓名</th>
        <th>身份证号</th>
        <th>身份证正面</th>
        <th>身份证正面</th>
        <th>清晰生活照</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['users'])foreach($this->_var['users'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_name']; ?></td>
        <td><?php echo $this->_var['item']['value']['truname']; ?></td>
        <td><?php echo $this->_var['item']['value']['ident']; ?></td>
        <td>
        	<p class="p-m">
        		<img src="../<?php echo $this->_var['item']['value']['file1']; ?>" width="120" height="100" class="img">
        	</p>
        </td>
        <td>
        	<p class="p-m">
        		<img src="../<?php echo $this->_var['item']['value']['file2']; ?>" width="120" height="100" class="img">
        	</p>
        </td>
        <td>
        	<p class="p-m">
        		<img src="../<?php echo $this->_var['item']['value']['file3']; ?>" width="120" height="100" class="img">
        	</p>
        </td>
        <td>
			<?php if($this->_var['item']['state'] == 1){ ?>
			<font color="green">已通过</font>
			<?php }elseif($this->_var['item']['state'] == 2){ ?>
			<font color="red" title="<?php echo $this->_var['item']['info']; ?>">已拒绝</font>
			<?php }else{ ?>
			<a href="JavaScript:;" style="color:green" data="<?php echo $this->_var['item']['uid']; ?>" class="tg">通过</a>|<a href="JavaScript:;" style="color:red" class="jj" data="<?php echo $this->_var['item']['uid']; ?>">拒绝</a>
			<?php } ?>
		</td>
      </tr>
	  <?php } ?>
    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$("img.img").click(function(){
		var src=$(this).attr('src');
		art.dialog({
			title: '友情提示',
			content: '<img src="'+src+'" style="width:800px;">',
			fixed: true,
			lock: true,
			cancelValue: '关闭',
			cancel: function () { return true;}
		});
	});
	$(".tg").click(function(){
		var user=$(this).attr('data');
		var t=$(this).parent().parent();
		art.dialog({
			title: '友情提示',
			content: '您确认要通过加V实名认证处理吗？',
			fixed: true,
			lock: true,
			ok : function(){
				$.post('user_addv.php?act=tg',{"user":user},function(data){
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
		var user=$(this).attr('data');
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
				$.post('user_addv.php?act=jj',{"user":user,"ju":ju},function(data){
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
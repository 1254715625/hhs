<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css" />
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao.css" />
<!-- <script type="text/javascript" src="themes/default/js/taobao/index.js"></script> -->
<script type="text/javascript">
$(function(){
<?php if($this->_var['_COOKIE'] [ 'safepass' ] != $this->_var['uinfo'] [ 'user_id' ]){ ?>
		var win = art.dialog({title : '请输入安全验证码',
				  content : '<div style="padding: 20px 25px;width:295px"><span style="color:red;padding: 20px 25px;">您需要输入安全操作码才可以继续进行操作。</span><br><br><span style="color:blue">请输入安全码： </span><input type="password" name="safepass"><br><br><br><a href="user.php?act=userinfo&opt=setsafepass" style="color:blue">找回安全码</a></div>',
				  okValue : "确定",
				  ok : function(){
				  			clearInterval(reload);
							$.post('taobao.php',{'safepass':'safepass','pass': $('input[name=safepass]').val()}, function(data){
								 art.dialog({title : '温馨提示',
								  content : data.str,
								  stack : true,
								  okValue : "确定",
								  ok : function(){
										if(data.state){
											location.href="taobao.php";
										}else{
											history.back();
										}
								  },
								  lock : true});
								  return false;
							},'json');
						},
	lock : true});
<?php } ?>
});
</script>
<?php if($this->_var['_COOKIE'] [ 'safepass' ] != $this->_var['uinfo'] [ 'user_id' ]){ ?>
<script>
	var reload=setInterval(function(){
		if($('.d-outer[role=dialog]').parent().css('visibility')=='hidden'){
			setTimeout(function(){
				top.location.href='home.php';
			},1000);
			clearInterval(reload);
			return false;
		}
	},300);
</script>
<?php } ?>
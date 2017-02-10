<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_userdata.css">
<script type="text/javascript" src="themes/default/js/user/artDlaig.js"></script>
<script type="text/javascript" src="themes/default/js/user/<?php echo $this->_var['opt']; ?>.js"></script>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">
	<div id="mid">
		<div id="myDate">
		<div class="bq_menu2">
	<a <?php if($this->_var['opt'] == 'userinfo'){ ?>class="nov"<?php }else{ ?>class="information"<?php } ?>  href="?act=userinfo&opt=userinfo">修改个人资料</a>

	<a <?php if($this->_var['opt'] == 'password'){ ?>class="nov"<?php }else{ ?>class="revLogin"<?php } ?> href="?act=userinfo&opt=password">修改登录密码</a>

	<a <?php if($this->_var['opt'] == 'setsafepass'){ ?>class="nov"<?php }else{ ?>class="safeCode"<?php } ?> href="?act=userinfo&opt=setsafepass">修改安全操作码</a>

	<a <?php if($this->_var['opt'] == 'setquestion'){ ?>class="nov"<?php }else{ ?>class="safeTrouble"<?php } ?> href="?act=userinfo&opt=setquestion">修改密码保护</a>

	<a <?php if($this->_var['opt'] == 'authname'){ ?>class="nov"<?php }else{ ?>class="vident"<?php } ?> href="?act=userinfo&opt=authname">加V实名认证</a>
</div>

		<form name="<?php echo $this->_var['opt']; ?>" action="" method="post" onsubmit="return check();" enctype="multipart/form-data"> 
		<br>
		<?php if($this->_var['opt'] == 'userinfo'){ ?><?php echo $this->fetch("user/userdata/userinfo"); ?><?php } ?>
		<?php if($this->_var['opt'] == 'password'){ ?><?php echo $this->fetch("user/userdata/password"); ?><?php } ?>
		<?php if($this->_var['opt'] == 'setsafepass'){ ?><?php echo $this->fetch("user/userdata/setsafepass"); ?><?php } ?>
		<?php if($this->_var['opt'] == 'setquestion'){ ?><?php echo $this->fetch("user/userdata/setquestion"); ?><?php } ?>
		<?php if($this->_var['opt'] == 'authname'){ ?><?php echo $this->fetch("user/userdata/authname"); ?><?php } ?>
		</form>
		</div>
	</div>
</div>
</div>
<?php echo $this->fetch("common/footer"); ?>
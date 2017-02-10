<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_userdata.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_paydetails.css">
<style type="text/css">
#page a:hover, #page a.now-page {
background: #EAF4FD;
border-color: #B0D0E9;
}
</style>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">
	<div class="paydetails">
	<div class="bq_menu">
		<a class="payde <?php if($this->_var['pay'] == 'payde'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=payde">存款</a>
		<a class="logpoint <?php if($this->_var['pay'] == 'logpoint'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logpoint">刷点</a>
		<a class="logcredit <?php if($this->_var['pay'] == 'logcredit'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logcredit">积分</a>
		<a class="logtask <?php if($this->_var['pay'] == 'logtask'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logtask">任务</a>
		<a class="logtopup <?php if($this->_var['pay'] == 'logtopup'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logtopup">充值</a>
		<a class="logpayment <?php if($this->_var['pay'] == 'logpayment'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logpayment">提现</a>
		<a class="logaccount <?php if($this->_var['pay'] == 'logaccount'){ ?>nov<?php } ?>" href="user.php?act=payde&pay=logaccount">登录</a>			
	</div>
	<div class="cle"></div>
		<?php if($this->_var['pay'] == 'payde'){ ?><?php echo $this->fetch("user/paydetails/payde"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logpoint'){ ?><?php echo $this->fetch("user/paydetails/logpoint"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logcredit'){ ?><?php echo $this->fetch("user/paydetails/logcredit"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logtask'){ ?><?php echo $this->fetch("user/paydetails/logtask"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logtopup'){ ?><?php echo $this->fetch("user/paydetails/logtopup"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logpayment'){ ?><?php echo $this->fetch("user/paydetails/logpayment"); ?><?php } ?>
		<?php if($this->_var['pay'] == 'logaccount'){ ?><?php echo $this->fetch("user/paydetails/logaccount"); ?><?php } ?>
</div>
</div>
<?php echo $this->fetch("common/footer"); ?>

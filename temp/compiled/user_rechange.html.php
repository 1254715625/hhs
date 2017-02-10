<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_message.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_rechange.css">
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">

<div class="rechange">
    <div class="mh_tishi">
		您可以在这里将您接任务赚取的刷点转换成存款哦！每个刷点根据您的平台等级的提高可以换取<span class="chengse2">0.3元-0.35元</span>。<br>
		详细数据请查看"<a class="comlink" target="_blank" href="user.php?act=vip">VIP申请栏目</a>"
	</div>
	<div class="bq_menu2">
		<a id="bq_menu2_1" <?php if($this->_var['Recovery'] == 'maipoint'){ ?>class="nov"<?php } ?> href="user.php?act=rechange&Recovery=maipoint">刷点回收</a>
		<a id="bq_menu2_2" <?php if($this->_var['Recovery'] == 'integral'){ ?>class="nov"<?php } ?> href="user.php?act=rechange&Recovery=integral">积分兑换</a>
	</div>
<form method="post" action="">
<?php if($this->_var['Recovery'] == 'maipoint'){ ?><?php echo $this->fetch("user/rechange/maipoint"); ?><?php } ?>
<?php if($this->_var['Recovery'] == 'integral'){ ?><?php echo $this->fetch("user/rechange/integral"); ?><?php } ?>
</form>
</div>
<?php echo $this->fetch("common/footer"); ?>
<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_message.css">
<script type="text/javascript" src="themes/default/js/user/personal.js"></script>
<script type="text/javascript" src="themes/default/js/user/newDate.js"></script>
<style type="text/css">
#messagedata #page a:hover, #messagedata #page a.now-page {
background: #EAF4FD;
border-color: #B0D0E9;
}
</style>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">

<div id="messagedata">
    <div class="bq_menu">
		<a class="myRest <?php if($this->_var['opt'] == 'myRest'){ ?>nov<?php } ?>"   href="user.php?act=personal&opt=myRest">私人消息<?php if($this->_var['opt'] == 'myRest'){ ?>(<span class="chengse2"><?php echo $this->_var['read']; ?>个</span>)<?php } ?></a>
		<a class="rootRest <?php if($this->_var['opt'] == 'rootRest'){ ?>nov<?php } ?>"   href="user.php?act=personal&opt=rootRest">官方消息<?php if($this->_var['opt'] == 'rootRest'){ ?>(<span class="chengse2">唯一</span>)<?php } ?></a>
		<a class="newDate <?php if($this->_var['opt'] == 'newDate'){ ?>nov<?php } ?>"   href="user.php?act=personal&opt=newDate">发新信息</a>
		<a class="instation <?php if($this->_var['opt'] == 'instation'){ ?>nov<?php } ?>"   href="user.php?act=personal&opt=instation">站内提醒设置</a>
	</div> 	
	<div class="h15"></div>

<?php if($this->_var['opt'] == 'myRest'){ ?><?php echo $this->fetch("user/usepersonal/myRest"); ?><?php } ?>
<?php if($this->_var['opt'] == 'rootRest'){ ?><?php echo $this->fetch("user/usepersonal/rootRest"); ?><?php } ?>
<?php if($this->_var['opt'] == 'newDate'){ ?><?php echo $this->fetch("user/usepersonal/newDate"); ?><?php } ?>
<?php if($this->_var['opt'] == 'instation'){ ?><?php echo $this->fetch("user/usepersonal/instation"); ?><?php } ?>

</div>
<?php echo $this->fetch("common/footer"); ?>

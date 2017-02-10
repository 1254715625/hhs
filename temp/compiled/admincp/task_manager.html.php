<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/css/common.css">
<link rel="stylesheet" type="text/css" href="template/css/main.css">

<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/artDialog.js"></script>
<script type="text/javascript" src="template/js/layer/layer.js"></script>
</head>
<body>
	<div class="ur_here">首页 &raquo; 任务管理 &raquo; 掌柜买号管理</div>
    <div class="container">
		<div class="itemtitle">
			<h3>掌柜买号管理</h3>
		</div>
		<div class="btnBox">
			<ul class="clearfix">
				<li class="<?php if($this->_var['opt'] == 'tbbuy'){ ?>current<?php } ?>"><a href="task_manager.php?act=tbbuy">淘宝买号管理</a></li>
				<li class="<?php if($this->_var['opt'] == 'tbsel'){ ?>current<?php } ?>"><a href="task_manager.php?act=tbsel">淘宝掌柜管理</a></li>

				<!--<li class="<?php if($this->_var['opt'] == 'ppbuy'){ ?>current<?php } ?>"><a href="task_manager.php?act=ppbuy">拍拍买号管理</a></li>
				<li class="<?php if($this->_var['opt'] == 'ppsel'){ ?>current<?php } ?>"><a href="task_manager.php?act=ppsel">拍拍掌柜管理</a></li>-->

			</ul>
		</div>
		<form name="cpform" method="post" autocomplete="off" action="task_manager.php" id="cpform">
			<input type="hidden" name="formhash" value="2fbf31a2">
			<input type="hidden" name="scrolltop" id="formscrolltop" value="">
			<input type="hidden" name="anchor" value="">
			<table width="100%" id="listTb">
			  <tr>
			    <th colspan="9">
			    	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['user_num']; ?></strong>名符合条件的用户
			    </th>
			  </tr>
			  <tr>
			    <th>ID</th>
				<th>昵称</th>
				<th>所属用户</th>
				<th>初始信誉</th>
				<th>当前信誉</th>
				<th>正在进行任务</th>
				<th>已经完成任务</th>
				<th>状态</th>
				<th>操作</th>
			  </tr>
			   <?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
			  <tr>
			    <td><?php echo $this->_var['val']['id']; ?></td>
				<td><?php echo $this->_var['val']['nickname']; ?></td>
				<td><?php echo $this->_var['val']['user_name']; ?></td>
				<td><?php echo $this->_var['val']['attr']['seller_credit']; ?> <?php echo $this->_var['val']['attr']['seller_credit_img']; ?></td>
				<td><?php echo $this->_var['val']['attr']['seller_credit']; ?> <?php echo $this->_var['val']['attr']['seller_credit_img']; ?></td>
				<td><?php echo $this->_var['val']['doing']; ?></td>
				<td><?php echo $this->_var['val']['complete']; ?></td>
				<td><?php echo $this->_var['val']['state']; ?></td>
				<td>
					<?php if($this->_var['val']['is_hang'] == 0){ ?><a href="task_manager.php?action=<?php echo $this->_var['action']; ?>&opt=tbbuy&hang=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要挂起此帐号吗？')">挂起</a>|<?php } ?><?php if($this->_var['val']['is_hang'] == 1){ ?><a href="task_manager.php?action=<?php echo $this->_var['action']; ?>&opt=tbbuy&unhang=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要解挂此帐号吗？')">解挂|</a><?php } ?><?php if($this->_var['val']['is_lock'] == 0){ ?><a href="task_manager.php?action=<?php echo $this->_var['action']; ?>&opt=tbbuy&lock=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要锁定此帐号吗？')">锁定</a>|<?php } ?><?php if($this->_var['val']['is_lock'] == 1){ ?><a href="task_manager.php?action=<?php echo $this->_var['action']; ?>&opt=tbbuy&unlock=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要解锁此帐号吗？')">解锁</a>|<?php } ?><a href="task_manager.php?action=<?php echo $this->_var['action']; ?>&opt=tbbuy&del=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要此此帐号吗？')">删除</a>
				</td>
			  </tr>
			  <?php } ?>
			  <tr>
			    <td colspan="9" class="footer"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
			  </tr>
			</table>
		</form>
	</div>
</body>
</html>
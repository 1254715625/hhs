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
	<div class="ur_here">首页 &raquo; 任务管理 &raquo; 任务管理</div>
	<div class="container">
		<div class="itemtitle">
			<h3>刷钻任务管理</h3>
		</div>
		<form name="cpform" method="post" autocomplete="off" action="task_brushdrill.php" id="cpform">
			<div class="btnBox">
				<ul class="clearfix classfiy">
					<li class="<?php if($this->_var['type'] == 'tb'){ ?>current<?php } ?>">
					  	<a href="task_brushdrill.php?opt=all&type=tb">淘 宝</a>
					</li>

					<!--<li class="<?php if($this->_var['type'] == 'pp'){ ?>current<?php } ?>">
					  	<a href="task_brushdrill.php?opt=all&type=pp">拍 拍</a>
					</li>-->

				</ul>
				<ul class="clearfix">
					<li class="<?php if($this->_var['opt'] == 'all'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=all&type=<?php echo $this->_var['type']; ?>">全部任务</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'wait'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=wait&type=<?php echo $this->_var['type']; ?>">等待接手任务</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'doing'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=doing&type=<?php echo $this->_var['type']; ?>">进行中任务</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'kwait'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=kwait&type=<?php echo $this->_var['type']; ?>">等待快递单号</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'over'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=over&type=<?php echo $this->_var['type']; ?>">已完成任务</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'puse'){ ?>current<?php } ?>">
						<a href="task_brushdrill.php?opt=puse&type=<?php echo $this->_var['type']; ?>">暂停中任务</a>
					</li>
				</ul>
			</div>
			<table width="100%" id="listTb">
			    <tr>
			        <th colspan="9">
			        	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['num']; ?></strong>名符合条件的用户
			        </th>
			    </tr>
			    <tr>
				    <td>任务</td>
					<td>发布人</td>
					<td>接手人</td>
					<td>类型</td>
					<td>商品总价</td>
					<td>发布点</td>
					<td>发布时间</td>
					<td>状态</td>
					<td>操作</td>
			    </tr>
			    <?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
			    <tr>
				    <td><?php echo $this->_var['val']['task']; ?></td>
					<td><?php echo $this->_var['val']['user_name']; ?></td>
					<td><?php echo $this->_var['val']['guser']; ?></td>
					<td><?php echo $this->_var['val']['types']; ?></td>
					<td><?php echo $this->_var['val']['goods_price']; ?></td>
					<td><?php echo $this->_var['val']['total_points']; ?></td>
					<td><?php echo $this->_var['val']['addtime']; ?></td>
					<td><?php echo $this->_var['val']['states']; ?></td>
					<td>
						<a href="javascript:;" onclick="return confirm('您确定要挂起此帐号吗？')">挂起</a>|<a href="javascript:;" onclick="return confirm('您确定要锁定此帐号吗？')">锁定</a>
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
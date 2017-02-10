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
	<div class="ur_here">首页 &raquo; 任务管理 &raquo; 任务纠纷处理</div>
	<div class="container">
		<div class="itemtitle">
			<h3>任务纠纷处理</h3>
		</div>
		<form name="cpform" method="post" autocomplete="off" action="task_appeal.php" id="cpform">
			<div class="btnBox">
				<ul class="clearfix">
					<li class="<?php if($this->_var['opt'] == 'tbbuy'){ ?>current<?php } ?>">
						<a href="task_appeal.php?opt=tbbuy">淘宝接手申诉管理</a>
					</li>
					<!--<li class="<?php if($this->_var['opt'] == 'tbsel'){ ?>current<?php } ?>">
						<a href="task_appeal.php?opt=tbsel">淘宝发布方申诉管理</a>
					</li>-->


					<!-- <li class="<?php if($this->_var['opt'] == 'ppbuy'){ ?>current<?php } ?>">
						<a href="task_appeal.php?opt=ppbuy">拍拍接手方申诉管理</a>
					</li>
					<li class="<?php if($this->_var['opt'] == 'ppsel'){ ?>current<?php } ?>">
						<a href="task_appeal.php?opt=ppsel">拍拍发布方申诉管理</a>
					</li> -->
				</ul>
			</div>
			<table width="100%" id="listTb">
				<tr>
				    <th colspan="7">
				    	共搜索到<strong style="padding:0 3px;color:#f30;"><?php echo $this->_var['num']; ?></strong>名符合条件的申诉
				    </th>
				</tr>
				<tr>
					<td>任务ID</td>
					<td>申诉人</td>
					<td>被申诉人</td>
					<td>任务状态</td>
					<td style="width:330px;">申诉内容</td>
					<td>发起时间</td>
					<td>操作</td>
				</tr>
				<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
				<tr>
				    <td><?php echo $this->_var['val']['task']; ?></td>
					<td><?php echo $this->_var['val']['user']; ?></td>
					<td><?php echo $this->_var['val']['aser']; ?></td>
					<?php if($this->_var['val']['state'] == 0){ ?>
							<td>未操作</td> 
						<?php }elseif($this->_var['val']['state'] == 1){ ?>
							<td>扣积分或刷点</td>
						<?php }elseif($this->_var['val']['state'] == 2){ ?>
							<td>撤销</td>
					<?php } ?>
					<td><?php echo $this->_var['val']['info']; ?></td>
					<td><?php echo $this->_var['val']['add_time']; ?></td>
					<td>
						<?php if($this->_var['val']['state'] == 0){ ?>
							<a href="task_mediation.php?id=<?php echo $this->_var['val']['id']; ?>">调解</a>
						<?php }elseif($this->_var['val']['state'] == 1){ ?>
							<a href="task_mediation.php?id=<?php echo $this->_var['val']['id']; ?>">查看</a>
						<?php }elseif($this->_var['val']['state'] == 2){ ?>
							<a href="task_mediation.php?id=<?php echo $this->_var['val']['id']; ?>">查看</a>
						<?php } ?>
						
					</td>
				  </tr>
				  <?php } ?>
				  <tr>
				    <td colspan="7" class="footer"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
				  </tr>
			</table>
		</form>
	</div>
</body>
</html>
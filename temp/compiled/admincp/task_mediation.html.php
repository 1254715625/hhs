<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>


<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<!-- <script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="../themes/default/css/user_complain.css"> -->
<style type="text/css">
/*ul{margin:0;padding:0;list-style-type:none;}*/
</style>
</head>
<body>
<!-- <form method="post" action="task_mediation.php">
	<div style="width:80%;margin-left:20px;">
		<div class="sllb" style="margin:0;font-size: 13px;">
	        <p class="sp">
	        	<strong>任 务 ID：</strong>
			    <span class="hongse rwid"><?php echo $this->_var['info']['task']; ?></span>
			    <input type="hidden" name="id" value="<?php echo $this->_var['id']; ?>">
			    <input type="hidden" name="task_uid" value="<?php echo $this->_var['info']['task_uid']; ?>">
	        </p>
	        <p class="sp">
	        	<strong>任务状态：</strong> 
				<span class="lanse">
					<?php if($this->_var['info']['process'] == 0){ ?>等待接手方付款<?php } ?>
					<?php if($this->_var['info']['process'] == 1){ ?>接手方已付款，等待发布方发货<?php } ?>
					<?php if($this->_var['info']['process'] == 2){ ?>发布方已发货，等待接手方好评<?php } ?>
					<?php if($this->_var['info']['process'] == 3){ ?>接手方已确认，等待发布方核实<?php } ?>
					<?php if($this->_var['info']['process'] == 4){ ?>任务已完成<?php } ?>
				</span>
	        </p>
			<p class="sp">
				<strong>申诉内容：</strong>
				<?php echo $this->_var['info']['info']; ?>
			</p>
			<p class="sp">
				<strong>对方 QQ：</strong>
				<?php echo $this->_var['info']['qq']; ?>
			</p>
			<ul class="tcss_hk">
				<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['val']){ ?>
				<li>
					<strong>
						 <?php echo $this->_var['val']['user']; ?>
						<i><?php echo $this->_var['val']['add_time']; ?></i>
					</strong>
					<p><?php echo $this->_var['val']['content']; ?></p>
				</li>
				<?php } ?>
				<li>
					<strong>
						<?php echo $this->_var['info']['user']; ?>(申诉方)
						<i><?php echo $this->_var['info']['add_time']; ?></i>
					</strong>
					<?php echo $this->_var['info']['content']; ?>
				</li>
			</ul>
	        <p style="clear: both;"></p>  

			<p class="pdjg">
				<?php if($this->_var['info']['state'] > 0){ ?>判定结果：<?php echo $this->_var['info']['over']; ?>
				<?php }else{ ?>
				处理选项：
				<select name="handle" id="handle" class='apple'>
					<option value="3" >撤销申诉</option>
					<option value="1" <?php if($this->_var['info']['rank_points'] == 0){ ?>disabled<?php } ?>>举报成功,扣积分</option>
					<option value="2" <?php if($this->_var['info']['pay_money'] == 0){ ?>disabled<?php } ?>>举报成功,扣刷点</option>
					<option value="4" >胡乱举报</option>
				</select>
				<input type="text" name="num" value="" placeholder="扣除数额" id="num" style="width:60px;">(该用户还有<?php echo $this->_var['info']['upay_money']; ?>刷点，<?php echo $this->_var['info']['urank_points']; ?>积分)
				<br>
				判定结果：
				<textarea name="over" id="mycomp" style="width:480px;height:140px;"></textarea>
				<input type="submit" id="mysubmit">
				<?php } ?>
			</p>
			<input type='hidden' class='mobile_phone' value='<?php echo $this->_var['mobile_phone']; ?>'>
			<input type='hidden' class='dingdan_id' value='<?php echo $this->_var['info']['task']; ?>'>
		</div>
	</div>
</form> -->



<div class="ur_here">首页 &raquo; 任务管理 &raquo; 任务申诉处理</div>
<div class="container">
	<div class="subnav">
		<a href="task_appeal.php">返回列表</a>
	</div>
    <form method="post" action="task_mediation.php">
	    <input type='hidden' class='mobile_phone' value='<?php echo $this->_var['mobile_phone']; ?>'>
		<input type='hidden' class='dingdan_id' value='<?php echo $this->_var['info']['task']; ?>'>
	    <table width="100%" id="editTb">
	        <tr>
	            <th colspan="2">任务申诉处理</th>
	        </tr>
	        <tr>
	            <td class="left">任务ID</td>
	            <td>
	          	    <span style="color:#f30;"><?php echo $this->_var['info']['task']; ?></span>
			        <input type="hidden" name="id" value="<?php echo $this->_var['id']; ?>">
			        <input type="hidden" name="task_uid" value="<?php echo $this->_var['info']['task_uid']; ?>">
	            </td>
	        </tr>
	        <tr>
	            <td class="left">任务状态</td>
	            <td>
	          	    <span style="color:#1996e6;">
	          	    <?php if($this->_var['info']['process'] == 0){ ?>等待接手方付款<?php } ?>
					<?php if($this->_var['info']['process'] == 1){ ?>接手方已付款，等待发布方发货<?php } ?>
					<?php if($this->_var['info']['process'] == 2){ ?>发布方已发货，等待接手方好评<?php } ?>
					<?php if($this->_var['info']['process'] == 3){ ?>接手方已确认，等待发布方核实<?php } ?>
					<?php if($this->_var['info']['process'] == 4){ ?>任务已完成<?php } ?>
					</span>
	            </td>
	        </tr>
	  	    <tr>
	            <td class="left">申诉内容</td>
	            <td><?php echo $this->_var['info']['info']; ?></td>
	        </tr>
	        <tr>
	            <td class="left">对方QQ</td>
	            <td><?php echo $this->_var['info']['qq']; ?></td>
	        </tr>
	        <tr>
	            <td class="left">申诉处理</td>
	            <td>
	            	<?php if($this->_var['info']['state'] > 0){ ?>判定结果：<?php echo $this->_var['info']['over']; ?>
					<?php }else{ ?>
					处理选项：
					<select name="handle" id="handle" class='apple' style="width:auto;">
						<option value="3" >撤销申诉</option>
						<option value="1" <?php if($this->_var['info']['rank_points'] == 0){ ?>disabled<?php } ?>>举报成功,扣积分</option>
						<option value="2" <?php if($this->_var['info']['pay_money'] == 0){ ?>disabled<?php } ?>>举报成功,扣刷点</option>
						<option value="4" >胡乱举报</option>
					</select>
					<input type="text" name="num" value="" placeholder="扣除数额" id="num" style="width:60px;">(该用户还有<?php echo $this->_var['info']['upay_money']; ?>刷点，<?php echo $this->_var['info']['urank_points']; ?>积分)
					
					<p>
						判定结果：<textarea name="over" id="mycomp" style="width:480px;height:140px;"></textarea>
					</p>
					
	            	<?php } ?>
	            </td>
	        </tr>
	        <tr>
	          <td colspan="2" class="footer">
	      			<input type="submit" class="submit" id="mysubmit" value="提交" />
	      		</td>
	        </tr>
	    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	var opval = "撤销申诉";
	$('.apple').change(function(){
		var options = $(this).find("option");
		for(var i=0; i<options.length; i++){
			if($(options[i]).is(":selected")){
				opval=$(options[i]).html();
			}
		}
	})
	$('form').submit(function(){
	
		var money=<?php echo $this->_var['info']['upay_money']; ?>;
		var rank_points=<?php echo $this->_var['info']['urank_points']; ?>;
		var handle=$("#handle option:selected").val();
		var num=$("#num").val();
		var mycomp=$("#mycomp").val();

		if(mycomp==''){alert('请填写判定结果');return false;}
		if(handle==1){if(num>rank_points){alert('积分不足');return false;}}
		if(handle==2){if(num>money){alert('刷点不足');return false;}}
		
		var mobile_phone=$('.mobile_phone').val();
		var dingdan_id=$('.dingdan_id').val();
		var apple_id=$(this).val();
		
		if(handle == 1){ //扣积分
			$.get('http://hhs.lianmon.com/plugins.php',{type:143791,dingdan_id:dingdan_id,mobile:mobile_phone,jf:num});
		}else if(handle == 2){ //扣刷点
			$.get('http://hhs.lianmon.com/plugins.php',{type:143793,dingdan_id:dingdan_id,mobile:mobile_phone,sd:num});
		}
		$.get('http://hhs.lianmon.com/plugins.php',{type:143786,dingdan_id:dingdan_id,mobile:mobile_phone,result:opval});

	});
});
</script>
</body>
</html>
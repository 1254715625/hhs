<div style=""><div class="sllb" style="">
<p class="sp"><strong>任 务 ID：</strong>
	
	<span class="hongse rwid"><?php echo $this->_var['info']['task']; ?></span>
	
</p>
<p class="sp"><strong>任务状态：</strong>
	
	<span class="lanse">
		
		<?php if($this->_var['info']['process'] == 0){ ?>等待接手方付款<?php } ?>
		<?php if($this->_var['info']['process'] == 1){ ?>接手方已付款，等待发布方发货<?php } ?>
		<?php if($this->_var['info']['process'] == 2){ ?>发布方已发货，等待接手方好评<?php } ?>
		<?php if($this->_var['info']['process'] == 3){ ?>接手方已确认，等待发布方核实<?php } ?>
		
	</span>
	
</p>
<p class="sp"><strong>申诉内容：</strong><?php echo $this->_var['info']['info']; ?></p>
<p class="sp"><strong>对方 QQ：</strong><?php echo $this->_var['info']['qq']; ?></p>
<p class="tishi">相互理解，和气生财</p>
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
<?php if($this->_var['info']['state'] == 1){ ?>
<p class="pdjg">
判定结果：<?php echo $this->_var['info']['over']; ?>
</p>
<?php }else{ ?>
<input type="hidden" id="mycomp" value="">
<iframe src="user.php?act=complaint&opt=see" width="100%" frameborder='0' scrolling='no' height="170px" name="con"></iframe>
<?php } ?>
</div></div>
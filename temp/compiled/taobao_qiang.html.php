<div class="chooseBuyer"><div id="task-tips-title"><span class="black font-18">此任务要求</span><span class="orange">（鼠标一到相应图标显示描述）</span></div>
<div class="tips-ico" >
<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['vals']){ ?>
  <?php if($this->_var['vals']['cbhp'] > 1){ ?><em title="对多个商品分开评价" class="hico limit2 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsAudit'] == 1){ ?><em title="接任务者需要发布者核审" class="hico limit3 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsWW'] == 1){ ?><em title="任务需要旺旺模拟咨询再拍下" class="hico limit4 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsLHS'] == 1){ ?><em title="任务需要模拟聊天后确认收货" class="hico limit5 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsMsg'] == 1){ ?> <em title="按发布者提供的评语进行评价" class="hico limit6 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsAddress'] == 1){ ?><em title="任务需要指定收货地址" class="hico limit7 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['pinimage'] == 1){ ?><em title="接任务者需要上传好评图片" class="hico limit8 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['isShare'] == 1){ ?><em title="好评后对宝贝进行分享" class="hico limit9 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['isReal'] == 1){ ?><em title="接手买号必须通过了支付宝实名认证" class="hico limit10 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsTaoG'] == 1){ ?><em title="需要淘金币:<?php echo $this->_var['vals']['attrs']['txtTaoG']; ?>个" class="hico limit11 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['isLimitCity'] == 1){ ?><em title="要求接手方地址是<?php echo $this->_var['vals']['attrs']['Province']; ?>" class="hico limit13 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['cbxIsWX'] == 1){ ?><em title="接任务者需要通过手机、pad等智能设备的app进行旺旺购买前聊天" class="hico limit30 lopt">&nbsp;</em>&nbsp;<?php } ?>
	
	<?php if($this->_var['vals']['attrs']['shopBrGoods'] == 1){ ?><em title="接任务者需要额外浏览商品，额外0.3~0.9个刷点" class="hnews limit25 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['stopDsTime'] == 1){ ?><em title="购买前需停留1~5分钟，接手后可查看，额外0.1~0.5个刷点" class="hnews limit26 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要上传商品底部截图，额外0.3个刷点" class="hnews limit27 lopt">&nbsp;</em>&nbsp;<?php } ?>
	<?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要根据提示进行货比截图，额外0.5~1.5个刷点" class="hnews limit28 lopt">&nbsp;</em>&nbsp;<?php } ?>

	<?php if($this->_var['vals']['attrs']['shopcoller'] == 1){ ?><em title="接任务者需要收藏该商品，收藏后提交收藏成功截图" class="hico limit31 lopt">&nbsp;</em>&nbsp;<?php } ?>
<?php } ?>
</div>

<div class="tdOpenTrueNameBa" val="0" onclick="tdopen(0);">
	<span>
	<img src="themes/default/images/taobao/hidden.gif" style="margin-top:2px;">普通买号（可用<?php echo $this->_var['con_mai']; ?>个，点击查看）
	</span>
</div>
<ul class="true-name-0" style="display: block;">
<?php if($this->_var['mai'])foreach($this->_var['mai'] as $this->_var['key'] => $this->_var['val']){ ?>
	<li>
		<label class="orange bname"><input type="radio" value="<?php echo $this->_var['val']['id']; ?>" name="buyer" <?php if($this->_var['key'] == 0){ ?>checked<?php } ?>><?php echo $this->_var['val']['nickname']; ?></label>
		<span>(淘宝信用：<?php echo $this->_var['val']['buyer_credit']; ?>,本周已接：<?php echo $this->_var['val']['week']; ?>,今日已接：<?php echo $this->_var['val']['today']; ?>)</span>
		
	</li>
<?php } ?>
</ul>

<div class="tdOpenTrueNameBa" val="1" onclick="tdopen(1);">
	<span>
	<img src="themes/default/images/taobao/show.png" style="margin-top:2px;">实名买号（可用<?php echo $this->_var['con_mais']; ?>个，点击查看）
	</span>
</div>
<ul class="true-name-1" style="display: none;">
	<?php if($this->_var['mais'])foreach($this->_var['mais'] as $this->_var['key'] => $this->_var['val']){ ?>
	<li>
		<label class="orange bname"><input type="radio" value="<?php echo $this->_var['val']['id']; ?>" name="buyer"><?php echo $this->_var['val']['nickname']; ?></label>
		<span>(淘宝信用：<?php echo $this->_var['val']['buyer_credit']; ?>,本周已接：<?php echo $this->_var['val']['week']; ?>,今日已接：<?php echo $this->_var['val']['today']; ?>)</span>
		
	</li>
 <?php } ?>

</ul>
</div>
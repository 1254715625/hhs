<div id="footer">
	<p>
		<span class="chengse">官方QQ群：<?php if($this->_var['cfg']['group_qq'])foreach($this->_var['cfg']['group_qq'] as $this->_var['item']){ ?><a style="color:#FE5500;" target="_blank" href="javascript:;"><?php echo $this->_var['item']; ?></a><?php } ?></span>
		（加群请注明好会刷）</p>
	<p class="lanse">
	<?php if($this->_var['links'])foreach($this->_var['links'] as $this->_var['key'] => $this->_var['val']){ ?>
		<?php if($this->_var['key'] > 0){ ?>|<?php } ?><a href="<?php echo $this->_var['val']['link']; ?>" target="_blank"><?php echo $this->_var['val']['name']; ?></a>
	<?php } ?>
	</p>
	 <p class="lanse"><?php echo $this->_var['cfg']['site_foot']; ?></p>
	 <a href="https://m.kuaidi100.com/" target="_blank">快递查询</a>
</div>
<script type="text/javascript" src="themes/default/js/jquery.JPlaceholder.js"></script>
</body>
</html>
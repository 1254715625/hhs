<div style="overflow-x: hidden;overflow-y:hidden;" id="count">
<ul id="dialogues">
<?php if($this->_var['info'])foreach($this->_var['info'] as $this->_var['key'] => $this->_var['val']){ ?>
	<li>
		<div class="<?php echo $this->_var['val']['class']; ?>">
			<span><?php echo $this->_var['val']['name']; ?></span>
			<i><?php echo $this->_var['val']['gettime']; ?></i>
			<p><?php echo $this->_var['val']['content']; ?></p>
		</div>
	</li>
<?php } ?>
<div id="page"><?php echo $this->_var['pagestr']; ?></div>
</ul>
</div>
<script type="text/javascript">
$(function(){
	var count=<?php echo $this->_var['count']; ?>;
	if(count>6){
		count=6;
	}
	$("#count").height(count*60);
});
</script>
<div class="tico menu">
	<a <?php if($this->_var['mod'] == 'addTask'){ ?>class="nov"<?php } ?> title="单个任务商品" href="?mod=addTask">单个任务商品</a>
	<a <?php if($this->_var['mod'] == 'lailuTask'){ ?>class="nov"<?php } ?> title="来路任务" href="?mod=lailuTask">来路任务</a>
	<a <?php if($this->_var['mod'] == 'mealTask'){ ?>class="nov"<?php } ?> title="套餐任务" href="?mod=mealTask">套餐任务</a>
	<a <?php if($this->_var['mod'] == 'weixinTask'){ ?>class="nov"<?php } ?> title="微信投票任务" href="?mod=weixinaddTask">微信投票任务</a>
	<a <?php if($this->_var['mod'] == 'shopTask'){ ?>class="nov"<?php } ?> title="购物车任务" href="?mod=shopTask">购物车任务</a>
	<!-- <a <?php if($this->_var['mod'] == 'searchTask'){ ?>class="nov"<?php } ?> title="搜索任务" href="?mod=searchTask">搜索任务</a> -->
	<a <?php if($this->_var['mod'] == 'taskTemplate'){ ?>class="nov"<?php } ?> title="任务模版" href="?mod=taskTemplate">任务模版</a>
	<a <?php if($this->_var['mod'] == 'outTask'){ ?>class="nov"<?php } ?> title="已发任务" href="?mod=outTask">已发任务</a>
</div>
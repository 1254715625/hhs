<p style="height:92px;margin-top: 10px;">
    	<a href="help.php?act=guide" target="_blank"><img src="themes/default/images/DM_2293137b.jpg" alt="防骗常识" title="防骗常识" width="245" height="92"></a>
    </p>
    <h4 class="luntan_zt">最近发表</h4>
    <ul class="luntan_rmbk">
		<?php if($this->_var['recently'])foreach($this->_var['recently'] as $this->_var['key'] => $this->_var['item']){ ?>
		<li><a href="bbs.php?act=view&id=<?php echo $this->_var['item']['id']; ?>" target="_blank" title="请教"><?php echo $this->_var['item']['title']; ?></a></li>
		<?php } ?>
	</ul>
    <img src="themes/default/images/wsxs_img.jpg" border="0" usemap="#Map" style="margin-top:10px;">
    <map name="Map" id="Map">
      <area shape="rect" coords="19,145,105,177" href="help.php">
    </map>
    <h4 class="luntan_zt">精华主题</h4>
    <ul class="luntan_rmbk">
		<?php if($this->_var['essence'])foreach($this->_var['essence'] as $this->_var['key'] => $this->_var['item']){ ?>
		<li><a href="bbs.php?act=view&id=<?php echo $this->_var['item']['id']; ?>" target="_blank" title="请教"><?php echo $this->_var['item']['title']; ?></a></li>
		<?php } ?>
	</ul>
    <img src="themes/default/images/wsxdz_img.jpg" border="0" usemap="#Map2" style="margin-top:10px;">
    <map name="Map2" id="Map2">
      <area shape="rect" coords="18,156,104,187" href="home.php?act=tuoguan">
    </map>
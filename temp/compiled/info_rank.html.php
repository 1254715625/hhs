<?php echo $this->fetch("common/header"); ?>
<style>
#wrap { margin: 0 auto;width: 1000px;}
.phb_fd { float: left;margin: 0 3px;}
.chengse2 { color: #EB0F0F;}
.imagstr{ background: url(themes/default/images/info/rank_3.gif) no-repeat;}
.phb_t1 { background: url(themes/default/images/info/rank_2.gif) no-repeat;color: #333333;font-size: 14px;font-weight: bold;text-indent: 20px;}
.phb_ht { height: 418px;}
.phb_t2 { border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;margin: 0 auto;padding: 0 10px;width: 299px;}
.phb_sx { border-bottom: 1px solid #DDDDDD;font-weight: bold;height: 37px;line-height: 37px;padding-left: 25px;}
.phb_md, .phb_md1 { float: right;margin: 0 15px 0 0;}
.phb_md1 { margin: 0 35px 0 0;}
.phb_name { border-bottom: 1px dotted #DDDDDD;clear: both;height: 37px;line-height: 37px;padding-left: 10px;}
.phb_nameico1{ background-position:0 -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_t3 { background:url(themes/default/images/info/rank_2.gif) no-repeat 0 -63px;height: 10px;}
.phb_nameico1{ background-position:0 -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico2{ background-position:-22px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico3{ background-position:-44px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico4{ background-position:-66px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico5{ background-position:-88px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico6{ background-position:-110px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico7{ background-position:-132px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico8{ background-position:-154px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico9{ background-position:-176px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
.phb_nameico10{ background-position:-198px -44px;display: block;float: left;height: 31px;margin: 3px 8px 0 0;width: 22px;}
</style>
<div id="wrap">
	<div style="margin:20px 0 10px 0;"><img src="themes/default/images/info/rank_1.jpg"></div>
	 
	<table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
		<tbody><tr><td height="41" class="phb_t1">金额消费排行榜</td></tr>
      	<tr>
	        <td>
				<ul class="phb_t2 phb_ht">
					<li class="phb_sx">用户名<span class="phb_md">消费金额</span></li>
						<?php if($this->_var['ranks']['money']['0']['user_name']){ ?>
						<?php if($this->_var['ranks']['money'])foreach($this->_var['ranks']['money'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico<?php echo $this->_var['key']+1;?> imagstr"></span>
							<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							<span class="phb_md chengse2"><?php echo $this->_var['v']['money']; ?>元</span>
						</li>
						<?php } ?>
						<?php } ?>
				</ul>
			</td>
      	</tr>
     	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
    
    <table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
    	<tbody><tr><td height="41" class="phb_t1">发布任务周排行榜</td></tr>
     	 <tr>
        	<td>
        		<ul class="phb_t2 phb_ht">
          			<li class="phb_sx">用户名<span class="phb_md">发布任务</span></li>
						<?php if($this->_var['ranks']['out']['0']['user_name']){ ?>
						<?php if($this->_var['ranks']['out'])foreach($this->_var['ranks']['out'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico<?php echo $this->_var['key']+1;?> imagstr"></span>
							<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							<span class="phb_md chengse2"><?php echo $this->_var['v']['num']; ?>个</span>
						</li>
						<?php } ?>
						<?php } ?>
						</ul>
			</td>
      	</tr>
      	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
    
    <table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
    	<tbody><tr><td height="41" class="phb_t1">接手任务周排行榜</td></tr>
     	 <tr>
        	<td>
        		<ul class="phb_t2 phb_ht">
					<li class="phb_sx">用户名<span class="phb_md">接手任务</span></li>
						<?php if($this->_var['ranks']['in']['0']['user_name']){ ?>
						<?php if($this->_var['ranks']['in'])foreach($this->_var['ranks']['in'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico<?php echo $this->_var['key']+1;?> imagstr"></span>
							<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							<span class="phb_md chengse2"><?php echo $this->_var['v']['num']; ?>个</span>
						</li>
						<?php } ?>
						<?php } ?>
				</ul>
			</td>
      	</tr>
      	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
    
    <table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
    	<tbody><tr><td height="41" class="phb_t1">本月推广收益排行榜</td></tr>
     	 <tr>
        	<td>
        		<ul class="phb_t2 phb_ht">
					<li class="phb_sx">用户名<span class="phb_md">预计收益</span><span class="phb_md1">推广人数</span></li>
					<?php if($this->_var['line'])foreach($this->_var['line'] as $this->_var['key'] => $this->_var['v']){ ?>
					<li class="phb_name">
						<span class="phb_nameico<?php echo $this->_var['v']['key']; ?> imagstr"></span>
						<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
						<span class="phb_md chengse2"><?php echo $this->_var['v']['money']; ?>元</span>
						<span class="phb_md1 chengse2"><?php echo $this->_var['v']['num']; ?></span>
					</li>
					<?php } ?>
				</ul>
			</td>
      	</tr>
      	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
    
    <table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
    	<tbody><tr><td height="41" class="phb_t1">推广收益总排行榜</td></tr>
     	 <tr>
        	<td>
        		<ul class="phb_t2 phb_ht">
					<li class="phb_sx">用户名<span class="phb_md">预计收益</span><span class="phb_md1">推广人数</span></li>
					<?php if($this->_var['lines'])foreach($this->_var['lines'] as $this->_var['key'] => $this->_var['v']){ ?>
					<li class="phb_name">
						<span class="phb_nameico<?php echo $this->_var['v']['key']; ?> imagstr"></span>
						<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
						<span class="phb_md chengse2"><?php echo $this->_var['v']['money']; ?>元</span>
						<span class="phb_md1 chengse2"><?php echo $this->_var['v']['num']; ?></span>
					</li>
					<?php } ?>
				</ul>
			</td>
      	</tr>
      	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
     
    <table width="325" cellspacing="0" cellpadding="0" border="0" class="phb_fd">
    	<tbody><tr><td height="41" class="phb_t1">积分总排行榜</td></tr>
     	 <tr>
        	<td>
				<ul class="phb_t2 phb_ht">
					<li class="phb_sx">用户名<span class="phb_md">积分</span></li>
						<?php if($this->_var['ranks']['points']['0']['user_name']){ ?>
						<?php if($this->_var['ranks']['points'])foreach($this->_var['ranks']['points'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico<?php echo $this->_var['key']+1;?> imagstr"></span>
							<a href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							<span class="phb_md chengse2"><?php echo $this->_var['v']['rank_points']; ?>分</span>
						</li>
						<?php } ?>
						<?php } ?>
				</ul>
			</td>
      	</tr>
      	<tr><td height="10" class="phb_t3">&nbsp;</td></tr>
    </tbody></table>
</div>
<?php echo $this->fetch("common/footer"); ?>
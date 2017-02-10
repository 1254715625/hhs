<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/thread.css">

<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right">

<div id="threaddate">
    <div class="bq_menu">
		<a class="theme <?php if($this->_var['thread'] == 'theme'){ ?>nov<?php } ?>" href="user.php?act=thread&thread=theme">我的主题</a>
		<a class="reply <?php if($this->_var['thread'] == 'reply'){ ?>nov<?php } ?>" href="user.php?act=thread&thread=reply">我的回复</a>
		<a class="collection <?php if($this->_var['thread'] == 'collection'){ ?>nov<?php } ?>" href="user.php?act=thread&thread=collection">我的收藏</a>
	</div>
		
    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
        <tbody><tr>
            <td height="15">&nbsp;</td>
        </tr>
        <tr>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              		<tbody><tr>
		                <td width="10" height="37" class="txjl_bg1"></td>
		                <td width="<?php if($this->_var['thread'] == 'collection'){ ?>5<?php }else{ ?>7<?php } ?>8%" align="left" class="txjl_bg2">&nbsp; 标题</td>
		                <td width="20%" align="center" class="txjl_bg2">时间</td>
						<?php if($this->_var['thread'] == 'collection'){ ?>
		                <td width="20%" align="center" class="txjl_bg2">操作</td>
						<?php } ?>
		                <td width="10" height="37" class="txjl_bg3"></td>
             		</tr>
             		<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
			  		<tr class="end">
		                <td height="35">&nbsp;</td>
		                <td align="left" class="mh_xxian">&nbsp; <a target="_blank" class="lttz_sj" href="bbs.php?act=view&id=<?php echo $this->_var['val']['id']; ?>"><?php echo $this->_var['val']['title']; ?></a></td>
		                <td align="center" class="mh_xxian"><?php echo $this->_var['val']['add_time']; ?></td>
						<?php if($this->_var['thread'] == 'collection'){ ?>
						<td class="mh_xxian" align="center">
							<a class="lttz_sj cd" data="<?php echo $this->_var['val']['did']; ?>" href="javascript:;">删除</a>
						</td>
						<?php } ?>
		                <td>&nbsp;</td>
              		</tr>
					<?php } ?>
			 	</tbody></table>
			</td>
    	</tr>
 	</tbody></table>
</div>
</div>
</div>
<?php if($this->_var['thread'] == 'collection'){ ?>
<script type="text/javascript">
$(function(){
	$(".cd").click(function(){
		var self=$(this);
		var form=self.attr('data');
		if(form){
			$.post('user.php?act=thread&thread=collection',{'id':form},function(data){
				if(data==form){
					self.parents('tr.end').remove();
				}
			});
		}
	});
});
</script>
<?php } ?>
<?php echo $this->fetch("common/footer"); ?>
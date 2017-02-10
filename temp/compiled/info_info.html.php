<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/userdatum.css">
<div id="userdatum">
			
		<?php if($this->_var['info']['user_id']){ ?>
		<ul id="u_info">
			<li class="tx"><img width="87" height="87" src="themes/default/images/user/headimg/<?php if($this->_var['info']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['info']['headimg']; ?><?php } ?>"></li>
			<li class="name"><?php echo $this->_var['info']['user_name']; ?>
			<?php if($this->_var['info']['realname']){ ?><span style="margin:9px 5px 0 0px;background: url(themes/default/images/taobao/verify.png) no-repeat;float: left;width: 18px;height: 18px;" title="通过V实名认证用户"></span><?php } ?>
			</li>
			<li name=""><?php if($this->_var['info']['sex']){ ?>女<?php }else{ ?>男<?php } ?><img src="themes/default/images/ico/level/b_red_1.gif" style="margin-left: 30px;" title="积分:"><span class="jf_ico"> <?php echo $this->_var['info']['rank_points']; ?>值 经验越高,信誉越高</span></li>
			<li class="pj"><span class="hp"><?php echo $this->_var['type']['1']; ?></span><span class="zp"><?php echo $this->_var['type']['2']; ?></span><span class="cp"><?php echo $this->_var['type']['3']; ?></span></li>
			<li class="jj">好评率：<span class="chengse"><?php echo $this->_var['haoping']; ?></span></li>
			<li class="jj">注册时间：<span class="time"><?php echo $this->_var['info']['add_time']; ?></span></li>
			<li class="jj">已被<?php echo $this->_var['info']['black']; ?>人加入黑名单啦！<a class="jh_btn" href="user.php?act=black" target="_blank"></a></li>
		</ul>
		
		<ul id="lt_info">
			<?php if($this->_var['hot_bbs'])foreach($this->_var['hot_bbs'] as $this->_var['key'] => $this->_var['v']){ ?>
			<li><a title="·<?php echo $this->_var['v']['title']; ?>" target="_blank" href="bbs.php?act=view&id=<?php echo $this->_var['v']['id']; ?>">·<?php echo $this->_var['v']['title']; ?></a><span class="date"><?php echo $this->_var['v']['add_time']; ?></span></li>
			<?php } ?>
		</ul>
		<div class="cle"></div>
		
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
	        <tbody><tr class="u_tit">
	            <td width="10" class="u_hr u_left">&nbsp;</td>
	            <td width="20%" class="u_hr">评论用户</td>
	            <td width="20%" class="u_hr">被评论用户</td>
	            <td width="25%" class="u_hr">评论内容</td>
	            <td width="20%" class="u_hr">提交时间</td>
	            <td class="u_hr">状态</td>
	            <td width="10" class="u_right">&nbsp;</td>
	        </tr>
	        	<?php if($this->_var['comm']['record'])foreach($this->_var['comm']['record'] as $this->_var['key'] => $this->_var['v']){ ?>
		        <tr>
		            <td>&nbsp;</td>
		            <td class="x_xian"><a class="lanse" target="_blank"><?php echo $this->_var['v']['user_name']; ?>(匿名)（接手者打分）</a></td>
		            <td class="x_xian"><?php echo $this->_var['info']['user_name']; ?></td>
		            <td class="x_xian"><?php echo $this->_var['v']['content']; ?></td>
		            <td class="time x_xian"><?php echo $this->_var['v']['addtime']; ?></td>
		            <td class="x_xian <?php echo $this->_var['v']['typeclass']; ?>"><?php echo $this->_var['v']['type']; ?></td>		            		            <td>&nbsp;</td>
		        </tr>
		        <?php } ?>
		    </tbody></table>
		<div id="page"><?php echo $this->_var['comm']['pagestr']; ?></div>
	</div>
	<?php }else{ ?>
	<div class="userError">
			<div class="h_30"></div> 
			<div class="error_panel"><span>对不起，此用户不存在！</span></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
			<div class="h_30"></div>
	</div>
	<?php } ?>
<?php echo $this->fetch("common/footer"); ?>
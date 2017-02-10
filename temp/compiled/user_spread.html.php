<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/speard.css">
<div id="spread">
	<div class="wdtg_bg1"></div>
	<div class="wdtg_bg2">
		<table width="875" border="0" align="center" cellspacing="0" cellpadding="0">
			<tbody><tr>
				<td width="432">
					<input type="text" value="http://www.haohuisua.com/?reg=<?php echo $this->_var['code']; ?>" class="wdtg_inp">
				</td>
				<td align="left">
					<a class="wdtg_btn" href="javascript:;"></a>
				</td>
            </tr><tr>
            </tr><tr>
				<td colspan="2">
					<h4 class="wdtg_tit">推广介绍</h4>
					<p>
						我们隆重邀请您参加我们"您去推广，我来送钱"活动。 我们系统为您分配了一个链接地址，您可以在微博、QQ群消息、QQ群邮件、QQ签名、Qzone日志, 论坛发贴, msn消息等发布您的推广连接地址，每个通过连接地址在本站注册的新朋友，都属于您自己名下的用户， 此后当这个用户每接手一个任务，任务完成后，您将获得该任务花费麦点的
						<span class="chengse2">2%-4%作为提成</span>（永久有效），当这个用户成功完成10个任务后（接任务和发任务），您还将获得系统为您赠送的<span class="chengse2">5元</span>存款。
					</p>
				</td>
			</tr>
			<tr>
				
				<td colspan="2">
					<h4 class="wdtg_tit">推广人数查看　( 总推荐人数：<?php echo $this->_var['all']; ?>，当月推荐人数：<?php echo $this->_var['mon']; ?>，当日推荐人数：<?php echo $this->_var['day']; ?> )</h4>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td class="wdtg_tit1"></td>
								<td class="wdtg_tit2">推广会员</td>
								<td class="wdtg_tit2">注册时间</td>
								<td class="wdtg_tit2">已接任务数</td>
								<td class="wdtg_tit2">已发任务数</td>
								<td class="wdtg_tit2">领取推荐奖励</td>
								<td class="wdtg_tit2">最近登录时间</td>
								<td class="wdtg_tit3"></td>
							</tr>
							<?php if($this->_var['my']['record'])foreach($this->_var['my']['record'] as $this->_var['key'] => $this->_var['v']){ ?>
							<tr>
								<td class="wdtg_bian"></td>
								<td class="wdtg_cont"><strong><?php echo $this->_var['v']['user_name']; ?></strong></td>
								<td class="wdtg_cont"><?php echo $this->_var['v']['add_time']; ?></td>
								<td class="wdtg_cont"><?php echo $this->_var['v']['in']; ?></td>
								<td class="wdtg_cont"><?php echo $this->_var['v']['out']; ?></td>
								<td class="wdtg_cont">未达到条件</td>
								<td class="wdtg_cont"><?php echo $this->_var['v']['last_login']; ?></td>
								<td class="wdtg_bian"></td>
							</tr>
							<?php } ?>
						</tbody></table>
					<div id="page"><?php if($this->_var['my']['pages']['pagetotal'] > 1){ ?><?php echo $this->_var['my']['pagestr']; ?><?php } ?></div>
				</td>
			</tr>
			<tr>
			<td width="50%" valign="top">
				<div class="wdtg_phb">
					<h4 class="wdtg_ph">推广<strong class="lanse">月排行</strong></h4>
					<ul class="phb_t2">
						<li class="phb_sx">
							<span class="phb_md">预计收益</span><span class="phb_md1">推广人数</span>用户名
						</li>
						<?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico1" style="background-position: -<?php echo $this->_var['v']['position']; ?>px -44px"></span>
							<span class="phb_yh">
								<a target="_blank" href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							</span>
							<span class="phb_rs"><?php echo $this->_var['v']['num']; ?></span>
							<span class="phb_money"><?php echo $this->_var['v']['money']; ?>元</span>
						</li>
						<?php } ?>
					</ul>
				</div>
			</td>
			<td width="50%" valign="top">
				<div class="wdtg_phb">
					<h4 class="wdtg_ph">推广<strong class="lanse">总排行</strong></h4>
					<ul class="phb_t2">
						<li class="phb_sx">
							<span class="phb_md">预计收益</span><span class="phb_md1">推广人数</span>用户名
						</li>
						<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['v']){ ?>
						<li class="phb_name">
							<span class="phb_nameico1" style="background-position: -<?php echo $this->_var['v']['position']; ?>px -44px"></span>
							<span class="phb_yh">
								<a target="_blank" href="info.php?act=info&uname=<?php echo $this->_var['v']['user_name']; ?>"><?php echo $this->_var['v']['user_name']; ?></a>
							</span>
							<span class="phb_rs"><?php echo $this->_var['v']['num']; ?></span>
							<span class="phb_money"><?php echo $this->_var['v']['money']; ?>元</span>
						</li>
						<?php } ?>
					</ul>
				</div>
			</td>
			</tr>
		</tbody></table>
    </div>
    <div class="wdtg_bg3"></div>
</div>
<script>
	$(function(){
		$(".wdtg_btn").click(function(){
			art.dialog({ id:'wdtg_btn',title: '请使用 Ctrl+C 复制到剪贴板',content: $(".wdtg_inp").val(),fixed: true});
		});
	    $(".wdtg_ljf").click(function(){
			var name = $(this).attr('vnid');
			var thisCon = $(this);
			art.dialog({
					id :'wdtg_ljf',
				    title: '提示',
				    fixed: true,
				    content: '确定后您将获得5元存款~',
				    okValue: '确定',
				    cancelValue: '取消',
				    ok: function () {
				    	$.ajax({ type: "POST", url: "/user/Ajax",data: "vnid="+name, success: function(data){
						   		obj = jQuery.parseJSON(data);

						   		if(obj.status == 1){
						   			art.dialog({ id:'wdtg_ljf',title: '提示',content: obj.info,fixed: true});
						   			thisCon.parent().html('已领取5元奖励');
						   		}else{
						   			art.dialog({ id:'wdtg_ljf',title: '提示',content: obj.info,fixed: true});
						   		}
							}
						});
				    },
				    cancel: function () { return true;}
			});
	 	});
	});
</script>
<?php echo $this->fetch("common/footer"); ?>
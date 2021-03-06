<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_userjob.css">
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
		<div id="_right"><div id="myjob">
	<div class="top">
		<div class="tiebuy">
			<h1>温馨提示：</h1>
			<p>1、接发平台信誉任务，必须完成或者取消后才可以更换。请根据自身情况进行接手！<br>
			2、任务完成后需要您返回到任务中心进行奖品认领，系统在完成任务后会发站内邮件通知，无论任务是否完成，任务进度将会在领取任务7天后凌晨自动清零，请您务必在此前领取奖励！<br>
			3、领取奖励时接发任务数量大于或者等于都可以，如果7天内某天或某几天小于任务数量，任务将失败。
			</p>
		</div>
	</div>
	<div class="member-job1">
		<h1><span>类型1</span>接发平台信誉任务</h1>
		<?php if($this->_var['reward'])foreach($this->_var['reward'] as $this->_var['key'] => $this->_var['item']){ ?>
		<ul>
			<li class="to1">
				<span class="li0">任务发不停，奖励送不断！</span>共有 <?php echo $this->_var['item']['num']; ?> 位用户完成此任务
				<?php if($this->_var['item']['id'] == $this->_var['static']['reward']){ ?>
					<a class="<?php echo $this->_var['static']['state']; ?>" href="javascript:;" type="<?php echo $this->_var['item']['id']; ?>"></a>
					<?php if($this->_var['static']['state'] == 'schedule'){ ?>
					<a class="over" href="javascript:;" type="<?php echo $this->_var['item']['id']; ?>"></a>
					<?php } ?>
				<?php }else{ ?>
				<a class="a" href="javascript:;" type="<?php echo $this->_var['item']['id']; ?>"></a>
				<?php } ?>
			</li>
			<li>
				<span class="li1">此任务等待着接手...</span>
			</li>
			<li>
				您需要连续<span class="li1">7</span>天，每天发布<span class="li1"><?php echo $this->_var['item']['releases']; ?></span>个任务，接手<span class="li1"><?php echo $this->_var['item']['takeover']; ?></span>个任务，任务完成后，平台奖励您<span class="li1"><?php echo $this->_var['item']['reward']; ?></span>个刷点 
			</li>
		</ul>
		<p></p>
		<?php } ?>
	</div>
	
	<div class="member-job2" style="display:none;">
		<div class="space10"></div>
		<ul id="userjob2">
		    <li class="to1">
		    	<span class="li0"><a name="#fa">任务接不停，奖励送不断！</a></span>
				<a class="aa" href="/#specialty"></a>
			</li>
			<li>
				<span class="li1">任务正在进行...</span>
			</li>
			<li>职业刷客在本周接手任务量达到<span class="li1">500</span>个，平台奖励您<span class="li1">100</span>刷点</li>
		 </ul>
	</div>
</div>
</div>
	</div>
<script type="text/javascript">
	$(function(){
		/*任务接手*/
		$('.to1 a').click(function(){
			var self=$(this);
			var type = self.attr('type');
			var clas=self.attr('class');
			switch(clas){
				case 'a':
					a(self,type);
				break;
				case 'schedule':
					schedule(self,type);
				break;
				case 'ok':
					ok(self,type);
				break;
				case 'over':
					over(self,type);
				break;
				case 'no':
					over(self,type);
				break;
			}
		});
		function schedule(self,type){
			$.post('user.php?act=userjob&opt=schedule',{"type":type},function(data){
				art.dialog({ title: '提示',content: data,fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});
			});
		}
		function a(self,type){
			var length = $(".to1 .over").length;
			if(length != 0){
				art.dialog({id:'tsxs',title: '提示',content: '很抱歉，您目前有未完成的任务，请先取消再接其他任务~',fixed: true,lock: true,cancelValue: '关闭',cancel: function () {return true;}});
				return false;
			}
			var length1 = $(".to1 .ok").length;
			if(length1 != 0){
				art.dialog({id:'tsxs',title: '提示',content: '很抱歉，您有奖励还没领取，请先领奖后再接其他任务~',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});
				return false;
			}
			var length2 = $(".to1 .no").length;
			if(length2 != 0){
				art.dialog({id:'tsxs',title: '提示',content: '很抱歉，您有任务失败了，请先取消再接其他任务~',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});
				return false;
			}
			art.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true});
			$.post('user.php?act=userjob&opt=a',{"type":type},function(data){
				art.dialog.get('ajaxStart').close();
	    		art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () {if(data.state){location.reload();} return true;}});
			},'json');
		}
		function over(self,type){
			$.post('user.php?act=userjob&opt=over',{"type":type},function(data){
				art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () {if(data.state){self.removeClass("over").addClass("a").prev().remove();self.removeClass("no").addClass("a").prev().remove();}return true;}});
			},'json');
		}
		function ok(self,type){
			$.post('user.php?act=userjob&opt=ok',{"type":type},function(data){
				art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () {if(data.state){location.reload();}return true;}});
			},'json');
		}
	});
</script>
<?php echo $this->fetch("common/footer"); ?>
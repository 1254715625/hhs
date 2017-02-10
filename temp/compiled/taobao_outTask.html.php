<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css" />
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao.css" />
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/task_fun.js"></script>
<script type="text/javascript" src="themes/default/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
$(function(){
	getoutTask(),getinTaskb('operat');
	var InterValObj=setInterval(SetRemainTime, 1000);
});
</script>

<?php echo $this->fetch("taobao/nav_up"); ?>
<span id="tloading" style="background-image: url(themes/default/images/taobao/loading.gif); width: 100px; height: 50px; float: left; text-indent: 40px; margin: 25px 0px 0px 305px; background-attachment: scroll; background-repeat: no-repeat; background-position: 0% 0%;background-color: transparent;"><img src="themes/default/images/taobao/fg.gif"></span>

<div id="moveContent"><div><div class="rwdt_xx">
    <p class="rwdt_marquee_close">X</p>
    <p class="rwdt_marquee">
    	<marquee onmouseover="this.stop()" onmouseout="this.start()" width="100%" height="18">　
    		<a href="bbs.php" style="color:red;" target="_blank"><?php echo $this->_var['result']['content']; ?></a>　　
    	</marquee>
    </p>
	<ul class="yfrw_sub">
		 
		<li style="z-index:11">
			<a href="javascript:getoutTask(),getinTaskb('operat');" class="sbico active operat"></a>
			<div class="tips-number" style="" id="operat">
				<span class="sbico reddit1"></span>
				<span class="reddit2"><?php echo $this->_var['canhandle']['canhandle']; ?></span>
				<span class="sbico reddit3"></span>
			</div>
			
		</li>
		<li style="z-index:10">
			<a href="javascript:getoutTask({process:'4'}),getinTaskb('pause');" class="sbico pause" val="1"></a>
			<div class="tips-number" style="display:none" id="pause">
				<span class="sbico whitedit1"></span>
				<span class="whitedit2"><?php echo $this->_var['pause']['pause']; ?></span>
				<span class="sbico whitedit3"></span>
			</div>
			
		</li>
		<li style="z-index:9">
			<a href="javascript:getoutTask({process:'2'}),getinTaskb('complete');" class="sbico complete"></a>
			<div class="tips-number sbicos" style="display:none" id="complete">
				<span class="sbico whitedit1"></span>
				<span class="whitedit2"><?php echo $this->_var['complete']['complete']; ?></span>
				<span class="sbico whitedit3"></span>
			</div>
			
		</li>
		
		<li style="z-index:9">
			<a href="javascript:getoutTask({process:'3'}),getinTaskb('all-task')" class="sbico all-task"></a>
			<div class="tips-number sbicos" id="all-task" style="display:none">
				<span class="sbico whitedit1"></span>
				<span class="whitedit2"><?php echo $this->_var['alltask']['alltask']; ?></span>
				<span class="sbico whitedit3"></span>
			</div>
		</li>
		
	</ul>
	<div class="rwdt_btn">
		<a href="javascript:;" class="tico fb_btn"></a>
		<a href="javascript:sx();" class="tico sx_btn"></a>
	</div>
	<div class="autotk orange cnxhtask" style="right: 430px;top: 35px;cursor: pointer;padding: 6px;background: #3ABCE5;color: #FFF;border-radius: 3px;font-size: 13px;" val="1">
    	<strong style="font-weight: normal;">猜你喜欢任务</strong>
    </div>
	<div class="rwdt_sort">
		<div class="btn_blue" style="float:left;display:none">

		<a href="javascript:getoutTask({'num':0});" class="def-a" val="4">待付款(<span class="orange"><?php echo $this->_var['fukuan']['num']; ?></span>)</a>
		
		<a href="javascript:getoutTask({'num':1});" class="def-a" val="5">待发货(<span class="orange"><?php echo $this->_var['fahuo']['num']; ?></span>)</a>
		
		<a href="javascript:getoutTask({'num':2});" class="def-a" val="6">待收货(<span class="orange"><?php echo $this->_var['shouhuo']['num']; ?></span>)</a>
		
		<a href="javascript:getoutTask({'num':3});" class="def-a" val="7">待确认(<span class="orange"><?php echo $this->_var['fangkuan']['num']; ?></span>)</a>
		</div>

		<span style="color:#B4B3B1;">（本月完成任务：<?php echo $this->_var['m']['num']; ?>，周完成任务：<?php echo $this->_var['w']['num']; ?>，日完成任务：<?php echo $this->_var['d']['num']; ?>）</span>		
	</div>
<input type="hidden" name="desc" value="desc">
<input type="hidden" name="process" value="1">
	<div class="task_search">
		
		<input type="text" name="task_keys" id="taskinfo" onclick="if(this.value.indexOf('搜索任务ID') &gt;= 0)this.value='';" value="搜索任务ID">
		<a href="javascript:;" class="search" onclick="getTasksearch('getoutTask');">搜索</a>
	</div>
</div>

<div class="cle">
	<div>
		<div id="taskList">

		</div>
	</div>
</div>

</div>

<?php echo $this->fetch("common/footer"); ?>
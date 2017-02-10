<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_seckill.css">
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
		<div id="_right"><div class="SecKill">
  	<p class="SecKill_down">
  		<span class="dleft">
  			<span id="SecKill_times"></span>　<font id="ks">开始秒杀！</font>
  		</span>
  		<span class="dright"></span>
  	</p>
 	<p class="SecKill_sub">
 		麦点秒杀<span><?php echo $this->_var['cfg']['seckill_price']; ?></span>元一个
 	</p>
 	<p class="SecKill_txt">
 		<span class="SecKill_txt1">
 			<input type="text" maxlength="4" id="SecKill_nums" name="SecKill_nums" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
 		</span>
 		<span id="SecKill_buy" class="SecKill_buy">
 			<input type="button">
 		</span>
 	</p>
	<p class="SecKill_explain">
		<span>1</span>个起售（库存<span><?php echo $this->_var['cfg']['seckill_num']; ?></span>个）
		<br>
		拥有麦点，就可以发布自己的任务，获得好评
	</p>
</div>

<div class="SecKill_ftCon">
	活动介绍：<br>
	麦点惊喜特惠价！每个<span>麦点低至<?php echo $this->_var['cfg']['seckill_price']; ?></span>元，低到不行的麦点，小成本涨信誉有木有<br>
	<?php echo $this->_var['cfg']['seckill_stime']; ?> - <?php echo $this->_var['cfg']['seckill_etime']; ?> 期间，好会刷特别发送<span><?php echo $this->_var['cfg']['seckill_num']; ?>个麦点供秒杀</span>，数量有限，真的是先到先得咯！<br>
</div></div>
	</div>
<script type="text/javascript">
$(function(){
	var myDate = new Date();
	//显示星期
	var Week = ['日','一','二','三','四','五','六'];  
	$(".dright").html("当前时间：星期"+ Week[myDate.getDay()]);
	
	//获取今日时间
	var jrDate=new Date(Date.parse(myDate.toString())-(myDate.getHours()+myDate.getMinutes()+myDate.getSeconds()));
	//获取今日凌晨时间
	var jrLcDate = new Date(Date.parse(myDate.toString())-(myDate.getHours()*60*60+myDate.getMinutes()*60+myDate.getSeconds())*1000);
	//获取今日星期几
	var jrXqing = jrLcDate.getDay();
		
	if(jrXqing === 0){ day = -5}
	if(jrXqing === 1){ day = -4}
	if(jrXqing === 2){ day = -3}
	if(jrXqing === 3){ day = -2}
	if(jrXqing === 4){ day = -1}
	if(jrXqing === 5){ day = 0 }
	if(jrXqing === 6){ day = -6}
		
	/*获取相隔星期五的时间
	if(day === 0 ){
		t = 0;
	}else{
		var edate = new Date(jrLcDate-(day*24*60*60*1000));
		//相隔描述
		var t = (Date.parse(edate) - Date.parse(jrDate))/1000;
	}*/
	var t=<?php echo $this->_var['ut']; ?>;
	var st=<?php echo $this->_var['st']; ?>;
	var ct=<?php echo $this->_var['ct']; ?>;
	if (t <=0 || st==0){
		$(".dleft").html("秒杀活动已结束！");
	}else{
		var id = "#SecKill_times";
		var sub = $("#SecKill_buy input");
		sm=parseInt((t-(parseInt(t/3600))*3600)/60);
		ss=(t-(parseInt(t/3600))*3600)%60;
		if(sm<10)sm='0'+sm;
		if(ss<10)ss='0'+ss;
		$(id).html(parseInt(t/3600) + ":" + sm + ":" + ss +"后");
		if(st==2&&t>0){
			$("#ks").html("秒杀活动将结束！");
		}
		var uptime = function() {
			t = t - 1;
			m = parseInt((t-(parseInt(t/3600))*3600)/60);
			s = (t-(parseInt(t/3600))*3600)%60;
			if(m<10)m='0'+m;
			if(s<10)s='0'+s;
			if(st==0){
				$(".dleft").html("秒杀活动已结束！");
				$("#SecKill_buy").removeClass("SecKill_buy1").addClass("SecKill_buy").html("<input type='button'>");
			}else if(st==1){
				if(t<=0){
					t=ct;
					st=2;
				}else{
					$(id).html(parseInt(t/3600) + ":" + m + ":" + s +"后" );
				}
			}else if(st==2){
				if(t<=0){
					window.clearInterval(tt_0);
					st=0;
					$(".dleft").html("秒杀活动已结束！");
					$("#SecKill_buy").removeClass("SecKill_buy1").addClass("SecKill_buy").html("<input type='button'>");
				}else{
					$(id).html(parseInt(t/3600) + ":" + m + ":" + s +"后" );
					$("#ks").html("秒杀活动将结束！");
					$("#SecKill_buy").removeClass("SecKill_buy").addClass("SecKill_buy1").html("<input id='sekill' type='submit' value='' onclick='kill()'/>");
				}
				
			}
			
		} 
		var tt_0 = window.setInterval(uptime, 1000);
	}
});
function kill(){
	m = $("#SecKill_nums").val();
	n = parseInt(<?php echo $this->_var['cfg']['seckill_num']; ?>);
	if(m == '' || m == 0 ){
		art.dialog({ id:'ms',title: '提示',content: '对不起！麦点秒杀1个起售~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
	}else if(m>n){
		art.dialog({ id:'ms',title: '提示',content: '对不起！超出库存~',fixed: true,cancelValue: '确定',cancel: function () { return true;}});return false;
	}else{
		num=m;
		art.dialog({
			id:'hsmd',
			title: '提示',
			content: '亲，提交后您将失去'+ (<?php echo $this->_var['cfg']['seckill_price']; ?>*m).toFixed(2) +'存款，获得'+ m +'个麦点~<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>',
			fixed: true,
			lock: true,
			okValue: '确定',
			ok: function () {
				if($("#safecode").val() ==''){
					art.dialog({id:'mention', title: '提示',content: '请输入安全码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
				}
				
				$.post('user.php?act=seckill',{"m":num,'safecode':$("#safecode").val()},function(data){
					art.dialog({id:'asd',title: '提示',content: data.info,fixed: true,lock: true,okValue: '确定',ok: function(){if(data.state){location.reload();return true;}}});return false;
				},'json');
			}
		});
	}
}
</script>
<?php echo $this->fetch("common/footer"); ?>
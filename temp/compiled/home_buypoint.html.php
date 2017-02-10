<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/buypoint.css">
<style type="text/css">
.cx11 {
float: left;
width: 100%;
height: 100%;
background: url('themes/default/images/activity/niudan/dg_src.png');
text-align: center;
font-size: 17px;
color: #FFF;
line-height: 126px;
display: none;
}
</style>
<div id="content">
	<div id="gm_kd">
		<div class="line open">
			<p class="STYLE5">购买数量：</p>
			<input id="nums" class="in_bk" type="text" value="20" maxlength="4" name="buymd" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
			<p class="t2">
				<span class="STYLE3">个</span>
				<span class="STYLE4">(每个<strong><?php echo $this->_var['cfg']['unit_price']; ?></strong>元)</span>
			</p>
			<input class="gm_btn" type="submit" name="submit" id="buymd">
		</div>
		<div class="line bg2 open">
			<p>
				<select id="urank">
				  <option value="6">一级VIP客户</option>
				  <option value="7">钻石VIP客户</option>
				  <option value="8">皇冠VIP客户</option>
				</select>
				<select id="months">
				<?php if($this->_var['viparr']['6'])foreach($this->_var['viparr']['6'] as $this->_var['key'] => $this->_var['v']){ ?>
					<option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['mount'][$this->_var['key']]; ?><?php echo $this->_var['v']; ?>元</option>
				<?php } ?>
				</select>
			</p>
			<div class="jiage">
				<span class="STYLE7">价格：<span id="price"><?php echo $this->_var['viparr']['6']['1']; ?></span>元</span>
				<a target="_blank" class="tq" href="info.php?act=vip">查看VIP特权</a>
			</div>
			<input type="submit" class="gm_btn" name="submit" id="buyvip">
		</div>
		<ul id="list">
			<li class="k1 open">
				<div class="kp">
					<input type="button" value="A" class="btn2" style="display: block;">
					<input type="hidden" value="156" name="price">
					<input type="hidden" value="260" name="num">
					<input type="hidden" value="A" name="card">
					<span class="cx11" style="display: none;">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">为您增加<span class="hongse"><strong>260</strong></span>个麦点，尽情发布任务去吧</p>
			</li>
			<li class="k2 open">
				<div class="kp">
					<input type="button" value="B" class="btn2" style="display: block;">
					<input type="hidden" value="290" name="price">
					<input type="hidden" value="501" name="num">
					<input type="hidden" value="B" name="card">
					<span class="cx11" style="display: none;">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">卡内含<span class="hongse"><strong>501</strong></span>个麦点，发布任务也如此激情</p>
			</li>
			<li class="k3 open">
				<div class="kp">
					<input type="button" value="C" class="btn2" style="display: block;">
					<input type="hidden" value="570" name="price">
					<input type="hidden" value="1001" name="num">
					<input type="hidden" value="C" name="card">
					<span class="cx11" style="display: none;">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">卡内含<span class="hongse"><strong>1001</strong></span>个麦点，畅快淋漓尊享三钻</p>
			</li>
			<li class="k4 open">
				<div class="kp">
					<input type="button" value="D" class="btn2" style="display: block;">
					<input type="hidden" value="1080" name="price">
					<input type="hidden" value="2001" name="num">
					<input type="hidden" value="D" name="card">
					<span class="cx11" style="display: none;">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">内含<span class="hongse"><strong>2001</strong></span>个麦点，四钻到手莫着急</p>
			</li>
			<li class="k5 open">
				<div class="kp">
					<input type="button" value="E" class="btn2" style="display: block;">
					<input type="hidden" value="2600" name="price">
					<input type="hidden" value="5001" name="num">
					<input type="hidden" value="E" name="card">
					<span class="cx11">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">内含<span class="hongse"><strong>5001</strong></span>个麦点，五钻是幸福的</p>
			</li>
			<li class="k6 open">
				<div class="kp">
					<input type="button" value="F" class="btn2" style="display: block;">
					<input type="hidden" value="5000" name="price">
					<input type="hidden" value="10001" name="num">
					<input type="hidden" value="F" name="card">
					<span class="cx11">购C卡以上立即赢大奖<a href="help.php" target="_blank" style="display:none;">前往抽奖页&gt;&gt;</a></span>
				</div>
				<p class="text">内含<span class="hongse"><strong>10001</strong></span>个麦点，<span class="STYLE1">至尊信誉，皇冠在手</span></p>
			</li>
			<li class="k7 open">
				<div name="saninter" class="kp Homemade"></div>
				<p class="text">价格：<span class="hongse">3元/张</span></p>
			</li>
			<li class="k8 open">
				<div name="qiinter" class="kp Homemade"></div>
				<p class="text">价格：<span class="hongse">16元/张</span></p>
			</li>
			<li class="k9 open">
				<div name="task" class="kp Homemade"></div>
				<p class="text">价格：<span class="hongse">1元/天</span></p>
			</li>
			<li class="k10 open">
				<div name="haoping" class="kp Homemade"></div>
				<p class="text">价格：<span class="hongse">5元/张</span></p>
			</li>
			<li class="k11 open">
				<div name="tousu" class="kp Homemade"></div>
				<p class="text">价格：<span class="hongse">5元/张</span></p>
			</li>
		</ul>
	</div>
</div>
<script language="JavaScript" type="text/javascript">
$(function(){
		$("#list li").each(function(i){
			var j = i+1;
			$('.k'+j).addClass("open");
		})
		
		$('.line').addClass("open");
		
		/*VIP选项卡*/
		$("#urank").change(function(){
			if($(this).val() == 6){
				var arr = [<?php if($this->_var['viparr']['6'])foreach($this->_var['viparr']['6'] as $this->_var['key'] => $this->_var['v']){ ?><?php if($this->_var['key'] > 1){ ?>,<?php } ?>"<?php echo $this->_var['mount'][$this->_var['key']]; ?>"+(<?php echo $this->_var['v']; ?>*1)+"元"<?php } ?>];	
				$("#price").text(<?php echo $this->_var['viparr']['6']['1']; ?>);
			}
			if($(this).val() == 7){
				var arr = [<?php if($this->_var['viparr']['7'])foreach($this->_var['viparr']['7'] as $this->_var['key'] => $this->_var['v']){ ?><?php if($this->_var['key'] > 1){ ?>,<?php } ?>"<?php echo $this->_var['mount'][$this->_var['key']]; ?>"+(<?php echo $this->_var['v']; ?>*1)+"元"<?php } ?>];	
				$("#price").text(<?php echo $this->_var['viparr']['7']['1']; ?>);
			}
			if($(this).val() == 8){
				var arr = [<?php if($this->_var['viparr']['8'])foreach($this->_var['viparr']['8'] as $this->_var['key'] => $this->_var['v']){ ?><?php if($this->_var['key'] > 1){ ?>,<?php } ?>"<?php echo $this->_var['mount'][$this->_var['key']]; ?>"+(<?php echo $this->_var['v']; ?>*1)+"元"<?php } ?>];	
				$("#price").text(<?php echo $this->_var['viparr']['8']['1']; ?>);
			}
			
			$("#months option").each(function(n){
				$(this).html(arr[n]);
			});
		});

		/*购买麦点*/
		$("#buymd").click(function(){
			var md = $("input[name='buymd']").val();
			var r = /^\+?[1-9][0-9]*$/; 
			
			if(r.test(md) == false){ 
				art.dialog({ title: '提示',content: '请输入正整数~',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});
				return false;
			}

			art.dialog({
				id:'buy',
			    title: '购买信息',
			    fixed: true,
			    lock: true,
			    content: '<div id="mdData"><img src="themes/default/images/buypoint/maidian.png"><p>请确定购买信息</p><br/><p>麦点价格：<b><?php echo $this->_var['cfg']['unit_price']; ?></b>元</p><br/><p>麦点数量：<b>'+md+'</b>个</p><br/><p>消耗存款：<b>'+new Number(md*<?php echo $this->_var['cfg']['unit_price']; ?>).toFixed(2)+'</b>元</p></div>',
			    okValue: '确定',
			    cancelValue: '取消',
			    ok: function(){			    	
			    	$.ajax({
					   type: "POST",
					   url: "home.php?act=buypoint",
					   data: {mod:'points', num:md},
					   success:function(data){
					   		obj = jQuery.parseJSON(data);
							art.dialog({title:'提示', content:obj.info, fixed:true, lock:true, cancelValue:'关闭',cancel: function () {location.reload();}});
					   }
					});
			    },
			    cancel: function () { return true;}
			});
		});

		/*购买优惠麦点*/
		$("#list li").click(function(){
			var cname = $(this).find('.btn2').val();
			var price = $(this).find('input[name=price]').val();
			var num = $(this).find('input[name=num]').val();
			var card = $(this).find('input[name=card]').val();
            
			art.dialog({
				id:'buy',
			    title: '购买信息',
			    fixed: true,
			    lock: true,
			    content: '<div id="mdData"><img style="padding:0;" src="themes/default/images/buypoint/maidian.png"><p>您将购买 <b>'+cname+'</b> 卡</p><p>内含<b>'+ num +'</b>个刷点，特价<b>'+ price +'</b>元</p></div>',
			    okValue: '确定',
			    cancelValue: '取消',
			    ok: function () {			    	
			    	$.ajax({
					   type: "POST",
					   url: "home.php?act=buypoint",
					   data: {mod:'card', card:card},
					   success: function(data){
					   		obj = jQuery.parseJSON(data);
							art.dialog({title: '提示',content: obj.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function(){if(obj.code == 1){location.reload();}else{return true;}}});
					   }
					});
			    },
			    cancel: function () { return true;}
			});
		})
		
		/*购买VIP*/
		$("#buyvip").click(function(){
			var type = $("#urank").val();
			var num = $("#months").val();
			
			art.dialog({
				id:'buy',
			    title: '提示',
			    fixed: true,
			    lock: true,
			    content: '你确定购买VIP，立即享受18重平台特权吗？',
			    okValue: '确定',
			    cancelValue: '取消',
			    ok: function () {
			    	$.ajax({
					   type: "POST",
					   url: "home.php?act=buypoint",
					   data: {mod:'vip', urank:type, months:num},
					   success: function(data){
					   		obj = jQuery.parseJSON(data);							
							art.dialog({title: '提示',content:obj.info, fixed: true,lock: true,okValue: '确定',ok: function (){if(obj.code == 1){location.reload();}else{return true;}}});
					   }
					});
			    },
			    cancel: function () { return true;}
			});
		})

		$("#list .Homemade").click(function(){

			var title = $(this).attr('name');

			/*弹出内容*/
			if(title == 'saninter'){
				var cont = '新平台用户积分增长利器，早日成为万人敬仰的平台皇冠达人！<br/>购买后积分实效为24小时<br/>不与会员等级相累计！您确定购买吗？';
			}else if(title == 'qiinter'){
				var cont = '新平台用户积分增长利器，早日成为万人敬仰的平台皇冠达人！<br/>购买后积分实效为7天<br/>不与会员等级相累计！您确定购买吗？';
			}else if(title == 'task'){
				//art.dialog({ title: '提示',content: '任务定制卡等待更新升级，谢谢！',fixed: true,lock: true,okValue: '确定',ok: function () { }});return false;

				var cont = '<div id="mdData" style="width: 320px;"><p style="margin-bottom: 20px;">平台任务那么快就被别人抢走了，又慢了一步？使用预定任务次卡可以享有单次任务优先预定权，坐等满足条件的任务自己送上门，节省宝贵时间省去麻烦的拼抢任务！<p/><p>价格：<input type="text" id="spreader" value="1" size=1 maxlength=4 onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')"/><b>元/天</b><p/></div>';
			}else if(title == 'haoping'){
				var cont = '此卡仅限一月使用一次，购买后将清理您的一个中评，或者差评，让您的满意度提升！<br/>您确定购买吗？';
			}else if(title == 'tousu'){
				var cont = '购买后您的平台有效投诉将 -1<br/>（此卡一月只可以购买一次）<br/>您确定购买吗？';
			}else{
				art.dialog({ title: '提示',content: '请勿非法操作~',fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});return false;
			}

			art.dialog({
				id:'buy',
			    title: '提示',
			    fixed: true,
			    lock: true,
			    content: cont,
			    okValue: '确定',
			    cancelValue: '取消',
			    ok: function () {
			    	if(title == "task"){ 
			    		var r = /^\+?[1-9][0-9]*$/; 
						if(r.test($("#spreader").val()) == false){ art.dialog({ title: '提示',content: '请输入正整数~',fixed: true,lock: true});return false;}
			    	}
					$.post('home.php?act=buypoint',{'mod':'cards','title':title,'num':$("#spreader").val()},function(data){
						if(data.status){
							art.dialog({ 
								title: '提示',
								content: data.info,
								fixed: true,
								lock: true,
								okValue: '确定',
								cancelValue: '取消', 
								ok: function () {
									if(data.url){
										location.href=data.url;
									}else{
										location.reload();
									}
								},
								cancel: function () { return true;} 
							});
						}else{
							art.dialog({ title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function () { return true;}});
						}
					},'json');
			    },
			    cancel: function () { return true;}
			});
		});
		
		/*
		$(".kp").mouseover(function(){
			$(this).find('span').show();
			$(this).find('.btn2').hide();
		});
		$(".kp").mouseout(function(){
			$(this).find('span').hide();
			$(this).find('.btn2').show();
		});
		*/
	});
</script> 
<?php echo $this->fetch("common/footer"); ?>

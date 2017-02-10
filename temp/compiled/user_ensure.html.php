<?php echo $this->fetch("common/header"); ?>
<style type="text/css">
/*商保*/
#shangbao {float: left;width: 760px;margin-left: 10px;}
#shangbao .mh_tishi {background: #FFFBF2;border: 1px solid #FBE1C4;margin-bottom: 15px;padding: 12px 15px;}
#shangbao .chengse2 {color: #EB0F0F;}
#shangbao .lanse {color: #1996E6;}
#shangbao .content{border-bottom: 1px dotted #DDDDDD;height:115px;width:760px;}
#shangbao .jrsb_left{ background: url(themes/default/images/user/jrsb_btn.gif) no-repeat  -10px -614px ;height:115px;width:160px;margin-left: 20px;float: left;}
#shangbao .jrsb_text{height: 70px;margin-left: 15px;float: left;margin-top: 20px;}
#shangbao .jrsb_btn1{background: url(themes/default/images/user/jrsb_btn.gif) no-repeat  -310px -633px;float: left;height: 33px;width: 95px;margin:55px 0 0 35px;}
#shangbao .agree {font-size: 14px;border: tan;margin: 10px 0 0 195px;float: left;}
#shangbao .jrsb_btn2 {background: url(themes/default/images/user/jrsb_btn.gif) no-repeat  -416px -633px ;height: 33px;float: left;width: 95px;}
#shangbao .jrsb_btn3 {background: url(themes/default/images/user/jrsb_btn.gif) no-repeat  -524px -633px ;height: 33px;float: left;width: 95px;margin-left:10px;}
#shangbao .jrsb_img {background: url(themes/default/images/user/jrsb_btn.gif);height: 613px;margin-top: 30px;width: 760px;float:left;}
</style>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
		<div id="_right"><div id="shangbao">
	<div class="mh_tishi">
		<span class="chengse2">缴纳保证金后</span>即成为
		<span class="chengse2">好会刷商保会员</span>，保障发布人权益同时
		<span class="chengse2">赚取更高的发布点回报</span>。
	</div>

	<div class="content">
		<div class="jrsb_left"></div>
		<div class="jrsb_text">
			您已缴纳了：<span class="lanse"> <?php echo $this->_var['uinfo']['business']; ?> </span>元保证金<font color="red"><?php if($this->_var['uinfo']['business_time'] > 0 && $this->_var['uinfo']['business'] > 0){ ?>(冻结中 预计还剩<lable value="<?php echo $this->_var['uinfo']['business_time']; ?>"></lable>)<?php } ?></font><br>
			本次需要缴纳：<strong style="color:#fe5500;"> <?php echo $this->_var['cfg']['business_money']; ?> </strong>元保证金<br>
			您剩余的存款：<span class="lanse"> <?php echo $this->_var['uinfo']['user_money']; ?> </span>元
		</div>
		<script>
			var date=new Date();
			var times=<?php echo $this->_var['freezetime']; ?>-(date.getTime()-$("lable").attr("value")*1000)/1000;
			var day=parseInt(times/24/3600)+1;
			if(day<=0){
				day=1;
			}
			$("lable").html(+day+"天");
		</script>
		<script>
			if(day==1){
				$(".jrsb_text font").html(" 即将在24小时内排队处理");
			}
		</script>
		<a class="jrsb_btn1" target="_blank" href="user.php?act=topup"></a>
	</div>
	<p class="agree">
		<input type="checkbox" checked="checked" value="1" name="checkbox">
		同意并接受《好会刷网商家保障基础协议》
		<a class="chengse2" target="_blank" href="javascript:;">查看详细</a>
	</p>
	<p class="agree">
		<a class="jrsb_btn2" href="javascript:;"></a>
		<a class="jrsb_btn3" href="javascript:;"></a>
	</p>
	<div class="jrsb_img"></div>
</div></div>
</div>
<script type="text/javascript">
$(function(){
	$(".jrsb_btn2").click(function(){
		 var v = $("input[name='checkbox']:checked").val();
		 if(!v){ art.dialog({title: '提示',content: "请勾选同意并接受《好会刷网商家保障基础协议》", fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false; }

		art.dialog({
			title: '提示',
			content: '您确定要加入商家保障并缴纳保证金么？<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>',
			fixed: true,
			lock: true,
			okValue: '确定',
			cancelValue: '取消',
			ok: function () {
				if($("#safecode").val() ==''){
					art.dialog({id:'mention', title: '提示',content: '请输入安全码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
				}
				$.post('user.php?act=ensure&opt=add',{'safecode':$("#safecode").val()},function(data){
					art.dialog({title: '提示',content: data.info,fixed: true,lock: true});
				},'json');
			},
			cancel: function () {location.reload(); return true;}
		});
	});

	$(".jrsb_btn3").click(function(){
		art.dialog({
				title: '提示',
				content: '您确定要退出商家保障并返还保证金么？',
				fixed: true,
				lock: true,
				okValue: '确定',
				cancelValue: '取消',
			    ok: function () {
					$.post('user.php?act=ensure&opt=destroy',function(data){
						art.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue: '确定',cancel: function () { location.reload();return true;}});
					},'json');
				 },
			    cancel: function () { return true;}
			});
	});
});
</script>
<?php echo $this->fetch("common/footer"); ?>
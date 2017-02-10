<div id="bq_menu2_cont_1">
		<p class="hsmd_ts">您当前等级为：<?php echo $this->_var['uinfo']['rank_name']; ?>，你现在有
			<span class="chengse2">
				<strong><?php echo $this->_var['uinfo']['pay_money']; ?></strong>
			</span>
			个刷点。刷点回收价格：
			<span class="chengse2">
				<span>1个刷点=</span>
				<?php echo $this->_var['uinfo']['params']['sdhsjg']; ?>元
			</span>&nbsp;
			<a class="comlink" target="_blank" href="info.php?act=vip">查看高等级回收价格</a>
		</p>
		<span class="hsmd_hsj">回收数量：
				<select name="nums">
					<option value="20">20 </option>
					<option value="50">50 </option>
					<option value="100">100 </option>
					<option value="200">200 </option>
					<option value="500">500 </option>
					<option value="1000">1000 </option>
					<option value="5000">5000 </option>
				</select>个
		</span>
		<input type="submit" class="hsmd_btn" name="hsmd_btn">
    </div>
	<div class="cle"></div>
	<p class="fuli">刷点还可以换以下福利：</p>
	<div class="weal_hsj">
		<ul>
			<?php if($this->_var['vip'])foreach($this->_var['vip'] as $this->_var['key'] => $this->_var['val']){ ?>
			<li><input type="radio" name="sid" value="<?php echo $this->_var['val']['rank_id']; ?>"> <img src="themes/default/images/ico/rechange<?php echo $this->_var['val']['class']; ?>.gif"> <?php echo $this->_var['val']['rank_name']; ?>月使用权　<font color="red"><?php echo $this->_var['val']['point']; ?>刷点</font></li>
		<?php } ?>
	 	 </ul>
     	<p>
     		<input type="button" class="weal_btn" name="weal_btn">
     	</p>
	</div>
	<script type="text/javascript">
	$(function(){
		$('.hsmd_btn').click(function(){
			var m = parseInt($(".hsmd_hsj select option:selected").val());
			var pay="<?php echo $this->_var['uinfo']['pay_money']; ?>";
			if(pay < (m+3)){
				art.dialog({title: '提示',content: '对不起，您的麦点小于'+ m +'+3 (需保留3个麦点)',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});
				return false;
			}
			var sdhsjg="<?php echo $this->_var['uinfo']['params']['sdhsjg']; ?>";
			art.dialog({
				title: '友情提示',
				content: '亲，提交后您将得到'+ (sdhsjg*m).toFixed(2) +'存款，失去'+ m +'个麦点~<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>',
				fixed: true,
				lock: true,
				okValue: '确定',
			    ok: function () {
			    	if($("#safecode").val() ==''){
						art.dialog({id:'mention', title: '提示',content: '请输入安全码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
					}
			    	$.post('user.php?act=rechange&Recovery=maipoint',{'nums': m,'safecode':$("#safecode").val()},function(data){
			    		art.dialog({title: '提示',content: data.info,fixed: true,lock: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});

			    	},'json');
			    }
			})
			return false;
		});
		$('.weal_btn').click(function(){
			var i = parseInt($("input[name='sid']:checked").val());
			var brush=<?php echo $this->_var['uinfo']['brush_time']; ?>;
			var rank="<?php echo $this->_var['uinfo']['user_rank']; ?>";
			if(brush){
				art.dialog({title: '提示',content: '对不起，您是职业刷客，必须到期后才能正常使用VIP功能~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
			}
			if(isNaN(i)){art.dialog({title: '提示',content:'请选择您要兑换的选项~',fixed: true,lock: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;}
			if( rank >=6 && rank <=8 && i >=6){

				if(i == rank){
					cont = '您已是VIP会员,若兑换则为您增加该VIP30天~'
				}
				if(i > rank){
					cont = '您兑换的VIP高于本身，若兑换则会替换原先特权~'
				}
				if(i < rank){
					cont = '您兑换的VIP小于本身，若兑换则会替换原先特权~'
				}
			}else{
				cont = '';
			}
			cont += '您确定要兑换吗？<br/><p style="margin:10px 0;color:#EB0F0F;">请输入安全码：<input style="border:1px solid #999;" type="password" id="safecode"></p>'

			art.dialog({
				title: '提示',
				content: cont,
				fixed: true,
				lock: true,
				okValue: '确定',
			    ok: function () {
			    	if($("#safecode").val() ==''){
						art.dialog({id:'mention', title: '提示',content: '请输入安全码~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
					}
					$.post('user.php?act=rechange&Recovery=welfare',{"type":i,"safecode":$("#safecode").val()},function(data){
						art.dialog({
			    			title: '提示',
			    			content: data.info,
			    			fixed: true,
			    			lock: true,
			    			okValue: '确定',
						    ok: function () {
						    	if(data.status == 1){
						    		window.location.href="user.php";
						    	}
						    }
			    		});
					},'json');
			    }
			});
		});
	});
	</script>

<a href="JavaScript:;" class="imgico renwu1" style="background-position: -68px -387px;"></a>
<div class="left_alert" style="display:none;">
	<ul>
	   <li><a href="http://taobao.haohuisua.com">淘宝任务</a></li>
	   <li><a href="http://paipai.haohuisua.com">拍拍任务</a></li>
	</ul>
</div>


<span class="imgdian dian1"></span>
<span class="imgdian dian2" style="top: 262px;"></span>
<span class="imgdian dian3" style=""></span>

<div class="left_main">
	<ul>
		<li>
			<a class="imgico li1 lia_a1"></a>
			<a href="user.php?act=topup" class="imgico text1 lia_a2"></a>
			<i></i>
		</li>
		<li>
			<a class="imgico li1 lib_a1"></a>
			<a href="user.php?act=payment" class="imgico text1 lib_a2"></a>
			<i></i>
		</li>
			<li>
				<a class="imgico li1 lic_a1"></a>
				<a href="user.php?act=payde" class="imgico text1 lic_a2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lid_a1"></a>
				<a href="user.php?act=rechange" class="imgico text1 lid_a2"></a>
				<i></i>
			</li>
			<li></li>
			
			<li>
				<a class="imgico li1 lie_rjxz1"></a>
				<a href="home.php?act=soft" class="imgico text1 lie_rjxz2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lif_a1"></a>
				<a href="user.php?act=seckill" class="imgico text1 lif_a2"></a>
				<i></i>
			</li>
			
			<!-- <li>
				<a class="imgico li1 lif_dilei1"></a>
				<a href="user.php?act=mineaction" class="imgico text1 lif_dilei2"></a>
				<i></i>
			</li> -->
			<li>
				<a class="imgico li1 lig_a1"></a>
				<a href="user.php?act=black" class="imgico text1 lig_a2"></a>
				<i></i>
			</li>

<!-- 
			<li>
				<a class="imgico li1 lie_aa1"></a>
				<a href="home.php?act=tuoguan" class="imgico text1 lie_aa2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lie_bb1"></a>
				<a href="home.php?act=tuoguan" class="imgico text1 lie_bb2"></a>
				<i></i>
			</li> -->
			
			<li>
				<a class="imgico li1 lie_bb1"></a>
				<a href="info.php?act=info&uname=<?php echo $this->_var['uinfo']['user_name']; ?>" class="imgico text1 lie_bb2"></a>
				<i></i>
			</li>


			<li></li>
			<li>
				<a class="imgico li1 lih_a1"></a>
				<a href="user.php?act=userinfo" class="imgico text1 lih_a2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lii_a1"></a>
				<a href="user.php?act=popularize" class="imgico text1 lii_a2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lij_a1"></a>
				<a href="user.php?act=thread" class="imgico text1 lij_a2"></a>
				<i></i>
			</li>
			<li>
				<a class="imgico li1 lik_a1"></a>
				<a href="user.php?act=personal" class="imgico text1 lik_a2"></a>
				<i></i>
			</li>
			  
		</ul>
	</div>
	<a class="imgico renwu2" href="user.php?act=userjob"></a>
	
<script type="text/javascript">
$(function(){
	$(".user_left .renwu1").hover(function(){
		$(".left_alert").show();
	});
	$(".user_left:not(.left_alert,renwu1)").mouseleave(function(){
		$(".left_alert").hide();
	});
});
</script>
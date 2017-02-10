<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css"/>
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao.css"/>
<!-- <script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/addtask.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/shoptask.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/from.js"></script> -->
<script type="text/javascript" src="themes/default/js/jquery.form.js"></script>
<script language="javascript" type="text/javascript" src="themes/default/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
<?php if(! $this->_var['accs']){ ?>
alert("您还没有绑定掌柜号，请先绑定~");
location.href = '?mod=bindseller';
<?php } ?>
</script>
<div id="content"><div class="h15"></div>
<div class="fabu_box1">
    <div class="fabu_title"><span class="tico fabu_left"></span><span class="tico fabu_h2">发布任务须知（*号为必填项）</span><span class="tico fabu_right"></span></div>
	<div class="cle"></div>
	<div class="fabu_cont">
	  <ul>
		<li>马上好评任务：淘宝交易的物品为虚拟物品，买卖双方可以即时确认完成交易并付款；</li>
		<li>24-72小时确认任务：淘宝交易的物品为实际存在的物品，可能包含运费和物流等，需要1－3天后方能确认收货并评价；</li>
		
		<li>要尽量保证平台任务担保价大于 (淘宝商品价格+快递运费)/2 ，否则接手人拍下商品后您的淘宝改价将会导致您的支付宝使用率低于50%既被淘宝视为信用炒作处理；</li>
		<li>您发任务时，平台中的保证金不得少于任务价，成功发布任务将会在平台中扣押相应的任务保证金；接手人完成您的任务时等额的资金会作为商品款返回给您网店的帐户中；</li>
		<li>您想发布任务的时候，必须保证您拥有相应的刷点，每次发布都会根据商品价格不同扣除相应的刷点数。您如果想让任务排名靠前就可以追加刷点奖励，追加的越多排名就越靠前；</li>
		<li class="chengse">请确认商品地址绝对正确，否则会造成不必要的纠纷。</li>
		<li class="chengse">为了您的店铺安全，发布“实物任务”商品价格请大于10元！</li>
	  </ul>
	</div>
</div>

<div class="newsHelp">
	<a href="tencent://message/?uin=188239031"></a>
</div>

<a id="mao1"></a>
<?php echo $this->fetch("taobao/taskmenu"); ?>
<div class="cle"></div>

<?php if($this->_var['mod'] == 'shopTask'){ ?>
<ul class="gou">
	<div class="gouimg"><img src="themes/default/images/taobao/che_big.gif"></div>
	<li style="padding-top:8px;">请不要使用相同的商品地址，最多只能添加6个不同的商品，每天发布的购物车任务数量请不要太多，根据自身情况添加2-6个商品，不一定要全部都加满6个商品的。</li>
	<li>
	<span>购物车请在其中一个商品价格中包含运费</span>
	</li>
</ul>
<?php } ?>

<form id="all-data" method="post" enctype="multipart/form-data">
<div class="fabu_box2">

   <ul class="cont">
	<?php if($this->_var['mod'] == 'searchTask'){ ?>
   	<li style="color: red;text-indent: 40px;height: 15px;padding: 5px 10px;">
	本页仅供发布搜索（流量）任务，接手方不会拍下付款，只需要按需求浏览！
	</li>
	<?php } ?>
   		<li>
	  <?php if($this->_var['mod'] == 'addTask'){ ?>
		<input type="hidden" name="task_type" value="1">
	  <?php } ?>
	  <?php if($this->_var['mod'] == 'lailuTask'){ ?>
		<input type="hidden" name="task_type" value="2">
	  <?php } ?>
	  <?php if($this->_var['mod'] == 'mealTask'){ ?>
		<input type="hidden" name="task_type" value="3">
	  <?php } ?>
	  <?php if($this->_var['mod'] == 'shopTask'){ ?>
		<input type="hidden" name="task_type" value="4">
	  <?php } ?>
	
	<div class="exp">
	您可以选择从已经保存的任务模板中选择一个，发布任务将更加方便快捷。
	<a target="_blank" href="help.php">查看使用帮助</a>
	</div>
</li>

<?php if($this->_var['mod'] == 'mealTask'){ ?>
<li>
	<div class="name">
		<span style="color:Red;">*</span>
		套餐类型：
		</div>
		<div class="value">
		<select id="ddlMealType" name="task_other[ddlMealType]">
		<option value="1" <?php if($this->_var['temval']['task_other']['ddlMealType'] == 1){ ?>selected<?php } ?>>普通套餐任务</option>
		<option value="2" <?php if($this->_var['temval']['task_other']['ddlMealType'] == 2){ ?>selected<?php } ?>>来路套餐任务</option>
		</select>
		</div>
		<div class="exp">
		普通套餐任务，
		<span><?php echo $this->_var['task_set']['ddlMealType1']; ?></span>
		刷点基础消耗，来路套餐任务在此基础上再增加
		<span><?php echo $this->_var['task_set']['ddlMealType2']-$this->_var['task_set']['ddlMealType1'];?></span>
		刷点基础消耗。
	</div>
</li>
<li class="limeal" style="margin-left: 40px; display: none;">
	<div class="name"></div>
	<div id="divtype" class="value">
	<input id="rshop" type="radio" class="visitWay" checked="checked" name="task_other[visitWay]" value="1">
	搜店铺&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input id="rgoods" type="radio" class="visitWay" name="task_other[visitWay]" value="2">
	搜商品
	</div>
	<div class="exp" style="margin-left: 338px;">
	需要额外支付<?php echo $this->_var['task_set']['ddlMealType2']-$this->_var['task_set']['ddlMealType1'];?>个麦点
	</div>
</li>
<li class="visitWay visitWay-1 com-hidden" style="display: none;">
	<div id="divkey" class="name">搜索店铺关键字</div>
	<div class="value">
	<input id="txtDes" class="txt" type="text" style="width:182px;color:#f50;" maxlength="100" name="task_other[txtDes]">
	</div>
	<div id="divkeytip" class="exp">请输入您的“店铺名称”或者“掌柜名称”，要确保接手人在淘宝店铺搜索中正确并且唯一能搜索到您的店铺。</div>
</li>
<li class="visitWay visitWay-1 com-hidden" style="height: 65px; display: none;">
	<div id="divdes" class="name">店铺搜索提示</div>
	<div class="value">
	<textarea id="txtSearchDes" rows="3" style="width:188px" name="task_other[txtSearchDes]"></textarea>
	</div>
	<div id="divdestip" class="exp">请输入提示信息，说明店铺在淘宝搜索结果列表中的位置，商品在店铺首页中的大概位置等等，例如：店铺在搜索结果第二个，商品在店铺首页第二排第一个</div>
</li>
<?php } ?>

<?php if($this->_var['mod'] == 'lailuTask'){ ?>
<li style="margin-left: 40px;">
	<div id="divtype" style="float:left;width:340px;">
	<input id="rshop" type="radio" name="task_other[visitWay]" value="1" <?php if($this->_var['temval']['task_other']['visitWay'] == 1 || ! isset ( $this->_var['temval']['task_other']['visitWay'] )){ ?>checked="checked"<?php } ?>>
	搜店铺&nbsp;&nbsp;&nbsp;
	<input id="rgoods" type="radio" name="task_other[visitWay]" value="2" <?php if($this->_var['temval']['task_other']['visitWay'] == 2){ ?>checked="checked"<?php } ?>>
	搜商品&nbsp;&nbsp;&nbsp;
	<input id="rcredits" type="radio" name="task_other[visitWay]" value="3" <?php if($this->_var['temval']['task_other']['visitWay'] == 3){ ?>checked="checked"<?php } ?>>
	信用评价&nbsp;&nbsp;&nbsp;
	<input id="rtrains" type="radio" name="task_other[visitWay]" value="4" <?php if($this->_var['temval']['task_other']['visitWay'] == 4){ ?>checked="checked"<?php } ?>>
	直通车
	</div>
	<div style="color:#999; float:left;">
	需要额外支付<?php echo $this->_var['task_set']['l_visitWay']; ?>个刷点
	</div>
</li>
<li class="visitWay visitWay-1">
	<div id="divkey" class="name">搜索店铺关键字</div>
	<div class="value">
	<input id="txtDes" class="txt" type="text" style="width:182px;color:#f50;" maxlength="100" name="task_other[txtDes]" value="<?php echo $this->_var['temval']['task_other']['txtDes']; ?>">
	</div>
	<div id="divkeytip" class="exp">请输入您的“店铺名称”或者“掌柜名称”，要确保接手人在淘宝店铺搜索中正确并且唯一能搜索到您的店铺。</div>
</li>
<li class="visitWay visitWay-1" style="height:65px;">
	<div id="divdes" class="name">店铺搜索提示</div>
	<div class="value">
	<textarea id="txtSearchDes" rows="3" style="width:188px" name="task_other[txtSearchDes]"><?php echo $this->_var['temval']['task_other']['txtSearchDes']; ?></textarea>
	</div>
	<div id="divdestip" class="exp">请输入提示信息，说明店铺在淘宝搜索结果列表中的位置，商品在店铺首页中的大概位置等等，例如：店铺在搜索结果第二个，商品在店铺首页第二排第一个</div>
</li>
<li>
	<div class="name">
	店铺链接位置截图
	</div>
	<div class="value long">
	<input class="url-upfile" type="text" title="没有图片请保留空" readonly="readonly" style="width:206px;height:20px" maxlength="150" name="task_other[PhotoUrl]" value="<?php echo $this->_var['temval']['task_other']['PhotoUrl']; ?>">
	</div>
	<div class="exp" style="float:left;"> 
	<div class="uploadImgs"><input type="hidden" name="PhotoUrl" value="<?php echo $this->_var['temval']['task_other']['PhotoUrl']; ?>" class="url-upfile">
		<span class="uploadImg" style="float:left;">          
	        <input type="file" name="file" class="file" id="upfile-1" size="25" style="margin-left:-232px;margin-top:0px;" value=""> 
	        <input type="button" class="button" value="选择本地图片并上传"> 
	      </span>
	      <span id="info-upfile-1" class="upload-info green"></span>
		  </div>
	</div>
	<div class="cle"></div>
	<div style="padding:5px 0px 0px 145px; height:18px;width:700px; ">可以用QQ截图功能把目标链接位置截图并保存到你的电脑，再上传图片方便接手人查看链接所在位置</div>
</li>
<?php } ?>

<?php if($this->_var['mod'] == 'shopTask'){ ?>

<li class="ligoods">
	<div class="name" name="url">任务链接：</div>
	<div class="va">
	<input class="txt" id="goodsurl" type="text"  placeholder="http://" name="task_other[shopAll][1][txturl]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['1']['txturl']; ?>">
	</div>
	<div class="exp">
	此价格为您发布宝贝改价后包括邮费的总价！此价格不能大于您在平台的保证金<em><?php echo $this->_var['uinfo']['user_money']; ?></em>元！
	<a target="_blank" href="user.php?act=topup">我要充值</a>
	</div>
	<div class="vc" style="display:none;"></div>
    <div class="cle"></div>
	<div class="nr">
	<div class="short">
	<input type="checkbox" value="1" show="1" name="task_other[shopAll][1][cbhp]" <?php if($this->_var['temval']['task_other']['shopAll']['1']['cbhp'] == 1){ ?>checked="checked"<?php } ?>>
	</div>
	<div class="ny">
	规定好评内容：
	<em>您可以要求接手人对您的商品添加好评内容</em>　
	<input type="checkbox" value="1" name="task_other[shopAll][1][chssp]" <?php if($this->_var['temval']['task_other']['shopAll']['1']['chssp'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#999">打折类物品，取消商品价格限制</span>
	</div>
	<div class="nyy01 nyy-1" <?php if($this->_var['temval']['task_other']['shopAll']['1']['cbhp'] == 1){ ?>style="display:block"<?php } ?>>
		<div class="nyy">
		<textarea rows="2" cols="45" name="task_other[shopAll][1][txthptext]"><?php echo $this->_var['temval']['task_other']['shopAll']['1']['txthptext']; ?></textarea>
		</div>
		<div class="exp">
		您可以规定接手方在淘宝交易好评时填写规定的内容。额外支付的
		<em>0.1</em>
		个金币将奖励给接手方
		</div>
		<div class="cle"> </div>
		<div class="name01">商品名称：</div>
		<div class="va">
		<input class="txt" type="text" maxlength="100" name="task_other[shopAll][1][txtgtitle]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['1']['txtgtitle']; ?>">
		</div>
		<div class="vaa">
		请输入与商品本身
		<span>一致的名称</span>
		，防止评价错乱！就是您发布在淘宝的商品标题，复制过来即可
		</div>
	</div>
	</div>
</li>

<li class="ligoods">
	<div class="name" name="url">任务链接2：</div>
	<div class="va">
	<input class="txt" id="goodsurls" type="text" placeholder="http://" name="task_other[shopAll][2][txturl]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['2']['txturl']; ?>">
	</div>

	<div class="ex">
	<a href='javascript:void(0)' name='delli' value='2' style='display: none'>删除此商品地址</a>
	<a href="javascript:void(0)" name="addli" style="display: <?php if($this->_var['temval']['task_other']['shopAll']['3']){ ?>none<?php }else{ ?>inline<?php } ?>" onclick="add(this)">添加一个商品地址</a>
	</div>
	<div class="vc" style="display:none;"></div>
	<div class="cle"></div>
	<div class="nr">
	<div class="short">
	<input type="checkbox" value="1" show="2" name="task_other[shopAll][2][cbhp]" <?php if($this->_var['temval']['task_other']['shopAll']['2']['cbhp'] == 1){ ?>checked="checked"<?php } ?>>
	</div>
	<div class="ny">
	规定好评内容：
	<em>您可以要求接手人对您的商品添加好评内容</em>　<input type="checkbox" value="1" name="task_other[shopAll][2][chssp]" <?php if($this->_var['temval']['task_other']['shopAll']['2']['chssp'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#999">打折类物品，取消商品价格限制</span>
	</div>
	<div class="nyy01 nyy-2" <?php if($this->_var['temval']['task_other']['shopAll']['2']['cbhp'] == 1){ ?>style="display: block;"<?php } ?>>
	<div class="nyy">
	<textarea rows="2" cols="45" name="task_other[shopAll][2][txthptext]"><?php echo $this->_var['temval']['task_other']['shopAll']['2']['txthptext']; ?></textarea>
	</div>
	<div class="exp">
	您可以规定接手方在淘宝交易好评时填写规定的内容。额外支付的
	<em>0.1</em>
	个金币将奖励给接手方
	</div>
	<div class="cle"> </div>
	<div class="name01">商品名称：</div>
	<div class="va">
	<input class="txt" type="text" maxlength="100" name="task_other[shopAll][2][txtgtitle]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['2']['txtgtitle']; ?>">
	</div>
	<div class="vaa">
	请输入与商品本身
	<span>一致的名称</span>
	，防止评价错乱！就是您发布在淘宝的商品标题，复制过来即可
	</div>
	</div>
	</div>
</li>
<?php if($this->_var['temval']['task_other']['shopAll'])foreach($this->_var['temval']['task_other']['shopAll'] as $this->_var['key'] => $this->_var['vals']){ ?>
<?php if($this->_var['key'] > 2){ ?>
<li class='ligoods'>
	<div class='name' name='url'>任务链接<?php echo $this->_var['key']; ?>：</div><div class='va'><input class='txt' type='text' placeholder='http://' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][txturl]' style='width:100%;' value="<?php echo $this->_var['vals']['txturl']; ?>"></div>
		
	<div class='ex'><a href='javascript:void(0)' name='delli' value='<?php echo $this->_var['key']; ?>' style='display: inline' onclick='del(<?php echo $this->_var['key']; ?>)'>删除此商品地址</a><a href='javascript:void(0)' name='addli' style='display: <?php if($this->_var['key'] < $this->_var['temlen']){ ?>none<?php }else{ ?>inline<?php } ?>;' onclick='add(this)'>添加一个商品地址</a></div>
	
	<div class='vc' style='display:none;'></div><div class='cle'></div><div class='nr'><div class='short'><input type='checkbox' value='1' show='<?php echo $this->_var['key']; ?>' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][cbhp]' onclick='shows(<?php echo $this->_var['key']; ?>)' <?php if($this->_var['vals']['cbhp'] == 1){ ?>checked="checked"<?php } ?>></div>
	
	<div class='ny'>规定好评内容：<em>您可以要求接手人对您的商品添加好评内容</em>　<input type='checkbox' value='1' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][chssp]' <?php if($this->_var['vals']['chssp'] == 1){ ?>checked="checked"<?php } ?>> <span style='color:#999'>打折类物品，取消商品价格限制</span></div>
	<div class='nyy01 nyy-<?php echo $this->_var['key']; ?>' <?php if($this->_var['vals']['cbhp'] == 1){ ?>style="display:block;"<?php } ?>><div class='nyy'><textarea rows='2' cols='45' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][txthptext]'><?php echo $this->_var['vals']['txthptext']; ?></textarea></div><div class='exp'>您可以规定接手方在淘宝交易好评时填写规定的内容。额外支付的<em>0.1</em>个金币将奖励给接手方</div><div class='cle'> </div><div class='name01'>商品名称：</div><div class='va'><input class='txt' type='text' maxlength='100' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][txtgtitle]' style='width:100%;' value="<?php echo $this->_var['vals']['txtgtitle']; ?>"></div><div class='vaa'>请输入与商品本身<span>一致的名称</span>，防止评价错乱！就是您发布在淘宝的商品标题，复制过来即可</div></div></div>
</li>
<?php } ?>
<?php } ?>


<?php } ?>


<?php if($this->_var['mod'] != 'shopTask'){ ?>
<li>
	<div class="name">
	<span style="color:Red;">*</span>
	任务链接：
	</div>
	<div class="value long">
	<input id="goodsurl" class="txt" type="text" placeholder="http://" style="width:100%;color:#000;" name="goodsurl" value="<?php echo $this->_var['temval']['goodsurl']; ?>">
	<input type="hidden" name="is_dp" id="is_dp" value="0">
	</div>
	<div class="exp" id="goodsurlexp">填写您要对方购买的商品地址，尽量使用不同商品来发布任务。</div>
</li>
<?php } ?>
		
		<li>
			<div class="name">是否商保任务：</div>
			<div class="value">
			<input id="cbxIsSB" type="checkbox" style="margin-left:-2px;+margin-left:-5px;" value="<?php echo $this->_var['task_set']['cbxIsSB']; ?>" name="cbxIsSB" <?php if($this->_var['temval']['cbxIsSB'] == 1){ ?>checked="checked"<?php } ?>>
			<br>
			<br>
			</div>
			<div class="exp">
			要求接手方缴纳保证金后成为平台的商保用户才可以接手，每叠加<?php echo $this->_var['task_set']['superposition']; ?>元，则需额外支付<em><?php echo $this->_var['task_set']['cbxIsSB']; ?></em>个刷点给接手方，——
			<a href="user.php?act=ensure" target="_blank">我要立即加入商保</a>
			</div>
		</li>
		<li>
			<div class="name">基本刷点：</div>
			<div class="value">
			<input id="txtMinMPrice" class="txt" type="text" style="width:130px;color:#f50;background:#F0F0F0;" name="txtMinMPrice" readonly="" value="<?php echo $this->_var['needpoint']; ?>">
			  个刷点
			</div>
			<div class="exp">
			发布该价格任务需要扣除的刷点，不包括增值服务.   
			<a target="_blank" href="info.php?act=vip">查看商品的价格与最底消耗额的关系</a>
		
				
			<br>
			您目前还有刷点
			<em ><?php echo $this->_var['uinfo']['pay_money']; ?></em>
			个，
			<a target="_blank" href="home.php?act=buypoint">我要购买</a>
			</div>
		</li>
		
		
		<li><div class="name">追加悬赏刷点：</div>
			<div class="value">
			<input id="pointExt" class="txt" type="text" style="width:130px;color:#f50;" value="<?php echo $this->_var['temval']['pointExt']; ?>" name="pointExt">
			  个刷点
			</div>
			<div class="exp">
			追加悬赏刷点数越多，更易被人接手，刷钻效率越高！  
			</div>
		</li>
		<li>
			<div class="name">活动截图:</div>
			<div class="value">
				<div class="exp">
					<input type="file" name="wximg">  
				</div>
			</div>
		</li>
		
		<a id="mao2"></a>
		</ul>
</div>

</div>
<div id="subform" style="display: block;background-color:#fff;">
	<div class="center">
	 	<p class="anone"></p>
		<p class="txtone">
			批量发布数量:<input name="txtFCount" type="text" id="txtFCount" value="1" class="txt" maxlength="5">个&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	批量发布间隔:<input name="txtFTime" type="text" id="txtFTime" value="0" class="txt" maxlength="5">秒</p>
    </div>
</div>
</form>
<?php echo $this->fetch("common/footer"); ?>
<script>
	$(".anone").click(function(){
		$("#all-data").submit();
	});
</script>
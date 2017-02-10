<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css"/>
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao.css"/>
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/addtask.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/shoptask.js"></script>
<script type="text/javascript" src="themes/default/js/taobao/from.js"></script>
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

<form id="all-data" method="post" action="taobao.php?mod=addTask" onsubmit="return check();">
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
	<div class="name">
	<span style="color:Red;"></span>
	使用模板：
	</div>
	<div class="value">
	<select id="tmpname" name="tmpname" style="width:190px;">
	<option value="0">请选择模板</option>
  <?php if($this->_var['date'])foreach($this->_var['date'] as $this->_var['key'] => $this->_var['val']){ ?>
	<option value="<?php echo $this->_var['val']['id']; ?>" <?php if($this->_var['temid'] == $this->_var['val']['id']){ ?>selected<?php } ?>><?php echo $this->_var['val']['name']; ?></option>
	<?php } ?>

	</select>
	</div>
	<div class="exp">
	您可以选择从已经保存的任务模板中选择一个，发布任务将更加方便快捷。
	<a target="_blank" href="help.php">查看使用帮助</a>
	</div>
</li>
<li>
	<div class="name">
	<span style="color:Red;">*</span>
	淘宝掌柜名：
	</div>
	<div class="value">
	<select id="accid" name="accid" style="width:190px;">
	<?php if($this->_var['accs'])foreach($this->_var['accs'] as $this->_var['key'] => $this->_var['acc']){ ?>
	<option value="<?php echo $this->_var['acc']['id']; ?>" <?php if($this->_var['temval']['accid'] == $this->_var['acc']['id']){ ?>selected<?php } ?>><?php echo $this->_var['acc']['nickname']; ?></option>
	<?php } ?>
	</select>
	</div>
	<div class="exp">就是您想提升信誉的淘宝帐号，接任务的朋友用来确认您的身份。<a href="?mod=bindseller">绑定掌柜</a></div>
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
	<div class="name" name="url">商品链接地址1：</div>
	<div class="va">
	<input class="txt" type="text"  placeholder="http://" name="task_other[shopAll][1][txturl]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['1']['txturl']; ?>">
	</div>
	<div class="name">商品担保价格：</div>
	<div class="vb">
	<input class="txt txtprice" type="text"  name="task_other[shopAll][1][txtprice]" style="width:45px;" onblur='change()' value="<?php echo $this->_var['temval']['task_other']['shopAll']['1']['txtprice']; ?>">
	  元
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
	<div class="name" name="url">商品链接地址2：</div>
	<div class="va">
	<input class="txt" type="text" placeholder="http://" name="task_other[shopAll][2][txturl]" style="width:100%;" value="<?php echo $this->_var['temval']['task_other']['shopAll']['2']['txturl']; ?>">
	</div>
	<div class="name">商品担保价格：</div>
	<div class="vb">
	<input class="txt txtprice" type="text" name="task_other[shopAll][2][txtprice]" style="width:45px;" onblur='change()' value="<?php echo $this->_var['temval']['task_other']['shopAll']['2']['txtprice']; ?>">
	  元
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
	<div class='name' name='url'>商品链接地址<?php echo $this->_var['key']; ?>：</div><div class='va'><input class='txt' type='text' placeholder='http://' name='task_other[shopAll][<?php echo $this->_var['key']; ?>][txturl]' style='width:100%;' value="<?php echo $this->_var['vals']['txturl']; ?>"></div>
	
	<div class='name'>商品担保价格：</div><div class='vb'><input class='txt txtprice' type='text' value="<?php echo $this->_var['vals']['txtprice']; ?>" name='task_other[shopAll][<?php echo $this->_var['key']; ?>][txtprice]' style='width:45px;' onblur='change()'>  元</div>
	
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
	商品链接地址：
	</div>
	<div class="value long">
	<input id="goodsurl" class="txt" type="text" placeholder="http://" style="width:100%;" name="goodsurl" value="<?php echo $this->_var['temval']['goodsurl']; ?>">
	<input type="hidden" name="is_dp" id="is_dp" value="0">
	</div>
	<div class="exp" id="goodsurlexp">填写您要对方购买的商品地址，尽量使用不同商品来发布任务。</div>
</li>
<li>
	<div class="name">
	<span style="color:Red;">*</span>
	商品担保价格：
	</div>
	<div class="value">
	<input id="goods_price" class="txt" type="text" style="width:152px;color:#f50;" name="goods_price" value="<?php echo $this->_var['temval']['goods_price']; ?>">
	  元<p style="padding-top:3px;"><input id="chssp" type="checkbox" style="margin-left:-2px;+margin-left:-5px;" value="1" name="chssp" <?php if($this->_var['temval']['chssp'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#999">打折类物品，取消商品价格限制</span></p>
	</div>
	<div class="exp">
	此价格为您发布的宝贝改价后包括邮费的总价，接手者购买商品时支付给您的价钱总和！此价格不能大于您在平台的保证金！您目前平台保证金为
	<em><?php echo $this->_var['uinfo']['user_money']; ?></em>
	元，
	<a target="_blank" href="user.php?act=topup">我要充值</a>
	</div>
</li>
<?php } ?>
		<li>
			<div class="name">是否需要改价：</div>
			<div class="value">
			<input id="cbxIsGJ" type="checkbox" style="margin-left:-2px;+margin-left:-5px;" value="1" name="cbxIsGJ" <?php if($this->_var['temval']['cbxIsGJ'] == 1){ ?>checked="checked"<?php } ?>>
			<br>
			<br>
			</div>
			<div class="exp">
				商品价格不等于任务商品担保价格时，请勾选！改价不要超过商品价格的50%，支付宝使用率低于50%既被淘宝视为信用炒作处理。
			</div>
		</li>
		<li>
			<div class="name">是否商保任务：</div>
			<div class="value">
			<input id="cbxIsSB" type="checkbox" style="margin-left:-2px;+margin-left:-5px;" value="1" name="cbxIsSB" <?php if($this->_var['temval']['cbxIsSB'] == 1){ ?>checked="checked"<?php } ?>>
			<br>
			<br>
			</div>
			<div class="exp">
			要求接手方缴纳保证金后成为平台的商保用户才可以接手，每叠加<?php echo $this->_var['task_set']['superposition']; ?>元，则需额外支付<em><?php echo $this->_var['task_set']['cbxIsSB']; ?></em>个刷点给接手方，——
			<a href="user.php?act=ensure" target="_blank">我要立即加入商保</a>
			</div>
		</li>
		<li>
			<div class="name">是否需要浏览店铺：</div>
			<div class="value">
			<input id="cbxIsLook" type="checkbox" style="margin-left:-2px;+margin-left:-5px;" value="1" name="cbxIsLook" <?php if($this->_var['temval']['cbxIsLook'] == 1){ ?>checked="checked"<?php } ?>>
			<br>
			<br>
			</div>
			<div class="exp">
			要求接手<em>按要求浏览店铺商品<?php echo $this->_var['task_set']['cbxIsLook']; ?></em>
			</div>
		</li>
		<li>
			<div class="name">基本刷点：</div>
			<div class="value">
			<input id="txtMinMPrice" class="txt" type="text" style="width:130px;color:#f50;background:#F0F0F0;" name="txtMinMPrice" readonly="" value="<?php if($this->_var['temval']['txtMinMPrice']){ ?><?php echo $this->_var['temval']['txtMinMPrice']; ?><?php }else{ ?>0<?php } ?>">
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
				<div class="name">
				<span style="color:Red;">*</span>
				要求确认时间：
				</div>
				<div class="value">
				<select id="ddlOKDay" style="width:230px; height:20px;" name="ddlOKDay">
				<option value="0" <?php if($this->_var['temval']['ddlOKDay'] == 0){ ?>selected="selected"<?php } ?> <?php if($this->_var['temval']['isSign'] == 1){ ?>style="display:none"<?php } ?>>马上好评（虚拟任务）</option>
				<option value="1" <?php if($this->_var['temval']['ddlOKDay'] == 1){ ?>selected="selected"<?php } ?> <?php if($this->_var['temval']['isSign'] == 1){ ?>style="display:none"<?php } ?>>24小时好评实物任务(基本刷点×1.5+0)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay1']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay1'] + 1){ ?>selected="selected"<?php } ?>>48小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay1']; ?>)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay2']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay2'] + 1){ ?>selected="selected"<?php } ?>>72小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay2']; ?>)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay3']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay3'] + 1){ ?>selected="selected"<?php } ?>>96小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay3']; ?>)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay4']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay4'] + 1){ ?>selected="selected"<?php } ?>>120小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay4']; ?>)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay5']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay5'] + 1){ ?>selected="selected"<?php } ?>>144小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay5']; ?>)</option>
				<option value="<?php echo $this->_var['task_set']['ddlOKDay6']+1;?>" <?php if($this->_var['temval']['ddlOKDay'] == $this->_var['task_set']['ddlOKDay6'] + 1){ ?>selected="selected"<?php } ?>>168小时好评实物任务(基本刷点×1.5+<?php echo $this->_var['task_set']['ddlOKDay6']; ?>)</option>
				</select>
				<p id="pOKDes"></p>
				<p style="padding-top:3px;"><input id="isNoword" type="checkbox" value="1" name="isNoword" <?php if($this->_var['temval']['isNoword'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#999">不带字好评</span></p>
				</div>
				<div class="exp">
				24小时以上属于实物任务！平台强制接手方延迟收货！
				<br>
				马上好评则必须立刻发货，属于虚拟商品任务，如果强制要求对方延期，是会被投诉的。<br>
				如勾选了不带字好评，又设置了好评内容，则系统自动取消不带字好评勾选
				</div>
			</li>
			<li>
				<div class="name">真实签收任务：</div>
				<div class="value">
					<input name="isSign" style="margin-left:-2px;+margin-left:-5px;" type="checkbox" id="isSign" value="1" <?php if($this->_var['temval']['isSign'] == 1){ ?>checked="checked"<?php } ?>> <label><input type="radio" id="Express_1" name="Express" value="1" <?php if($this->_var['temval']['Express'] == 1){ ?>checked="checked"<?php } ?>> 全国</label>
					<label><input type="radio" id="isProvince" name="Express" value="2" cid="0" <?php if($this->_var['temval']['Express'] == 2){ ?>checked="checked"<?php } ?>> 
	                    同省[请选择]
	                </label>
				<br>
				<br>
				</div>
				<div class="exp">
					全国(<em><?php echo $this->_var['task_set']['Express1']; ?></em>个刷点)，同省(<em><?php echo $this->_var['task_set']['Express2']; ?></em>个刷点)。按物流信息签收任务，单号请自行准备。<a href="javascript:;" target="_blank">了解详情</a>
				</div>
			</li>
			
		
		<a id="mao2"></a>
		<li class="add">
		    <div class="name">增值服务：</div>
			<div class="addvalue">
			   <ul>
			   		
			        <li>
                          <div class="name">留言提醒：</div>
                          <div class="value longest">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td valign="top" style="padding-left:0px;_padding-left:0px;margin:0px;"><input id="cbxIsTip" type="checkbox" name="attrs[cbxIsTip]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsTip'] == 1){ ?>checked="checked"<?php } ?>></td>
                                    <td valign="top" style="padding-left:15px;">
                                        <div id="divTip" style="margin-bottom:10px;display:<?php if($this->_var['temval']['attrs']['cbxIsTip'] == 1){ ?>block<?php }else{ ?>none<?php } ?>">
                                            <div style="margin-bottom:2px;">
              	                                请拍商品 <input name="attrs[txtBuyCount]" type="text" maxlength="4" id="txtBuyCount" class="txt" style="width:50px;" value="<?php echo $this->_var['temval']['attrs']['txtBuyCount']; ?>"> 件
              	                                <input id="cbIsHiddenName" type="checkbox" name="attrs[cbIsHiddenName]" value="1" <?php if($this->_var['temval']['attrs']['cbIsHiddenName'] == 1){ ?>checked="checked"<?php } ?>>请匿名购买
              	                                <input id="cbIsNoneAssess" type="checkbox" name="attrs[cbIsNoneAssess]" value="1" <?php if($this->_var['temval']['attrs']['cbIsNoneAssess'] == 1){ ?>checked="checked"<?php } ?>>请只收货等待默认好评
              	                            </div>
              	                            <div style="margin-bottom:2px;">
              	                                区服请填 <input name="attrs[txtAreaService]" type="text" maxlength="11" id="txtAreaService"  class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['txtAreaService']; ?>">&nbsp;&nbsp;
              	                                帐号请填 <input name="attrs[txtattrs]" type="text" maxlength="11" id="txtattrs" class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['txtattrs']; ?>">
              	                            </div>
              	                            <div style="margin-bottom:2px;">
              	                                手机请填 <input onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" name="attrs[txtMobile]" type="text" maxlength="11" id="txtMobile"  class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['txtMobile']; ?>">&nbsp;&nbsp;
              	                                选择规格 <input name="attrs[txtSpecs]" type="text" maxlength="11" id="txtSpecs" class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['txtSpecs']; ?>">
              	                            </div>
              	                            <div style="margin-bottom:2px;">
              	                                动态评分
              	                                <select name="attrs[ddlPoints]" id="ddlPoints" style="width:70px;">
													<option value="0" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 0){ ?>selected="selected"<?php } ?>>请选择</option>
													<option value="1" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 1){ ?>selected="selected"<?php } ?>>1 分</option>
													<option value="2" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 2){ ?>selected="selected"<?php } ?>>2 分</option>
													<option value="3" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 3){ ?>selected="selected"<?php } ?>>3 分</option>
													<option value="4" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 4){ ?>selected="selected"<?php } ?>>4 分</option>
													<option value="5" <?php if($this->_var['temval']['attrs']['ddlPoints'] == 5){ ?>selected="selected"<?php } ?>>5 分</option>

												</select> 分，
												                      	                                物流选择
												<select name="attrs[ddlDeliver]" id="ddlDeliver" style="width:70px;">
													<option >请选择</option>
													<option value="平邮" <?php if($this->_var['temval']['attrs']['ddlDeliver'] == '平邮'){ ?>selected="selected"<?php } ?>>平邮</option>
													<option value="快递" <?php if($this->_var['temval']['attrs']['ddlDeliver'] == '快递'){ ?>selected="selected"<?php } ?>>快递</option>
													<option value="EMS" <?php if($this->_var['temval']['attrs']['ddlDeliver'] == 'EMS'){ ?>selected="selected"<?php } ?>>EMS</option>

												</select>
              	                            </div>
              	                            <div style="margin-bottom:2px;">提醒内容 
              	                            	<input name="attrs[txtRemind]" type="text" maxlength="18" id="txtRemind" class="txt" style="width:375px;" value="<?php echo $this->_var['temval']['attrs']['txtRemind']; ?>">
              	                            </div>
                                        </div>
              	                        <div style="color:#999;padding-left:1px;">您可在此给接手方留言提醒。<em>留言提醒不能作为申诉理由，但总不理会留言的接手方客户酌情处罚，广告留言则重罚。</em><a target="_blank" href="javascript:;">查看留言规范</a></div>
                                    </td>
                                </tr>
                            </tbody></table>
                          </div>
                    </li>
                    <!-- <li>
                    	<div class="name">审核账号信息：</div>
                      	<div class="value longest">
	                        <table border="0" cellpadding="0" cellspacing="0">
	                            <tbody><tr>
	                                <td valign="top" style="padding-left:0px;_padding-left:0px;margin:0px;"><input id="isZgh" type="checkbox" name="attrs[isZgh]" value="1" <?php if($this->_var['temval']['attrs']['isZgh'] == 1){ ?>checked="checked"<?php } ?>></td>
	                                <td valign="top" style="padding-left:15px;">
	                                    <div id="guolv" style="margin-bottom:10px;display:<?php if($this->_var['temval']['attrs']['isZgh'] == 1){ ?>block<?php }else{ ?>none<?php } ?>">
	                                        <div style="margin-bottom:2px;">过滤掌柜名：
					                        	<input type="radio" name="attrs[realZgh]" value="1" id="isZgh_1" <?php if($this->_var['temval']['attrs']['realZgh'] == 1){ ?>checked="checked"<?php } ?>><label>是</label>
					                        	<input type="radio" name="attrs[realZgh]" value="0" id="isZgh_1" <?php if($this->_var['temval']['attrs']['realZgh'] == 0){ ?>checked="checked"<?php } ?>><label>否</label>
	          	                            </div>
	          	                            <div style="margin-bottom:2px;">要大麦过滤安全：
					                        	<input type="radio" name="attrs[realYdm]" value="1" id="isYdm_1" <?php if($this->_var['temval']['attrs']['realYdm'] == 1){ ?>checked="checked"<?php } ?>>
					                        	<label>安全</label>
					                        	<input type="radio" name="attrs[realYdm]" value="2" id="isYdm_2" <?php if($this->_var['temval']['attrs']['realYdm'] == 2){ ?>checked="checked"<?php } ?>>
					                        	<label>一般</label>
					                        	<input type="radio" name="attrs[realYdm]" value="0" id="isYdm_3" <?php if($this->_var['temval']['attrs']['realYdm'] == 0){ ?>checked="checked"<?php } ?>>
					                        	<label>危险 </label>
					                        	<a href="javascript:;" target="_blank" style="margin-left: 10px;">前往要大麦</a>
	          	                            </div>
	                                    </div>
	          	                        <div style="color:#999;padding-left:1px;">接手方选择抢任务后，系统根据要大麦的情况核审出买号的安全系数，再允许接手任务，还可以设置是否是掌柜号接任务。需要额外支付<em><?php echo $this->_var['task_set']['isZgh']; ?></em>个刷点给接手方</div>
	                                </td>
	                            </tr>
	                        </tbody></table>
                      	</div>
                  	</li> -->

                    
			        <li>
							<div class="name">设置审核对象：</div>
							<div class="value short">
							<input id="cbxIsAudit" type="checkbox" name="attrs[cbxIsAudit]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsAudit'] == 1){ ?>checked="checked"<?php } ?>>
							</div>
							<div class="exp">
							接手方接任务后，要您亲自审核后，接手方才可看到商品地址，对刷实物和规定旺旺聊天的商家很有用!可以事先QQ联系对方商量好。需要额外支付
							<em><?php echo $this->_var['task_set']['cbxIsAudit']; ?></em>
							个刷点给接手方
							</div>
					</li>
					
					<li>
                        <div class="name">淘宝手机订单：<img src="themes/default/images/public/new.png" style="left: -15px;"></div>
                        <div class="value short"><input id="isMobile" type="checkbox" name="attrs[isMobile]" value="1" <?php if($this->_var['temval']['attrs']['isMobile'] == 1){ ?>checked="checked"<?php } ?>></div>
                        <div class="exp">要求接手方通过手机、pad等智能设备的app下单购买支付，需要额外支付<em><?php echo $this->_var['task_set']['isMobile']; ?></em>个刷点<br><a target="_blank" href="javascript:;">手机订单教程</a></div>
                    </li>
                    <li>
                        <div class="name">旺信聊天：<img src="themes/default/images/public/new.png"></div>
                        <div class="value short"><input id="cbxIsWX" type="checkbox" name="attrs[cbxIsWX]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsWX'] == 1){ ?>checked="checked"<?php } ?>></div>
                        <div class="exp">要求接手方通过手机、pad等智能设备的app进行旺旺购买前聊天，需要额外支付<em><?php echo $this->_var['task_set']['cbxIsWX']; ?></em>个刷点</div>
                    </li>
                    
					<li>
							<div class="name">需要旺旺聊天：</div>
							<div class="value short">
							<input id="cbxIsWW" type="checkbox" name="attrs[cbxIsWW]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsWW'] == 1){ ?>checked="checked"<?php } ?>>
							</div>
							<div class="exp">
							要求接手方先在旺旺上聊几句，
							<em>强烈建议开启审核先使用QQ约定好</em>
							。需额外支付
							<em><?php echo $this->_var['task_set']['cbxIsWW']; ?></em>
							个刷点给接手方
							</div>
					</li>
					
						<li>
	                          <div class="name">旺旺确认收货：</div>
	                          <div class="value short"><input id="cbxIsLHS" type="checkbox" name="attrs[cbxIsLHS]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsLHS'] == 1){ ?>checked="checked"<?php } ?>></div>
	                          <div class="exp">要求接手方收货前登录旺旺与卖家确认收到“货物/服务”同时声明对收到“货物/服务”满意以作为收货证据，需额外支付<em><?php echo $this->_var['task_set']['cbxIsLHS']; ?></em>个刷点给接手方</div>
	                    </li>
	                    <?php if($this->_var['mod'] != 'shopTask'){ ?>
	                      <li>
	                          <div class="name">规定好评内容：</div>
	                          <div class="value long">
	                          	<input id="cbxIsMsg" type="checkbox" name="attrs[cbxIsMsg]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsMsg'] == 1){ ?>checked="checked"<?php } ?>>
	                            <textarea name="attrs[txtMessage]" id="txtMessage"><?php if($this->_var['temval']['attrs']['cbxIsMsg'] == 1){ ?><?php echo $this->_var['temval']['attrs']['txtMessage']; ?><?php }else{ ?>此处填写您希望接手人对您的任务商品的评语内容，例如：“掌柜妹妹很热情，发货速度很快，商品拿到了,感觉比图片上还要漂亮”。请不要填写“请带字好评”等引导的文字<?php } ?></textarea>
	                          </div>
	                          <div class="exp">您可以规定接手方在淘宝交易好评时填写规定的内容。额外支付的<em><?php echo $this->_var['task_set']['cbxIsMsg']; ?></em>个刷点将奖励给接手方</div>
	                      </li>
	                      <?php } ?>
	                      <li>
	                          <div class="name">规定收货地址：</div>
	                          <div class="value longest">
	                            <table border="0" cellpadding="0" cellspacing="0">
	                                <tbody><tr>
	                                    <td valign="top" style="padding-left:0px;_padding-left:0px;margin:0px;">
	                                    	<input id="cbxIsAddress" type="checkbox" name="attrs[cbxIsAddress]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsAddress'] == 1){ ?>checked="checked"<?php } ?>>
	                                    </td>
	                                    <td valign="top" style="padding-left:15px;">
	                                        <div id="cbxTip" style="margin-bottom:10px;display:<?php if($this->_var['temval']['attrs']['cbxIsAddress'] == 1){ ?>block<?php }else{ ?>none<?php } ?>">
	                                            <div style="margin-bottom:2px;">
	              	                                
	              	                            </div>
	              	                            <div style="margin-bottom:2px;">
	              	                                姓名： <input name="attrs[cbxName]" type="text" maxlength="8" id="cbxName" class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['cbxName']; ?>">&nbsp;&nbsp;
													手机： <input name="attrs[cbxMobile]" type="text" maxlength="11" id="cbxMobile" class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['cbxMobile']; ?>">
	              	                            </div>
	              	                            <div style="margin-bottom:5px;">
	              	                                邮编： <input name="attrs[cbxcode]" type="text" maxlength="6" id="cbxcode" class="txt" style="width:150px;" value="<?php echo $this->_var['temval']['attrs']['cbxcode']; ?>">
	              	                            </div>
	              	                            <div style="margin-bottom:2px;">
												 地址： <textarea name="attrs[cbxAddress]" id="cbxAddress" style="margin-left:0px;" title="此处填写您要求接手人的修改的收货地址，包含具体省、市、区及详细地址。"><?php if($this->_var['temval']['attrs']['cbxIsAddress'] == 1){ ?><?php echo $this->_var['temval']['attrs']['cbxAddress']; ?><?php }else{ ?>此处填写您要求接手人的修改的收货地址，包含具体省、市、区及详细地址，请不要填写“请带字好评”等引导的文字。<?php } ?></textarea>
												</div>
	                                        </div>
	              	                        <div style="color:#999;">您可以规定接手方在淘宝购买商品时填写您指定的收货地址。额外支付<em><?php echo $this->_var['task_set']['cbxIsAddress']; ?></em>个刷点将奖励给接手方</div>
	                                    </td>
	                                </tr>
	                            </tbody></table>
	                          </div>
	                      </li>
	                
						  <li>
	                          <div class="name">购物收藏：<img src="themes/default/images/public/new.png"></div>
	                          <div class="value short">
	                          	<input id="shopcoller" type="checkbox" name="attrs[shopcoller]" value="1" <?php if($this->_var['temval']['attrs']['shopcoller'] == 1){ ?>checked="checked"<?php } ?>>
	                          </div>
	                          <div class="exp">淘宝购物收藏，收藏后提交收藏成功截图给您，额外支付<em><?php echo $this->_var['task_set']['shopcoller']; ?></em>个刷点将奖励给接手方</div>
	                      </li>
	                
	                      <li>
	                          <div class="name">好评需要截图：</div>
	                          <div class="value short">
	                          	<input id="pinimage" type="checkbox" name="attrs[pinimage]" value="1" <?php if($this->_var['temval']['attrs']['pinimage'] == 1){ ?>checked="checked"<?php } ?>>
	                          </div>
	                          <div class="exp">您可以规定接手方好评后，必须上传截图证明好评内容。额外支付的<em><?php echo $this->_var['task_set']['pinimage']; ?></em>个刷点将奖励给接手方</div>
	                      </li>
						  <li>
	                          <div class="name">购物分享：</div>
	                          <div class="value short">
	                          	<input id="isShare" type="checkbox" name="attrs[isShare]" value="1" <?php if($this->_var['temval']['attrs']['isShare'] == 1){ ?>checked="checked"<?php } ?>>
	                          </div>
	                          <div class="exp">淘宝购物分享，分享内容同好评内容，额外支付<em><?php echo $this->_var['task_set']['isShare']; ?></em>个刷点将奖励给接手方</div>
	                      </li>
                    
                      
                      <li>
                          <div class="name">限制接手人：</div>
                          <div class="value longest">
                            <div id="divFMCount" style="margin-bottom:5px;">
                            	<div>
	                            	<label><input type="checkbox" value="1" id="cbxIsFMaxMCount" name="attrs[cbxIsFMaxMCount]" <?php if($this->_var['temval']['attrs']['cbxIsFMaxMCount'] == 1){ ?>checked="checked"<?php } ?>></label> 
	                            	<input type="radio" name="attrs[fmaxmc]" id="fmaxmc_1" value="1" <?php if($this->_var['temval']['attrs']['fmaxmc'] == 1){ ?>checked="checked"<?php } ?>> 1天接1个(<em><?php echo $this->_var['task_set']['fmaxmc1']; ?></em>个刷点)
	                            	<input type="radio" name="attrs[fmaxmc]" value="2" id="fmaxmc_2" <?php if($this->_var['temval']['attrs']['fmaxmc'] == 2){ ?>checked="checked"<?php } ?>> 1天接2个(<em><?php echo $this->_var['task_set']['fmaxmc2']; ?></em>个刷点)
	                            	<input type="radio" name="attrs[fmaxmc]" id="fmaxmc_3" value="3" <?php if($this->_var['temval']['attrs']['fmaxmc'] == 3){ ?>checked="checked"<?php } ?>> 1周接1个(<em><?php echo $this->_var['task_set']['fmaxmc3']; ?></em>个刷点)
	                            	<input type="radio" name="attrs[fmaxmc]" id="fmaxmc_4" value="4" <?php if($this->_var['temval']['attrs']['fmaxmc'] == 4){ ?>checked="checked"<?php } ?>> 每月接1个(<em><?php echo $this->_var['task_set']['fmaxmc4']; ?></em>个刷点)
                            	</div>
                            </div>
                            <div class="exp">您可以设置接手人在1天或一周内接手您发布任务的次数，需额外支付刷点</div>
                          </div>
                      </li>
                      <li>
                      <div class="name">购买前停留：</div>
                      <div class="value longest">
                        <div id="divFMCount" style="margin-bottom:5px;">
                        	<div>
                            	<label><input type="checkbox" value="1" id="stopDsTime" name="attrs[stopDsTime]" <?php if($this->_var['temval']['attrs']['stopDsTime'] == 1){ ?>checked="checked"<?php } ?>></label> 
  								<input type="radio" name="attrs[stopTime]" value="1" <?php if($this->_var['temval']['attrs']['stopTime'] == 1){ ?>checked="checked"<?php } ?>>
  								<span>停留1分钟（<b style="color: #FF5500;font-weight: normal;"><?php echo $this->_var['task_set']['stopTime1']; ?></b>个刷点）</span>
  								<input type="radio" name="attrs[stopTime]" value="2" <?php if($this->_var['temval']['attrs']['stopTime'] == 2){ ?>checked="checked"<?php } ?>>
  								<span>停留3分钟（<b style="color: #FF5500;font-weight: normal;"><?php echo $this->_var['task_set']['stopTime2']; ?></b>个刷点）</span>
  								<input type="radio" name="attrs[stopTime]" value="3" <?php if($this->_var['temval']['attrs']['stopTime'] == 3){ ?>checked="checked"<?php } ?>>
  								<span>停留5分钟（<b style="color: #FF5500;font-weight: normal;"><?php echo $this->_var['task_set']['stopTime3']; ?></b>个刷点）</span>
  							</div>
                        </div>
                      </div>
                 	</li>
                      <!--li>
                          	<div class="name">延迟购买：</div>
                          		<div class="value longest">
                            		<div id="divFMCount" style="margin-bottom:5px;">
		                            	<div>
			                            	<label><input type="checkbox" value="1" id="isYanchi" name="attrs[isYanchi]" <?php if($this->_var['temval']['attrs']['isYanchi'] == 1){ ?>checked="checked"<?php } ?>></label> 
			                            	<input type="radio" name="attrs[yanchi_state]" value="3" <?php if($this->_var['temval']['attrs']['yanchi_state'] == 3){ ?>checked="checked"<?php } ?>> <span class="ycgmtime" style="cursor: pointer;">延迟3小时(<em><?php echo $this->_var['task_set']['yanchi_state3']; ?></em>个麦点)</span>
			                            	<input type="radio" name="attrs[yanchi_state]" value="24" <?php if($this->_var['temval']['attrs']['yanchi_state'] == 24){ ?>checked="checked"<?php } ?>> <span class="ycgmtime" style="cursor: pointer;">延迟24小时(<em><?php echo $this->_var['task_set']['yanchi_state24']; ?></em>个麦点)</span>
		                            	</div>
                            		</div>
                            	<div class="exp">接手方先将商品加入购物车，然后过3、24小时候后在进行购买</div>
                          	</div>
                      	</li>
                      <li-->
                          <div class="name">买号实名认证：</div>
                          <div class="value longest">
                            <div id="divBaLevel" style="margin-bottom:5px;">
                            	<input id="isReal" type="checkbox" value="1" name="attrs[isReal]" <?php if($this->_var['temval']['attrs']['isReal'] == 1){ ?>checked="checked"<?php } ?>>
                            	<input type="radio" name="attrs[realname]" value="1" id="realname" <?php if($this->_var['temval']['attrs']['realname'] == 1){ ?>checked="checked"<?php } ?>>
                            	<label for="isReal_1">普通实名(<em><?php echo $this->_var['task_set']['isReal']; ?></em>个刷点)</label>
                            </div>
                           
                            <div class="exp">限制接手买号必须是通过了支付宝实名认证才可以接手此任务</div>
                          </div>
                      </li>
                      
                      	<li>
                          <div class="name">淘金币：</div>
                          <div class="value longest">
                            <input id="cbxIsTaoG" type="checkbox" value="1" name="attrs[cbxIsTaoG]" <?php if($this->_var['temval']['attrs']['cbxIsTaoG'] == 1){ ?>checked="checked"<?php } ?>>
                            <input name="attrs[txtTaoG]" type="text" maxlength="3" id="txtTaoG" class="txt" value="<?php echo $this->_var['temval']['attrs']['txtTaoG']; ?>" style="width:40px;">
                            必须为10的倍数，最大不超过300，每10个淘金币需支付<em><?php echo $this->_var['task_set']['cbxIsTaoG']; ?></em>个刷点给接手方
                          </div>
                          <div class="exp"></div>
                      	</li>
                      	<?php if($this->_var['isvip'] == 1){ ?>
					  	<li>
                          <div class="name">指定接手地区：</div>
                          <div class="value longest">
						  <div style="margin-bottom:10px;">
						  <input id="isLimitCity" type="checkbox" title="勾上才启用 Tips:如果你只想指定某个省份接手，只需要选择省份即可，不需要选择市；也可以具体指定到某个省某个市接手" value="1" name="attrs[isLimitCity]" <?php if($this->_var['temval']['attrs']['isLimitCity'] == 1){ ?>checked="checked"<?php } ?>>
						  
						  <select name="Province[]" id="Province" <?php if($this->_var['temval']['attrs']['isMultiple'] == 1){ ?>multiple="multiple" size="6" style="border: 1px inset gray;color: black;cursor:default"<?php } ?>>
						  <?php
						  $city_arr=array('北京市','上海市','天津市','重庆市','河北省','山西省','辽宁省','吉林省','黑龙江','江苏省','浙江省','安徽省','福建省','江西省','山东省','河南省','湖北省','湖南省','广东省','甘肃省','陕西省','内蒙古','广西','四川省','贵州省','云南省','西藏','新疆','香港','奥门','台湾');
						  foreach($city_arr as $ci){
						  ?>
						  	<option value="<?php echo $ci;?>" <?php if(is_array($this->_var['temval']['Province'])&&in_array("$ci",$this->_var['temval']['Province'])){echo 'selected="selected"';}?>><?php echo $ci;?></option>
						  <?php }?>
						  </select>
						  <input type="checkbox" name="attrs[isMultiple]" id="isMultiple" value="1" <?php if($this->_var['temval']['attrs']['isMultiple'] == 1){ ?>checked="checked"<?php } ?>>
						  多选省份
						  </div>
						  <div style="color:#999;">例如你指定北京和上海用户才可以接手，这样可避免重复用户交易，需额外支付<font color="red"><?php echo $this->_var['task_set']['isLimitCity']; ?></font>个发布点</div>
						  </div>
					 	</li>
					 	<?php } ?>
						<li>
							<div class="name" style="padding-top:5px\9;+padding-top:10px;">任务发布时间：</div>
							<div class="value longest">
								<div style="margin-bottom:3px;">
									<input id="cbxIsSetTime1" type="checkbox" name="attrs[cbxIsSetTime1]" value="1" <?php if($this->_var['temval']['attrs']['cbxIsSetTime1'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#000">定时发布(1)</span>此任务将于
									<input name="attrs[txtSetTime]" type="text" id="txtSetTime" class="txt" style="width:70px;color:#f50;" maxlength="3" value="<?php echo $this->_var['temval']['attrs']['txtSetTime']; ?>">分钟后显示在大厅
								</div>
								<div>
									<input id="cbxIsSetTime2" type="checkbox" value="1" name="attrs[cbxIsSetTime2]" <?php if($this->_var['temval']['attrs']['cbxIsSetTime2'] == 1){ ?>checked="checked"<?php } ?>> <span style="color:#000">定时发布(2)</span>此任务将于
									<input name="attrs[txtdelaydate]" type="text" id="txtdelaydate" onfocus="WdatePicker({minDate:'%y-%M-%d %H:%m',startDate:'%y-%M-%d %H:%m',dateFmt:'yyyy-MM-dd HH:mm'})" class="txt Wdate" style="width:200px;" value="<?php echo $this->_var['temval']['attrs']['txtdelaydate']; ?>" readonly="readonly">
								</div>
								<p>定时发布需额外支付<em><?php echo $this->_var['task_set']['cbxIsSetTime']; ?></em>个刷点给接者</p> 
								<p>(设置延迟发布后，不论您是否在线，都会显示在任务大厅，请保持您的联系方式畅通，长时间不响应会被接手方投诉的，只针对单个任务，勾选后审核设置将跳过)</p>
							</div>
						</li>
                  	  

                    <li>
                        <div class="name">过滤接手人：</div>
                        <div class="value longest">
                         <div id="divFilter" style="margin-bottom:10px;">
                         	<div>
                         		<label style="float:left;"><input type="checkbox" value="1" id="cbxIsFMinGrade" name="attrs[cbxIsFMinGrade]" <?php if($this->_var['temval']['attrs']['cbxIsFMinGrade'] == 1){ ?>checked="checked"<?php } ?>></label>
                         		<label class="labelstyle" style="float:left;width:160px;margin-left:10px;">接手人积分不低于</label>
                         		<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmingrade]" value="10" <?php if($this->_var['temval']['attrs']['fmingrade'] == 10){ ?>checked="checked"<?php } ?>>10</label>
                         		<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmingrade]" value="30" <?php if($this->_var['temval']['attrs']['fmingrade'] == 30){ ?>checked="checked"<?php } ?>>30</label>
                         		<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmingrade]" value="50" <?php if($this->_var['temval']['attrs']['fmingrade'] == 50){ ?>checked="checked"<?php } ?>>50</label>
                         		<label class="labelstyle" style="width:40px"><input type="radio" name="attrs[fmingrade]" value="100" <?php if($this->_var['temval']['attrs']['fmingrade'] == 100){ ?>checked="checked"<?php } ?>>100</label>
                         	</div>
							<div>
								<label style="float:left;"><input type="checkbox" value="1" id="cbxIsFMaxBBC" name="attrs[cbxIsFMaxBBC]" <?php if($this->_var['temval']['attrs']['cbxIsFMaxBBC'] == 1){ ?>checked="checked"<?php } ?>></label>
								<label class="labelstyle" style="float:left;width:160px;margin-left:10px;">接手买号被拉黑次数不大于</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxbbc]" value="5" <?php if($this->_var['temval']['attrs']['fmaxbbc'] == 5){ ?>checked="checked"<?php } ?>>5</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxbbc]" value="10" <?php if($this->_var['temval']['attrs']['fmaxbbc'] == 10){ ?>checked="checked"<?php } ?>>10</label>
								<label class="labelstyle" style="width:40px"><input type="radio" name="attrs[fmaxbbc]" value="15" <?php if($this->_var['temval']['attrs']['fmaxbbc'] == 15){ ?>checked="checked"<?php } ?>>15</label>
							</div>

						<!-- 	<div>
								<label style="float:left;"><input type="checkbox" value="1" id="cbxIsFMaxABC" name="attrs[cbxIsFMaxABC]" <?php if($this->_var['temval']['attrs']['cbxIsFMaxABC'] == 1){ ?>checked="checked"<?php } ?>></label>
								<label class="labelstyle" style="float:left;width:160px;margin-left:10px;">接手人刷客满意度不低于</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxabc]" value="98" <?php if($this->_var['temval']['attrs']['fmaxabc'] == 98){ ?>checked="checked"<?php } ?>>98%</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxabc]" value="95" <?php if($this->_var['temval']['attrs']['fmaxabc'] == 95){ ?>checked="checked"<?php } ?>>95%</label>
								<label class="labelstyle" style="width:40px"><input type="radio" name="attrs[fmaxabc]" value="90" <?php if($this->_var['temval']['attrs']['fmaxabc'] == 90){ ?>checked="checked"<?php } ?>>90%</label>
							</div>

							<div>
								<label style="float:left;"><input type="checkbox" value="1" id="cbxIsFMaxCredit" name="attrs[cbxIsFMaxCredit]" <?php if($this->_var['temval']['attrs']['cbxIsFMaxCredit'] == 1){ ?>checked="checked"<?php } ?>></label>
								<label class="labelstyle" style="float:left;width:160px;margin-left:10px;">接手买号信誉不高于</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxcredit]" value="10" <?php if($this->_var['temval']['attrs']['fmaxcredit'] == 10){ ?>checked="checked"<?php } ?>>10</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxcredit]" value="150" <?php if($this->_var['temval']['attrs']['fmaxcredit'] == 150){ ?>checked="checked"<?php } ?>>150</label>
								<label class="labelstyle" style="width:40px"><input type="radio" name="attrs[fmaxcredit]" value="200" <?php if($this->_var['temval']['attrs']['fmaxcredit'] == 200){ ?>checked="checked"<?php } ?>>200</label>
							</div> -->

							<div>
								<label style="float:left;"><input type="checkbox" value="1" id="cbxIsFMaxBTSCount" name="attrs[cbxIsFMaxBTSCount]" <?php if($this->_var['temval']['attrs']['cbxIsFMaxBTSCount'] == 1){ ?>checked="checked"<?php } ?>></label>
								<label class="labelstyle" style="float:left;width:160px;margin-left:10px;">接手人被有效投诉次数不大于</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxbtsc]" value="2" <?php if($this->_var['temval']['attrs']['fmaxbtsc'] == 2){ ?>checked="checked"<?php } ?>>2</label>
								<label class="labelstyle" style="float: left;width:40px"><input type="radio" name="attrs[fmaxbtsc]" value="3" <?php if($this->_var['temval']['attrs']['fmaxbtsc'] == 3){ ?>checked="checked"<?php } ?>>3</label>
								<label class="labelstyle" style="width:40px"><input type="radio" name="attrs[fmaxbtsc]" value="4" <?php if($this->_var['temval']['attrs']['fmaxbtsc'] == 4){ ?>checked="checked"<?php } ?>>4</label>
							</div>
						</div>
                         
	                        <div style="color:#999;">
	                        	您可以设置接手人的最低资质要求，系统将自动为您过滤掉不合格的接手人。每条任务需额外支付<em><?php echo $this->_var['task_set']['cbxIsFMinGrade']; ?></em>个刷点给接手方。 
	                        	<a target="_blank" href="javascript:;">如何设置筛选条件</a>
	                        </div>
                        </div>
                    </li>
					<?php if($this->_var['mod'] == 'lailuTask'){ ?>
					<li>
                      <div class="name">货比三家：<img src="themes/default/images/public/new.png" style="left: 5px;"></div>
                      <div class="value longest">
                        <div id="divFMCount" style="margin-bottom:5px;">
                        	<div>
                            	<label><input value="1" id="isCompare" name="attrs[isCompare]" <?php if($this->_var['temval']['attrs']['isCompare'] == 1){ ?>checked="checked"<?php } ?> type="checkbox"></label> 
  								<input name="attrs[contrast]" <?php if($this->_var['temval']['attrs']['contrast'] == 1){ ?>checked="checked"<?php } ?> value="1" type="radio">
  								<span>货比一家</span>
  								<input name="attrs[contrast]" <?php if($this->_var['temval']['attrs']['contrast'] == 2){ ?>checked="checked"<?php } ?> value="2" type="radio">
  								<span>货比二家</span>
  								<input name="attrs[contrast]" <?php if($this->_var['temval']['attrs']['contrast'] == 3){ ?>checked="checked"<?php } ?> value="3" type="radio">
  								<span>货比三家</span>
  							</div>
                        </div>
                        <div class="exp">每货比一家需额外支付<em><?php echo $this->_var['task_set']['isCompare']; ?></em>个麦点&nbsp;&nbsp;&nbsp;<a href="javascript:;">货比教程</a></div>
                      </div>
                 	</li>
					<?php } ?>
                    
                    <li>
                      	<div class="name">过滤买号等级：<img src="themes/default/images/public/new.png" style="left: -18px;"></div>
                      	<div class="value longest">
							<div style="margin-bottom:10px;">
							  	<input id="isBuyerFen" type="checkbox" value="1" name="attrs[isBuyerFen]" <?php if($this->_var['temval']['attrs']['isBuyerFen'] == 1){ ?>checked="checked"<?php } ?>>
							  	<select name="attrs[BuyerJifen]" id="BuyerJifen" style="width:185px;" data="<?php echo $this->_var['temval']['attrs']['BuyerJifen']; ?>">
								  	<option value="1" data="<?php echo $this->_var['task_set']['buyerJifen1']; ?>">一心买号(4~10信誉)</option>
								  	<option value="2" data="<?php echo $this->_var['task_set']['buyerJifen2']; ?>">二心买号(11~40信誉)</option>
								  	<option value="3" data="<?php echo $this->_var['task_set']['buyerJifen3']; ?>">三心买号(41~90信誉)</option>
								  	<option value="4" data="<?php echo $this->_var['task_set']['buyerJifen4']; ?>">四心买号(91~150信誉)</option>
								  	<option value="5" data="<?php echo $this->_var['task_set']['buyerJifen5']; ?>">五心买号(151~250信誉)</option>
								  	<option value="11" data="<?php echo $this->_var['task_set']['buyerJifen11']; ?>">一钻买号(251~500信誉)</option>
								  	<option value="12" data="<?php echo $this->_var['task_set']['buyerJifen12']; ?>">二钻买号(501~1000信誉)</option>
								  	<option value="13" data="<?php echo $this->_var['task_set']['buyerJifen13']; ?>">三钻买号(1001~2000信誉)</option>
								  	<option value="14" data="<?php echo $this->_var['task_set']['buyerJifen14']; ?>">四钻买号(2001~5000信誉)</option>
								  	<option value="15" data="<?php echo $this->_var['task_set']['buyerJifen15']; ?>">五钻买号(5001~10000信誉)</option>
								</select>
								<a href="javascript:;" id="ismgo"><input type="checkbox" value="1" name="attrs[ismgo]" <?php if($this->_var['temval']['attrs']['ismgo'] == 1){ ?>checked="checked"<?php } ?>>此买号以上信誉都可以接手</a>
							</div>
						  	<div style="color:#999;">限制接手方接手的买号等级，需要额外支付<font color="red"><?php echo $this->_var['task_set']['buyerJifen1']; ?></font>个发布点</div>
						</div>
				 	</li>
				
                 	<li>
						<div class="name">完整浏览到底：</div>
						<div class="value short" style="height: 20px;">
							<input id="isViewEnd" type="checkbox" name="attrs[isViewEnd]" value="1" <?php if($this->_var['temval']['attrs']['isViewEnd'] == 1){ ?>checked="checked"<?php } ?>>
						</div>
						<div class="exp">要求接手方上传任务商品的底部浏览截图，需要额外支付<em><?php echo $this->_var['task_set']['isViewEnd']; ?></em>个刷点</div>
					</li>
                    <!-- <li>
                      <div class="name">店内浏览商品：</div>
                      <div class="value longest">
                        <div id="divFMCount" style="margin-bottom:5px;">
                        	<div>
                            	<label><input type="checkbox" value="1" id="shopBrGoods" name="attrs[shopBrGoods]" <?php if($this->_var['temval']['attrs']['shopBrGoods'] == 1){ ?>checked="checked"<?php } ?>></label> 
                            	<input type="radio" name="attrs[lgoods]" value="1" <?php if($this->_var['temval']['attrs']['lgoods'] == 1){ ?>checked="checked"<?php } ?>> 额外浏览1个商品
                            	<input type="radio" name="attrs[lgoods]" value="2" <?php if($this->_var['temval']['attrs']['lgoods'] == 2){ ?>checked="checked"<?php } ?>> 额外浏览2个商品
                            	<input type="radio" name="attrs[lgoods]" value="3" <?php if($this->_var['temval']['attrs']['lgoods'] == 3){ ?>checked="checked"<?php } ?>> 额外浏览3个商品
                        	</div>
                        </div>
                        <div class="exp">每额外浏览一个商品需要<em><?php echo $this->_var['task_set']['shopBrGoods']; ?></em>个麦点</div>
                      </div>
                 	</li> -->
					<li>
                        <div class="name"> 保存任务模版：</div>
                        <div class="value longest">
                            <input id="isTpl" type="checkbox" value="1" name="attrs[isTpl]"> <span style="color:#000">模版名称</span>
                            <input name="attrs[tplTo]" type="text" id="tplTo" class="txt" maxlength="50"><br>
                            实现快捷方便的发布任务,普通用户最多可保存3个任务发布模板，VIP最高可拥有30个任务发布模板 <a target="_blank" href="info.php?act=vip">查看VIP特权</a>
                        </div>
                        <div class="exp"></div>
                    </li>
                  </ul>
				  
              </div>
          </li>
        

		    <!-- <li>
	            <div class="name"><span style="color:Red;">*</span>发布数量：</div>
	            <div class="value"><input name="txtFCount" type="text" id="txtFCount" style="width:70px;color:#f50;" value="1" class="txt" maxlength="5">&nbsp;&nbsp;个</div>
	            <div class="exp">设置您要批量发布的任务数量，最少1个，最多个</div>
	       </li>  -->

		  <p class="taskbutton"><input type="submit" id="btnCilentAdd" class="taskadd" value="立即发布" style="cursor: pointer;"></p>
		   <p class="taskbutton"><img src="themes/default/images/taobao/rwss.jpg"></p>
		</ul>
</div>
</form>
</div>
<div id="subform" style="display: block;background-color:#fff;">
	<div class="center">
	 	<p class="anone"></p>
		<p class="txtone">
			批量发布数量:<input name="txtFCount" type="text" id="txtFCount" value="1" class="txt" maxlength="5">个&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    	批量发布间隔:<input name="txtFTime" type="text" id="txtFTime" value="0" class="txt" maxlength="5">秒</p>
    </div>
</div>
<?php echo $this->fetch("common/footer"); ?>
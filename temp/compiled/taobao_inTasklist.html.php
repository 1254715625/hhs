<div id="taskList">			
   	    <table id="insert-after" width="100%" border="0" cellspacing="0" cellpadding="0">
   	      <thead>
          	<tr>
	            <td width="10" height="39" align="center" valign="middle" class="tico rwdt_bt1"></td>
	            <td width="200" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort" val="id" onclick="javascript:location.reload();">任务编号</span></td>
	            <td width="12%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort floatcenter" val="goodsPrice" onclick="getTasksa('getinTask','a.goods_price')">任务价格</span></td>
	            <td width="18%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort floatcenter" val="timeEnter" style="width:88px;" onclick="getTasksa('getinTask','a.ddlOKDay')">发布者要求</span></td>
	            <td width="12%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort floatcenter" val="maidian" onclick="getTasksa('getinTask','a.txtMinMPrice')">悬赏刷点</span></td>
	            <td width="12%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort floatcenter" val="state" onclick="getTasksa('getinTask','a.process')">任务状态</span></td>
	            <td width="1%" align="center" valign="middle" class="tico rwdt_bt2"></td>
	            <td width="50" align="center" valign="middle" class="tico rwdt_bt2">
	            </td>
	            <td width="15%" align="center" valign="middle" class="tico rwdt_bt2">操作</td>
	            <td width="10" align="center" valign="middle" class="tico rwdt_bt3"></td>
            </tr>
   	      </thead>
    	</table>	
			<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['vals']){ ?>
    	<table class="yfrw_list" style=""><tbody>
    <tr>
        <td width="180" class="yf_pd2">
            
            <span class="hico type<?php echo $this->_var['vals']['task_types']; ?> topt" style="width: 180px;">
                <strong>TB<?php echo $this->_var['vals']['id']; ?></strong>
               <?php if($this->_var['vals']['process'] == 0){ ?><b id="reporTask" title="举报该任务" onclick="jubao(<?php echo $this->_var['val']['id']; ?>);">举报</b><?php } ?>
            </span>
            <p class="cle"></p>
            <span class="block">
                接手时间:<?php echo $this->_var['vals']['add_time']; ?>
                
            </span>
            <span class="rwdt_xbh0">发布方:<a target="_blank" href="info.php?act=info&uname=<?php echo $this->_var['vals']['add_user']; ?>"><?php echo $this->_var['vals']['add_user']; ?></a></span>
        </td>
        <td width="90" class="yf_pd2">
             <?php if($this->_var['vals']['cbxIsGJ'] == 1){ ?>
			<span class="hico xgj" title="拍下商品，付款前需要联系店主修改价格，使得支付费用与任务金额相等，即为<?php echo $this->_var['vals']['goods_price']; ?>元"><?php echo $this->_var['vals']['goods_price']; ?></span>
			<?php }else{ ?><span class="hico rwdt_db " title="平台担保：此任务卖家已缴纳全额担保存款，买家可放心购买，任务完成时，买家平台账号自动获得相应存款。"><?php echo $this->_var['vals']['goods_price']; ?></span><?php } ?>
           
            
        </td>
        <td width="170" align="center" class="yf_pd yf_em">
            
      <?php if($this->_var['vals']['ddlOKDay'] == 0){ ?><p class="orange" title="任务接手付款后，立即对宝贝进行好评并打五星！">立即五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 1){ ?><p class="green" title="任务接手付款后，在24小时后对宝贝进行收货好评！">24小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 2){ ?><p class="green" title="任务接手付款后，在48小时后对宝贝进行收货好评！">48小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 3){ ?><p class="green" title="任务接手付款后，在72小时后对宝贝进行收货好评！">72小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 4){ ?><p class="green" title="任务接手付款后，在96小时后对宝贝进行收货好评！">96小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 5){ ?><p class="green" title="任务接手付款后，在120小时后对宝贝进行收货好评！">120小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 6){ ?><p class="green" title="任务接手付款后，在144小时后对宝贝进行收货好评！">144小时五星带字好评</p><?php } ?>
			<?php if($this->_var['vals']['ddlOKDay'] == 7){ ?><p class="green" title="任务接手付款后，在168小时后对宝贝进行收货好评！">168小时五星带字好评</p><?php } ?>
            
            
      <?php if($this->_var['vals']['cbhp'] > 1){ ?><em title="对多个商品分开评价" class="hico limit2 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['finish']['cbxIsAudit'] != 1){ ?><em title="接任务者需要发布者核审" class="hico limit3 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsWW'] == 1){ ?><em title="任务需要旺旺模拟咨询再拍下" class="hico limit4 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsLHS'] == 1){ ?><em title="任务需要模拟聊天后确认收货" class="hico limit5 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsMsg'] == 1){ ?><em title="按发布者提供的评语进行评价" class="hico limit6 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsAddress'] == 1){ ?><em title="任务需要指定收货地址" class="hico limit7 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['pinimage'] == 1){ ?><em title="接任务者需要上传好评图片" class="hico limit8 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['isShare'] == 1){ ?><em title="好评后对宝贝进行分享" class="hico limit9 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['isReal'] == 1){ ?><em title="接手买号必须通过了支付宝实名认证" class="hico limit10 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsTaoG'] == 1){ ?><em title="需要淘金币:<?php echo $this->_var['vals']['attrs']['txtTaoG']; ?>个" class="hico limit11 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['isLimitCity'] == 1){ ?><em title="要求接手方地址是<?php echo $this->_var['vals']['attrs']['Province']; ?>" class="hico limit13 lopt">&nbsp;</em>&nbsp;<?php } ?>
			<?php if($this->_var['vals']['attrs']['cbxIsWX'] == 1){ ?><em title="接任务者需要通过手机、pad等智能设备的app进行旺旺购买前聊天" class="hico limit30 lopt">&nbsp;</em>&nbsp;<?php } ?>
			
			<?php if($this->_var['vals']['attrs']['shopBrGoods'] == 1){ ?><em title="接任务者需要额外浏览商品，额外0.3~0.9个刷点" class="hnews limit<?php if(! empty ( $this->_var['vals']['finish']['shopBrGoods'] )){ ?>h<?php } ?>25 lopt" <?php if(! empty ( $this->_var['vals']['finish']['isViewEnd'] )){ ?>onclick="imgs('<?php echo $this->_var['vals']['finish']['shopBrGoods']; ?>');"<?php } ?>>&nbsp;</em>&nbsp;<?php } ?>

			<?php if($this->_var['vals']['attrs']['stopDsTime'] == 1){ ?><em title="购买前需停留1~5分钟，接手后可查看，额外0.1~0.5个刷点" class="hnews limit26 lopt">&nbsp;</em>&nbsp;<?php } ?>

			<?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要上传商品底部截图，额外0.3个刷点" class="hnews limit<?php if(! empty ( $this->_var['vals']['finish']['isViewEnd'] )){ ?>h<?php } ?>27 lopt" <?php if(! empty ( $this->_var['vals']['finish']['isViewEnd'] )){ ?>onclick="imgs('<?php echo $this->_var['vals']['finish']['isViewEnd']; ?>');"<?php } ?>>&nbsp;</em>&nbsp;<?php } ?>


			<?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要根据提示进行货比截图，额外0.5~1.5个刷点" class="hnews limit28 lopt">&nbsp;</em>&nbsp;<?php } ?>

			<?php if($this->_var['vals']['attrs']['shopcoller'] == 1){ ?><em title="接任务者需要收藏该商品，收藏后提交收藏成功截图" class="hico limit31 lopt">&nbsp;</em>&nbsp;<?php } ?>
   
        </td>
        <td width="120" align="center" class="yf_pd">
            <span class="<?php if($this->_var['vals']['ddlOKDay'] == 0){ ?>red<?php }else{ ?>green<?php } ?> "><strong><?php echo $this->_var['vals']['total_points']; ?>个刷点</strong></span><br>
			<?php if($this->_var['vals']['pointExt']){ ?> <span class="orange">↑ 发布者追加了刷点<?php echo $this->_var['vals']['pointExt']; ?>个</span><?php } ?> 
        </td>
        <td width="120" align="center" class="yf_pd">
              
            <strong class="orange">
				<?php if($this->_var['vals']['appeal'] == 1){ ?>任务申诉中<?php }else{ ?>
                <?php if($this->_var['vals']['process'] == 0){ ?>等待您对商品付款<?php } ?>
                <?php if($this->_var['vals']['process'] == 1){ ?>接手方已付款，等待发布方发货<?php } ?>
				<?php if($this->_var['vals']['process'] == 2){ ?>发布方已发货，等待接手方好评<?php } ?>
				<?php if($this->_var['vals']['process'] == 3){ ?>接手方已确认，等待发布方核实<?php } ?>
				<?php if($this->_var['vals']['process'] == 4){ ?>确认已被好评，任务完成<?php } ?>
				<?php if($this->_var['vals']['appeal'] == 1){ ?>任务申诉中<?php } ?>
				<?php } ?>
            </strong>
        </td>
        <td width="240" align="right" class="yf_pd2" valign="top" style="padding:0px;">
            <div style="height:30px; position:relative; top:5px;left: 20px;">
			<?php if($this->_var['vals']['appeal'] == 1){ ?>任务申述中，暂停操作<?php }else{ ?>

				<?php if($this->_var['vals']['process'] == 0 && $this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['get_user'] > 0 && $this->_var['vals']['finish']['cbxIsAudit'] != 1){ ?><a href="javascript:;" class="aico abtn1 copy-field goodsUrl" onclick="qq(<?php echo $this->_var['vals']['qq']; ?>);">&nbsp;</a><?php } ?>
				
				<?php if($this->_var['vals']['process'] == 0 && ( ( $this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['finish']['cbxIsAudit'] == 1 ) || $this->_var['vals']['attrs']['cbxIsAudit'] == 0 ) && $this->_var['vals']['get_user'] > 0){ ?>
					<?php if($this->_var['vals']['task_other']['visitWay'] > 0){ ?>
						<?php if($this->_var['vals']['finish']['goods_url'] == $this->_var['vals']['goods_url']){ ?>
							<?php if($this->_var['vals']['attrs']['lgoods'] > 0){ ?>
								<?php if($this->_var['vals']['finish']['contrast'][$this->_var['vals']['attrs']['lgoods']] != ''){ ?>
									<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn3" copy-field="goodsUrl">&nbsp;</a>
									<a href="javascript:payment(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn4 " copy-field="goodsUrl">&nbsp;</a>
								<?php }else{ ?>
									<a href="javascript:<?php if($this->_var['vals']['attrs']['isCompare'] == 1){ ?>hb(<?php echo $this->_var['vals']['id']; ?>)<?php }else{ ?>yz(<?php echo $this->_var['vals']['id']; ?>)<?php } ?>;" class="aico abtn2 " copy-field="goodsUrl">&nbsp;</a>
								<?php } ?>
							<?php }else{ ?>
								<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn3" copy-field="goodsUrl">&nbsp;</a>
								<a href="javascript:payment(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn4 " copy-field="goodsUrl">&nbsp;</a>
							<?php } ?>
						<?php }else{ ?>
							<a href="javascript:<?php if($this->_var['vals']['attrs']['isCompare'] == 1){ ?>hb(<?php echo $this->_var['vals']['id']; ?>)<?php }else{ ?>yz(<?php echo $this->_var['vals']['id']; ?>)<?php } ?>;" class="aico abtn2 " copy-field="goodsUrl">&nbsp;</a>
						<?php } ?>
					<?php }else{ ?>
						<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn3" copy-field="goodsUrl">&nbsp;</a>
						<a href="javascript:payment(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn4 " copy-field="goodsUrl">&nbsp;</a>
					<?php } ?>
				<?php } ?>
				
				<?php if($this->_var['vals']['process'] == 1){ ?><a href="javascript:nopayment(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn5" copy-field="goodsUrl">&nbsp;</a><?php } ?>
				
				<?php if($this->_var['vals']['process'] == 2 && $this->_var['vals']['ddlOKDay'] > 0){ ?><a href="javascript:;" class="aico abtn21" copy-field="goodsUrl">&nbsp;</a><?php } ?>

				<?php if($this->_var['vals']['process'] == 2 && $this->_var['vals']['attrs']['pinimage'] == 1 && $this->_var['vals']['ddlOKDays'] == 0){ ?><a href="javascript:haoimg(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn18" copy-field="goodsUrl">&nbsp;</a><?php } ?>

				<?php if($this->_var['vals']['process'] == 2 && $this->_var['vals']['attrs']['pinimage'] == 0 && $this->_var['vals']['ddlOKDay'] == 0){ ?><a href="javascript:praise(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn6" copy-field="goodsUrl">&nbsp;</a><?php } ?>

				<?php if($this->_var['vals']['process'] == 3){ ?><a href="javascript:;" class="aico abtn20" copy-field="goodsUrl">&nbsp;</a><?php } ?>

				<?php if($this->_var['vals']['process'] == 4 && $this->_var['vals']['evaluation'] == 0){ ?><a href="javascript:pingjia(<?php echo $this->_var['vals']['id']; ?>);" class="aico abtn8" copy-field="goodsUrl">&nbsp;</a><?php } ?>
			<?php } ?>
            </div>
			<?php if($this->_var['vals']['appeal'] == 1){ ?>
				<p style="clear:both;line-height:30px;height:30px;"><strong class="green time" ></strong></p>
			<?php }else{ ?>
			<?php if($this->_var['vals']['process'] == 0 && $this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['get_user'] > 0 && $this->_var['vals']['finish']['cbxIsAudit'] != 1){ ?><p style="clear:both;line-height:30px;height:30px;">审核剩余时间：<strong class="green time" time="<?php echo $this->_var['vals']['time']; ?>"></strong></p><?php } ?>

			<?php if($this->_var['vals']['process'] == 0 && $this->_var['vals']['get_user'] > 0){ ?>
				<?php if(( $this->_var['vals']['attrs']['cbxIsAudit'] == 0 || ( $this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['finish']['cbxIsAudit'] == 1 ) )){ ?><p style="clear:both;line-height:30px;height:30px;">付款剩余时间：<strong class="green time" time="<?php echo $this->_var['vals']['time']; ?>"></strong></p><?php } ?>
			<?php } ?>

			<?php if($this->_var['vals']['process'] == 1){ ?><p style="clear:both; line-height:30px;height:30px;">发货剩余时间：<strong class="green time" time="<?php echo $this->_var['vals']['time']; ?>"></strong></p><?php } ?>
			<p style="clear:both; line-height:30px;height:30px;"></p>
			<?php } ?>

			<?php if($this->_var['vals']['process'] == 2 && $this->_var['vals']['ddlOKDay'] > 0 && $this->_var['vals']['ddlOKDays'] > 0){ ?><p style="clear:both; line-height:30px;height:30px;">收货剩余时间<strong class="green time" time="<?php echo $this->_var['vals']['times']; ?>"></strong></p><?php } ?>

            <p class="task-border">
                联系对方：<a href="javascript:;" class="yf_lx">
                <img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['vals']['qq']; ?>:17" alt="<?php echo $this->_var['vals']['qq']; ?>" title="qq联系对方" onclick="qq(<?php echo $this->_var['vals']['qq']; ?>);"></a>
                <a href="javascript:;" title="给卖家发送手机短信" alt="给卖家发送手机短信" class="aico phone"></a> |
                <?php if($this->_var['vals']['appeal'] == 1){ ?><a href="user.php?act=complaint" title="查看申述" class="yf_ckss">查看申述</a><?php }else{ ?>
               <?php if($this->_var['vals']['process'] == 0){ ?> <a href="javascript:task_out(this,<?php echo $this->_var['vals']['id']; ?>);" title="退出任务" class="yf_wz">退出</a><?php } ?>
			   <?php if($this->_var['vals']['process'] > 0 && $this->_var['vals']['process'] < 4){ ?><a href="javascript:shenshu(<?php echo $this->_var['vals']['id']; ?>);" title="任务申述" class="yf_ss">投诉</a><?php } ?><?php } ?>
         <?php if($this->_var['vals']['remarks'] == ''){ ?><a href="javascript:remarks('',<?php echo $this->_var['vals']['id']; ?>);;" style=" height:12px;top:2px;" class="aico no-flag yf_bz" ></a><?php } ?>
			   <?php if($this->_var['vals']['remarks']){ ?><a href="javascript:remarks('<?php echo $this->_var['vals']['remarks']; ?>',<?php echo $this->_var['vals']['id']; ?>);;" style=" height:12px;top:2px;" class="aico flag yf_bz" title="<?php echo $this->_var['vals']['remarks']; ?>"></a><?php } ?>
            </p>
        </td>
        <td width="15">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9" valign="middle" class="yfrw_listxia">
            <ul>
                <li class="info">不按规定修改地址、好评的的接手人将给予严厉处分</li>
                <li>
                    <span class="f-left" style="width: 150px;overflow: hidden;height: 20px;">
                        <span class="aico"></span>掌柜名:<a href="javascript:;" class="blue nicknames" val="qinsijiong"><?php echo $this->_var['vals']['nickname']; ?></a>
                    </span>
                    <span class="f-left"><span class="aico wangwang"></span>
                        <span>
                            采用买号:<a href="http://www.haohuisua.com/user.php?act=info&uname=<?php echo $this->_var['vals']['buyno']; ?>" class="blue" target="_blank" title="查看买号信息"><?php echo $this->_var['vals']['buyno']; ?></a>
							
                            <span title="买号信誉：<?php echo $this->_var['vals']['buyer_credit']; ?>" ><?php echo $this->_var['vals']['buyer_credit_img']; ?></span>
                        </span>
                    </span>
                </li>
                <li width="12%" style="float:right">
                <?php if($this->_var['vals']['process'] == 0 && $this->_var['vals']['get_user'] > 0){ ?>
					<?php if(( $this->_var['vals']['attrs']['cbxIsAudit'] == 1 && $this->_var['vals']['finish']['cbxIsAudit'] == 1 ) || $this->_var['vals']['attrs']['cbxIsAudit'] == 0){ ?>
						<?php if($this->_var['vals']['task_other']['visitWay'] > 0){ ?>
							<?php if($this->_var['vals']['finish']['goods_url'] == $this->_var['vals']['goods_url']){ ?>
								<?php if($this->_var['vals']['attrs']['lgoods'] > 0){ ?>
									<?php if($this->_var['vals']['finish']['contrast'][$this->_var['vals']['attrs']['lgoods']] != ''){ ?>
										<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" copy-field="goodsUrl" class="strong lookgurl">查看淘宝地址</a>
									<?php } ?>
								<?php }else{ ?>
									<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" copy-field="goodsUrl" class="strong lookgurl">查看淘宝地址</a>
								<?php } ?>
							<?php } ?>
						<?php }else{ ?>
							<a href="javascript:getTaobaourl(<?php echo $this->_var['vals']['id']; ?>);" copy-field="goodsUrl" class="strong lookgurl">查看淘宝地址</a>
						<?php } ?>
					<?php } ?>
				<?php } ?>
                    
                    
                </li>
            </ul>
        </td>
    </tr>
<?php if($this->_var['vals']['remind']){ ?><tr>
	<td colspan="9" height="40" class="yf_ts1">
		<span class="aico bcomment"></span>
		<strong class="orange"><?php echo $this->_var['vals']['remind']; ?></strong>
	</td>
</tr>
<?php } ?>
<?php if($this->_var['vals']['attrs']['cbxIsMsg']){ ?>
<tr>
	<td colspan="9" height="40" class="yf_ts2">
		<span class="aico goodcomment"></span>
		<strong class="orange goodinfo"><?php echo $this->_var['vals']['attrs']['txtMessage']; ?></strong>
		<span copy-field="goodMessage" class="aico cpycomment" onclick="copys('<?php echo $this->_var['vals']['attrs']['txtMessage']; ?>');"></span>
	</td>
</tr>
<?php } ?>
<?php if($this->_var['vals']['attrs']['cbxIsAddress']){ ?>
<tr>
        <td colspan="9" height="40" class="yf_ts2"> 
            <span class="aico limit-address"></span>
            <span>姓名：</span>
            <strong class="orange"><?php echo $this->_var['vals']['attrs']['cbxName']; ?></strong>
            <span class="address-title">地址：</span>
            <strong class="orange"><?php echo $this->_var['vals']['attrs']['cbxAddress']; ?></strong>
            <span class="address-title">电话：</span>
            <strong class="orange"><?php echo $this->_var['vals']['attrs']['cbxMobile']; ?></strong>
            <span class="address-title">邮编：</span>
            <strong class="orange"><?php echo $this->_var['vals']['attrs']['cbxcode']; ?></strong>
            <span class="aico cpyaddress" copy-field="readdres" onclick="copys('<?php echo $this->_var['vals']['attrs']['cbxName']; ?>&nbsp;<?php echo $this->_var['vals']['attrs']['cbxAddress']; ?>&nbsp;<?php echo $this->_var['vals']['attrs']['cbxMobile']; ?>&nbsp;<?php echo $this->_var['vals']['attrs']['cbxcode']; ?>');"></span>
        </td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>


<div id="insert-before"></div>
		<div id="page"><span style="padding-left:20px;">本页合计金额：金额:<span class="orange"><?php echo $this->_var['page_amount']; ?></span>元，刷点:<span class="orange"><?php echo $this->_var['page_mai']; ?></span>个；未完成金额:<span class="orange"><?php echo $this->_var['page_wamount']; ?></span>元，未完成刷点:<span class="orange"><?php echo $this->_var['page_wmai']; ?></span>个，待付款任务金额：<span style="color:blue;"><?php echo $this->_var['page_wfu']; ?></span>元</span><?php echo $this->_var['array']['pagestr']; ?></div>
</div>
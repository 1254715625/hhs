<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tlisttable">

    <thead>
    <tr>
        <td width="10" height="39" align="center" valign="middle" class="tico rwdt_bt1"></td>
        <td width="21%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort" val="0"
                                                                                   style="width:80px;margin-left: 30px;"
                                                                                   onclick="getTask();">任务编号</span></td>
        <td width="12%" align="left" valign="middle" class="tico rwdt_bt2">发布人</td>
        <td width="12%" align="left" valign="middle" class="tico rwdt_bt2"><span class="h-sort" val="1"
                                                                                 onclick="getTasks('gettask','goods_price')">任务价格</span>
        </td>
        <td width="23%" align="center" valign="middle" class="tico rwdt_bt2"><span class="h-sort" val="2"
                                                                                   style="width:93px"
                                                                                   onclick="getTasks('gettask','ddlOKDay')">发布者要求</span>
        </td>
        <td width="22%" align="left" valign="middle" class="tico rwdt_bt2"><span class="h-sort" val="3"
                                                                                 onclick="getTasks('gettask','txtMinMPrice')">悬赏刷点</span>
        </td>
        <td width="10%" align="center" valign="middle" class="tico rwdt_bt2">操作</td>
        <td width="10" align="center" valign="middle" class="tico rwdt_bt3"></td>
    </tr>
    <tr>
        <td colspan="8" class="newdatas" style="display:none">有<b>0</b>个新发布的任务，点击刷新<span></span></td>
    </tr>
    </thead>

    <tbody class="tlisttable table-row">

    <?php if($this->_var['count'] < 5){ ?>
    <tr class="redt_list">
        <center>对不起,你暂时没有完成5个任务!!!</center>
    </tr>
    <?php die;?><?php } ?>
    <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['vals']){ ?>
    <tr class="rwdt_list <?php if($this->_var['key'] % 2 != 0){ ?>bgcollor<?php } ?>">
        <td width="10">&nbsp;</td>
        <td width="21%">
<span class="hico type<?php echo $this->_var['vals']['task_types']; ?> topt" title="来路任务">
		<strong>TB<?php echo $this->_var['vals']['id']; ?></strong>
	</span>
            <br>
            <?php if($this->_var['vals']['cbxIsSB'] == 1){ ?><span class="hico limit1 lopt" title="接任务者需要加入平台商保">Time:&nbsp;<?php echo $this->_var['vals']['addtime']; ?><?php if($this->_var['vals'] [ attrs ] [ isMobile ] == 1){ ?><img
                src="themes/default/images/public/sjdd.png" style="vertical-align: sub;margin-left:5px;"
                title="接任务者需要通过手机、pad等智能设备的app下单支付"><?php } ?></span><a href="user.php?act=ensure"
                                                                   title="接任务者的平台商保金额需要大于150.00元，可额外获得0.3个刷点"
                                                                   style="width: 150px;float: left;text-align: center;">接任务需要加入平台商保</a><?php }else{ ?>Post
            Time:&nbsp;<?php echo $this->_var['vals']['addtime']; ?><?php if($this->_var['vals'] [ attrs ] [ isMobile ] == 1){ ?><img src="themes/default/images/public/sjdd.png"
                                                                         style="vertical-align: sub;margin-left:5px;"
                                                                         title="接任务者需要通过手机、pad等智能设备的app下单支付"><?php } ?>
            <?php } ?><?php if($this->_var['vals']['cbxIsLook'] == 1){ ?>需要浏览店铺<?php } ?>
            </span>
        </td>
        <td width="12%">
            <a title="接任务后方可查看到对方QQ号码" target="_blank" href="info.php?act=info&uname=<?php echo $this->_var['vals']['add_user']; ?>"
               class="<?php if($this->_var['vals']['special'] == 1){ ?>orange strong<?php }else{ ?>blue<?php } ?>">
                <span><?php echo $this->_var['vals']['add_user']; ?></span>
            </a>
            <br>
            <?php if($this->_var['vals']['special'] == 1){ ?><span class="hico vip<?php echo $this->_var['vals']['user_rank']; ?> vopt" title="<?php echo $this->_var['vals']['rank_name']; ?>客户">exp:<?php echo $this->_var['vals']['rank_points']; ?></span><?php } ?>
        </td>
        <td width="12%">
            <?php if($this->_var['vals']['cbxIsGJ'] == 1){ ?>
            <span class="hico xgj"
                  title="拍下商品，付款前需要联系店主修改价格，使得支付费用与任务金额相等，即为<?php echo $this->_var['vals']['goods_price']; ?>元"><?php echo $this->_var['vals']['goods_price']; ?></span>
            <?php }else{ ?><span class="hico rwdt_db " title="平台担保：此任务卖家已缴纳全额担保存款，买家可放心购买，任务完成时，买家平台账号自动获得相应存款。"><?php echo $this->_var['vals']['goods_price']; ?></span><?php } ?>
        </td>
        <td width="23%" class="noktime">
            <?php if($this->_var['vals']['ddlOKDay'] == 0){ ?><p class="orange" title="任务接手付款后，立即对宝贝进行好评并打五星！">立即五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 1){ ?><p class="green" title="任务接手付款后，在24小时后对宝贝进行收货好评！">24小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 2){ ?><p class="green" title="任务接手付款后，在48小时后对宝贝进行收货好评！">48小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 3){ ?><p class="green" title="任务接手付款后，在72小时后对宝贝进行收货好评！">72小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 4){ ?><p class="green" title="任务接手付款后，在96小时后对宝贝进行收货好评！">96小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 5){ ?><p class="green" title="任务接手付款后，在120小时后对宝贝进行收货好评！">120小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 6){ ?><p class="green" title="任务接手付款后，在144小时后对宝贝进行收货好评！">144小时五星带字好评</p><?php } ?>
            <?php if($this->_var['vals']['ddlOKDay'] == 7){ ?><p class="green" title="任务接手付款后，在168小时后对宝贝进行收货好评！">168小时五星带字好评</p><?php } ?>

            <?php if($this->_var['vals']['cbhp'] > 1){ ?><em title="对多个商品分开评价" class="hico limit2 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsAudit'] == 1){ ?><em title="接任务者需要发布者核审" class="hico limit3 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsWW'] == 1){ ?><em title="任务需要旺旺模拟咨询再拍下" class="hico limit4 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsLHS'] == 1){ ?><em title="任务需要模拟聊天后确认收货" class="hico limit5 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsMsg'] == 1){ ?> <em title="按发布者提供的评语进行评价" class="hico limit6 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsAddress'] == 1){ ?><em title="任务需要指定收货地址" class="hico limit7 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['pinimage'] == 1){ ?><em title="接任务者需要上传好评图片" class="hico limit8 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['isShare'] == 1){ ?><em title="好评后对宝贝进行分享" class="hico limit9 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['isReal'] == 1){ ?><em title="接手买号必须通过了支付宝实名认证" class="hico limit10 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsTaoG'] == 1){ ?><em title="需要淘金币:<?php echo $this->_var['vals']['attrs']['txtTaoG']; ?>个" class="hico limit11 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['isLimitCity'] == 1){ ?><em title="要求接手方地址是<?php echo $this->_var['vals']['attrs']['Province']; ?>" class="hico limit13 lopt">
            &nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['cbxIsWX'] == 1){ ?><em title="接任务者需要通过手机、pad等智能设备的app进行旺旺购买前聊天" class="hico limit30 lopt">
            &nbsp;</em>&nbsp;<?php } ?>

            <?php if($this->_var['vals']['attrs']['shopBrGoods'] == 1){ ?><em title="接任务者需要额外浏览商品，额外0.3~0.9个刷点" class="hnews limit25 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['stopDsTime'] == 1){ ?><em title="购买前需停留1~5分钟，接手后可查看，额外0.1~0.5个刷点" class="hnews limit26 lopt">
            &nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要上传商品底部截图，额外0.3个刷点" class="hnews limit27 lopt">&nbsp;</em>&nbsp;<?php } ?>
            <?php if($this->_var['vals']['attrs']['isViewEnd'] == 1){ ?><em title="接任务者需要根据提示进行货比截图，额外0.5~1.5个刷点" class="hnews limit28 lopt">
            &nbsp;</em>&nbsp;<?php } ?>

            <?php if($this->_var['vals']['attrs']['shopcoller'] == 1){ ?><em title="接任务者需要收藏该商品，收藏后提交收藏成功截图" class="hico limit31 lopt">&nbsp;</em>&nbsp;<?php } ?>
        </td>
        <td width="22%" align="left">
            <span class="<?php if($this->_var['vals']['ddlOKDay'] == 0){ ?>red<?php }else{ ?>green<?php } ?> "><strong><?php echo $this->_var['vals']['total_points']; ?>个刷点</strong></span><br>
            <?php if($this->_var['vals']['pointExt']){ ?> <span class="orange">↑ 发布者追加了刷点<?php echo $this->_var['vals']['pointExt']; ?>个</span><?php } ?>
        </td>
        <td width="10%" class="center">
            <p style=" position: relative; ">
                <a class="tico qrw_btn" href="javascript:;" onclick="qiang(<?php echo $this->_var['vals']['id']; ?>);">&nbsp;</a>
            </p>
        </td>
        <td width="10">&nbsp;</td>
    </tr>
    <?php } ?>

    </tbody>
</table>
<div class="rwdt_dlm">
    <a href="bbs.php" target="_blank" class="tico rwdt_tbhelp"></a>
    <div id="page"><?php echo $this->_var['page']; ?></div>
</div>
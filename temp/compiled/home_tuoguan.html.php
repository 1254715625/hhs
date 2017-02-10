<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/fuwu.css">

<style type="text/css">
.service-view-quan { padding-top:10px;}
.service-view-quan input { overflow: hidden;width: 130px;height: 14px;margin-right: 5px;padding: 8px;border: 1px solid #CCC;background: #FFF url(http://www.17gude.com/Service/img/input-bg.png) repeat-x;line-height: 14px;vertical-align: top;color: #AAA;}
.service-view-quan button { overflow: hidden;width: 95px;height: 32px;border: 0;background: url(http://www.17gude.com/Service/img/btn-95x32.png) no-repeat;text-align: center;vertical-align: top;color: #FFF;cursor: pointer;}
.service-view-quan p{ float: left;font-size: 13px;color: #1A7A1A;}
.service-view-quan p b{ color: #F00;margin-right: 10px;}
</style>

<div id="p-focus" class="a-mb15">
    <div class="g-layout">
        
        <div class="crumb">
            <a class="item" href="home.php?act=tuoguan" target="_blank">全部服务</a>
            <b class="f-arr">&gt;</b>
            <em class="item">快速托管</em>
        </div>
        <div class="service-view">
            <span class="service-view-pic"><img src="themes/default/images/fuwu/service-view-tuoguan2.jpg" alt=""><b></b></span>
            <div class="service-view-cnt" style="margin-top: -5px;">
                <h1 style="margin-bottom:0px;">网店托管-指定类目托管管理</h1>
                <div class="service-view-content">
                    
                    在瞬息万变的互联网时代，已经晚开网店的我们来说已经慢人一步，为了尽快与您的对手站在统一起跑线上，我们注定要不走寻常路了，区别传统方法，依据我们多年的从业经验及庞大的用户数据，总结出来的独家运营方法。让您在最短的时间内快速提升店铺形象，有利于宝贝转换和客户的信任度。另有商家保障计划，全程无忧，如出现问题我们免费进行补回。把店铺交给我们，您轻松上班去。
                    
                </div>
                <div class="service-view-quan">
				<!--<input name="YHCode" class="quan-input" type="text" value="输入代金券抵扣现金" style="color: rgb(170, 170, 170);" maxlength="10"> <button type="button" name="get" class="quan-button">领用代金券</button>-->
					<?php if($this->_var['tuoguanod']){ ?>
					<div style="line-height:22px; text-align:center; font-weight:bold; font-size:14px;">当前进行的套餐是：<?php echo $this->_var['tuoguanod']['title']; ?></div>
					<div style="height:32px; line-height:32px; border:1px #CCC solid; text-align:center; position:relative;">
						<div style="height:32px; background:red; width:<?php echo $this->_var['tuoguanod']['bl']; ?>%; position:absolute; left:0; top:0;"></div>
						<strong style="color:green;">当前进度：<?php echo $this->_var['tuoguanod']['bl']; ?>%</strong>
					</div>
					<?php } ?>
				
               </div>
            </div>
            <div class="service-view-order">
                <div class="order-package">
                    <h3>可选套餐: </h3>
                    <ul class="package-list">
						<?php if($this->_var['tgitem'])foreach($this->_var['tgitem'] as $this->_var['item']){ ?>
                        <li key="<?php echo $this->_var['item']['id']; ?>" price="<?php echo $this->_var['item']['price']; ?>"><?php echo $this->_var['item']['title']; ?></li>
						<?php } ?>
                    </ul>
                </div>
                <div class="act">
                    <a class="btn-buy" id="buyGo" href="javascript:void(0);">立刻购买</a>
                    <a class="qq" href="tencent://message/?uin=<?php echo $this->_var['cfg']['serv_qq']['0']; ?>">联系我们</a>
                </div>
                
                <?php if($this->_var['status'] == 1){ ?>
                <a href="javascript:;" style="display: block; width:280px; height:30px; line-height:30px; border:1px #CCC solid; text-align:center; background-color: rgb(205,95,87); color:#fff; margin-top: 14px" class="addInfo">完善信息</a>
                <?php } ?>

            </div>
			
        </div>
    </div>
</div>

<div id="p-content">
    <div class="g-layout">
        <div class="g-s215m760">
            <div class="col-sub">
                <div class="sub-box">
                    <div class="ui-title"><h2 class="ui-title-tit">最新任务</h2></div>
                    <div class="service-list">
						<ul>
						<?php if($this->_var['tglist'])foreach($this->_var['tglist'] as $this->_var['item']){ ?>
							<li><span style="color:red;"><?php echo $this->_var['item']['user_name']; ?></span> 刚刚购买了 
							<p><?php echo $this->_var['item']['title']; ?> 套餐</p></li>
						<?php } ?>
						</ul>
					</div>
                </div>
      		</div>
            <div class="col-main">
                <div id="taocont" style="display:none;">
                    <h3>推荐服务</h3>
                    <div class="uls">
                        <div class="taogoods cur">
                            <a href="javascript:;">
                                <img src="themes/default/images/fuwu/phorder/sj.png" width="60" height="60">
                                <p><span>手机定制 网店托管</span><br>10单起 每单10元</p>
                            </a>
                        </div>
                        <i class="jia"></i>
                        <div class="taogoods cur">
                           <a href="javascript:;">
                                <img src="themes/default/images/fuwu/taocang/tuo.png" width="60" height="60">
                                <p><span>网店托管 个性订制</span><br>特价:250笔 599元</p>
                            </a>
                        </div>
                        <i class="jia"></i>
                        <div class="taogoods cur">
                            <a href="javascript:;">
                                <img src="themes/default/images/fuwu/taocang/su.png" width="60" height="60">
                                <p><span>快速托管 三天完成</span><br>特价:250笔 599元</p>
                            </a>
                        </div>
                        <i class="jia"></i>
                        <div class="taogoods">
                            <img src="themes/default/images/fuwu/taocang/a1.png" width="60" height="60">
                        </div>
                        <i class="jia"></i>
                        <div class="taogoods">
                            <img src="themes/default/images/fuwu/taocang/a1.png" width="60" height="60">
                        </div>
                        <i class="jia"></i>
                        <div class="taogoods">
                            <img src="themes/default/images/fuwu/taocang/a1.png" width="60" height="60">
                        </div>
                    </div>
                </div>
                <div class="ui-tabs" style="float: left;">
                    <div class="ui-tabs-nav" style="width:740px;display:none;">
                        <span type="0" class="ui-tabs-tri ui-tabs-tri-active">服务详情</span>
                        <!-- <span type="1" class="ui-tabs-tri ">成功案例</span> -->
                        <span type="1" class="ui-tabs-tri ">购买记录</span>
                    </div>
                    <div class="ui-tabs-crop">
                        <div class="ui-tabs-cnt">
                            
                            <div class="ui-tabs-panel">
                                <div class="sevice-detail">
                                    <img src="themes/default/images/fuwu/pai.jpg" alt="">
                                    <img src="themes/default/images/fuwu/zhanwaill_02.jpg" alt="">
                                </div>
                            </div>
                            
                            <!-- <div class="ui-tabs-panel" style="display:none;">
                                <div class="sevice-detail">
                                    <img src="themes/default/images/fuwu/service_detail/ba1.jpg" width="835"/>
                                    <img src="themes/default/images/fuwu/service_detail/ba2.jpg" width="835"/>
                                    <img src="themes/default/images/fuwu/service_detail/ba3.jpg" width="835"/>
                                    <img src="themes/default/images/fuwu/service_detail/ba4.jpg" width="835"/>
                                    <img src="themes/default/images/fuwu/service_detail/ba5.jpg" width="835"/>
                                    <img src="themes/default/images/fuwu/service_detail/ba6.jpg" width="835"/>
                                </div>
                            </div> -->
                            
                            <div class="ui-tabs-panel" style="display:none;">
                                <div class="sevice-detail">
                                                                                                                        <strong class="lanse2">登录后显示......</strong>
                                                                                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
	$('.package-list li').click(function(){
		$('.package-list li').removeClass('selected');
		$(this).addClass("selected");
	});
	
	$('.btn-buy').click(function(){
		var obj = $('.package-list li.selected');
		var id = $(obj).attr('key');
		var price = $(obj).attr('price');
		
		if(id == undefined || price == undefined)
		{
			art.dialog({title:'提示', content:'请选择您要购买的套餐', fixed:true, lock:true, okValue:'确定', ok:{}});
			return false;
		}
		
		art.dialog({title:'提示', content:'后门托管安全快速，100%保证，请系好安全带哟！<br />您将支付 <b style="color:red;"> '+ price +' </b> 元，请确认。', fixed:true, lock:true, 
				okValue:'确定订购', 
				ok: function(){
					$.ajax({
					   type: "POST",
					   url: "home.php?act=tuoguan",
					   data: {itemid:id},
					   success: function(data){
					   		obj = jQuery.parseJSON(data);
							art.dialog({title: '提示',content: obj.info,fixed: true,lock: true,cancelValue: '关闭',cancel: function(){if(obj.code == 1){location.reload();}else{return true;}}});
					   }
					});
				},
				cancelValue:'取消',
				cancel:{}
			});
		
		
	});
	$('.addInfo').click(function(){
		var contents="<form action='home.php?act=addInfo' method='post' id='form1'><div style=' width: 300px; height:60px; line-height:60px; text-align:center'>店铺地址：<input name='shopUrl' type='text' value=''></div><div style='width: 300px; height:60px; line-height:60px; text-align:center'>商品地址：<input type='text' name='proUrl' value=''></div><div style='width: 300px; height:60px; line-height:60px; text-align:center'>QQ号码：<input name='QQ' type='text' value=''></div><div style='width: 300px; height:60px; line-height:60px; text-align:center'>手机号码：<input type='text' name='phone' value=''></div><input type='hidden' name='oid' value='<?php echo $this->_var['tuoguanod']['oid']; ?>'></form>";
		art.dialog({title:'完善信息', content:contents, fixed:true, lock:true,okValue:'提交', 
			ok: function(){
				$("#form1").submit();
			},
			cancelValue:'取消',
			cancel:{}
		});
	})
	
})
</script>


<?php echo $this->fetch("common/footer"); ?>

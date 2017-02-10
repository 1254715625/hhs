<link rel="stylesheet" type="text/css" href="themes/default/css/weixinindex.css">
<div class="w1190">

        <div class="xgguod" style="width:90%;">
            <ul>
				<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['vals']){ ?>
                <li class="pitem">
                    <a href="javascript:void(0)" target="_blank">
                        <img class="tryimg dbdl lazy" src="<?php echo $this->_var['vals']['aimg']; ?>" data-original="" alt="活动图片加载失败" style="display: block;">
                    </a>
                    <h4>
                        <a href="javascript:void(0)" target="_blank">活动ID : <?php echo $this->_var['vals']['id']; ?></a>
                    </h4>
                    <p>
                        <em class="hqeme">￥<?php echo $this->_var['vals']['goods_price']; ?> </em>&nbsp;&nbsp;
                        <!-- 限量<em class="c_red"> 1</em> 份&nbsp;&nbsp; -->
                        奖励<em class="c_red"> <?php echo $this->_var['vals']['total_points']; ?></em> 刷点
                    </p>

                      <?php if($this->_var['vals']['process'] == 0){ ?>
                        <a href="javascript:void(0)" onclick="weixinment('<?php echo $this->_var['vals']['id']; ?>');" class="freeof" style="background-color: #FF6E02;color: white;">我已投票</a>
                      <?php } ?>
                      <?php if($this->_var['vals']['process'] == 1 || $this->_var['vals']['process'] == 2){ ?>
                        <a href="javascript:void(0)"  class="freeof" style="background-color: #CCC;color: white;">等待确认</a>
                      <?php } ?>
                </li>
                <?php } ?>
                              
   
        </div>
    </div>
</div>


<div id="insert-before"></div>
		<div id="page"><span style="padding-left:20px;">本页合计金额：金额:<span class="orange"><?php echo $this->_var['page_amount']; ?></span>元，刷点:<span class="orange"><?php echo $this->_var['page_mai']; ?></span>个；未完成金额:<span class="orange"><?php echo $this->_var['page_wamount']; ?></span>元，未完成刷点:<span class="orange"><?php echo $this->_var['page_wmai']; ?></span>个，待付款任务金额：<span style="color:blue;"><?php echo $this->_var['page_wfu']; ?></span>元</span><?php echo $this->_var['array']['pagestr']; ?></div>
</div>
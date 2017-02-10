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
                        限量<em class="c_red"> 1</em> 份&nbsp;&nbsp;
                        奖励<em class="c_red"> <?php echo $this->_var['vals']['total_points']; ?></em> 刷点
                    </p>

                      
                        <a href="javascript:void(0)" onclick="weixinqiang('<?php echo $this->_var['vals']['id']; ?>');" class="freeof" style="background-color: #FF6E02;color: white;">抢此任务</a>
                </li>
                <?php } ?>
                              
   
        </div>
    </div>
</div>

<div class="rwdt_dlm">
			<a href="bbs.php" target="_blank" class="tico rwdt_tbhelp"></a>
			<div id="page"><?php echo $this->_var['page']; ?></div>
</div>
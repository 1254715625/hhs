<?php echo $this->fetch("common/header"); ?>
<style type="text/css">
.app-focus {height: 342px;background: url(themes/default/images/platform/focus-bg.jpg) repeat-x;}
.g-layout, .xf-layout { width: 960px;margin-left: auto;margin-right: auto;}
.app-focus-bann { overflow: hidden;position: relative;width: 100%;height: 100%;}
.app-focus-bann-btn { display: block;overflow: hidden;position: absolute;left: 0;top: 234px;width: 205px;height: 70px;background: url(themes/default/images/platform/focus-bann-btn.png) no-repeat;line-height: 999px;}
.app-focus-bann-btn:hover { background-position: 0 -70px;}
.app-section-title1, .app-section-title2 { overflow: hidden;width: 100%;height: 52px;margin: 25px 0 20px;background: url(themes/default/images/platform/section-title.png) no-repeat center top;line-height: 999px;}
.app-bricks-list { overflow: hidden;width: 960px;/*height: 360px;*/}
.app-bricks-list ul { overflow: hidden;width: 100%;height: 100%;}
.app-bricks-list li { overflow: hidden;position: relative;float: left;width: 240px;height: 180px;cursor: default;}
.app-bricks-list li .num { display: block;overflow: hidden;position: absolute;z-index: 1;left: 0;top: 0;width: 30px;height: 30px;text-align: center;background: #5C5C5C;font: 18px/30px Arial;color: #FFF;}
.app-bricks-list dl { overflow: hidden;position: relative;width: 100%;height: 100%;}
.app-bricks-list dt, .app-bricks-list dd { display: block;overflow: hidden;position: absolute;left: 0;width: 240px;height: 180px;margin: 0;padding: 0;background: #5C5C5C;}
.app-bricks-list dd { display: none;color: #FFF;}
.app-bricks-list dd h3 { overflow: hidden;width: 196px;margin: 0 auto;font: 20px/50px Arial,微软雅黑;text-align: center;color: #FFF;}
.app-bricks-list dd p { overflow: hidden;width: 196px;height: 50px;margin: 0 auto 10px;line-height: 25px;}
.app-bricks-list dd .act { padding: 10px 0;font-size: 14px;font-family: Arial,微软雅黑;text-align: center;}
.app-bricks-list dd .act .price { display: inline-block;margin-right: 4px;font-size: 16px;color: #EF4610;}
.app-bricks-list dd .act .btn { display: inline-block;vertical-align: middle;width: 90px;background: #02B606;height: 38px;border-radius: 2px;line-height: 38px;text-decoration: none;color: #FFF;}
.app-section-title2 { background-position: 0 -52px;}
</style>
 
<div class="p-content content-app">
    <div class="app-focus">
        <div class="g-layout">
            <div class="app-focus-bann">
                
				<img src="<?php echo $this->_var['picture']['value']; ?>" width="960" height="342" alt="淘宝助手APP" style="display: block; width: 100%; height: 100%; border: 0;">
                <a class="app-focus-bann-btn" href="http://789gude.gotoip1.com/soft/DamaihuApp.exe">下载淘宝助手APP</a>
            </div>
        </div>
    </div>
    <div class="g-layout">
        <h2 class="app-section-title1">内含软件</h2>
        <div class="app-bricks-list">
            <ul>
				<?php if($this->_var['downs'])foreach($this->_var['downs'] as $this->_var['key'] => $this->_var['item']){ ?>
                <li>
                    <i class="num">0<?php echo $this->_var['item']['key']; ?></i>
                    <dl class="item">
                        <dt style="display: block;"><img src="<?php echo $this->_var['item']['img']; ?>" width="240" height="180"></dt>
                        <dd style="display: none;">
                            <h3><?php echo $this->_var['item']['title']; ?></h3>
                            <p><?php echo $this->_var['item']['intro']; ?></p>
                            <div class="act">
                                <a val="1" class="btn subBuy" href="<?php echo $this->_var['item']['file_path']; ?>" target="_blank">立即下载</a>
                            </div>
                        </dd>
                    </dl>
                </li>
				<?php } ?>
            </ul>
        </div>
    </div>
</div>
<script language="JavaScript" type="text/javascript">
$(function(){
		$('.app-bricks-list').find('li').hover(function(){
            $(this).find('dt').stop(false,true).fadeOut(200).siblings('dd').stop(false,true).fadeIn(200);
        },function(){
            $(this).find('dd').stop(false,true).fadeOut(200).siblings('dt').stop(false,true).fadeIn(200);
        });
	});
</script>
<?php echo $this->fetch("common/footer"); ?>
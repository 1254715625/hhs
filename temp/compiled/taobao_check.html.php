<div class="tips-lailu" style="width:550px"><div id="tits" name="1">
		接手方需要完成下列来路步骤后方能查看商品网址
</div>
<table class="tbl" border="0" cellpadding="6" cellspacing="0" width="100%" style="display:nones;">
	<tbody>
		<tr>
			<td class="f_b_green" align="right" valign="top" width="80" style="color: rgb(0, 163, 255);">第一步：</td>
			<td>
			请在淘宝首页搜索<?php if($this->_var['info']['task_other']['visitWay'] == 1){ ?>店铺<?php }else{ ?>宝贝<?php } ?>：
			<strong><?php echo $this->_var['info']['nickname']; ?></strong>　
			</td>
		</tr>
		<tr>
		  <td class="f_b_green" align="right" valign="top" style="color: rgb(0, 163, 255);">第二步：</td>
		  <td>根据搜索提示打开搜索结果列表为：<strong class="orange"><?php echo $this->_var['info']['task_other']['txtDes']; ?></strong>的商品</td>
		</tr>

		<tr>
		  <td class="f_b_green" align="right" valign="top" style="color: rgb(0, 163, 255);">第三步：</td>
		  <td>复制商品页面地址栏的地址，并黏贴到下面, 然后点击【验证商品】按钮；<span class="f_b_red"></span></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>
				<input id="goodsurl" value="" style="width:400px" type="text"> 
				<input id="verifyGoods" ids="<?php echo $this->_var['info']['id']; ?>" onclick="(function(){
					var url=$('#goodsurl').val();
					var ids=$('#verifyGoods').attr('ids');
					$.post('?mod=istrueurl',{data:url,id:ids},function(backdata){
						if(backdata==1){
							$('input[name=goodsurl]').val($('#goodsurl').val());
							alert('验证成功');
						}else{
							alert('验证失败');
						}
					});
				})()" value="验证商品" type="button">
				<span id="suess" style="color: rgb(51, 197, 15);margin-left: 5px;"></span>
			</td>
		</tr>

		<tr>
			<td style="color: rgb(55, 128, 36);" class="f_b_green" align="right" valign="top">搜索提示：</td>
			<td style="color: rgb(55, 128, 36);"><?php echo $this->_var['info']['task_other']['txtSearchDes']; ?></td>
		</tr>

		<tr>
			<td class="f_b_green" align="right" valign="top">截图提示：</td>
			<td>
				<?php if($this->_var['info']['task_other']['PhotoUrl']){ ?><a href="http://hhs.lianmon.com<?php echo $this->_var['info']['task_other']['PhotoUrl']; ?>" target="_blank">点击查看图片</a><?php }else{ ?>无<?php } ?>
			</td>
		</tr>
		<?php if($this->_var['info']['attrs']['shopBrGoods']){ ?>
		<tr>
				<td align="right" class="f_b_green" valign="top">商品浏览：</td>
				<td>
					<span class="lxnum" style="color: rgb(254, 85, 0);">此任务需要额外浏览该店内其他 <b><?php echo $this->_var['info']['attrs']['lgoods']; ?></b>件商品，浏览后进行截图。</span>
				</td>
			</tr>
			<tr>
		     	<td align="right" class="f_14" valign="top">上传截图：</td>
		      	<td valign="top">
					<script id="container" name="content" type="text/plain"></script>
					<textarea name="remark" id="topimages-editor" style="width: 447px; display: none; heigth: 300px;"></textarea>
				</td>
		    </tr>
		<?php } ?>
		
	</tbody>
	<input type="hidden" name="goodsurl" value="0">
</table>
<div style="padding:20px 20px 10px 20px; color:#F00; font-weight:bold;">注意：请接手人一定在通过验证商品后再淘宝拍下与支付，否则将无法继续任务得到任务保证金！</div>
</div>
<script type="text/javascript">
var ue = UE.getEditor('container',{
		initialFrameWidth:440,
		initialFrameHeight:150,
		elementPathEnabled:false,
		wordCount:false,
		zIndex :9999,
		toolbars: [
			.bold', 'italic', 'underline', 'forecolor', 'simpleupload', 'snapscreen', 'emotion', 'undo', 'redo', 'unlink', 'link', 'source', 'backcolor', 'fullscreen
		],
	});

$(function(){
	$("#verifyGoods").click(function(){
		var goodsurl = $('#goodsurl').val();
		console.log(goodsurl)
		if (goodsurl==''){
			//art.dialog({id:'temp-info',title : '温馨提示',content :'商品URL不能为空',okValue : "确定",ok : function(){return true;},lock : true});
			return false;
		}
		$.getJSON('taobao.php?mod=shopurl',{'url':goodsurl,'id':<?php echo $this->_var['info']['id']; ?>},function(data){
			if(data.error){
				art.dialog({id:'temp-infos',title : '温馨提示',content :data.error,okValue : "确定",ok : function(){return true;},lock : true});
			}else if(data.info){
				$("#goodsurl").attr("readonly",true);
				$("#suess").html(data.info);
			}			
		});
	});
});
</script>
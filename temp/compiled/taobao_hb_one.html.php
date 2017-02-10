<div class="tips-lailu" style="width:550px"><div id="tits">
		该任务属于商品来路任务，且需要接手方<span style="color:Red;">货比1家</span>后才能验证商品来路&nbsp;&nbsp;&nbsp;&nbsp;<a class="jdlink" href="help.php">帮助教程</a>
</div>
<div id="hbsj">

<p style="color: #fe5500;margin-top: 10px;font-size: 13px;">货比第1家商品</p>
<table class="tbl" border="0" cellpadding="6" cellspacing="0" width="100%" style="border: 1px solid #ddd;">
	<tbody><tr>
		<td class="f_b_green" align="right" valign="top" width="80" style="color: rgb(0, 163, 255);">第一步：</td>
		<td>
	    请在淘宝首页搜索<?php if($this->_var['info']['task_other']['visitWay'] == 1){ ?>店铺<?php }else{ ?>宝贝<?php } ?>：
		<strong><?php echo $this->_var['info']['task_other']['txtDes']; ?></strong>　
		</td>
	</tr>
	<tr>
	  <td class="f_b_green" align="right" valign="top" style="color: rgb(0, 163, 255);">第二步：</td>
	  <td>根据搜索提示打开搜索结果列表其中一个商品</td>
	</tr>
	<tr>
		<td class="f_b_green" align="right" valign="top" style="color: rgb(0, 163, 255);">第三步：</td>
		<td><div class="uploadImgs">
			<input class="url-upfile" type="text" readonly style="width:206px;height:20px" maxlength="150" alt="1">
			<span class="uploadImg"><input type="hidden" name="id" value="<?php echo $this->_var['info']['id']; ?>"><input type="hidden" name="contrast" value="1">
		        <input size="24" type="file" name="file" class="file" id="upfile-1" style="margin-top:0px;margin-left:-215px;width: 350px;">    
		        <input type="button" class="button" value="上传货比商品的截图">
		        <a href="javascript:;" class="bzliu">上传帮助</a>
		      </span>
		      <span id="info-upfile-1" class="green" style="float:left;"></span>
			  </div>
		</td>
	</tr>

	<tr>
		<td style="color: rgb(55, 128, 36);" class="f_b_green" align="right" valign="top">搜索提示：</td>
		<td style="color: rgb(55, 128, 36);">请不要上传重复的商品地址截图和掌柜名为<span style="color:#F00; font-weight:bold;margin:0 2px;"><?php echo $this->_var['info']['nickname']; ?></span>的商品</td>
	</tr>
</tbody></table>
</div>
<div style="padding:20px 20px 10px 20px; color:#F00; font-weight:bold;">注意：请接手人一定在通过验证商品后再淘宝拍下与支付，否则将无法继续任务得到任务保证金！</div></div>
<script type="text/javascript">
$(function () {
	$(".uploadImgs").wrap("<form class='myupload' action='?mod=hbfile' method='post' enctype='multipart/form-data'></form>");
    $(".file").change(function(){
		var self=$(this);
		var green=self.parents(".uploadImg").siblings('.green');
		self.parents(".myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		var percentVal = '0%';
        		green.html("上传中，已完成"+percentVal);
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		green.html("上传中，已完成"+percentComplete+"%");
    		},
			success: function(data){
				if(data&&data.pic!=''){
					var img = "uploads/task/"+data.pic;
					self.parents(".uploadImg").siblings('.url-upfile').val("http://www.haohuisua.com/"+img);
					green.html("上传成功&nbsp;<a href='"+img+"' target='_blank'>查看</a>");
				}else{
					self.parents(".uploadImg").siblings('.url-upfile').val('');
					green.html(data);
				}
			},
			error:function(data){
				self.parents(".uploadImg").siblings('.url-upfile').val('');
				green.html("上传失败&nbsp;"+data.responseText);
			}
		});
	});
});
</script>
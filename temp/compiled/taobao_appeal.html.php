<link rel="stylesheet" type="text/css" href="themes/default/css/twitter.css" />
<link rel="stylesheet" type="text/css" href="themes/default/css/main.css" />
<script type="text/javascript" src="themes/default/js/ueditor/third-party/jquery-1.10.2.js"></script>
<form method="post" name="appeal" id="appeal" onsubmit="return false;">
<input type="hidden" name="id" value="<?php echo $this->_var['list']['id']; ?>">
<style>
*{font-size:10px;}
</style>
<div style="">
<div class="tip_gun" style="font-size: 13px;color: #F00;">1，双方沟通无果或无法继续任务时，您可以任务投诉；<br>
2，认真选择投诉类型，并附带完整网店交易截图，越详细越早处理。（不必提交平台截图）；<br>
3，根据反映的真实描述截图，投诉会在48小时内处理，如果投诉情况不符不详细，将撤销本次投诉。<br>
</div>

  <table border="0" cellspacing="0" cellpadding="2" style="">
    <tbody style=""><tr>
      <td width="100" align="right" class="f_14">被投诉人：</td>
      <td><input name="member" type="text" disabled="disabled" class="text_normal" id="member" value="<?php echo $this->_var['list']['respondent']; ?>">
				<input name="plat" type="text" disabled="disabled" class="text_normal" id="plat" value="淘宝互动区"></td>
    </tr>
    <tr>
      <td align="right" class="f_14">任务ID：</td>
      <td><input name="taskId" type="text" disabled="disabled" class="text_normal" id="textfield3" value="TB<?php echo $this->_var['list']['id']; ?>">
				<span class="f_b_red">[注意]申诉人必须在下面的描述中上传申诉涉及淘宝交易的淘宝交易状态截图！否则将申诉将不能被受理！</span></td>
    </tr>
    <tr>
      <td align="right" class="f_14">投诉类别：</td>
      <td valign="top">
        <select name="info" id="explain-title">
			<option value="">请选择申诉的类型</option>
          	<option value="投诉发布方：我已确认收货，发布方平台不最后确认！">投诉发布方：我已确认收货，发布方平台不最后确认！</option>
            <option value="投诉发布方：平台收货时间到了，发布方淘宝还没有发货！">投诉发布方：平台收货时间到了，发布方淘宝还没有发货！</option>
            <option value="投诉发布方：淘宝到时间收货了，发布方平台还没有点击发货！">投诉发布方：淘宝到时间收货了，发布方平台还没有点击发货！</option>
            <option value="投诉发布方：任何双方协商一致关闭淘宝交易，申请取消任务！">投诉发布方：任何双方协商一致关闭淘宝交易，申请取消任务！</option>
          
        </select><br>（请选择申诉的类型）
      </td>
    </tr>
    <tr style="">
      <td align="right" valign="top" class="f_14">投诉详细描述：</td>
      <td valign="top" style="">
		<script type="text/javascript" charset="utf-8" src="themes/default/js/ueditor/ueditor.config.js"></script> 
		<script type="text/javascript" src="themes/default/js/ueditor/ueditor.all.js" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8" src="ueditor143/lang/zh-cn/zh-cn.js"></script>
		<script id="container" name="content" type="text/plain" style="width:95%; height:360px;" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			var ue = UE.getEditor('container', {
				toolbars: [
					['bold', 'italic', 'underline', 'forecolor', 'simpleupload', 'snapscreen','emotion','undo','redo','unlink','link','source','backcolor','fullscreen']
				],
				autoHeightEnabled: true,
				autoFloatEnabled: true,
				initialFrameWidth:447,
				initialFrameHeight:120,
				elementPathEnabled:false,
				wordCount:false,
				charset:"utf-8"
			});
			ue.ready(function(){
				ue.focus();
			})
		</script>
	<script type="text/javascript" charset="utf-8">
	function imgcheck(){
		var con=ue.getContent();
		if(con.indexOf("<img")<0){
			return 0;
		}
		return con;
	}
	</script>
	  </td>
    </tr>
  </tbody>
</table></div>
</form>
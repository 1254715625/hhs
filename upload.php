<?php
require 'mcscore/init.php';

$payment=isset($_REQUEST['payment'])?intval($_REQUEST['payment']):0;//点击已付款
if($payment){
	$this_attr=$db->getField("mcs_task_taobao a,mcs_member_bindacc b","attrs","a.id=$payment and a.get_user=b.id and b.uid=$uinfo[user_id] and a.process=0");
	if($this_attr){
		$this_attr=unserialize($this_attr);
		if($this_attr['isViewEnd']==1){
		
?>
<meta charset="utf-8">
<style type="text/css">
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
.progress { position:relative; margin-left:100px; margin-top:-24px; width:200px;padding: 1px; border-radius:3px; display:none}
.bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
.files{height:22px; line-height:22px; margin:10px 0}
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<script type="text/javascript" src="themes/default/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="themes/default/js/jquery.form.js"></script>
<div class="demo">
	<div class="btn">
		<span>添加附件</span>
		<input id="fileupload" type="file" name="mypic">
		<input type="hidden" name="has" id="has" value="0">
	</div>
	<div class="progress">
		<span class="bar"></span><span class="percent">0%</span >
	</div>
	<div class="files"></div>
	<div id="showimg"></div>
</div>
<script type="text/javascript">
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$(".demo").wrap("<form id='myupload' action='action.php?payment=<?php echo $payment;?>' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.empty();
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				btn.html("上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal)
        		percent.html(percentVal);
    		},
			success: function(data) {
				var img = "uploads/task/"+data.pic;
				showimg.html("<a href='"+img+"' target='_blank'>查看原图</a>");
				btn.html("上传成功");
				$("#fileupload").hide();
				$("#has").val('1');
				files.html("<b>"+data.name+"("+data.size+"k)</b>");
			},
			error:function(xhr){
				btn.html("上传失败");
				$("#has").val('0');
				bar.width('0')
				files.html(xhr.responseText);
			}
		});
	});
});
</script>
<?PHP
	}}
}
?>
<script type="text/javascript" charset="utf-8" src="themes/default/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="themes/default/js/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="themes/default/js/ueditor/lang/zh-cn/zh-cn.js"></script>
<form method="post" action="user.php?mod=complaint">
<input type="hidden" name="see" value="2">
<script id="editor" type="text/plain" name="info"></script>
</form>
<script type="text/javascript">
   var ue = UE.getEditor('editor', {
		toolbars: [
			['bold', 'italic', 'underline', 'forecolor', 'simpleupload', 'snapscreen','emotion','undo','redo','unlink','link','source','backcolor','fullscreen']
		],
		autoHeightEnabled: true,
		autoFloatEnabled: true,
		initialFrameWidth:490,
		initialFrameHeight:120,
		elementPathEnabled:false,
		wordCount:false
	});
	ue.ready(function(){
		ue.focus();
	});
function check(){
	var con=ue.getContent();
	return con;
}
</script>
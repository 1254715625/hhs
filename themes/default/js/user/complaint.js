$(function(){
	$(".rw_btn").click(function(){
		var id=$(this).attr("state");
		if(id){
			cakan(id);
		}
	});
});
function cakan(obj){
	if(obj){
		$.get('user.php?act=complaint&see='+obj, function(data, status){
			shows(obj,data);
		});
	}
}
function shows(obj,infos){
	art.dialog({title : '申诉中心（申诉详细）',
	  content : infos,
	  okValue : "追加内容",
	  ok : function(){
			var info=con.window.check();
			if(info.length<15){
				var x=art.dialog({title : '提示',content : '追加内容不能小于15个字符~', lock: true});
				win.show();
			}else{
				$.post('user.php?act=complaint&see='+obj,{'info':info},function(data, status){
					  art.dialog({title : '提示',content : '您的申诉追加提交成功~<br>如提交资料不够完善，请尽快补充，越完善您的投诉将越早处理。', lock: true});
				});
			}
	  },
	  lock : true});
}
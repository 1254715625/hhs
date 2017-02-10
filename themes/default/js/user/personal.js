$(function(){
	$(".delete_mes").click(function(){
		$("input[name='set']").val('delete_mes');
		art.dialog({
			title: '提示：',
			content: "<div style='width:220px;font-size:14px'>您确定要删除本页面所选消息吗？</div>",
			fixed: true,
			lock:true,
			okValue : "确定",
			cancelValue:"取消",
			ok: function(){ 
				$("form").submit();
			},
			cancel: function(){
				return true;
			}
		});

	});

	$(".read_mes").click(function(){
		$("input[name='set']").val('read_mes');
		if($("input[type='checkbox']:checked").val()){
			$("form").submit();
		}else{
			art.dialog({title: '提示',content: '请选择~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
	});

	$(".no_mes").click(function(){
		$("input[name='set']").val('no_mes');
		if($("input[type='checkbox']:checked").val()){
			$("form").submit();
		}else{
			art.dialog({title: '提示',content: '请选择~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
	});

	$(".readAll_mes").click(function(){
		$("input[name='set']").val('readAll_mes');
			art.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>您确定要全部设为已读吗？</div>",
					fixed: true,
					lock:true,
					okValue : "确定",
					cancelValue:"取消",
					ok: function(){ 
						$("form").submit();
					},
					cancel: function(){
						return true;
					}
		});
	});

	$(".noAll_mes").click(function(){
		$("input[name='set']").val('noAll_mes');
			art.dialog({
					title: '提示：',
					content: "<div style='width:150px;font-size:14px'>您确定要全部设为未读吗？</div>",
					fixed: true,
					lock:true,
					okValue : "确定",
					cancelValue:"取消",
					ok: function(){ 
						$("form").submit();
					},
					cancel: function(){
						return true;
					}
		});
	});

	$(".All_mes").click(function(){
		 $("input[name='msg[]']:checkbox").each(function () {  
			$(this).attr("checked", !$(this).attr("checked"));  
		 });  
	});
	
	$(".msgDetailed").click(function(){
		var id=$(this).attr("cont");
		$("input[name='set']").val('getinfo');
		$.post("user.php?act=personal", {"cid":id,"set":'getinfo'},     
		   function (data, textStatus){  
					art.dialog({
						id:'dialogue',
						title: '对话消息',
						content: data,
						fixed: true,
						lock:true,
						okValue : "确定",
						ok: function(){
							location.reload();
						}
					});

		   }, "text");
	});

	$(".text_normal").blur(function(){
		var uname=$(".text_normal").val();
		$("input[name='set']").val('hasuser');
		$.post("user.php?act=personal&opt=myRest", {"uname":uname,"set":"hasuser"},     
		   function (data, textStatus){ 
				if(data>0){
					$(".error").hide();
					$(".real").show(200);
					$("input[name='uid']").val(data);
				}else{
					$(".real").hide();
					$(".error").show(200);
					$("input[name='uid']").val('');
				}
		});
	});
	
	$("#message").click(function(){
		var uname=$(".text_normal").val();
		$("input[name='set']").val('hasuser');
		if(uname){$.post("user.php?act=personal&opt=myRest", {"uname":uname,"set":"hasuser"},     
		   function (data, textStatus){ 
				if(data>0){
					$(".error").hide();
					$(".real").show(200);
					$("input[name='uid']").val(data);
				}else{
					$(".real").hide();
					$(".error").show(200);
					$("input[name='uid']").val('');
				}
		});}
	});
});
function getinfos(obj){
	var page,cid;
	if(obj){page=obj.page,cid=obj.cid;}
	$.post("user.php?act=personal", {"cid":cid,"set":'getinfo','page':page},     
	   function (data, textStatus){  
		art.dialog.get('dialogue').close();
				art.dialog({
					id:'dialogue',
					title: '对话消息',
					content: data,
					fixed: true,
					lock:true,
					okValue : "确定",
					ok: function(){
						location.reload();
					}
				});

	   }, "text");
}
$(function(){
	$("form").submit(function(){
		var self =this;
		var truname = $("#formShenhe input[name='real[truname]']").val();
		var ident = $("#formShenhe input[name='real[ident]']").val();
		var upfile1 = $("#formShenhe #upfile1").val();
		var upfile2 = $("#formShenhe #upfile2").val();
		var upfile3 = $("#formShenhe #upfile3").val();

		var check = $("#isAgree:checked").val();
		if(!check){
			$.dialog({id:'ident',title: '提示',content: '阅读并同意好会刷加V认证协议~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(truname==''){
			$.dialog({id:'ident',title: '提示',content: '请填写真实姓名~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(/^[1-9]{1}\d{14}$|^[1-9]{1}\d{13}(\d|X|x)$|^[1-9]{1}\d{17}$|^[1-9]{1}\d{16}(\d|X|x)$/.test(ident) == false){
			$.dialog({id:'ident',title: '提示',content: '身份证号格式不正确，请重新输入~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(upfile1==''){
			$.dialog({id:'upfile',title: '提示',content: '请上传身份证正面~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(upfile2==''){
			$.dialog({id:'upfile',title: '提示',content: '请上传身份证反面~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
		if(upfile3==''){
			$.dialog({id:'upfile',title: '提示',content: '请上传清晰生活照~',fixed: true,lock: true,cancelValue: '确定',cancel: function () { return true;}});return false;
		}
	});
	$(".button").click(function(){
		$.dialog({id:"ajaxStart",title: '正在处理中..',fixed: true,lock: true});
		$.post('user.php?act=userinfo&opt=authname',function(data){
			$.dialog.get('ajaxStart').close();
			if(data.reload){
				location.reload();
			}else{
				$.dialog({title: '提示',content: data.info,fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
			}
			return false;
		},'json');
	});
	$("input.file").change(function(){
		$(this).parent('span.uploadImg').prev('input.text_normal').val($(this).val());
	});
});


$(function(){
	var hdfot_top = $.cookie('hdfot_top');
	if(hdfot_top == 1){
		$(".hdfot").hide();
		$(".hdfots").show();
		$(".bw").hide();
	}
	$(".hdfot").click(function(){
		var hdfot_top = $.cookie('hdfot_top');
		if(hdfot_top != 1){
			$.cookie('hdfot_top', '1', { expires: 1 });
		}
		$(".hdfot").hide();
		$(".hdfots").show();
		$(".bw").slideUp("slow");
	});
	$(".hdfots").click(function(){
		var hdfot_top = $.cookie('hdfot_top');
		if(hdfot_top != 0){
			$.cookie('hdfot_top', '0', { expires: 1 });
		}
		$(".hdfots").hide();
		$(".hdfot").show();
		$(".bw").slideDown("slow");
	});

	$(".sub_bt a").mouseover(function(){
		var v;
		$('.sub_bt a').removeClass('nov');
		v = $(this).addClass('nov').attr('val');
		$('.task_header').hide().eq(v).show();
	});

	$('.fb_btn').click(function(){	
		location.href = "taobao.php?mod=addTask";
	});
	
	$('#addSeller').click(function(){
		var nickname = $('#nickName').val();
		if(nickname == '')
		{
			alert('请输入您要绑定的掌柜名称');
			return false;
		}else if(nickname.indexOf('输入旺旺名称')>=0){
			$('#nickName').val('');
			$('#nickName').focus();
			return false;
		}else{
			var win = $.dialog({content : '正在查询，请稍候...',lock : true});
			$.get('?mod=bindacc&type=seller&nickname='+nickname, function(data, suatus){
				if(data == 'ok')
				{
					$.get('?mod=getaccount&type=seller', function(data, suatus){
						$('.sellerdiv').html(data);
					});
					alert('绑定成功~');	
					$('#nickName').val('');
				}
				else
				{
					alert(data);
				}			
				win.close();
			});
		}
	});

	$('.bindBuyer').click(function(){
		var nickname = $('#nickName').val();
		if(nickname == '')
		{
			alert('请输入您要绑定的买号名称');
			return false;
		}else if(nickname.indexOf('输入旺旺名称')>=0){
			$('#nickName').val('');
			$('#nickName').focus();
			return false;
		}

		var win = $.dialog({content : '正在查询，请稍候...',lock : true});

		$.get('?mod=bindacc&type=Buyer&nickname='+nickname, function(data, suatus){
			if(data == 'ok')
			{
				$.get('?mod=getaccount&type=Buyer', function(data, suatus){
					$('.sellerdiv').html(data);
				});
				alert('绑定成功~');	
				$('#nickName').val('');
			}
			else
			{
				alert(data);
			}			
			win.close();
		})
	});

	$("#rshop").click(function(){
		$("#divkey").html('搜索店铺关键字');
		$("#divkeytip").html('请输入您的“店铺名称”或者“掌柜名称”，要确保接手人在淘宝店铺搜索中正确并且唯一能搜索到您的店铺。');
		$("#divdes").html('店铺搜索提示');
		$("#divdestip").html('请输入提示信息，说明店铺在淘宝搜索结果列表中的位置，商品在店铺首页中的大概位置等等，例如：店铺在搜索结果第二个，商品在店铺首页第二排第一个');
	});

	$("#rgoods").click(function(){
		$("#divkey").html('搜索商品关键字');
		$("#divkeytip").html('请输入能够在淘宝搜索中搜索到您商品的关键字，平台推荐使用商品全名，如果您商品在淘宝中重名过多，建议先修改商品名或者使用搜店铺的方式设置来路');
		$("#divdes").html('商品搜索提示');
		$("#divdestip").html('请输入搜索提示信息，说明商品在淘宝搜索结果列表中的位置，例如：搜索结果第一页第三个。');
	});
	
	$("#rcredits").click(function(){
		$("#divkey").html('买家信用评价地址');
		$("#divkeytip").html('输入已经购买过您的该任务宝贝的买家信用评价页面地址，可以在您的宝贝销售记录中点击买家用户名右侧的信用等级图标（如红心，黄钻等）进入获得地址。');
		$("#divdes").html('来路提示');
		$("#divdestip").html('请输入提示信息，说明店铺在淘宝搜索结果列表中的位置，商品在店铺首页中的大概位置等等，例如：店铺在搜索结果第二个，商品在店铺首页第二排第一个');
	});

	$("#rtrains").click(function(){
		$("#divkey").html('搜索宝贝关键字');
		$("#divkeytip").html('推荐使用您的宝贝名称，如果您的宝贝名称在淘宝中重名商品过多，我们建议您在宝贝名称后面增加个唯一性字符或编号等信息。');
		$("#divdes").html('搜索提示');
		$("#divdestip").html('请输入提示信息，说明店铺在淘宝搜索结果列表中的位置，商品在店铺首页中的大概位置等等，例如：店铺在搜索结果第二个，商品在店铺首页第二排第一个');
	});
	
	

	$(".rwdt_marquee_close").click(function(){
		$(".rwdt_marquee_close").hide();
		$(".rwdt_marquee").hide();
	});

	$("#kuzhan").mouseover(function(){
		$("#kuzhan .services").show();
	});
	$("#kuzhan").mouseout(function(){
		$("#kuzhan .services").hide();
	});
	$(window).scroll( function() {
		if($(document).scrollTop() > 0){
			$("#m_top #kuzhan").height(152).find(".rtop").show();
		}else{
			$("#m_top #kuzhan").height(130).find(".rtop").hide();
		}
	});
	$("#m_top #kuzhan .rtop").click(function(){
		$("html, body").animate({ scrollTop: 0 }, 120);
	});
});
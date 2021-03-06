<!DOCTYPE html>
<html>
<head>
<title>好会刷网站管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="template/css/common.css">
<link rel="stylesheet" type="text/css" href="template/css/index.css">
<link rel="stylesheet" type="text/css" href="template/css/twitter.css">
<link rel="stylesheet" type="text/css" href="template/css/easyscroll.css">
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/artDialog.js"></script>
<script type="text/javascript" src="template/js/easyscroll.js"></script>
<script type="text/javascript" src="template/js/mousewheel.js"></script>
</head>
<body style="overflow-y:hidden;">
<div id="header">
	<!--div class="helpnav">
			锁屏|授权|支持论坛|帮助？
	</div-->
	<div class="logo"></div>
	<div class="loginfo">
		<div class="info-t">
			您好！<?php echo $_SESSION['user_name']."&nbsp;&nbsp;".$_SESSION['role']?>  | <a href="privilege.php?act=logout" style="color:#fff"> 退出</a> | <a href="../index.php" target="_blank" style="color:#fff"> 站点首页</a><!--| 会员中心| 搜索-->
		</div>
		<ul class="topnav clearfix">
			<?php if($this->_var['nav'])foreach($this->_var['nav'] as $this->_var['k'] => $this->_var['v']){ ?>
			<li class="<?php if($this->_var['k'] == 'setting'){ ?>sel<?php } ?>" data="<?php echo $this->_var['k']; ?>">
				<a data-id="<?php echo $this->_var['v']['id']; ?>"href="javascript:;"><?php echo $this->_var['v']['name']; ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
<div id="content" class="clearfix">
	<div id="mlbox" class="menus"></div>
	<div id="mrbox">
		<iframe name="rightFrame" id="rightFrame" src="index.php?act=main" frameborder="false" scrolling="auto" width="100%" height="100%" allowtransparency="true"></iframe>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		getMenus(1,"网站设置","setting");
		$(".topnav li a").click(function(){
			var id = $(this).attr("data-id");
			var title = $(this).text();
			var classes = $(this).parent().attr("data");
			getMenus(id,title,classes);
		});
		
		function getMenus(id,title,classes){
			var htmls = "";
			$.ajax({
				type:"post",
				url:"menu.php?act=get_menu",
				data:"id="+id,
				dataType:"json",
				success:function(data){
					//console.log(data);
					htmls += '<div class="div_scroll"><div id="'+classes+'" ><h3>'+title+'</h3><ul>'; 
					for(var i=0; i<data.length; i++){
						htmls += '<li><a href="'+data[i]["method"]+'" target="rightFrame">'+data[i]["name"]+'</a></li>'
					}
					htmls += '</ul></div></div>';
					$("#mlbox").html(htmls);
					$(".menus a").eq(0).addClass("sel");
					$("#rightFrame").attr("src",$(".menus a").eq(0).attr("href"));
					$("#mlbox li a").click(function(){
						$(".menus a").removeClass("sel");
						$(this).addClass("sel");
						setWinSize();
					});
					//__EasyScroll();
				}
			})
		}
		setWinSize();
		$(window).resize(setWinSize);
		
		$("ul.topnav li").click(function(){
			$(this).addClass("sel").siblings('li.sel').removeClass("sel");
			var data=$(this).attr('data');
			if(data){
				$('#mlbox div').hide();
				$('#mlbox #'+data).show();
				var href=$('#mlbox #'+data+' li:first a').attr('href');
				$('#mlbox #'+data+' li:first a').click();
				$("#rightFrame").attr('src',href);
			}
		}); 
	});

	function setWinSize(){
		var w = $(window).width();
		var h = $(window).height();	
		
		if(w<1000) w = 1000;	
		
		$("#mlbox").height(h - $("#header").height());
		$("#mrbox").height(h - $("#header").height());
		$("body").width(w);
		$("#mrbox").width(w - $("#mlbox").width());
	}

	function __EasyScroll(){
		// 滚动条插件调用
		$('.container2 .div_scroll').scroll_absolute({arrows:false});
	}
</script>
</body>
</html>
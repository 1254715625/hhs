<!DOCTYPE html>
<html>
<head>
<title>好会刷网站管理中心-登录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="template/css/common.css"/>
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<style type="text/css">
	.hhs-wrapper{margin:0 auto;width:1200px;padding-top:120px;}
	.login-box{width:610px;margin:0 auto;}
	.login-box .login-pic{float:left;width:290px;height:60px;margin-top:70px;}
	.login-box .login-pic img{width:100%;height:100%;}
    .login-box .login-form{float:right;}
    .login-box .login-form ul{padding:10px 15px;}
	.login-box .login-form li{height:48px;line-height:48px;position:relative;}
	.login-box .login-form li:first-child{height:52px;line-height:38px;}
	.login-box .login-form li strong{font-size:18px;}
	.login-box .login-form li em{padding:0 10px;}
	.login-box .login-form li span{height:15px;line-height:15px;color:#ff2323;position:absolute;top:43px;left:65px;display:none;}
	.login-box .login-form li label{display:inline-block;width:60px;font-size:14px;color:#333;}
	.login-box .login-form li input.input-txt,.login-box .login-form li input.input-btn{vertical-align:middle;border-radius:3px;}
    .login-box .login-form li input.input-txt{width:156px;height:25px;line-height:25px;border:1px solid #a9a9a9;color:#555;padding:0 5px;background-color:transparent;}
    .login-box .login-form li input.input-txt.error{border:1px solid #ff2323;}
    .login-box .login-form li input.input-btn{background-color:#3399ff;padding:3px 10px;color:#fff;cursor:pointer;font-size:14px;*margin-left:4px;-webkit-transition:all 0.2s linear 0s;-moz-transition:all 0.2s linear 0s;-ms-transition:all 0.2s linear 0s;-o-transition:all 0.2s linear 0s;transition:all 0.2s linear 0s;}
    .login-box .login-form li input.input-btn:hover{background-color:#46acff;}
	.copyright{text-align:center;padding:90px 0;color:#333;}
	.copyright a:hover{color:#333;}
</style>
</head>
<body>
	<div class="hhs-wrapper">
		<div class="login-box clearfix">
			<div class="login-pic">
				<img src="template/images/hhs-logo.png" />
			</div>
			<form action="" method="post" class="login-form" onSubmit="return __checkForm(this);">
				<ul>
					<li><strong>Login<em>|</em>后台管理系统</strong></li>
					<li>
						<label>用户名：</label>
						<input type="text" name="username" class="input-txt"/>
						<span>用户名不能为空！</span>
					</li>
					<li>
						<label>密　码：</label>
						<input type="password" name="password" class="input-txt"/>
						<span>密码不能为空！</span>
					</li>
					<li>
						<label></label>
					    <input type="submit" value="登录" class="input-btn"/>
					</li>
				</ul>
			</form>
		</div>
		<div class="copyright">Powered by <a href="javascript:;">连梦科技</a></div>
		<!-- <div class="copyright">Powered by MCSYS X3.2 &copy; 2001-2013, MingCheng Inc.</div> -->
	</div>
	<script type="text/javascript">
	    if(window.parent != window) window.top.location.href = location.href;
		function __checkForm(form) {
			if(form.username.value == ""){
				form.username.focus();
				$(form).find('input[name="username"]').addClass('error').siblings('span').show();
				return false;
			}
			if(form.password.value == ""){
				form.password.focus();
				$(form).find('input[name="password"]').addClass('error').siblings('span').show();
				return false;
			}
			return true;
		}

		function __errorTips() {
			$('.input-txt').each(function(index,ele) {
				$(ele).blur(function() {
					if($(this).val() == ''){
						$(this).addClass('error').siblings('span').show();
						return false;
					}else{
						$(this).removeClass('error').siblings('span').hide();
					}
				});
			});
		}
		__errorTips();
	</script>
</body>
</html>
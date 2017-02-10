<?php
// if($_GET['code']&&$_GET['state']){
// 	function qqlogin($client_id,$redirect_uri,$state=1){
// 		$url="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&state={$state}&scope=get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr";
// 		echo $url;die;
// 	}
// 	qqlogin("101247368",'http://hhs.lianmon.com');
// }

require 'mcscore/init.php';
if(!empty($_GET['reg'])){
	setcookie("spread_name",$_GET['reg'],time()+3600*24*31,"/",".lianmon.com");
	$_SESSION['extensionuser']=$db->getRow("select uid from mcs_extension where code='".$_GET['reg']."'")['uid'];
}
$_ENV['hostarr'] = explode('.', $_SERVER['HTTP_HOST']);
$_ENV['domainroot'] = substr($_SERVER['HTTP_HOST'], strpos($_SERVER['HTTP_HOST'], '.')+1);
$_ENV['domain'] = root::loadConfig('domain');

$_ENV['curapp'] = $_ENV['hostarr'][0];

if(!array_key_exists($_ENV['curapp'], $_ENV['domain'])) $_ENV['curapp'] = 'home';


header("HTTP/1.1 301 Moved Permanently");
header("location: ". $_ENV['domain'][$_ENV['curapp']]);
//require $_ENV['domain'][$_ENV['curapp']];
?>
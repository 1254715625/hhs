<?php
require 'mcscore/init.php';

switch($action)
{
	case 'video':
		$opt=trim($_GET['opt']);
		switch($opt)
		{
			case 'spread':
				$video='http://player.youku.com/player.php/sid/XMTI1ODk5NTg3Mg==/v.swf';
			break;
			case 'trusteeship':
				$video='http://player.youku.com/player.php/sid/XMTI1ODk5NTg3Mg==/v.swf';
			break;
			case 'get_task':
				$video='http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?max_age=86400&v=20140714';
			break;
			case 'post_task':
				$video='http://player.56.com/v_MTM3NTU0NDg5.swf';
			break;
			case 'chongzhi':
				$video='http://player.youku.com/player.php/sid/XNjc3OTM1MjIw/v.swf';
			break;
			case 'register':
				$video='http://player.youku.com/player.php/sid/XMTI1ODk3Nzk3Ng==/v.swf';
			break;

			default:
				$view->display('help/video-index');exit;
			break;
		}
		$view->assign('opt', $opt);
		$view->assign('video', $video);
        $view->display('help/video');
    break;

	case 'guide':
		$view->display('help/guide');
	break;
	
	case 'taskout':
		$view->display('help/taskout');
	break;
	
	case 'taskin':
		$view->display('help/taskin');
	break;

	case 'security':
		$view->display('help/security');
	break;

	case 'selfservice':
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			if(intval($_POST['action'])==1){
				$username=trim($_POST['username']);
				$mobile=trim($_POST['mobile']);
				if(empty($username)){
					$data['info']='用户名不能为空，请输入~';
				}elseif(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-9])|(?:7[0-9]))\d{8}$/', $mobile)){
					$data['info']='手机号码格式不正确，请重新输入~';
				}else{
					$user=intval($db->getField('mcs_users','user_id','mobile_phone="'.$mobile.'" and user_name="'.$username.'"'));
					if($user){
						$t=time();
						if($_SESSION['time']>$t){
							$data['info']='30分钟之内只能找回一次密码~';
						}else{
							$cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
							$cfgs = unserialize($cfgs);

							require ROOT_PATH . 'mcscore/ccpsms.class.php';		
							$accountSid = $cfgs['accountSid'];	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
							$accountToken = $cfgs['accountToken'];
							$appId = $cfgs['appId'];
							$serverIP = $cfgs['serverIP'];
							$serverPort = $cfgs['serverPort'];
							$softVersion = $cfgs['softVersion'];
							$savetime = $cfgs['savetime'];

							$rest = new REST($serverIP, $serverPort, $softVersion);
							$rest->setAccount($accountSid, $accountToken);
							$rest->setAppId($appId);

							$smscode = mt_rand(100000, 999999);
							//setcookie('smscode', $smscode, time()+$savetime*60);
							$result = $rest->sendTemplateSMS($mobile, array($smscode, $cfgs['savetime']), 5411);
							if($result == null){
								$data['info']='短信发送失败';	
							}else{
								$db->Execute('update mcs_message set state=1 where phone="'.$mobile.'"');
								$db->Execute('insert into mcs_message(phone,code,sendtime) values("'.$mobile.'","'.$smscode.'","'.$t.'")');
								$data['info']='验证码已发送到'.substr_replace($mobile,'****',3,4).'，请注意查收~';
								$_SESSION['selfservice']=$user;
								$_SESSION['time']=time()+1800;
								$data['state']=1;
								$data['uid']=$user;
							}
						}
					}else{
						unset($_SESSION['selfservice']);
						$data['info']='您输入的账户与绑定的手机号码不匹配 若不记得帐号名或者手机号码,请提供相关证据并向客服咨询~~';
					}
				}
			}else{
				$t=time();
				if(($_SESSION['time']-$t)<1500){
					$data['info']='认证信息已过期，请重新获取~';
				}else{
					$code=intval($_POST['code']);
					$qd_newpsd=trim($_POST['qd_newpsd']);
					$usid=intval($_POST['usid']);
					
					if($usid>0&&$_SESSION['selfservice']==$usid){
						$smscode=$db->getRow('select a.code,a.id from mcs_message a,mcs_users b where b.user_id='.$usid.' and a.phone=b.mobile_phone and a.sendtime>'.($t-600).' and a.state=0 order by a.sendtime desc');
						if(empty($code)){
							$data['info']='验证码不能为空，请输入~';
						}elseif(empty($smscode['code'])){
							$data['info']='验证码已过期，请重新发送~';		
						}elseif($code != $smscode['code']){
							$data['info']=$smscode['code'];		
						}else{
							if(strlen($qd_newpsd)<6||strlen($qd_newpsd)>16){
								$data['info']='请输入6~16位密码~';
							}else{
								$newpass=cipherStr($qd_newpsd);
								$sql = "update mcs_users set password = '".$newpass."',questiontype=0,question='' where user_id=".$usid;
								$db->Execute('update mcs_message set state=1 where id='.$smscode['id']);
								if($db->Execute($sql)){
									$data['info']='密码修改成功~';
									$data['state']=1;
								}else{
									$data['info']='密码修改失败，请更换密码~';
								}
							}
						}
					}else{
						$data['info']='您输入的账户信息不匹配,请刷新后重新获取~';
					}
				}
			}
			echo json_encode($data);
			exit;
		}

		$view->display('help/selfservice');
	break;



    default:
        $view->display('help/help');
    break;
}
?>
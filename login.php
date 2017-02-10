<?php
SESSION_START();
$code_key=substr(md5(substr(SESSION_ID(),1,8).'hhsbbs'),1,8);
if($_SERVER['REQUEST_METHOD'] == 'POST'&&$_SERVER['HTTP_HOST']==$_SERVER['SERVER_NAME']&&isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	$data['info']='访问出错~';
	$act=trim($_GET['act']);
	$key=trim($_POST['key']);
	$access_token=authcode($key,'DECODE',$code_key,100);
	if(empty($_SESSION['tencent'][$access_token])){
		$data['info']='访问超时，请重新登陆~';
	}else{
		$code['access_token']=$access_token;
		$code['openid']=$_SESSION['tencent'][$access_token];
		require_once('mcscore/init.php');
		require_once("api/qqConnectAPI.php");
		$qc = new QC();
		$qq['access_token']=$code['access_token'];
		$qq['openid']=$code['openid'];
		$qc = new QC($qq['access_token'],$qq['openid']);
		$arr = $qc->get_user_info();
		switch($act){
			case 'regUserqq':
				$username=trim($_POST['name']);
				$pwd=trim($_POST['pwd']);
				$email=trim($_POST['email']);
				$phone=trim($_POST['phone']);
				$qq=trim($_POST['qq']);
				if(strlen($username)<3){
					$data['info']='用户名不能小于3位~';
				}elseif(strlen($username)>14){
					$data['info']='用户名不能大于14位~';
				}elseif(strlen($pwd)<6){
					$data['info']='密码不能小于6位~';
				}elseif(strlen($pwd)>16){
					$data['info']='密码不能大于16位~';
				}elseif(!preg_match('/^[a-z0-9][a-z0-9_]+@[a-z0-9]+(\.[a-z0-9]+){1,3}$/i', $email)){
					$data['info']='邮箱格式不正确~';
				}elseif(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9]))\d{8}$/', $phone)){
					$data['info']='手机号码格式不正确~';
				}elseif(!preg_match('/^\d{3,15}$/', $phone)){
					$data['info']='QQ号码格式不正确~';
				}else{
					if($db->getCount('mcs_users','user_name="'.$username.'"')){
						$data['info']='用户名已存在，请更换~';
					}elseif($db->getCount('mcs_users','mobile_phone="'.$phone.'"')){
						$data['info']='手机号码已存在，请更换~';
					}elseif($db->getCount('mcs_users','email="'.$email.'"')){
						$data['info']='邮箱已存在，请更换~';
					}elseif($db->getCount('mcs_users','qq="'.$qq.'"')){
						$data['info']='QQ已存在，请更换~';
					}else{
						$password = cipherStr($pwd);
						$sql = "insert into mcs_users(user_name, password, mobile_phone, qq, email, add_time,user_rank,token) values('$username', '$password', '$phone', '$qq', '$email', '". time() ."',1,'".$access_token."')";
						if($db->Execute($sql))
						{
							$_SESSION['user_id'] = $db->insertId();
							$_SESSION['user_name'] = $username;
							$data['info']='注册成功~';
							$data['status']=true;
							$data['url']='user.php';
						}else{
							$data['info']='绑定失败~';
						}
					}
				}
			break;

			case 'bindUserqq':
				$name=trim($_POST['name']);
				$pwd=trim($_POST['pwd']);
				$safe=trim($_POST['safe']);
				if(empty($name)||empty($pwd)||empty($safe)){
					$data['info']='请填写完整信息~';
				}else{
					$info=$db->getRow('select * from mcs_users where user_name="'.$name.'"');
					if(intval($info['user_id'])==0){
						$data['info']='会员不存在，请注册~';
					}elseif(cipherStr($pwd)!=$info['password']){
						$data['info']='密码不正确~';
					}elseif(cipherStr($safe)!=$info['safepass']){
						$data['info']='安全码不正确~';
					}elseif(!empty($info['token'])){
						$data['info']='会员已绑定QQ,请更换~';
					}else{
						if($db->Execute('update mcs_users set token="'.$qq['access_token'].'" where user_id='.$info['user_id'])){
							unset($_SESSION['tencent']);
							$_SESSION['user_id'] = $info['user_id'];
							$_SESSION['user_name'] = $info['user_name'];
							$last_ip=getRealIp();
							$db->Execute("update mcs_users set log_count=log_count+1, last_login='". time() ."', last_ip='".$last_ip."' where user_id='{$info['user_id']}'");
							$str=$info['user_name'].'登陆网站||QQ登陆';
							$db->Execute("insert into mcs_member_logs(uid,createtime,type,logtype,info,ip) values(".$info['user_id'].",".time().",'logaccount','登陆网站','".$str."','".$last_ip."')");
							$data['info']='绑定成功~';
							$data['status']=true;
							$data['url']='user.php';
						}else{
							$data['info']='绑定失败~';
						}
					}
				}
			break;
		}
	}
	echo json_encode($data);
	exit;
}
if(!empty($_GET['code'])){
	$access_token=authcode($_GET['code'],'DECODE',$code_key,100);
	if(empty($_SESSION['tencent'][$access_token])){
		unset($_SESSION['tencent']);
		header('Location: home.php');
	}else{
		$code['access_token']=$access_token;
		$code['openid']=$_SESSION['tencent'][$access_token];
		require_once('mcscore/init.php');
		require_once("api/qqConnectAPI.php");

		$qc = new QC();
		$qq['access_token']=$code['access_token'];
		$qq['openid']=$code['openid'];

		$qc = new QC($qq['access_token'],$qq['openid']);
		$arr = $qc->get_user_info();
		$_SESSION['tencent'][$qq['access_token']]=$qq['openid'];
		$view->assign('access',authcode($qq['access_token'],'ENCODE',$code_key,100));

		$is_has=$db->getField('mcs_users','user_id','token="'.$qq['access_token'].'"');
		if(intval($is_has)){
			/*if($user['headimg']!=$arr['figureurl_qq_2']){
				$db->Execute('update member set headimg="'.$arr['figureurl_qq_2'].'" where id='.$user['id']);
			}
			if($user['username']!=$arr['nickname']){
				$db->Execute('update member set username="'.$arr['nickname'].'" where id='.$user['id']);
			}*/
			
			$row = $db->getRow('select * from mcs_users where user_id='.$is_has);
			if($row)
			{
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['user_name'] = $row['user_name'];
				$last_ip=getRealIp();
				$db->Execute("update mcs_users set log_count=log_count+1, last_login='". time() ."', last_ip='".$last_ip."' where user_id='{$row['user_id']}'");

				$info=$row['user_name'].'登陆网站||QQ登陆';
				$db->Execute("insert into mcs_member_logs(uid,createtime,type,logtype,info,ip) values(".$row['user_id'].",".time().",'logaccount','登陆网站','".$info."','".$last_ip."')");
				Redirect('user.php');
			}
		}else{
			$view->display('user/qq');  
		}
		
	}
}else{
	//header('location: home.php');
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0){
 if($operation == 'DECODE') {
  $string = str_replace('AdD','+',$string);
  $string = str_replace('aNd','&',$string);
  $string = str_replace('XiE','/',$string);
 }
    $ckey_length = 4;
    $key = md5($key ? $key : 'livcmsencryption ');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
   
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
  $ustr = $keyc.str_replace('=', '', base64_encode($result));
  $ustr = str_replace('+','AdD',$ustr);
  $ustr = str_replace('&','aNd',$ustr);
  $ustr = str_replace('/','XiE',$ustr);
        return $ustr;
    }
}
?>
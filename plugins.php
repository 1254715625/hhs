<?php
require 'mcscore/init.php';


$url = $_SERVER['host'];
$url = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];


switch($action)
{
    case 'exam':
		$item = isset($_POST['item']) ? trim($_POST['item']) : '';
        
        if($item)
        {
            if($db->getCount('mcs_exam', "code='$item'"))
            {
                $db->Execute("update mcs_exam set num=num+1 where code='$item'");
            }
            else
            {
                $db->Execute("insert into mcs_exam values('$item', 1)");
            }

            $db->Execute("update mcs_users set pay_money=pay_money+1, isdc=1 where user_id='{$_SESSION['user_id']}'");

			$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','完成小调查','1','刷点日志',".($uinfo['pay_money']+1).",'logpoint')");//刷点日志
        }
        break;

	case 'checkcode':
		$mod = isset($_POST['mod']) ? trim($_POST['mod']) : '';
		$smscode = isset($_POST['code']) ? trim($_POST['code']) : '';
		$sms=$db->getRow('select code,id from mcs_message where phone="'.$uinfo['mobile_phone'].'" and sendtime>'.($t-600).' and state=0 order by sendtime desc');
		if(empty($sms['code'])){
			$info = array('code'=>0, 'info'=>'验证码已过期，请重新发送~');
		}elseif($smscode == $sms['code']){
			$info = array('code'=>1, 'info'=>'验证成功~');
		}else{
			$info = array('code'=>0, 'info'=>'验证失败，你输入的验证码不正确~');		
		}
		if($info['code'])
		{
			switch($mod)
			{
				case 'mprz':
					$phone=trim($_POST['phone']);
					if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
						$info = array('code'=>0, 'info'=>'手机号码格式不正确~');
					}elseif($db->getCount('mcs_users','mobile_phone="'.$phone.'" and mprz=1')){
						$info = array('code'=>0, 'info'=>'此手机号码已在平台激活，请更换~');
					}else{
						$db->Execute("update mcs_users set pay_money=pay_money+1, mprz=1,mobile_phone='".$phone."' where user_id='{$_SESSION['user_id']}'");
						$db->Execute('update mcs_message set state=1 where id='.$sms['id']);
					}
					break;
			}
		}
		echo json_encode($info);
		break;

	case 'sendsoundcode':
        $cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
		$cfgs = unserialize($cfgs);

		$phone = isset($_POST['phone']) ? trim($_POST['phone']) : $uinfo['mobile_phone'];
        if(empty($phone))
        {
            echo json_encode(array('code'=>-2, 'info'=>'手机号码不能为空'));
            exit;
        }
		if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
			echo json_encode(array('code'=>-2, 'info'=>'手机号码格式不正确'));
            exit;
		}
		$t=time();
		$c=$db->getField('mcs_message','sendtime','phone="'.$phone.'" and sendtime>'.($t-180).' and state=0 and type=1 order by sendtime desc');
		if($c){
			$et=(180-($t-$c));
			echo json_encode(array('code'=>-2,'time'=>$et, 'info'=>'请在'.$et.'后重新发送~'));
            exit;
		}
		require ROOT_PATH . 'mcscore/ccpsms.class.php';		
		$accountSid = $cfgs['accountSid'];	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountToken = $cfgs['accountToken'];
		$appId = $cfgs['appId'];
		$serverIP = $cfgs['serverIP'];
		$serverPort = $cfgs['serverPort'];
		$softVersion = $cfgs['softVersion'];
		$savetime = $cfgs['savetime'];		

		$rest = new REST($serverIP, $serverPort, $softVersion);
		$rest->setAccount($accountSid,$accountToken);
		$rest->setAppId($appId);
		
		$smscode = mt_rand(100000, 999999);
		//setcookie('smscode', $smscode, time()+$savetime*60);

		$result = $rest->voiceVerify($smscode, 2, $phone, $phone, 'http://hhs.lianmon.com');
  
		if($result == null)
		{
			$info = array('code'=>-1, 'info'=>'语音发送失败');			
		}
		else
		{
			$db->Execute('update mcs_message set state=1 where phone="'.$phone.'"');
			$db->Execute('insert into mcs_message(phone,code,sendtime,type) values("'.$phone.'","'.$smscode.'","'.$t.'",1)');
			$info = array('code'=>$result->statusCode, 'info'=>'语音发送成功');
		}

		echo json_encode($info);
		break;

	case 'sendsmscode':
        $cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
		$cfgs = unserialize($cfgs); //开发者账号信息

		$phone = isset($_POST['phone']) ? trim($_POST['phone']) : $uinfo['mobile_phone'];
        if(empty($phone))
        {
            echo json_encode(array('code'=>-2, 'info'=>'手机号码不能为空'));
            exit;
        }
		if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
			echo json_encode(array('code'=>-2, 'info'=>'手机号码格式不正确'));
            exit;
		}
		$t=time();
		$c=$db->getField('mcs_message','sendtime','phone="'.$phone.'" and sendtime>'.($t-180).' and state=0 and type=0 order by sendtime desc');
		if($c){
			$et=(180-($t-$c));
			echo json_encode(array('code'=>-2,'time'=>$et, 'info'=>'请在'.$et.'后重新发送~'));
            exit;
		}
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
    
		$result = $rest->sendTemplateSMS($phone, array($smscode, $cfgs['savetime']), 5411);
		
		if($result == null)
		{
			$info = array('code'=>-1, 'info'=>'短信发送失败');			
		}
		else
		{
			$db->Execute('update mcs_message set state=1 where phone="'.$phone.'"');
			$db->Execute('insert into mcs_message(phone,code,sendtime) values("'.$phone.'","'.$smscode.'","'.$t.'")');
			$info = array('code'=>$result->statusCode, 'info'=>'短信发送成功');
		}

		echo json_encode($info);
		break;

	case 'shengpay':
		$cfgs = $db->getField('mcs_configs', 'value', "code='shengpay'");
		$cfgs = unserialize($cfgs);

		$m = isset($_GET['m']) ? floatval($_GET['m']) : 0;
		$s = $m * ($cfgs['poundage'] / 100);

		$shengpay=root::loadClass('shengpay');

		$array=array(
			'Name' => $cfgs['Name'],
			'Version' => $cfgs['Version'],
			'Charset' => $cfgs['Charset'],
			'MsgSender' => $cfgs['MsgSender'],
			'SendTime' => date('YmdHis'),
			'OrderTime' => date('YmdHis'),
			'PayType' => $cfgs['PayType'],
			'InstCode' => $cfgs['InstCode'],
			'PageUrl' => $cfgs['PageUrl'],
			'NotifyUrl' => $cfgs['NotifyUrl'],
			'ProductName' => $cfgs['ProductName'],
			'BuyerContact' => '',
			'BuyerIp' => '',
			'Ext1' => $m,
			'Ext2' => $s,
			'SignType' => 'MD5',
		);
		$shengpay->init($array);
		$shengpay->setKey($cfgs['setKey']);

		$oid = date('YmdHis') . mt_rand(10, 99);
		$fee = round($m + $s, 2);

		$shengpay->takeOrder($oid, $fee);
		break;

	case 'sftreturn':
		$cfgs = $db->getField('mcs_configs', 'value', "code='shengpay'");
		$cfgs = unserialize($cfgs);

		$m = isset($_GET['m']) ? floatval($_GET['m']) : 0;
		$s = $m * $cfgs['poundage'];

		$shengpay=root::loadClass('shengpay');
		$shengpay->setKey($cfgs['setKey']);

		if($shengpay->returnSign())
		{
			/*支付成功*/
			$oid = $_POST['OrderNo'];
			$fee = $_POST['TransAmount'];
			$Ext1 = $_POST['Ext1'];

			if($db->getCount("mcs_user_logs", "oid='$oid'"))
			{
				echo '订单号已过期';
				exit;
			}
			
			$db->Execute("update mcs_users set user_money = user_money + $Ext1 where user_id='{$_SESSION['user_id']}'");
			
			$newnum = $db->getField("mcs_users","user_money","user_id='{$_SESSION['user_id']}'");
			
			$sql = "insert into mcs_user_logs(uid, add_time, user_money, type, logtype, info, num, oid, state) values({$_G['uid']}, ".time().", '$Ext1', 'payment', '在线充值', '会员盛付通在线充值', $newnum, '$oid', 1)";
			$db->Execute($sql);
			
			header("location: user.php");
			exit;

		}else{
			echo 'Error';
		}
		break;
		
		
		
		
		
		
	//短信通知模板
	
	case 'notify':
        $cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
		$cfgs = unserialize($cfgs); //开发者账号信息

		$phone = isset($_GET['phone']) ? trim($_GET['phone']) : $uinfo['mobile_phone'];
		
        if(empty($phone))
        {
            echo json_encode(array('code'=>-2, 'info'=>'手机号码不能为空'));
            exit;
        }
		if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
			echo json_encode(array('code'=>-2, 'info'=>'手机号码格式不正确'));
            exit;
		}
		
		require ROOT_PATH . 'mcscore/ccpsms.class.php';		
		$accountSid = $cfgs['accountSid'];	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountToken = $cfgs['accountToken'];
		$appId = $cfgs['appId'];
		$serverIP = $cfgs['serverIP'];
		$serverPort = $cfgs['serverPort'];
		$softVersion = $cfgs['softVersion'];
		$savetime = $cfgs['savetime'];

		$rest 	= new REST($serverIP, $serverPort, $softVersion);
		$rest->setAccount($accountSid, $accountToken);
		$rest->setAppId($appId);
		$type	=$_GET['type'];
		$time	=date('Y-m-d',time());
		
		
		

        //如果传uid 默认是后台,不传默认是前台.免费短信--
        if($_GET['uid']){
            $uid=$_GET['uid'];
        }elseif($_POST['uid']){
            $uid=$_POST['uid'];
        }else{
            $uid=$uinfo['user_id'];
        }
        $res=$db->getRow("select * from mcs_user_rank as a,mcs_users as b where b.user_rank=a.rank_id and b.user_id = " .$uid);
        $param=unserialize($res['param']);
        $mfdx=$param['mfdx'];
        if($param['special'] == 1){

            $value=$db->getField('mcs_configs','value','id = 913 ');
            $db->Execute("update mcs_users set user_money = user_money - '".$value."' where user_id = " .$uid);
        }else{

            $value=$db->getField('mcs_configs','value','id = 912 ');
            $db->Execute("update mcs_users set user_money = user_money - '".$value."' where user_id = " .$uid);
        }
		//--
		
		if($type == 141226){ //购买刷点
		
			$price=$_GET['price'];
			$result = $rest->sendTemplateSMS($phone, array($time, $cfgs['savetime'],$price), $type);
		}elseif($type == 141225 ){ //申请提现
		
			$bank	=$_GET['bank'];
			$mesid	=$_GET['mesid'];
			$price	=$_GET['price'];
			$result = $rest->sendTemplateSMS($phone, array($time, $bank,$mesid,$price), $type);
		}
		

		if($result == null)
		{
			$info = array('code'=>-1, 'info'=>'短信发送失败');			
		}
		else
		{
			$info = array('code'=>$result->statusCode, 'info'=>'操作成功');			
		}

		echo json_encode($info);
		break;
		

	
	
	//ajax短信通知模板
	
	default:
		
        $cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
		$cfgs = unserialize($cfgs); //开发者账号信息

		$phone = isset($_GET['phone']) ? trim($_GET['phone']) : $uinfo['mobile_phone'];
		
        if(empty($phone))
        {
            echo json_encode(array('code'=>-2, 'info'=>'手机号码不能为空'));
            exit;
        }
		if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
			echo json_encode(array('code'=>-2, 'info'=>'手机号码格式不正确'));
            exit;
		}
		
		require ROOT_PATH . 'mcscore/ccpsms.class.php';		
		$accountSid = $cfgs['accountSid'];	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountToken = $cfgs['accountToken'];
		$appId = $cfgs['appId'];
		$serverIP = $cfgs['serverIP'];
		$serverPort = $cfgs['serverPort'];
		$softVersion = $cfgs['softVersion'];
		$savetime = $cfgs['savetime'];

		$rest 	= new REST($serverIP, $serverPort, $softVersion);
		$rest->setAccount($accountSid, $accountToken);
		$rest->setAppId($appId);
		$type	=$_GET['type'];
		$time	=date('Y-m-d',time());

        //如果传id 默认是后台,不传默认是前台.免费短信--
        if($_GET['uid']){
            $uid=$_GET['uid'];
        }elseif($_POST['uid']){
            $uid=$_POST['uid'];
        }else{
            $uid=$uinfo['user_id'];
        }
        $res=$db->getRow("select * from mcs_user_rank as a,mcs_users as b where b.user_rank=a.rank_id and b.user_id = " .$uid);
        $param=unserialize($res['param']);
        $mfdx=$param['mfdx'];
        if($param['special'] == 1){

            $value=$db->getField('mcs_configs','value','id = 913 ');
            $db->Execute("update mcs_users set user_money = user_money - '".$value."' where user_id = " .$uid);
        }else{

            $value=$db->getField('mcs_configs','value','id = 912 ');
            $db->Execute("update mcs_users set user_money = user_money - '".$value."' where user_id = " .$uid);
        }
        //--



        if($type == 141226){ //购买刷点
		
			$price=$_GET['price'];
			$result = $rest->sendTemplateSMS($phone, array($time, $cfgs['savetime'],$price), $type);
		}elseif($type == 141225 ){ //申请提现
		
			$bank	=$_GET['bank'];
			$mesid	=$_GET['mesid'];
			$price	=$_GET['price'];
			$result = $rest->sendTemplateSMS($phone, array($time, $bank,$mesid,$price), $type);
		}elseif($type == 143786){ //投诉审核结果
			$dingdan_id=$_GET['dingdan_id'];
			$phone=$_GET['mobile'];
			$result=$_GET['result'];
			$result = $rest->sendTemplateSMS($phone, array($dingdan_id, $result), $type);
		}elseif($type == 143791){
			$dingdan_id=$_GET['dingdan_id'];
			$phone=$_GET['mobile'];
			$jf=$_GET['jf'];
			$result = $rest->sendTemplateSMS($phone, array($dingdan_id, $jf), $type);
		}elseif($type == 143793){
			$dingdan_id=$_GET['dingdan_id'];
			$phone=$_GET['mobile'];
			$sd=$_GET['sd'];
			$result = $rest->sendTemplateSMS($phone, array($dingdan_id, $sd), $type);
		}
		

		if($result == null){
			$info = array('code'=>-1, 'info'=>'短信发送失败');			
		}
		else
		{
			$info = array('code'=>$result->statusCode, 'info'=>'操作成功');			
		}

		
		break;
		
	break;
	
	case 'test':


		break;
		
}
?>
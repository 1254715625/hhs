<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}

$question_arr=array('无安全问题','早上几点起床？','TA最爱吃的菜？','好朋友的名字？','你理想的体重？','爱人的生日？');
$view->assign('question_arr', $question_arr);

$view->assign('mobile',substr_replace($uinfo['mobile_phone'],'****',3,4));

$opt = isset($_REQUEST['opt']) ? trim($_REQUEST['opt']) : ''; 

if(!in_array($opt, array('userinfo', 'password', 'setsafepass', 'setquestion', 'authname')))
{
    $opt = 'userinfo';
}
$view->assign('opt', $opt);

if(IS_POST&&$_POST['safepass']=='safepass'){
	$getsafepass = isset($_POST['getsafepass']) ? trim($_POST['getsafepass']) : '';
	if($db->getCount('mcs_users', "user_id='".$uinfo['user_id']."' and safepass='". cipherStr($getsafepass) ."'")){
		echo 'ok';
		exit;
	}
}

if(IS_POST)
{
	switch($opt){
		
		case 'userinfo':
			$data['info']='访问出错~';
			if(intval($_POST['action'])==1){
				$code=intval($_POST['code']);
				$phone=trim($_POST['phone']);
				if(empty($code)){
					$data['info']='验证码不能为空，请输入~';
				}elseif(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-9])|(?:7[0-9]))\d{8}$/', $phone)){
					$data['info']='新手机号码格式不正确，请重新输入~';
				}else{
					$sms=$db->getRow('select code,id from mcs_message where phone="'.$uinfo['mobile_phone'].'" and sendtime>'.($t-600).' and state=0 order by sendtime desc');
					if(empty($sms['code'])){
						$data['info']='验证码已过期，请重新发送~';
					}elseif($code != $sms['code']){
						$data['info']='你输入的验证码不正确~';		
					}else{
						if($db->getCount('mcs_users','mobile_phone="'.$phone.'"')){
							$data['info']='修改失败，新手机号已在平台上激活过，请更换后尝试~';
						}elseif($db->Execute('update mcs_users set mobile_phone="'.$phone.'" where user_id='.$uinfo['user_id'])){
							$db->Execute('update mcs_message set state=1 where id='.$sms['id']);
							
							
							//资料变更通知
							$res=$db->getRow("select mess_set from mcs_users where user_id = ". $uinfo['user_id']);
							$mess_set=unserialize($res['mess_set']);
							$u_edit=$mess_set['u_edit']['website'];
							if($u_edit == 1) {
								$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$uinfo['user_id']."','".$uinfo['user_id']."','手机号成功修改为:".$phone."','0','".time()."')");
							}
							$data['info']='手机号码修改成功~';
							$data['status']='1';
							
							if($mess_set['u_edit']['mobile'] == 1){
								header("location:http://hhs.lianmon.com/plugins.php?act=notify&type=141164&phone=
								{$phone}");
							}
						}
					}
				}
			}else{
				if(!$db->getCount('mcs_users', "user_id='".$uinfo['user_id']."' and safepass='". cipherStr($_POST['safepass']) ."'"))
				{
					echo '<script type="text/javascript">alert("您输入的安全验证码不正确");history.back();</script>';
					exit;
				}
				$chgaddress=unserialize($uinfo['chg_address']);
				$POST['chg_address']=$_POST['chg_address'];
				if(empty($uinfo['send_address'])){
					$send_address=$_POST['send_address'];
				}else{
					$send_address=$uinfo['send_address'];
				}
				if(!empty($chgaddress['0']['prov'])){
					$POST['chg_address']['0']['prov']=$chgaddress['0']['prov'];
				}
				if(!empty($chgaddress['1']['prov'])){
					$POST['chg_address']['1']['prov']=$chgaddress['1']['prov'];
				}
				if(!empty($chgaddress['2']['prov'])){
					$POST['chg_address']['2']['prov']=$chgaddress['2']['prov'];
				}
				$sql = "update mcs_users set qq = '{$_POST['qq']}', realname = '{$_POST['realname']}', sex = '{$_POST['sex']}', asyn_sms = '{$_POST['asyn_sms']}', send_address = '".$send_address."', chg_address = '".serialize($POST['chg_address'])."' where user_id='".$uinfo['user_id']."'";
				$db->Execute($sql);
				echo '<script type="text/javascript">alert("保存成功");history.back();</script>';
				
				//资料变更通知
				$sex=$_POST['sex'] == 0 ? '男':'女';
				$res=$db->getRow("select mess_set from mcs_users where user_id = ". $uinfo['user_id']);
				$mess_set=unserialize($res['mess_set']);
				$u_edit=$mess_set['u_edit']['website'];
				if($u_edit == 1) {
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$uinfo['user_id']."','".$uinfo['user_id']."','qq修改为:".$_POST['qq']." 真实姓名修改为".$_POST['realname']." 性别为".$sex."  地址为".$send_address." ','0','".time()."')");
				}
				
				exit;
			}
			echo json_encode($data);
			exit;
		break;

		case 'password':
			if(!$db->getCount('mcs_users', "user_id='".$uinfo['user_id']."' and safepass='". cipherStr($_POST['safepass']) ."'"))
			{
				echo '<script type="text/javascript">alert("您输入的安全验证码不正确");history.back();</script>';
				exit;
			}
			$password=(isset($_POST['password'])&&!empty($_POST['password']))?trim($_POST['password']):'';
			$pass=(isset($_POST['pass'])&&!empty($_POST['pass']))?trim($_POST['pass']):'';
			if(empty($password)||$password!=$pass){
				echo '<script type="text/javascript">alert("两次密码输入不一致");history.back();</script>';
				exit;
			}else{
				$newpass=cipherStr($password);
				$sql = "update mcs_users set password = '".$newpass."' where user_id='".$uinfo['user_id']."'";
				$db->Execute($sql);
				$sess->destroy_session();
				echo '<script type="text/javascript">alert("登陆密码修改成功！");history.back()</script>';
				exit;
			}
		break;

		case 'setsafepass':
			$data['info']='访问出错~';
			$smscode=trim($_POST['smscode']);
			$password=trim($_POST['password']);
			$pass=trim($_POST['pass']);
			$sms=$db->getRow('select code,id from mcs_message where phone="'.$uinfo['mobile_phone'].'" and sendtime>'.($t-600).' and state=0 order by sendtime desc');
			if(empty($smscode)){
				$data['info']='验证码不能为空，请输入~';
			}elseif(empty($sms['code'])){
				$data['info']='验证码已过期，请重新发送~';
			}elseif($smscode != $sms['code']){
				$data['info']='你输入的验证码不正确~';		
			}elseif(!preg_match('/^[0-9a-zA-Z_]{6,20}$/', $password)){
				$data['info']='安全操作码格式错误(操作码由英文字母、数字(0-9)、下划线组成,长度在6-20个字符之间)';
			}elseif($password!=$pass){
				$data['info']='新操作密码与确认密码不一致~';	
			}else{
				$db->Execute('update mcs_message set state=1 where id='.$sms['id']);
				$password=cipherStr($password);
				if($password==$uinfo['safepass']){
					$data['info']='修改成功~';
				}elseif($db->Execute('update mcs_users set safepass="'.$password.'" where user_id='.$uinfo['user_id'])){
					$data['info']='操作密码修改成功~';
					$data['status']='1';
				}else{
					$data['info']='修改失败~';
				}
			}
			echo json_encode($data);
			exit;
		break;

		case 'setquestion':
			if(!$db->getCount('mcs_users', "user_id='".$uinfo['user_id']."' and safepass='". cipherStr($_POST['safepass']) ."'"))
			{
				echo '<script type="text/javascript">alert("您输入的安全验证码不正确");history.back();</script>';
				exit;
			}
			$password=(isset($_POST['password'])&&!empty($_POST['password']))?trim($_POST['password']):'';
			$question=(isset($_POST['question'])&&!empty($_POST['question']))?intval($_POST['question']):'';
			if(!empty($question)&&$question==0){
				$password='';
			}
			$sql = "update mcs_users set questiontype = '{$question}',question = '{$password}' where user_id='".$uinfo['user_id']."'";
			$db->Execute($sql);
			$sess->destroy_session();
			echo '<script type="text/javascript">alert("密码问题修改成功！");history.back()</script>';
			exit;
		break;

		case 'authname':
			if(IS_AJAX){
				$data['info']='访问出错~';
				$realname=$db->getRow('select * from mcs_member_realname where uid='.$uinfo['user_id']);
				if($realname['uid']){
					if($realname['state']==2){
						if($db->Execute('delete from mcs_member_realname where uid='.$realname['uid'])){
							$data['reload']=1;
						}
					}elseif($realname['state']==1){
						$data['info']='您已通过实名认证~';
					}else{
						$data['info']='实名认证审核中~';
					}
				}else{
					$data['info']='您还未申请实名认证~';
				}
				echo json_encode($data);
				exit;
			}
			if($db->getCount('mcs_member_realname','uid='.$uinfo['user_id'])){
				echo '<script type="text/javascript">alert("实名验证审核中~");history.back()</script>';
				exit;
			}
			$real=$_POST['real'];
			$truname=$_POST['real']['truname'];
			$ident=$_POST['real']['ident'];
			if(empty($truname)){
				echo '<script type="text/javascript">alert("请填写真实姓名~");history.back()</script>';
				exit;
			}
			if(!preg_match('/^[1-9]{1}\d{14}$|^[1-9]{1}\d{13}(\d|X|x)$|^[1-9]{1}\d{17}$|^[1-9]{1}\d{16}(\d|X|x)$/', $ident)){
				echo '<script type="text/javascript">alert("身份证号格式不正确，请重新输入~");history.back()</script>';
				exit;
			}
			$real['file1']=upload('file1');
			$real['file2']=upload('file2');
			$real['file3']=upload('file3');
			$value=serialize($real);
			$sql = 'insert into mcs_member_realname(uid,value) values("'.$uinfo['user_id'].'",\''.$value.'\')';
			if($db->Execute($sql)){
				echo '<script type="text/javascript">alert("实名验证审核中~");history.back()</script>';
				exit;
			}
		break;
	}
}
$chg_address = unserialize($uinfo['chg_address']);
$view->assign('chg_address', $chg_address);

$questiontype=$uinfo['questiontype'];//安全问题
$view->assign('questiontype', $questiontype);

$realname=$db->getRow('select * from mcs_member_realname where uid='.$uinfo['user_id']);//实名认证
$view->assign('realname', $realname);

$email=explode('@',$uinfo['email']);
$email=substr_replace($email[0],'***',1,strlen($email[0])-2).'@'.$email[1];
$view->assign('email', $email);



$view->display('user/userdata');

function upload($file){
	$picname = $_FILES[$file]['name'];
	$picsize = $_FILES[$file]['size'];
	$data['state']=0;
	if(empty($picname)){
		echo '<script type="text/javascript">alert("上传图片不存在~");history.back()</script>';
		exit;
	}elseif ($picsize > 2048000) {
		echo '<script type="text/javascript">alert("图片大小不能超过2M~");history.back()</script>';
		exit;
	}else{
		$type = strtolower(strstr($picname, '.'));
		if ($type != ".gif" && $type != ".jpg"  && $type != ".png") {
			echo '<script type="text/javascript">alert("图片格式不对~");history.back()</script>';exit;
		}else{
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic_path = "uploads/user/". $pics;
			if(move_uploaded_file($_FILES[$file]['tmp_name'], $pic_path)){
				return $pic_path;
			}
		}
	}
}
?>
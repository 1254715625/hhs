<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}
$deltime=strtotime("-1 day");
$db->Execute('delete from mcs_member_black where adddate<'.$deltime.' and uid='.$uinfo['user_id']);

$buser = isset($_REQUEST['buser']) ? trim($_REQUEST['buser']) : ''; 

if(IS_POST&&IS_AJAX&&$_GET['opt']=='del'){
	$data['info']='移除失败~';
	$del = isset($_POST['del']) ? intval($_POST['del']) : 0; 
	if($del){
		$db->Execute('delete from mcs_member_black where id='.$del.' and uid='.$uinfo['user_id']);
		$data['info']='移除成功~';
	}
	echo json_encode($data);
	exit;
}

if(!in_array($buser, array('ublack', 'taobao','paipai')))
{
    $buser = 'ublack';
}
$view->assign('buser', $buser);

switch($buser){
	case "ublack":
		$black=$db->pagestr("select * from mcs_member_black where uid={$uinfo['user_id']} and usertype='ublack'",5,5);
		$black['num']=$db->getCount("mcs_member_black","uid={$uinfo['user_id']} and usertype='ublack'",'uid');
		$black['num']=($uinfo['params']['yhhmdgs']-$black['num'])>0?($uinfo['params']['yhhmdgs']-$black['num']):0;
	break;

	case "taobao":
		$black=$db->pagestr("select * from mcs_member_black where uid={$uinfo['user_id']} and usertype='taobao'",5,5);
		$black['num']=$db->getCount("mcs_member_black","uid={$uinfo['user_id']} and usertype='taobao'",'uid');
		$black['num']=($uinfo['params']['mhhmdgs']-$black['num'])>0?($uinfo['params']['mhhmdgs']-$black['num']):0;
	break;

	case "paipai":
		$black=$db->pagestr("select * from mcs_member_black where uid={$uinfo['user_id']} and usertype='paipai'",5,5);
		$black['num']=$db->getCount("mcs_member_black","uid={$uinfo['user_id']} and usertype='paipai'",'uid');
		$black['num']=($uinfo['params']['mhhmdgs']-$black['num'])>0?($uinfo['params']['mhhmdgs']-$black['num']):0;
	break;

	default:
		
	break;
}

if(IS_POST&&IS_AJAX)
{
	$data['info']='访问出错~';
	$types=isset($_POST['sel'])?intval($_POST['sel']):0;//类型编号
	$typesname=isset($_POST['title'])?trim($_POST['title']):'';//输入值
	$complain=isset($_POST['content'])?trim($_POST['content']):'';//原因
	if(empty($typesname)){
		$data['info']='请填写您要拉黑的值~';
	}elseif(empty($complain)){
		$data['info']='请填写拉黑原因~';
	}elseif(strlen($complain)<10){
		$data['info']='为了避免恶意拉黑，拉黑内容不能少于10个字符~';
	}else{
		
		switch($buser){
			case "ublack":
				
				if($black['num']==0){
					$data['info']='黑名单达到上限~';
				}elseif($types==1){
					$accid=$db->getField("mcs_users","user_id","user_name='".$typesname."'");
					if($accid==''){
						$data['info']='此用户不存在~';
					}elseif($accid==$uinfo['user_id']){
						$data['info']='不能拉黑自己~';
					}elseif($db->getCount("mcs_member_black","uid=".$uinfo['user_id']." and accid=".$accid." and usertype='ublack'")){
						$data['info']='您已拉黑此名单~';
					}elseif(
					$db->Execute("insert into mcs_member_black(uid,accid,types,complain,adddate,usertype) value('{$uinfo['user_id']}','$accid',$types,'$complain',".time().",'{$buser}')")
					
					){
						
					//进入他人黑名单提醒
					$result=$db->getRow("select mess_set from mcs_users where user_name = '".$typesname."' ");
					$result=unserialize($result['mess_set']);
					$res=$result['c_push_black'];
					if($res['website'] == 1){
						
						$name=substr($uinfo['user_name'],-4);
						$s='****';
						$rename=$s.$name;
						$bid=$db->getRow("select user_id from mcs_users  where user_name = " .$typesname);//被举报人id
						$db->Execute("insert into mcs_member_message (pid,tuid,fuid,guid,content,state) value(0,'".$bid['user_id']."',0,'".$bid['user_id']."','您已被".$rename."拉入黑名单','0')");
					}
						$data['info']=$typesname.'添加成功~';
					}

					
				}elseif($type==2){
					
				}
			break;

			case 'taobao':
				if($black['num']==0){
					$data['info']='黑名单达到上限~';
				}elseif($types==1){
					$accid=$db->getRow("select id,uid from mcs_member_bindacc where nickname='$typesname' and acc_type='tb' and buyno=0");
					if($accid==''){
						$data['info']='淘宝买号不存在';
					}elseif($accid['uid']==$uinfo['user_id']){
						$data['info']='不能拉黑自己~';
					}elseif($db->getRow("select * from mcs_member_black where uid=".$uinfo['user_id']." and accid=".$accid['id']." and usertype='taobao'")){
						$data['info']='您已拉黑此名单~';
					}elseif($db->Execute("insert into mcs_member_black(uid,accid,types,complain,adddate,usertype) value('{$uinfo['user_id']}','$accid[id]',$types,'$complain',".time().",'{$buser}')")){
						$data['info']='添加成功~';
					}
				}elseif($type==2){
					
				}
				
			break;

			case 'paipai':
				if($black['num']==0){
					$data['info']='黑名单达到上限~';
				}elseif($types==1){
					$accid=$db->getRow("select id,uid from mcs_member_bindacc where nickname='$typesname' and acc_type='pp' and buyno=0");
					if($accid==''){
						$data['info']='拍拍买号不存在';
					}elseif($accid['uid']==$uinfo['user_id']){
						$data['info']='不能拉黑自己~';
					}elseif($db->getRow("select * from mcs_member_black where uid=".$uinfo['user_id']." and accid=".$accid['id']." and usertype='paipai'")){
						$data['info']='您已拉黑此名单~';
					}elseif($db->Execute("insert into mcs_member_black(uid,accid,types,complain,adddate,usertype) value('{$uinfo['user_id']}','$accid[id]',$types,'$complain',".time().",'{$buser}')")){
						$data['info']='添加成功~';
					}
				}elseif($type==2){
					
				}
			break;
		}
	}
	echo json_encode($data);
	exit;
}

if(count($black['record'])&&is_array($black['record'])){
	foreach($black['record'] as $k => $v){
		$black['record'][$k]['blacknum']=blacknum($v['accid'],$db);
		$black['record'][$k]['getuname']=getuname($v['accid'],$buser,$db);
		$black['record'][$k]['btime']=intval((time()-$v['adddate'])/(24*3600));
		$black['record'][$k]['bname']=mb_substr($v['complain'],0,30,'utf8');
	}
}
$view->assign('black', $black);


function getuname($fuid,$buser,&$db){
	$fuid=intval($fuid);
	if($buser=='ublack'){
		if($fuid){
			return $db->getField("mcs_users",'user_name','user_id='.$fuid);
		}
	}
	else{
		return $db->getField("mcs_member_bindacc",'nickname','id='.$fuid);
	}
}

function blacknum($fuid,&$db){
	$fuid=intval($fuid);
	if($fuid){
		return $db->getCount("mcs_member_black","accid=".$fuid);
	}
}
$view->display('user/black');
?>
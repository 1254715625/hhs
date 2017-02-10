<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}

$instation=array(
	'信用记录提醒'=>array('收到投诉'=>'c_complaint','收到申诉审核结果'=>'c_complaint_result','官方扣除积分提醒'=>'c_minus_integral','进入他人黑名单提醒'=>'c_push_black','收到维权投诉'=>'c_rights','收到维权审核结果'=>'c_rights_result'),
	'资金变动通知'=>array('申请提现通知'=>'f_apply_money','购买刷点提醒'=>'f_buy_maidian','充值失败通知'=>'f_charge_error','充值成功通知'=>'f_charge_success','兑换刷点提醒'=>'f_exchange_maidian','发放提现通知'=>'f_grant_money','各种奖励通知'=>'f_reward','推广相关通知'=>'f_spread'),
	'接手任务提醒'=>array('买号相关提醒'=>'ft_buyer','信用额度过低提醒'=>'ft_credit_low','使用预定特权卡，预定到任务'=>'ft_destine','发布方确认付款'=>'ft_pay','发布方确认发货'=>'ft_ship','成功接手任务'=>'ft_take'),
	'任务发布提醒'=>array('接手人平台确认好评'=>'jt_comment','接手人平台确认付款'=>'jt_pay','接手人平台确认收货'=>'jt_shouhuo','发布的任务被人接手'=>'jt_take'),
	'账户记录提醒'=>array('资料更改提醒'=>'u_edit','封号通知'=>'u_lock','帐号挂起通知'=>'u_pause','会员到期提醒'=>'u_vip')
);






$opt = isset($_REQUEST['opt']) ? trim($_REQUEST['opt']) : ''; 

if(!in_array($opt, array('myRest', 'rootRest', 'newDate', 'instation','del')))
{
    $opt = 'myRest';
}
$view->assign('opt', $opt);
$view->assign('instation', $instation);
if(IS_POST)
{
	$delid=isset($_POST['msg'])?$_POST['msg']:'';
	$set=isset($_POST['set'])?$_POST['set']:'';
	switch($set){
		case 'delete_mes':
			if(count($delid)>0&&is_array($delid)){
				foreach($delid as $val){
					$db->Execute("delete from mcs_member_message where tuid=".$uinfo['user_id']." and  id={$val}");
				}
			}
		break;

		case 'read_mes':
			if(count($delid)>0&&is_array($delid)){
				foreach($delid as $val){
					$db->Execute("update mcs_member_message set state='1' where tuid=".$uinfo['user_id']." and id={$val}");
				}
			}
		break;

		case 'no_mes':
			if(count($delid)>0&&is_array($delid)){
				foreach($delid as $val){
					$db->Execute("update mcs_member_message set state='0' where tuid=".$uinfo['user_id']." and id={$val}");
				}
			}
		break;

		case 'readAll_mes':
			$db->Execute("update mcs_member_message set state='1' where tuid={$uinfo['user_id']}");
		break;

		case 'noAll_mes':
			$db->Execute("update mcs_member_message set state='0' where tuid={$uinfo['user_id']}");
		break;

		case 'getinfo'://弹出消息
			$cid=isset($_POST['cid'])?intval($_POST['cid']):'';
			if($cid){
				$con=$db->getRow('select * from mcs_member_message where id='.$cid.' and tuid='.$uinfo['user_id']);
				if(count($con)){
					$uid=$con['fuid'];
					if($uid==$uinfo['user_id']){
						$uid=$con['guid'];
					}
					if($uid>0){
						$info=$db->pagestrs('select * from mcs_member_message where tuid='.$uinfo['user_id'].' and ((fuid='.$con['fuid'].' and guid='.$con['guid'].') or (guid='.$con['fuid'].' and fuid='.$con['guid'].')) order by gettime desc',6,5,'getinfos','cid:'.$cid);
						$pagestr=$info['pagestr'];
						$info=$info['record'];
					}else{
						$info[0]=$con;
					}

					if(count($info)){
						foreach($info as $k => $v){
							if($v['state']==0){
								$db->Execute('update mcs_member_message set state=1 where id='.$v['id']);
							}
							if($v['fuid']==$uinfo['user_id']){
								$info[$k]['class']='my';
								$info[$k]['name']='自己';
							}else{
								$info[$k]['class']='his';
								if($v['fuid']==0){
									$info[$k]['name']='admin';
								}else{
									$info[$k]['name']=getuname($v['fuid'],$db);
								}
							}
							$info[$k]['gettime']=date("Y-m-d H:i:s",$v['gettime']);
						}
					}
					$view->assign('cid', $cid);
					$view->assign('pagestr', $pagestr);
					$view->assign('info', $info);
					$view->assign('count', count($info));
				}
				$view->display('user/usepersonal/info');
			}
			exit;
		break;
			
		case 'hasuser'://判断用户是否存在
			$uname=isset($_POST['uname'])?trim($_POST['uname']):'';
			if(!empty($uname)){
				echo $db->getCount("mcs_users","user_name='{$uname}'");
			}
			exit;
		break;

		case 'newDate':
			if(IS_AJAX){
				$data['info']='访问出错~';
				$message = htmlspecialchars(trim($_REQUEST['message']),ENT_QUOTES);
				$uname=isset($_POST['username'])?trim($_POST['username']):'';
				$uid=$db->getField("mcs_users",'user_id',"user_name='{$uname}'");
				if($uid){
					if($uid==$uinfo['user_id']){
						$data['info']="不能给自己留言~";
					}elseif(!empty($message)){
						if(isset($_SESSION['message'])&&$_SESSION['message']>time()){
							$data['info']="发送消息速度过快，休息一下吧~";
						}else{
							$has=$db->getField('mcs_member_message','id','tuid='.$uinfo['user_id'].' and ((fuid='.$uinfo['user_id'].' and guid='.$uid.') or (guid='.$uinfo['user_id'].' and fuid='.$uid.')) and pid=0');
							//$state=1;
							$state=0;
							if(empty($has)){
								$has=0;
							}
							$db->Execute("insert mcs_member_message(pid,tuid,fuid,guid,content,gettime,state) value('".$has."',".$uinfo['user_id'].",'".$uinfo['user_id']."','{$uid}','{$message}',".time().",".$state.")");
							
							$has=$db->getField('mcs_member_message','id','tuid='.$uid.' and ((fuid='.$uinfo['user_id'].' and guid='.$uid.') or (guid='.$uinfo['user_id'].' and fuid='.$uid.')) and pid=0');
							$state=0;
							if(empty($has)){
								$has=0;
							}
							
							$db->Execute("insert mcs_member_message(pid,tuid,fuid,guid,content,gettime) value('".$has."',".$uid.",'".$uinfo['user_id']."','{$uid}','{$message}',".time().")");
							$data['info']="消息发送成功~";
							$data['state']=1;
							//$_SESSION['message']=time()+30;
							$_SESSION['message']=time()+3;
						}
					}else{
						$data['info']="请填写内容";
					}
				}else{
					$data['info']="用户不存在";
				}
				echo json_encode($data);
				exit;
			}
		break;

		case 'instation':
			if(IS_AJAX){
				
				$data['info']='访问出错~';
				if(isset($_POST['reset'])&&$_POST['reset']==1){
					$db->Execute('update mcs_users set mess_set="" where user_id='.$uinfo['user_id']);
					$data['info']='重置成功~';
				}else{
					$safepass=trim($_POST['safecode']);
					if(empty($safepass)||cipherStr($safepass)!=$uinfo['safepass']){
						$data['info']='安全码验证失败~';
					}else{
						foreach($instation as $v){
							foreach($v as $s){
								if($_POST[$s]['website']==1){
									$mess_set[$s]['website']=1;
								}
								if($_POST[$s]['mobile']==1){
									$mess_set[$s]['mobile']=1;
								}
							}
						}
						if($mess_set){
							$db->Execute('update mcs_users set mess_set=\''.serialize($mess_set).'\' where user_id='.$uinfo['user_id']);
						}
						$data['info']='修改成功~';
					}
				}
				echo json_encode($data);
				exit;
			}
		break;
	}
}

//$page=$db->page("select * from mcs_member_message where tuid=".$uinfo['user_id']." and pid=0 and fuid>0 order by gettime desc",10,5);
//$page=$db->page("select * from mcs_member_message where tuid=".$uinfo['user_id']." and fuid != 0 order by gettime desc",10,5);

$page=$db->page("select * from mcs_member_message where tuid=".$uinfo['user_id']." and fuid != 0 order by gettime desc",10,5);


if(count($page['record'])){
	foreach($page['record'] as $k => $v){
		//print_r($v);
		//$ms=$db->getRow('select * from mcs_member_message where pid='.$v['id'].' order by gettime desc');
		$ms=$db->getRow('select * from mcs_member_message where pid='.$v['id'].' order by gettime desc');
		//print_r($ms);
		if($ms['gettime']){
			if($v['fuid']==$v['tuid']){
				$ms['guid']=$v['guid'];
			}else{
				$ms['guid']=$v['fuid'];
			}
			$v=$ms;
			$page['record'][$k]=$v;
			
		}
		$page['record'][$k]['content']=mb_substr($v['content'],0,28,'utf-8');
		if(strlen($v['content'])>28){
			$page['record'][$k]['content'].='...';
		}
		$page['record'][$k]['name']=getuname($v['guid'],$db);
		$page['record'][$k]['gettime']=date('Y-m-d H:i',$v['gettime']);
	} 
}


$view->assign('page', $page);
//$sql="select * from mcs_member_message where guid={$uinfo['user_id']} and fuid=0 and pid=0 and tuid=guid order by state,gettime desc";
$sql="select * from mcs_member_message where guid={$uinfo['user_id']} and fuid=0  and tuid=guid order by state,gettime desc";
$rootpage=$db->page($sql,10,5);

// pre($rootpage);die;
if(count($rootpage['record'])){
	foreach($rootpage['record'] as $k => $v){
		$rootpage['record'][$k]['content']=mb_substr($v['content'],0,40,'utf-8');
		if(strlen($v['content'])>40){
			$rootpage['record'][$k]['content'].='...';
		}
		$rootpage['record'][$k]['name']='admin';
		$rootpage['record'][$k]['gettime']=date('Y-m-d',$v['gettime']);
	} 
}
$view->assign('rootpage', $rootpage);
$view->assign('read', count($page['record']));
function getuname($fuid,&$db){
	$fuid=intval($fuid);
	if($fuid){
		return $db->getField("mcs_users",'user_name','user_id='.$fuid);
	}
}
// pre($rootpage);die;
$view->display('user/userpersonal');
?>
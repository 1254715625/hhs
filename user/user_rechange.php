<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}

$Recovery = isset($_REQUEST['Recovery']) ? trim($_REQUEST['Recovery']) : ''; 

if(!in_array($Recovery, array('maipoint', 'integral','welfare')))
{
    $Recovery = 'maipoint';
}
$view->assign('Recovery', $Recovery);

$vip=$db->getAll('select * from mcs_user_rank where special=1 order by rank_id asc');

$class=array('2','4','3','3');
foreach($vip as $k => $v){
	$vip[$k]['class']=$class[$k];
}
unset($vip[0]);
//var_dump($vip);
$view->assign('vip', $vip);

if(IS_POST&&IS_AJAX){
	$data['info']='操作出错！';
	switch($Recovery){
		case 'maipoint':
			$nums=isset($_POST['nums'])?intval($_POST['nums']):0;
			$safecode=trim($_POST['safecode']);
			if($nums==0){
				$data['info']='兑换失败~';
			}elseif(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
				$data['info']='安全码验证失败~';
			}elseif($uinfo['pay_money']<$nums+3){
				$data['info']="对不起，您的麦点小于".$nums."+3 (需保留3个麦点)~";
			}else{
				$pay_money=$uinfo['pay_money']-$nums;

				$user_money=$uinfo['user_money']+$nums*$uinfo['params']['sdhsjg'];
				if($db->Execute("update mcs_users set pay_money=".$pay_money.",user_money=".$user_money." where user_id=".$uinfo['user_id'])){
					$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','".$nums*$uinfo['params']['sdhsjg']."','兑换".$nums."个刷点','存款日志',".$user_money.",'payde')");//存款日志
					$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','刷点兑换存款','-".$nums."','刷点日志',".$pay_money.",'logpoint')");//刷点日志
					$data['info']="回收成功，麦点已转换为相应金额~";
					
					//回收卖点通知
					$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
					$resul=unserialize($resulta['mess_set']); 
					$resl=$resul['f_buy_maidian'];
					if($resl['website'] == 1 ){
						$time=date('Y-m-d H:i ',time());
						$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','成功兑换".$nums."个刷点,获得".$nums*$uinfo['params']['sdhsjg']."元','0','".time()."') ");
					}
				}
			}
		break;

		case 'integral':
			$num_arr=array(1,2,4,8,10,20);
			$rank_points=isset($_POST['rank_points'])?intval($_POST['rank_points']):0;
			$safecode=trim($_POST['safecode']);
			if(!in_array($rank_points,$num_arr)){
				$data['info']='兑换失败~';
			}elseif(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
				$data['info']='安全码验证失败~';
			}elseif(($uinfo['rank_points']-($rank_points*100))<1000){
				$data['info']='对不起，您的可换积分低于最小兑换~';
			}else{
				$pay_money=$uinfo['pay_money']+$rank_points;
				$rank_point=$uinfo['rank_points']-$rank_points*100;
				if($db->Execute("update mcs_users set pay_money=".$pay_money.",rank_points=".$rank_point." where user_id=".$uinfo['user_id'])){

					$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".$rank_point."','兑换".$rank_points."个刷点','积分日志',-".($rank_points*100).",'logcredit')");//积分日志

					$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','兑换".($rank_points*100)."积分','".$rank_points."','刷点日志',".$pay_money.",'logpoint')");//刷点日志
					
					$data['info']="兑换成功，积分已转换为相应刷点~";
				}
			}
		break;

		case 'welfare':
			$data['info']='访问出错~';
			$rank=intval($_POST['type']);
			$safecode=trim($_POST['safecode']);
			if(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
				$data['info']='安全码验证失败~';
			}else{
				$vipinfo=$db->getRow('select * from mcs_user_rank where special=1 and rank_id='.$rank);
				if($uinfo['brush_time']>0){
					$data['info']='对不起，您是职业刷客，必须到期后才能购买VIP特权~';
				}elseif(!empty($vipinfo)){
					if($uinfo['pay_money']>=$vipinfo['point']){
						$st='兑换';
						if($rank==$uinfo['user_rank']){
							$st='续费';
							$time=$uinfo['rank_expiry']+30*86400;//续费
						}else{
							$time = strtotime("1months", time());
						}
						$sql = 'update mcs_users set pay_money=pay_money-'.$vipinfo['point'].', user_rank='.$rank.', rank_expiry='.$time.' where user_id='.$uinfo['user_id'];
						if($db->Execute($sql))
						{
							$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','".$st.$vipinfo['rank_name']."一个月','-".$vipinfo['point']."','刷点日志',".($uinfo['pay_money']-$vipinfo['point']).",'logpoint')");//刷点日志
							$data['info']='购买成功~';
							$data['status']=1;
						}
					}else{
						$data['info']='抱歉，您的刷点不足，请<a href="home.php?act=buypoint" style="color:red">购买</a>~';
					}
				}else{
					$data['info']='你要兑换的选项不存在~';
				}
			}
		break;
	}
	echo json_encode($data);
	exit;
}
if(($uinfo['rank_points']-1000)>0){
	$rank_points=$uinfo['rank_points']-1000;
}else{
	$rank_points=0;
}
$view->assign('rank_points', $rank_points);
$view->display('user/rechange');
?>
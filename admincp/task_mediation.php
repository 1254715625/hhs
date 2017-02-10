<?php
require 'init.php';
$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
$view->assign('id', $id);
if($id){
	$info=$db->getRow("select * from mcs_task_appeal where pid=0 and id=".$id);
	if($info['task_type']=='tb'){
		$info['process']=$db->getField('mcs_task_taobao', 'process', "id='$info[task_id]'");
		$info['task_uid']=$db->getField('mcs_task_taobao', 'uid', "id='$info[task_id]'");
	}
	if($info['task_type']=='pp'){
		$info['process']=$db->getField('mcs_task_paipai', 'process', "id='$info[task_id]'");
	    $info['task_uid']=$db->getField('mcs_task_taobao', 'uid', "id='$info[task_id]'");
	}
	$info['task']=strtoupper($info['task_type']).$info['task_id'];
	$info['qq']=$db->getField('mcs_users', 'qq', "user_id='$info[uid]'");
	$info['rank_points']=$db->getField('mcs_users', 'rank_points', "user_id='$info[uid]'");
	$info['pay_money']=$db->getField('mcs_users', 'pay_money', "user_id='$info[uid]'");
	$info['user']=$db->getField('mcs_users', 'user_name', "user_id='$info[uid]'");
	$info['add_time']=date('Y-m-d H:i:s',$info['add_time']);
	$lists=$db->getAll("select uid,content,add_time from mcs_task_appeal where pid=".$info['id']." order by add_time desc");
	foreach($lists as $key => $val){
		$lists[$key]['user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
		$lists[$key]['user'].=($val['uid']==$info['task_uid'])?'(被申诉方)':'(申诉方)';
		$lists[$key]['add_time']=date('Y-m-d H:i:s',$val['add_time']);
	}
	if(IS_POST){
		$handle=intval($_POST['handle']);
		$num=intval($_POST['num']);
		$task_uid=$_POST['task_uid'];
		$dingdan_id=$db->getField('mcs_task_appeal','task_id',"id = '".$id."' ");
		$arr=$db->getRow("select b.user_id,b.pay_money,b.rank_points from mcs_task_appeal as  a,mcs_users as b where a.uid = b.user_id and task_id = '".$dingdan_id."' ");

		$state=1;
		$over=isset($_POST['over'])?trim($_POST['over']):''; //判定内容
		if($over!=''&&$handle>0){
			switch($handle){
				case 1: //扣积分
					$a=$db->Execute("update mcs_users set rank_points = rank_points + '".$num."' where user_id =" .$arr['user_id']);
					$db->Execute("update mcs_users set rank_points=rank_points-$num where user_id=$task_uid");
					 $now=$db->getField("mcs_users","rank_points","user_id=$task_uid");
					 $db->Execute("insert into mcs_member_logs(uid,createtime,integral,info,logtype,num,type) value('$task_uid','".time()."','-$num','任务$info[task]申诉处理结果为扣除积分$num分','积分日志',".$now.",'logcredit')");//扣除日志

					//扣除积分提醒通知
					$result=$db->getRow("select uid from mcs_task_taobao where id = " .$info['task_id']);
					$resulta=$db->getRow("select mess_set,mobile_phone from mcs_users where user_id = '".$result['uid']."' ");
					$resul=unserialize($resulta['mess_set']);
					$resl=$resul['c_minus_integral'];
					if($resl['website'] == 1 ){
						$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value (".$info['aid'].",'".$info['aid']."','你的订单{$info['task_id']}审核结果通过,你被扣除积分 {$num} 分','0','".time()."') ");
					}

                    //订单删除
                    $db->Execute("delete from mcs_task_taobao where id = " .$dingdan_id);

				break;

				case 2: //扣刷点

					//举报成功
					$result=$db->getRow("select * from mcs_task_taobao where id = '".$dingdan_id."' ");
                   // $db->Execude("update mcs_users set  pay_money=pay_money + '".."' where user_id= '".$result['uid']."'  ");
					$db->Execute("update mcs_users set pay_money=pay_money - '" .$num."',user_money = user_money + '".$result['goods_price']."' where user_id=$task_uid");
					$now=$db->getField("mcs_users","pay_money","user_id=$task_uid");
					 $db->Execute("insert into mcs_member_logs(uid,createtime,pay_point,info,logtype,num,type) value('$task_uid','".time()."','-$num','任务$info[task]申诉处理结果为扣除刷点$num点','刷点日志',".$now.",'logpoint')");//扣除日志
                    //订单删除
                    $db->Execute("delete from mcs_task_taobao where id = " .$dingdan_id);
				break;

				case 3://撤销
					$db->Execute("update mcs_task_taobao set process = 0 ,get_user = 0,get_time = 0 ,appeal = 0 ,timing = 0 where id = " .$dingdan_id);
					$state=2;
				break;

				case '4': //胡乱举报,扣除举报人卖点
                    $db->Execute("update mcs_task_taobao set process = 0 ,get_user = 0,get_time = 0 ,appeal = 0 ,timing = 0 where id = " .$dingdan_id);
					$db->Execute("update mcs_users set pay_money = pay_money - '".$num."' where user_id = " .$arr['user_id']);
			}



			//投诉审核信息通知
			if($handle == 1 ){
				$messge='扣除积分';
			}elseif($handle == 2){
				$messge='扣除刷点';
			}elseif($handle == 3){
				$messge='申诉撤销';
			}
			$result=$db->getRow("select uid from mcs_task_taobao where id = " .$info['task_id']);
			$resulta=$db->getRow("select mess_set,mobile_phone from mcs_users where user_id = '".$result['uid']."' ");
			$resul=unserialize($resulta['mess_set']);
			$resl=$resul['c_complaint_result'];
			if($resl['website'] == 1 ){
				$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value (".$info['aid'].",'".$info['aid']."','你的订单{$info['task_id']}审核结果为{$messge}','0','".time()."') ");
			}
            
			$table='mcs_task_taobao';
			if($info['task_type']=='pp'){$table='mcs_task_paipai';}
			//$db->Execute('update '.$table.' set process=4 where id='.$info['task_id']);
			$status=$db->Execute("update mcs_task_appeal set state=".$state.",over='".$over."' where id=".$id);
			if($status){
						Message('操作成功',0,'task_appeal.php');
					}
			echo '<script type="text/javascript">location.href="task_appeal.php";</script>';exit;

		}

	}
}

$result=$db->getRow("select user_id,mess_set,mobile_phone,pay_money,rank_points ,mobile_phone from mcs_users where user_id = ". $info['aid']);
$info['upay_money']=$result['pay_money'];
$info['urank_points']=$result['rank_points'];
$info['mobile_phone']=$result['mobile_phone'];
//短信通知

$view->assign('info', $info);
$view->assign('lists', $lists);
$view->assign('mobile_phone',$info['mobile_phone']);//'18895596968'
$view->assign('num', count($list['record']));
$view->display('task_mediation');
?>

<?php
require 'init.php';
// pre($_CFG);die;
$state=0;

if($_GET['show']){$state=1;}
$view->assign('state', $state);
if($state==0){$state='and mcs_users.business_time+mcs_member_set.freeze<='.time();}
if($state==1){$state='and mcs_users.business_time+mcs_member_set.freeze>'.time();}
$page=$db->page('select * from mcs_users join mcs_user_rank on mcs_user_rank.rank_id=mcs_users.user_rank join mcs_member_set on mcs_user_rank.rank_name=mcs_member_set.rank_name where mcs_users.business>0 and mcs_users.business_time>0 '.$state.' order by business_time asc',15,5);
$lists=$page['record'];
// echo "<pre>";
// print_r($lists);die;
foreach($lists as $key => $val){
	$lists[$key]['business_time']=date('Y-m-d H:i:s',$val['business_time']);
}
$view->assign('page', $page);
$view->assign('lists', $lists);
if(IS_POST&&IS_AJAX){
	$act=trim($_GET['act']);
	$data['info']='访问出错~';
	switch($act){
		case 'tg':
            $user_id=$_POST['user'];
            $result=$db->getRow("select c.freeze from mcs_user_rank as a ,mcs_users as b,mcs_member_set as c  where a.rank_id = b.user_rank  and c.rank_name=a.rank_name and b.user_id = '".$user_id."'");
            $tbtime=$result['freeze'];
            $t=time()-(($tbtime/86400)*86400);
            if($tbtime == 0){
                $user=$db->getRow('select * from mcs_users where business>0 and business_time>0  and  user_id='.intval($user_id));
            }else{
               // $user=$db->getRow('select * from mcs_users where business>0 and business_time>0  and business_time <= '.$t.' and  user_id='.intval($user_id));
                $user=$db->getRow('select * from mcs_users where business>0 and business_time>0  and (( ' .time().' + '.$t.')-business_time ) >0  and  user_id='.intval($user_id));
            }

			if($user['user_id']){
				if($db->Execute('update mcs_users set user_money=user_money+business,business=0,business_time=0 where user_id='.$user['user_id'])){
					$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$user['user_id'].",'".time()."','".$user['business']."','退出商保服务','存款日志',".($user['user_money']+$user['business']).",'payde')");//存款日志
					$db->Execute("insert into mcs_member_message(pid,fuid,tuid,guid,content,state,gettime) values(0,0,'".$user_id."','".$user_id."','您已退出商保',0,".time().")");
					$data['state']='1';
				}else{
					$data['info']='该记录已处理或不存在~';
				}
			}else{
				$data['info']='可退保用户未到期或不存在~';
			}
		break;
		case 'utg':
			$ju=trim($_POST['ju']);
			$id=trim($_POST['user']);
			if(empty($ju)){
				$data['info']='请填写拒绝原因~';
			}elseif($db->Execute("insert mcs_user_message(uid,addtime,message) values($id,'".time()."','".$ju."')")){
				$db->Execute("update mcs_users set business_time=0 where user_id=".$id);
				$data['state']='1';
			}else{
				$data['info']='该记录已处理或不存在~';
			}
		break;
		case 'unfreeze':
			if($db->Execute("update mcs_users set business_time=1 where business>0 and business_time>0 and user_id=".$_POST['id'])){
				echo 1;
			}else{
				echo 0;
			}die;
		break;
	}
	echo json_encode($data);
	exit;
}


$view->display('task_business');
?>
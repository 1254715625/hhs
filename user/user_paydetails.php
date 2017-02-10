<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}

$pay = isset($_REQUEST['pay']) ? trim($_REQUEST['pay']) : ''; 
if(!in_array($pay, array('payde', 'logpoint', 'logcredit', 'logtask','logtopup','logpayment','logaccount')))
{
    $pay = 'payde';
}
$view->assign('pay', $pay);

$logstype = isset($_REQUEST['logstype']) ? trim($_REQUEST['logstype']) : ''; 
if(!in_array($logstype, array('payde', 'logpoint', 'logcredit', 'logtask','logtopup','logpayment','logaccount')))
{
    $logstype = 'payde';
}

$weekstar = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));//上周零点
$dateStart=isset($_REQUEST['dateStart']) ? strtotime(trim($_REQUEST['dateStart'])) : 0; 
if($dateStart){$weekstar=date("Y-m-d H:i:s",$dateStart);}
$view->assign('weekstar', $weekstar);

$dateEnd=isset($_REQUEST['dateEnd']) ? strtotime(trim($_REQUEST['dateEnd'])) : 0;
$weekend = date("Y-m-d H:i:s");
if($dateEnd){$weekend=date("Y-m-d H:i:s",$dateEnd);}
$view->assign('weekend', $weekend);

switch($pay){
	case "payde"://存款日志
		$sql="select logtype,info,user_money,num,createtime from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
			$lists[$key]['user_money']=$val['user_money']>0?'+'.$val['user_money']:$val['user_money'];
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

	case "logpoint"://刷点日志
		$sql="select logtype,info,pay_point,num,createtime from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
			$lists[$key]['pay_point']=$val['pay_point']>0?'+'.$val['pay_point']:$val['pay_point'];
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

	case "logcredit"://积分日志
		$sql="select logtype,info,integral,num,createtime from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
			$lists[$key]['integral']=$val['integral']>0?'+'.$val['integral']:$val['integral'];
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

	case "logtask"://任务日志
		$sql="select logtype,taskid,info,createtime from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

	case "logtopup"://充值
		
	break;

	case "logpayment"://提现
		$sql="select * from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		$statearr=array('处理中','已成功','已拒绝');
		$stateclass=array('blue','green','red');
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
			if($val['gettime']){
				$lists[$key]['state']=date('Y-m-d H:i:s',$val['gettime']);
			}else{
				$lists[$key]['gettime']='';
			}
			$lists[$key]['state']=$statearr[$val['state']];
			$lists[$key]['class']=$stateclass[$val['state']];
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

	case "logaccount"://登陆
		$sql="select logtype,ip,info,createtime from mcs_member_logs where uid=".$uinfo['user_id']." and type='".$pay."'";
		if($dateStart){
			$sql.=" and createtime>=".$dateStart;
		}
		if($dateEnd){
			$sql.=" and createtime<=".$dateEnd;
		}
		$page=$db->page($sql." order by createtime desc",8,15);
		$lists=$page['record'];
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
		}
		$view->assign('page', $page);
		$view->assign('lists', $lists);
	break;

}

$view->display('user/paydetails');
?>
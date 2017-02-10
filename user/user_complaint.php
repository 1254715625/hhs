<?php
if(substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1)!='user.php'){
	header('location: ../user.php');
}
$opt = isset($_REQUEST['opt']) ? trim($_REQUEST['opt']) : '';
$see = isset($_REQUEST['see']) ? trim($_REQUEST['see']) : 0;

if(IS_POST){
	$info = isset($_REQUEST['info'])?trim($_REQUEST['info']): '';
	if($see){
		$db->Execute("insert into mcs_task_appeal(uid,content,add_time,pid) values($uinfo[user_id],'$info',".time().",$see)");
	}
}
if(!in_array($opt, array('launch', 'receive', 'lclaims', 'rclaims', 'see')))
{
    $opt = 'launch';
}
$appeal_state=$db->getCount("mcs_task_appeal","(uid=$uinfo[user_id] or aid=$uinfo[user_id]) and pid=0 and state=0");//投诉信息
$view->assign('appeal_state', $appeal_state);
$view->assign('opt', $opt);

switch($opt){
	case 'launch':
		$page=$db->page("select * from mcs_task_appeal where uid=".$uinfo['user_id']." and pid=0 order by add_time desc",5,5);
		$list=$page['record'];
		foreach($list as $key => $val){
			$list[$key]['user']=$db->getField('mcs_users', 'user_name', "user_id='$val[aid]'");
			$list[$key]['add_time']=date('m-d H:i',$val['add_time']);
		}
		$view->assign('page', $page);
		$view->assign('list', $list);
		$view->assign('list_num', count($list));
	break;

	case 'receive':
		$page=$db->pagestr("select * from mcs_task_appeal where aid=".$uinfo['user_id']." order by add_time desc",5,5);
		$list=$page['record'];
		foreach($list as $key => $val){
			$list[$key]['user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
			$list[$key]['add_time']=date('m-d H:i',$val['add_time']);
		}
		$view->assign('page', $page);
		$view->assign('list', $list);
		$view->assign('list_num', count($list));
	break;

	case 'see':
		$view->display('user/see');
		exit;
	break;
}

if($see){
	$info=$db->getRow("select * from mcs_task_appeal where pid=0 and id=".$see);
	if($info['task_type']=='tb'){
		$info['process']=$db->getField('mcs_task_taobao', 'process', "id='$info[task_id]'");
	}
	if($info['task_type']=='pp'){
		$info['process']=$db->getField('mcs_task_paipai', 'process', "id='$info[task_id]'");
	}
	$qid=($info['uid']==$uinfo['user_id'])?$info['aid']:$info['uid'];
	$info['task']=strtoupper($info['task_type']).$info['task_id'];
	$info['qq']=$db->getField('mcs_users', 'qq', "user_id='$qid'");
	$info['user']=$db->getField('mcs_users', 'user_name', "user_id='$info[uid]'");
	$info['add_time']=date('Y-m-d H:i:s',$info['add_time']);
	$lists=$db->getAll("select uid,content,add_time from mcs_task_appeal where pid=".$info['id']." order by add_time desc");
	foreach($lists as $key => $val){
			$lists[$key]['user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
			$lists[$key]['user'].=($val['uid']==$info['uid'])?'(申诉方)':'(被申诉方)';
			$lists[$key]['add_time']=date('Y-m-d H:i:s',$val['add_time']);
	}
	$view->assign('info', $info);
	$view->assign('lists', $lists);
	$view->display('user/appeal');
	exit;
}
$view->display('user/complaint');
?>
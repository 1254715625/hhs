<?php
require 'init.php';

$opt = preg_replace('/[^\[A-Za-z0-9_\]]/', '', $action);
$opt = empty($opt) ? 'tbbuy' : $opt;

$hang=isset($_REQUEST['hang'])?$_REQUEST['hang']:0;
$unhang=isset($_REQUEST['unhang'])?$_REQUEST['unhang']:0;
$lock=isset($_REQUEST['lock'])?$_REQUEST['lock']:0;
$unlock=isset($_REQUEST['unlock'])?$_REQUEST['unlock']:0;
$del=isset($_REQUEST['del'])?$_REQUEST['del']:0;
if($hang){
	
	$db->Execute("update mcs_member_bindacc set is_hang=1,hang_time=".time()." where id=$hang");
	echo '<script type="text/javascript">location.href="task_manager.php?action='.$action.'";</script>';
	exit;
}
if($unhang){
	$db->Execute("update mcs_member_bindacc set is_hang=0,unhang_time=".time()." where id=$unhang");
	echo '<script type="text/javascript">location.href="task_manager.php?action='.$action.'";</script>';
	exit;
}
if($lock){
	$db->Execute("update mcs_member_bindacc set is_lock=1,lock_time=".time()." where id=$lock");
	echo '<script type="text/javascript">location.href="task_manager.php?action='.$action.'";</script>';
	exit;
}
if($unlock){
	$db->Execute("update mcs_member_bindacc set is_lock=0,unlock_time=".time()." where id=$unlock");
	echo '<script type="text/javascript">location.href="task_manager.php?action='.$action.'";</script>';
	exit;
}
if($del){
	$db->Execute("delete from mcs_member_bindacc where id=$del");
	echo '<script type="text/javascript">location.href="task_manager.php?action='.$action.'";</script>';
	exit;
}

$where = '';
switch($opt)
{
    case 'tbbuy':
        $where = "acc_type = 'tb' and buyno=0";
		$table="mcs_task_taobao";
		$field='get_user=';
        break;

    case 'tbsel':
        $where = "acc_type = 'tb' and buyno=1";
		$table="mcs_task_taobao";
		$field='accid=';
        break;

    case 'ppbuy':
        $where = "acc_type = 'pp' and buyno=0";
		$table="mcs_task_paipai";
		$field='get_user=';
        break;

    case 'ppsel':
        $where = "acc_type = 'pp' and buyno=1";
		$table="mcs_task_paipai";
		$field='accid=';
        break;
}
$user_num=$db->getCount('mcs_member_bindacc', $where);
$view->assign('user_num', $user_num);

$sql = "select a.*,b.user_name from mcs_member_bindacc a,mcs_users b";
if($where){$sql .= " where a.uid=b.user_id and $where";}
$list = $db->page($sql.' order by uid asc,is_lock desc,is_hang desc',12,4);

foreach($list['record'] as $k => $val){
	$list['record'][$k]['attr'] = unserialize($val['value']);
	$list['record'][$k]['state'] = ($val['is_lock']==0)?(($val['is_hang']==0)?'正常':'<font color=green>挂起</font>'):(($val['is_hang']==0)?'<font color=red>锁定</font>':'<font color=red>挂起并锁定</font>');

	$list['record'][$k]['doing']=$db->getCount($table,$field.$val['id'].' and process<4 and get_user>0');
	$list['record'][$k]['complete']=$db->getCount($table,$field.$val['id'].' and process=4 and get_user>0');
}
$view->assign('opt', $opt);

$view->assign('list', $list);
$view->display('task_manager');
?>

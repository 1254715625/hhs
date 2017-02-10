<?php
require 'init.php';
$opt = preg_replace('/[^\[A-Za-z0-9_\]]/', '', trim($_GET['opt']));
$opt = empty($opt) ? 'tbbuy' : $opt;
$view->assign('opt', $opt);
switch($opt){
	case 'tbbuy':
		$where="and a.aid=b.uid and a.task_type='tb'";
	break;

	case 'tbsel':
		$where="and a.uid=b.uid and a.task_type='tb'";
	break;

	case 'ppbuy':
		$where="and a.aid=b.uid and a.task_type='pp'";
	break;

	case 'ppsel':
		$where="and a.uid=b.uid and a.task_type='pp'";
	break;

}


$sql = "select a.*,b.process from mcs_task_appeal a,mcs_task_taobao b where a.task_id=b.id ".$where."  and a.pid=0 order by add_time desc";//and a.state=0

$list = $db->page($sql,12,4);
//var_dump($list['record']);
$process=array('等待接手方付款','接手方已付款，等待发布方发货','发布方已发货，等待接手方好评','接手方已确认，等待发布方核实','完成'); 
foreach($list['record'] as $k => $val){
	//$attr = unserialize($val['value']);
	//$list['record'][$k]['state']=($val['is_lock']==0)?(($val['is_hang']==0)?'正常':'<font color=green>挂起</font>'):(($val['is_hang']==0)?'<font color=red>锁定</font>':'<font color=red>挂起并锁定</font>');
	$list['record'][$k]['task']=strtoupper($val['task_type']).$val['task_id'];
	$list['record'][$k]['user']=$db->getField('mcs_users','user_name','user_id='.$val['uid']);
	$list['record'][$k]['aser']=$db->getField('mcs_users','user_name','user_id='.$val['aid']);
	$list['record'][$k]['process']=$process[$val['process']];
	$list['record'][$k]['add_time']=date('Y-m-d H:i:s',$val['add_time']);
}
//var_dump($list['record']);
$view->assign('list', $list);
$view->assign('num', count($list['record']));
$view->display('task_appeal');
?>
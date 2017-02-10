<?php
require 'init.php';
$opt = preg_replace('/[^\[A-Za-z0-9_\]]/', '', $_GET['opt']);
$opt = empty($opt) ? 'all' : $opt;

switch($opt)
{
    case 'all'://全部
        $where = "id>0";
        break;

    case 'wait'://等待接手
        $where = "process=0 and get_user=0";
        break;

    case 'doing'://进行中
        $where = "get_user>0";
        break;

    case 'kwait'://等待快递单号
        $where = "id>0";
        break;
	case 'over'://已完成
        $where = "process=4";
        break;
	case 'puse'://暂停
        $where = "process=5";
        break;
}

$type=isset($_REQUEST['type'])?$_REQUEST['type']:'tb';
$state = array('未付款', '等待发布方发货', '等待接手方好评', '等待发布方打款', '任务完成', '任务暂停');

$table=($type=='pp')?'mcs_task_paipai':'mcs_task_taobao';
$sql = "select a.*,b.user_name from $table a,mcs_users b where a.uid=b.user_id and $where";
$list = $db->page($sql,12,8);

$task_type =  array('', '单个商品任务', '来路任务', '套餐任务', '购物车任务', '搜索任务');

foreach($list['record'] as $k => $v){
	$list['record'][$k]['attr'] = unserialize($v['value']);
	$list['record'][$k]['task'] = strtoupper($type).$v['id'];
	$list['record'][$k]['guser'] = $db->getField('mcs_member_bindacc a,mcs_users b','user_name','a.id='.intval($v['get_user']).' and a.uid=b.user_id');
	$list['record'][$k]['types']=$task_type[$v['task_type']];
	$list['record'][$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
	$list['record'][$k]['states']=$state[$v['process']];
	
}

$view->assign('type', $type);
$view->assign('opt', $opt);
$view->assign('state', $state);
$view->assign('list', $list);
$view->assign('num', count($list['record']));
$view->assign('task_type', $task_type);
$view->display('task_brushdrill');
?>

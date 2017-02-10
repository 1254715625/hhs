<?php
require 'init.php';

if(IS_POST&&IS_AJAX){
	$data=intval($_POST['data']);
	$safecode=trim($_POST['safecode']);
	$act=trim($_GET['act']);
	switch($act){
		case 'deliver':
		if($data&&$safecode){
			$db->Execute('update mcs_task_express set status=1,eid="'.$safecode.'" where type=1 and status=0 and id='.intval($data));
		}
		break;
		case 'change':
		if($data&&$safecode){
			$db->Execute('update mcs_task_express set eid="'.$safecode.'" where type=1 and status=1 and id='.intval($data));
		}
		break;
		
	}
	die();
}
$sql="select * from mcs_task_express where type=1 and uid>0 order by addtime desc";
$list = $db->page($sql,12,4);
if(count($list['record'])){
	foreach($list['record'] as $k => $v){
		$list['record'][$k]['send_adds']=cnsubstr($v['send_add'],22);
		$list['record'][$k]['to_adds']=$v['to_add'];
		$list['record'][$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
		$list['record'][$k]['user']=$db->getField('mcs_users','user_name','user_id='.$v['uid']);
		$list['record'][$k]['state']=$status_arr[$v['status']];
		if($v['status']){
			$list['record'][$k]['cz']='<a href="javascript:;" class="act xg" style="color:green" data="'.$v['id'].'" alt="'.$v['eid'].'">修改单号</a>';
		}else{
			$list['record'][$k]['cz']='<a href="javascript:;" class="act fh" style="color:red" data="'.$v['id'].'">点击发货</a>';
		}
	}
}
$view->assign('list', $list);
$view->assign('listnum',count($list['record']));
$view->display('express_real');
?>
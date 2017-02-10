<?php
require 'init.php';
$data = $db->page("select * from mcs_tuoguan_detail where 1=1",20,5);
foreach($data['record'] as $k => $v){
	$data[$k]['addtime'] = date("Y-m-d H:i",$v['addtime']);
	$data['record'][$k]['addtime'] = date("Y-m-d H:i:s",$v['addtime']);
	$data[$k]['uid']     = $db->getField("mcs_users","user_name","user_id = ".$v['uid']);
}
$view->assign("data",$data);
$view->display('managerlist');
?>
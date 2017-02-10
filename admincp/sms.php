<?php
require 'init.php';

$sql = "select * from mcs_message order by sendtime desc";
$list = $db->pageStr($sql);
$type=array('信息','语音');
$state=array('<font color="green">未使用</font>','<font color="red">已使用</font>');
foreach($list['record'] as $key => $val)
{
	$list['record'][$key]['sendtime']=date('Y-m-d H:i:s',$val['sendtime']);
	$list['record'][$key]['type']=$type[$val['type']];
	$list['record'][$key]['state']=$state[$val['state']];
}
$view->assign('list', $list);
$view->display('sms');
?>
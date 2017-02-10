<?php
require 'init.php';
$sql = "select a.user_name,b.* from mcs_users a,mcs_user_message b where a.user_id=b.uid order by b.addtime desc";
$users = $db->getAll($sql);
foreach($users as $key => $val){
	$users[$key]['addtime'] = date('Y-m-d H:i:s',$val['addtime']);
}
$view->assign('users', $users);
$view->display('user_message');
?>
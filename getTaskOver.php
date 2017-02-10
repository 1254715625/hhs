<?php
require 'mcscore/init.php';
if(IS_GET&&IS_AJAX){
	$t=time();
	if(empty($_SESSION['getTaskOver'])){
		$_SESSION['getTaskOver']=$t-10;
	}
	$sql="select a.addtime,b.user_name as susername from mcs_task_taobao a,mcs_users b where a.get_user=0 and a.appeal=0 and a.uid=b.user_id or a.addtime>".$_SESSION['getTaskOver']." order by rand() desc limit ".intval(rand(1,2));
	//$sql="select a.addtime,b.user_name as susername from mcs_task_taobao a,mcs_users b where a.uid=b.user_id order by rand() desc limit ".intval(rand(1,2));
	$data=$db->getAll($sql);
	//foreach($data as $k => $v){
		//$data[$k]['complateTime']=SetRemainTime($t-$v['addtime']);
	//}
	echo json_encode($data);
	$_SESSION['getTaskOver']=$t;
}
?>
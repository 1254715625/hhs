<?php
require 'init.php';
if($_GET['uid']){
	if($result=$db->getAll("select user_money,info from mcs_member_logs where uid=".$_GET['uid']." and (type='payde' or type='logtask')")){
		$view->assign("lists",$result);
		// pre($result);die;
		view("aboutuser");
	}else{
		echo "<script>alert('信息不存在');location.href='withdrawals.php';</script>";
	}
}else{
	echo "<script>alert('非法访问');location.href='withdrawals.php';</script>";
}


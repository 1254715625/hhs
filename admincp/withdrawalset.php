<?php
require 'init.php';
if($_GET['act']&&$_GET['act']=='update'){
	if($db->Execute("update mcs_user_rank set TXmin='".$_POST['data']."' where rank_id=".$_POST['id'])){
		echo 1;
	}else{
		echo 0; 
	}die;
}

$lists=$db->getAll("select * from mcs_user_rank");
$view->assign('lists',$lists);
// pre($lists);die;
$view->display('withdrawset');
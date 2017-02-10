<?php
require 'init.php';
if($_GET['mod']&&$_GET['mod']=='update'){
	if($db->Execute("update mcs_member_set set freeze='".$_POST['freeze']."' where id=".$_POST['id'])){
		echo 1;
	}
	die;
}
$result=$db->getAll("select rank_name,id,freeze from mcs_member_set");
$view->assign("lists",$result);
$view->display("businessset");
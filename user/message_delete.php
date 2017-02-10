<?php
require_once('../mcscore/init.php');
if(IS_AJAX&&IS_POST){
	$id=implode($_POST['id'],",");
	if($db->Execute("delete from mcs_user_message where id in({$id})")){
		echo 1;
	}else{
		echo 0;
	}
}
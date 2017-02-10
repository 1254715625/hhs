<?php
require 'init.php';

if(IS_POST)
{
	$param = $_POST['param'];

	foreach($param as $key => $val)
	{
		$db->Execute("update mcs_configs set value='$val' where code='$key'");
	}

	Message('信息保存成功！');
}
$act=trim($_GET['act']);
switch($act){
	case 'start':
		$id=intval($_GET['dropid']);
		$db->Execute('update mcs_express set state=1 where id='.$id);
	break;
	case 'stop':
		$id=intval($_GET['dropid']);
		$db->Execute('update mcs_express set state=0 where id='.$id);
	break;
	
	
}
$params = $db->getAll("select * from mcs_express order by shownum asc,id asc");
$view->assign('params', $params);
$view->display('express_set');
?>
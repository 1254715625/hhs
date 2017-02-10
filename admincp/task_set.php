<?php
require 'init.php';
if(IS_POST){
	$param=$_POST['param'];
	if(is_array($param)&&count($param)>0){
		foreach($param as $k => $v){
			$db->Execute('update mcs_configs set value="'.$v.'" where code="'.$k.'" and pid=5');
		}
	}
}
$info = $db->getAll("select * from mcs_configs where pid=5 order by id asc");
if(count($info)){
	foreach($info as $k => $v){
		if($v['type']=='radio'){
			$info[$k]['options']=explode(',',$v['options']);
		}
	}
}
$view->assign('info',$info);
$view->display('task_set');
?>

<?php
require 'init.php';

$act=trim($_GET['act']);
if(IS_POST&&IS_AJAX&&trim($_GET['type'])=='con'){
	$id=intval($_POST['data']);
	$info=trim($_POST['ju']);
	if($id>0&&$info!=''){
		if($act=='type'){
			$db->Execute('update mcs_task_express set info="'.$info.'" where status=1 and type=1 and apply=1 and id='.$id);
		}else{				
			$db->Execute('update mcs_task_express_user set info="'.$info.'" where apply=1 and id='.$id);
		}
	}
	die();
}


if(IS_POST){
	$picname = $_FILES['files']['name'];
	$picsize = $_FILES['files']['size'];
	if($picname != "") {
		$type = strtolower(strstr($picname, '.'));
		if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
			echo "<script type='text/javascript'>alert('图片格式不对！');</script>";
		}else{
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . $type;
			$pic_path = ROOT_PATH."uploads/express/". $pics;
			if(move_uploaded_file($_FILES['files']['tmp_name'], $pic_path)){
				$id=intval($_POST['id']);
				if($act=='type'){
					$db->Execute('update mcs_task_express set pic="'.$pics.'" where status=1 and type=1 and apply=1 and id='.$id);
				}else{				
					$db->Execute('update mcs_task_express_user set pic="'.$pics.'" where apply=1 and id='.$id);
				}
			}
			//@unlink($_SERVER['DOCUMENT_ROOT'].'/'.$finish['pinimage']);
			//$size = round($picsize/1024,2);
			//$arr = array('name'=>$picname,'pic'=>$pics,'size'=>$size);
		}
	}
	
}
if($act=='type'){
	$sql='select * from mcs_task_express where status=1 and type=1 and apply=1 order by addtime desc';
	
}else{
	$sql='select a.id,a.eid,a.type,a.addtime,a.wl,a.to_add,b.pic,b.info,b.id as sid from mcs_task_express a,mcs_task_express_user b where a.status=1 and a.type=0 and a.id=b.eid and b.apply=1 order by addtime desc';
}
$list = $db->page($sql,12,4);
if(count($list['record'])){
	foreach($list['record'] as $k => $v){
		$list['record'][$k]['to_adds']=$v['to_add'];
		$list['record'][$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
		$list['record'][$k]['type']=$v['type']==1?'<font color="green">真实快递</font>':'<font color="blue">虚拟快递</font>';
	}
}
$view->assign('act', $act);
$view->assign('list', $list);
$view->assign('listnum',count($list['record'] ));
$view->display('express_task');
?>
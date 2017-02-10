<?php
require_once 'init.php';
switch($_REQUEST['act']){
	
	case 'get_menu':
		$admin = $db->getRow("select * from mcs_aduser where admin_id = ".$_SESSION['admin_id']);
		$id = $_REQUEST['id'];
		if($admin['auth_str'] == null){
			$menu = $db->getAll("select * from mcs_menu where pid =".$id." order by id");
		}else{
			$ids = explode(",",$admin["auth_str"]);
			foreach($ids as $k => $v){
				$res = $db->getRow("select * from mcs_menu where pid = ".$id." and id = ".$v);
				if($res){
					$menu[] = $res;
				}
			}
		}	
		echo json_encode($menu);
	break;	
	
	default:
		$admin = $db->getRow("select * from mcs_aduser where admin_id = ".$_SESSION['admin_id']);
		if($admin['auth_str'] == null){
			$nav  = $db->getAll("select * from mcs_menu where pid = 0");
		}else{
			$ids = explode(",",$admin["auth_str"]);
			foreach($ids as $k => $v){
				$is_pid = $db->getRow("select * from mcs_menu where id = ".$v);
				if($is_pid['pid'] == 0){
					$pid[] = $v;
				}
			}
			foreach($pid as $v){
				$nav[]  = $db->getRow("select * from mcs_menu where id = ".$v);
			}
		}
		$view->assign('nav', $nav);
	break;
}
?>
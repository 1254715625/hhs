<?php
require 'init.php';

switch($action)
{	
	case 'adminlist':
		$data = $db->page("select * from mcs_aduser",20,5);
		foreach($data['record'] as $k => $v){
			if($data['record'][$k]['last_login'] > 0){
				$data['record'][$k]['last_login'] = date("Y-m-d H:i:s",$v['last_login']);
			}else{
				$data['record'][$k]['last_login'] = "没有登录";
			}
			$data['record'][$k]['is_ok']      = $v['is_ok'] == 0 ? "正常" : "屏蔽";
			$data['record'][$k]['role']       = $v['role']  == 1 ? "<span style='color:red'>超级管理员</span>" : "普通管理员";
		}
		
		
		$view->assign('data',$data);
		$view->display('admin_list'); 
	break;
	
	case 'add_aduser':
		
		if(IS_POST){
			$data = $_POST;
			if(empty($data['admin_name'])){
				Message("登录名不能为空");
			}
			if(empty($data['pwd']) || empty($data['repwd'])){
				Message("密码或确认密码不能为空");
			}
			if($data['pwd'] != $data['repwd']){
				Message("二次输入的密码不一致");
			}
			$res = $db->Execute("insert into mcs_aduser (admin_name,password,phone,email,is_ok,role) values ('".$data['admin_name']."','".md5($data['pwd'])."','".$data['phone']."','".$data['email']."','".$data['is_ok']."',".$data['role'].")");
			if($res){
				 Message('信息保存成功！',0,"set_system.php?act=adminlist");
			}else{
				 Message('信息保存失败！',0,"set_system.php?act=adminlist");
			}
		}else{
			$view->display('add_aduser'); 
		}
	break;
	
	case 'addmenu':
		
		if(IS_POST){
			$data = $_POST;
			if(empty($data['name'])){
				Message("栏目名不能为空");
			}
			
			if($data['active']){
				$data['pid'] = 0;
				$res = $db->Execute("insert into mcs_menu (name,active,pid) values ('".$data['name']."','".$data['active']."',0)");
			}
			if($data['method']){
				$res = $db->Execute("insert into mcs_menu (name,method,pid) values ('".$data['name']."','".$data['method']."',".$data['pid'].")");
			}
			if($res){
				 Message('信息保存成功！',0,"set_system.php?act=menulist");
			}else{
				 Message('信息保存失败！',1,"set_system.php?act=menulist");
			}
		}else{
			$data = $db->getAll("select * from mcs_menu where pid = 0");
			$view->assign('data',$data);
			$view->display('add_menu'); 
		}
	break;
	
	case 'menulist':
		$data = $db->getAll("select * from mcs_menu where pid = 0");
		
		foreach($data as $k => $v){
			$data[$k]['data'] = $db->getAll("select * from mcs_menu where pid = ".$v['id']." order by id");
		}
		//var_dump($data);
		$view->assign('data',$data);
		$view->display('menu_list'); 
		
	break;
	
	case 'edit_menu':
		if(IS_POST){
			$data = $_POST;
			if($data['active']){
				$upd = "set name = '".$data['name']."',active = '".$data['active']."'";
			}else{
				$upd = "set name = '".$data['name']."',method = '".$data['method']."',pid = ".$data['pid'];
			}
			$res = $db->Execute("update mcs_menu ".$upd." where id = ".$data['id']);
			if($res){
				Message('修改成功！',0,"set_system.php?act=menulist");
			}else{
				Message('修改失败！',1,"set_system.php?act=menulist");
			}
		}else{
			$id = intval($_GET['id']);
			if(!$id){
				Message('非法参数');
			}
			
			$data = $db->getRow("select * from mcs_menu where id = ".$id);
			$data['column'] = $db->getAll("select * from mcs_menu where pid = 0");
			$view->assign('data',$data);
			$view->display('edit_menu'); 
		}	
	break;
	
	case 'del_menu':
		$id = intval($_GET['id']);
		if(!$id){
			Message('非法参数');
		}
		$is_active = $db->getRow("select * from mcs_menu where id = ".$id);
		if($is_active['pid'] == 0){
			$is_method = $db->getAll("select * from mcs_menu where pid = ".$id);
			if($is_method){
				Message('您所删除的为顶部栏目，其所属还有子栏目，请删除子栏目后在删除顶部栏目！');
			}
		}
		$res = $db->Execute("delete from mcs_menu where id = ".$id);
		if($res){
			Message('删除成功！',0,"set_system.php?act=menulist");
		}else{
			Message('删除失败！',1,"set_system.php?act=menulist");
		}
		
	break;
	
	case 'edit_admin':
		if(IS_POST){
			$data = $_POST;
			if($data['pwd'] != null){
				$upd = " admin_name = '".$data['admin_name']."',role = ".$data['role'].",phone = '".$data['phone']."',email = '".$data['email']."',is_ok = ".$data['is_ok'].",password = '".md5($data['pwd'])."'";
			}else{
				$upd = " admin_name = '".$data['admin_name']."',role = ".$data['role'].",phone = '".$data['phone']."',email = '".$data['email']."',is_ok = ".$data['is_ok'];
			}
			$res = $db->Execute("update mcs_aduser set ".$upd." where admin_id = ".$data['admin_id']);
			if($res){
				Message('修改成功！',0,"set_system.php?act=adminlist");
			}else{
				Message('修改失败！',1,"set_system.php?act=adminlist");
			}
		}else{
			$id = intval($_GET['id']);
			if(!$id){
				Message('非法参数');
			}
			$data = $db->getRow("select * from mcs_aduser where admin_id = ".$id);
			$view->assign("data",$data);
			$view->display('edit_aduser');
		}
	break;
	
	case 'del_admin':
		$id = intval($_GET['id']);
		if(!$id){
			Message('非法参数');
		}
		$res = $db->Execute("delete from mcs_aduser where admin_id = ".$id);
		if($res){
			Message('删除成功！',0,"set_system.php?act=adminlist");
		}else{
			Message('删除失败！',1,"set_system.php?act=adminlist");
		}
	break;
	
	case 'auth':
		if(IS_POST){
			$data = $_POST['ids'];
			$admin_id = $_POST['admin_id'];
			foreach($data as $k => $v){
				foreach($v as $vv){
					$ids .= $vv.",";
				}
			}
			$res = $db->Execute("update mcs_aduser set auth_str = '".mb_substr($ids,0,strlen($ids)-1)."' where admin_id = ".$admin_id);
			if($res){
				Message('设置成功！',0,"set_system.php?act=adminlist");
			}else{
				Message('设置失败！',1,"set_system.php?act=adminlist");
			}
		}else{
			$id = intval($_GET['id']);
			if(!$id){
				Message('非法参数');
			}
			$data = $db->getAll("select * from mcs_menu where pid = 0 order by id");
			foreach($data as $k => $v){
				$data[$k]['column'] =  $db->getAll("select * from mcs_menu where pid = ".$v['id']." order by id");
			}
			$view->assign("admin_id",$id);
			$view->assign("data",$data);
			$view->display("admin_auth");
		}
	break;
    
}
?>
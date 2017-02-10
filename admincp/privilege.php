<?php
require 'init.php';

switch($action)
{
	case 'logout':
		$sess->destroy_session();
		Redirect('privilege.php');
	break;
	
    default:
        if(IS_POST)
        {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $password = cipherStr($password);

            $row = $db->getRow("select * from mcs_aduser where admin_name='$username' and password='$password'");

            if($row)
			{
				setcookie('auth',1,time()+3600*24,'/');
				//setcookie('auth','1',time(),'/');
				$_SESSION['admin_id']  = $row['admin_id'];
				$_SESSION['user_name'] = $row['admin_name'];
				if($row['role'] == 1){
					$_SESSION['role'] = "超级管理员";
				}else{
					$_SESSION['role'] = "普通管理员";
				}

				$db->Execute("update mcs_aduser set last_login=". time() .", last_ip='". getRealIp() ."' where admin_id={$row['admin_id']}");

				Redirect('index.php');
			}
			else
			{
				Message('您输入的帐号信息不正确。');
			}
        }
        $view->display('login');
        break;
}
?>
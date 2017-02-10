<?php
require 'init.php';
 
if(IS_POST&&IS_AJAX){
	$data['info']='访问出错~';
	$act=trim($_GET['act']);
	switch($act){
		case 'tg':
			$user=intval($_POST['user']);
			if($db->Execute('update mcs_member_realname set state=1 where uid='.$user.' and state=0')){
				$data['state']=1;
			}else{
				$data['info']='抱歉，用户不存在或者已验证~';
			}
		break;

		case 'jj':
			$user=intval($_POST['user']);
			$ju=trim($_POST['ju']);
			if(!empty($ju)){
				if($db->Execute('update mcs_member_realname set state=2,info="'.$ju.'" where uid='.$user.' and state=0')){
					$data['state']=1;
				}else{
					$data['info']='抱歉，用户不存在或者已验证~';
				}
			}else{
				$data['info']='请填写拒绝原因~';
			}
		break;
	}
	echo json_encode($data);
	exit;
}
$state='and a.state=0';
if($_GET['see']){$state='and a.state>0';}
$sql = 'select a.*,b.user_name from mcs_member_realname a,mcs_users b  where a.uid=b.user_id '.$state;
$users = $db->getAll($sql);
foreach($users as $key => $val)
{
	$users[$key]['value']=unserialize($val['value']);
}

$view->assign('users', $users);
$view->display('user_addv');
?>
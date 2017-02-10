<?php
require_once('mcscore/init.php');

switch($action)
{
	
	//留言反馈
	case 'message':
		$data['info']='访问出错~';
		if(IS_POST&&IS_AJAX){
			
		}
		$data['info']='留言成功，感谢您对我们的反馈~';
		echo json_encode($data);exit;
	break;
	
	default:
		echo 11;die;
	break;

	
}

?>
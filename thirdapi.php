<?php
@SESSION_START();
switch($_REQUEST['code'])
{	//���ɶ�����֤��
	case 'setsmscode':
		$_SESSION['smscode'] = mt_rand(100000, 999999);
		if(isset($_SESSION['smscode'])){
			echo "ok";
		}
	break;

	case 'getsmscode':
		$smscode=$_REQUEST['smscode'];
		if($smscode==$_SESSION['smscode']){echo 'ok';}
	break;
}
?>
<?php
function Message($msg_detail, $msg_type = 0, $links = '', $auto_redirect = true)
{
	if(empty($links)) $links =  $_SERVER['HTTP_REFERER'];

    $GLOBALS['view']->assign('msg_detail',  $msg_detail);
    $GLOBALS['view']->assign('msg_type',    $msg_type);
    $GLOBALS['view']->assign('links',       $links);
    $GLOBALS['view']->assign('auto_redirect', $auto_redirect);
    $GLOBALS['view']->display('message');
    exit;
}

function JSMessage($msg, $links = '')
{
    if(empty($links)) $links =  $_SERVER['HTTP_REFERER'];

    echo '<script type="text/javascript">alert("'. $msg .'"); location.href="'. $links .'";</script>';

    exit;
}

function loadConfig()
{
    $arr = array();

    $sql = "select * from mcs_configs where pid > 0";
    $row = $GLOBALS['db']->getAll($sql);

    foreach($row as $val) $arr[$val['code']] = trim($val['value']);

    $arr['serv_qq'] = explode(',', $arr['serv_qq']);
    $arr['pay_qq'] = explode(',', $arr['pay_qq']);
    $arr['group_qq'] = explode(',', $arr['group_qq']);


    return $arr;
}


function get_message_type($type){
	if($type == null){
		return "未知";
	}elseif($type == 0){
		return "短信验证码";
	}elseif($type == 1){
		return "语音验证码";
	}elseif($type == 2){
		return "普通短信";
	}
}

?>
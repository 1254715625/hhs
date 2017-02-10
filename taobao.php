<?php
require 'mcscore/init.php';

if(intval($_SESSION['user_id'])==0){//登陆验证
	setcookie('safepass','',time()-1);
	Redirect('user.php?act=login');
}

$uinfodata=$db->getRow("select * from mcs_users join mcs_user_rank on mcs_users.user_rank=mcs_user_rank.rank_id where mcs_users.user_id='".$uinfo['user_id']."'");
$uinfo['special']=$uinfodata['special'];
$view->assign('isvip',$uinfo['special']);
$memberset=$db->getRow("select * from mcs_member_set join mcs_user_rank on mcs_member_set.rank_name=mcs_user_rank.rank_name where mcs_user_rank.rank_id=".$uinfodata['user_rank']);
// pre($memberset);die;
// pre("select * from mcs_users join mcs_user_rank on mcs_users.user_rank=mcs_user_rank.rank_id where mcs_users.user_id='".$uinfo['user_id']."'");die;
// echo "<script> var data=".json_encode($uinfo['special'])."; console.log(data);</script>";
if(IS_POST&&IS_AJAX&&$_POST['safepass']=='safepass'){
	if($uinfo['safepass'] == cipherStr($_POST['pass'])){
		setcookie('safepass',cipherStr($uinfo['user_id']),time()+3600*12,'/','.lianmon.com');
		$state['state']=true;
		$state['str']='安全码验证成功！';
	}else{
		setcookie('safepass','',time()-1);
		$state['state']=false;
		$state['str']='安全码验证失败！';
	}
	echo json_encode($state);
	exit;
}

$view->assign('model_type', 'taobao');
$mod=$_REQUEST['mod']?$_REQUEST['mod']:'index';
$view->assign('mod', $mod);

/*清理一个月前黑名单*/
$deltime=strtotime("-1 month");
$db->Execute('delete from mcs_member_black where adddate<'.$deltime.' and uid='.$uinfo['user_id']);


/*有效投诉*/
$complaint=$db->getCount("mcs_task_appeal","aid=".$uinfo['user_id']);
$view->assign('complaint', $complaint);

/*模板数据调用*/
$temid=intval($_REQUEST['temid'])?intval($_REQUEST['temid']):0;
if($temid){
	$templates=$db->getRow("select value from mcs_task_template where uid=$uinfo[user_id] and id=$temid and type='$mod' and tem_type='tb'");
	$temval=unserialize($templates['value']);
	$temlen=count($temval['task_other']['shopAll']);
	$view->assign('temid', $temid);
	$view->assign('temlen', $temlen);
	$view->assign('temval', $temval);
}


/*任务参数*/
$task_sets=$db->getAll('select b.code,b.value from mcs_configs a left join mcs_configs b on b.pid=a.id where a.code="task_attr"');

if(count($task_sets)){
	foreach($task_sets as $v){
		$v['code']=str_replace("task_", "",$v['code']);
		$task_set[$v['code']]=$v['value'];
	}
	$view->assign('task_set', $task_set);
}



$acc_type = array('seller' => 1, 'Buyer'=>2);//买家、卖家

$umaihaoh=$db->getAll("select id from mcs_member_bindacc where acc_type='tb' and uid={$uinfo['user_id']} and buyno=0 and is_hang=1 and hang_time<".strtotime(date("Y-m-d")));
foreach($umaihaoh as $val){
	$db->execute("update mcs_member_bindacc set is_hang=0,hang_time=0,unhang_time=".time()." where id=".$val['id']);
}

$umaihaol=$db->getAll("select id from mcs_member_bindacc where acc_type='tb' and uid={$uinfo['user_id']} and buyno=0 and is_lock=1 and lock_time<".(time()-30*24*3600));
foreach($umaihaol as $val){
	$db->execute("update mcs_member_bindacc set is_lock=0,lock_time=0,unlock_time=".time()." where id=".$val['id']);
}

$maihao=$db->getAll("select id from mcs_member_bindacc where acc_type='tb' and uid={$uinfo['user_id']} and buyno=0 and is_hang=0 and is_lock=0");
foreach($maihao as $val){
	$user_state=$db->getCount('mcs_task_taobao','get_user='.$val['id'].' and get_time>'.strtotime(date("Y-m-d")));
	if($user_state>$uinfo['params']['mhgqs']&&$user_state>0){//买号挂起
		$db->execute("update mcs_member_bindacc set is_hang=1,hang_time=".time()." where id=".$val['id']);
	}
	if($user_state>$uinfo['params']['mhsds']&&$user_state>0){//买号锁定
		$db->execute("update mcs_member_bindacc set is_lock=1,lock_time=".time()." where id=".$val['id']);
	}
}


if(empty($uinfo['safepass'])){
	Redirect('user.php?act=operate');
}else{
	if($_COOKIE['safepass']!=cipherStr($uinfo['user_id'])){
		$view->display('safe');
	}else{
		require './taobao_mod.php';//加载页面
	}
}

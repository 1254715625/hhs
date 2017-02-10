<?php
require 'init.php';
$state=0;
if($_GET['show']){$state=1;}
$view->assign('state', $state);
$bank=$_GET['banks'];

if(!isset($bank)){
	$bank="%中国%";
}else{
	$bank="%$bank%";
}
if($state==0){$state='=0';}
if($state==1){$state='>0';}
$page=$db->page('select a.*,b.user_name,b.mobile_phone from mcs_member_logs a,mcs_users b where a.type="logpayment" and a.state'.$state.' and a.uid=b.user_id and bank like "'.$bank.'"  order by a.createtime desc',15,5);
$lists=$page['record'];
foreach($lists as $key => $val){
	$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
}
$view->assign('page', $page);
$view->assign('lists', $lists);
// pre($lists);die;
if(IS_POST&&IS_AJAX){
	$act=trim($_GET['act']);
	$data['info']='访问出错~';
	switch($act){
		case 'tg':
            //完善提现后台手机号通知,上一份是修改代码
            $mobile    =$_POST['mobile'];
            $data_bank =$_POST['data_bank'];
            $data_dd   =$_POST['data_dd'];
            $data_price=$_POST['data_price'];
			if($db->Execute('update mcs_member_logs set state=1,gettime="'.time().'" where type="logpayment" and state=0 and id='.intval($_POST['bank']))){
				$data['state']='1';
			}else{
				$data['info']='该记录已处理或不存在~';
			}
            if($mobile != 0){
                header("location:http://bbs.lianmon.com/plugins.php?act=notify&type=141225&phone=
				{$mobile}&bank={$data_bank}&mesid={$data_dd}&price={$data_price}");
            }
		break;
		case 'jj':
			$ju=trim($_POST['ju']);
			if(empty($ju)){
				$data['info']='请填写拒绝原因~';
			}elseif($db->Execute('update mcs_member_logs a,mcs_users b set a.state=2,a.gettime="'.time().'",a.error="'.$ju.'",b.user_money=b.user_money+a.num where a.uid=b.user_id and a.type="logpayment" and a.state=0 and a.id='.intval($_POST['bank']))){
				$log=$db->getRow('select a.uid,a.num,b.user_money from mcs_member_logs a,mcs_users b where a.uid=b.user_id and a.id='.intval($_POST['bank']));
				$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value('$log[uid]','".time()."',".$log['num'].",'提现失败','存款日志',".$log['user_money'].",'payde')");
				$data['state']='1';
			}else{
				$data['info']='该记录已处理或不存在~';
			}
		break;
	}
	echo json_encode($data);
	exit;
}


$view->display('withdrawals');
?>
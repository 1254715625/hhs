<?php
require 'init.php';
$lists=$db->getAll("select goods_price,total_points,id from mcs_task_taobao order by addtime desc");
$count=$db->getRow("select sum(goods_price) as money,sum(total_points) as allpoint from mcs_task_taobao");
$moneys=$db->getRow("select sum(user_money) as moneys from mcs_users")['moneys'];

$today=strtotime(date("Y-m-d"));
$tomorrow=$today+3600*24;
$thismonth=strtotime(date("Y-m")."-01");
if(date("m")==12){
	$m="01";
}else{
	$m=date("m")+1;
	if($m<10){
		$m="0".$m;
	}
}
$nextmonth=(date("Y")+1)."-".$m."-01";
$nextmonth=strtotime($nextmonth);
$data['pointtoday']=$db->getRow("select sum(pay_point) as pay_points from mcs_member_logs where createtime<=$tomorrow and createtime>=$today")['pay_points'];
$data['pointthismonth']=$db->getRow("select sum(pay_point) as pay_points from mcs_member_logs where createtime<=$nextmonth and createtime>=$thismonth")['pay_points'];
$data['moneytoday']=$db->getRow("select sum(user_money) as pay_moneys from mcs_member_logs where createtime<=$tomorrow and createtime>=$today")['pay_moneys'];
$data['moneythismonth']=$db->getRow("select sum(user_money) as pay_moneys from mcs_member_logs where createtime<=$nextmonth and createtime>=$thismonth")['pay_moneys'];
$week=date("w",time());
$weekstart=strtotime(date("Y-m-d",(time()-($week-1)*24*3600)));
$weekend=$weekstart+7*3600*24;
$thisyear=strtotime(date("Y",time())."-01-01");
$nextyear=strtotime((date("Y",time())+1)."-01-01");
// echo date("Y-m-d H:i",$thisyear);
// echo date("Y-m-d H:i",$nextyear);die;
$data['moneythisweek']=$db->getRow("select sum(user_money) as pay_moneys from mcs_member_logs where createtime<=$weekend and createtime>=$weekstart")['pay_moneys'];
$data['pointweek']=$db->getRow("select sum(pay_point) as pay_points from mcs_member_logs where createtime<=$weekend and createtime>=$weekstart")['pay_points'];
$data['moneythisyear']=$db->getRow("select sum(user_money) as pay_moneys from mcs_member_logs where createtime<=$nextyear and createtime>=$thisyear")['pay_moneys'];
$data['pointyear']=$db->getRow("select sum(pay_point) as pay_points from mcs_member_logs where createtime<=$nextyear and createtime>=$thisyear")['pay_points'];
$data['pointthismonth']=abs($data['pointthismonth']);
$data['moneythismonth']=abs($data['moneythismonth']);
$data['pointtoday']=abs($data['pointtoday']);
$data['moneytoday']=abs($data['moneytoday']);
$data['moneythisweek']=abs($data['moneythisweek']);
$data['pointweek']=abs($data['pointweek']);
$data['moneythisyear']=abs($data['moneythisyear']);
$data['pointyear']=abs($data['pointyear']);
// pre($data);die;
$view->assign('data',$data);
$view->assign('lists',$lists);
$view->assign('count',$count);
$view->assign('moneys',$moneys);

// pre($moneys);die;
view("statistics");
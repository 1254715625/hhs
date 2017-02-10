<?php
require_once('mcscore/init.php');
if(!empty($_GET['reg'])){
	setcookie("spread_name",$_GET['reg'],time()+3600*24*31,"/",".lianmon.com");
	$_SESSION['extensionuser']=$db->getRow("select uid from mcs_extension where code='".$_GET['reg']."'")['uid'];
}
$nologin = array('login', 'reg', 'regdetect');

if(!in_array($action, $nologin) && empty($_SESSION['user_id'])) $action = 'login';

switch($action)
{
	case 'autoam':
		if(IS_AJAX&&IS_POST){
			$data['info']='访问出错~';
			if($uinfo['autoam']){
				$istype=trim($_POST['istype']);
				if($istype=='taobao'||$istype=='paipai'){
					$uinfo['autoam_attr'][$istype]=$_POST;
					$db->Execute('update mcs_users set autoam_attr=\''.serialize($uinfo['autoam_attr']).'\' where user_id='.$uinfo['user_id']);
					$data['info']='更改成功~';
				}else{
					$data['info']='您的操作没有更新配置~';
				}
			}else{
				$data['info']='对不起，您还没有开通任务定制~';
			}
			echo json_encode($data);
			exit;
		}
		$view->assign('data', json_encode($uinfo['autoam_attr']));
		$view->display('user/autoam');
	break;
	//留言反馈
	case 'message':
		$data['info']='访问出错~';
		if(IS_POST&&IS_AJAX){
			$has=$db->getField('mcs_user_message','id','uid='.$uinfo['user_id'].' and addtime>'.strtotime('last monday'));
			if($has){
				$data['info']='本周您已提交过一次留言了，请下周留言';
			}else{
				$tex=trim($_POST['tex']);
				if($tex==''||$tex=='请亲输入点文字吧，您的意见即为我们的前进动力！'){
					$data['info']='请填写留言内容~';
				}else{
					$db->Execute('insert mcs_user_message(uid,addtime,message) values("'.$uinfo['user_id'].'","'.time().'","'.$tex.'")');
					$data['info']='留言成功，感谢您对我们的反馈~';
				}
			}
		}
		echo json_encode($data);exit;
	break;

	case 'mprz':
		$data['info']='访问出错~';
		if($uinfo['mprz']==1){
			$data['info']='您已激活手机~';
		}else{
			if(IS_POST&&IS_AJAX){
				$phone=trim($_POST['phone']);
				if(!preg_match('/^1(?:(?:3[0-9])|(?:5[0-35-9])|(?:4[0-35-9])|(?:8[0-35-9])|(?:7[0-9]))\d{8}$/', $phone)){
					$data['info']='手机号码格式不正确~';
				}elseif($db->getCount('mcs_users','mobile_phone="'.$phone.'" and mprz=1')){
					$data['info']='此手机号码已在平台激活，请更换~';
				}else{
					$data['state']=1;
					$data['info']=$phone;
				}
			}
		}
		echo json_encode($data);exit;
	break;
	//查看推广注册的列表
	case 'spread':
		$mon=0;
		$day=0;
		$code=$db->getField('mcs_extension','code','uid='.$uinfo['user_id']);
		if(empty($code)){
			for($i=0;$i<7;$i++){
				$code=short($uinfo['user_name'],$uinfo['user_id']+1);
				if($db->getCount('mcs_extension','code="'.$code.'"')==0){
					$db->Execute('insert mcs_extension(uid,code) values("'.$uinfo['user_id'].'","'.$code.'")');
					break;
				}
			}
		}
		$my=$db->page('select * from mcs_users where extension='.$uinfo['user_id'],15,5);

		foreach($my['record'] as $k => $v){
			$my['record'][$k]['add_time']=date('Y-m-d',$v['add_time']);

			if($v['last_login']==0){$v['last_login']=$v['add_time'];}

			$my['record'][$k]['last_login']=date('Y-m-d H:i:s',$v['last_login']);

			if($v['add_time']>strtotime(date('Y-m-01'))){
				$mon++;
			}
			if($v['add_time']>strtotime(date('Y-m-d'))){
				$day++;
			}
			$my['record'][$k]['in']=$db->getCount('mcs_task_taobao a,mcs_member_bindacc b','a.get_user=b.id and b.uid='.$v['user_id']);
			$my['record'][$k]['out']=$db->getCount('mcs_task_taobao','uid='.$v['user_id']);
		}
		$list=$db->getAll('select count(a.extension) as num,count(a.extension)*5 as money,b.user_name from mcs_users a,mcs_users b where a.add_time>'.strtotime(date('Y-m-01')).' and a.extension=b.user_id group by a.extension order by num desc limit 10');
		foreach($list as $k => $v){
			$list[$k]['position']=$k*22;
		}
		$lists=$db->getAll('select count(a.extension) as num,count(a.extension)*5 as money,b.user_name from mcs_users a,mcs_users b where a.extension=b.user_id group by a.extension order by num desc limit 10');

		foreach($lists as $k => $v){
			$lists[$k]['position']=$k*22;
		}

		//根据推荐人查询被推荐用户的注册完成任务情况
		//echo '<pre>';
		//var_Dump($my['record']);die;
		//foreach($my['record'] as $k = >$v){
		//	$tuijian_id = $v['extension'];


		//}

		$view->assign('all', count($my['record']));
		$view->assign('mon', $mon);
		$view->assign('day', $day);
		$view->assign('my', $my);
		$view->assign('lists', $lists);//总排行
		$view->assign('list', $list);//月排行
		$view->assign('code', $code);
		$view->display('user/spread');
	break;
	//我的推广
	case 'popularize':
		$code=$db->getField('mcs_extension','code','uid='.$uinfo['user_id']);
		if(empty($code)){
			for($i=0;$i<7;$i++){
				$code=short($uinfo['user_name'],$uinfo['user_id']+1);
				if($db->getCount('mcs_extension','code="'.$code.'"')==0){
					$db->Execute('insert mcs_extension(uid,code) values("'.$uinfo['user_id'].'","'.$code.'")');
					break;
				}
			}
		}
		$line=$db->getAll('select user_name from mcs_users where user_id>0 order by rand() desc limit 5');
		foreach($line as $k => $v){
			$line[$k]['user_name']=substr_replace($v['user_name'],'***',1,strlen($v['user_name'])-2);
		}

		$view->assign('line', $line);
		$view->assign('code', $code);
        $view->display('user/popularize');
    break;

	case 'info':
		$uname=trim($_GET['uname']);
		$arr=array(1=>'好评',2=>'中评',3=>'差评');
		$arrclass=array(1=>'hao',2=>'',3=>'cha');
		$haoping='暂无评论信息';
		$type=array(1=>0,2=>0,3=>0);
		if(!empty($uname)){
			$info=$db->getRow('select * from mcs_users where user_name="'.$uname.'"');
			$info['add_time']=date('Y-m-d',$info['add_time']);
			$comm=$db->page("select a.*,b.user_name from mcs_task_comm a,mcs_users b where a.uid=".$info['user_id']." and b.user_id=a.tuid order by a.addtime desc",10,5);
			$num=count($comm['record']);
			$info['black']=$db->getCount('mcs_member_black','accid='.$info['user_id']);
			if($num){
				foreach($comm['record'] as $k => $v){
					$comm['record'][$k]['user_name']=substr_replace($v['user_name'],'***',1,(strlen($v['user_name'])-2));
					if(empty($v['content'])){
						$comm['record'][$k]['content']='默认'.$arr[$v['type']];
					}
					$comm['record'][$k]['type']=$arr[$v['type']];
					$comm['record'][$k]['typeclass']=$arrclass[$v['type']];
					$comm['record'][$k]['addtime']=date('Y-m-d',$v['addtime']);
					$type[$v['type']]+=1;
				}
				$haoping=sprintf("%0.2f",(floatval($type[1]/$num)*100)).'%';
			}
		}
		$hot_bbs=$db->getAll('select * from mcs_forum_post where pid=0 order by views desc limit 7');
		if(count($hot_bbs)){
			foreach($hot_bbs as $k => $v){
				$hot_bbs[$k]['add_time']=date('m-d',$v['add_time']);
			}
		}
		$view->assign('info', $info);
		$view->assign('comm', $comm);
		$view->assign('type', $type);
		$view->assign('hot_bbs', $hot_bbs);
		$view->assign('haoping', $haoping);
		$view->display('user/info');
	break;

    case 'payde':
		require 'user/user_paydetails.php';
    break;

	case 'complaint':
		require 'user/user_complaint.php';
    break;

    case 'userinfo':
		require 'user/user_date.php';
    break;

	case 'personal':
		require 'user/user_personal.php';
    break;

    case 'black':
        require 'user/user_black.php';
    break;

    case 'seckill':
		$stime=strtotime($_CFG['seckill_stime']);
		$etime=strtotime($_CFG['seckill_etime']);
		if(intval($_CFG['seckill_num'])==0){
			$st=0;
			$ut=0;
		}else{
			if($stime>0&&$etime>0&&$stime<$etime){
				$t=time();
				if($t<$stime){
					$st=1;
					$ut=$stime-$t;
				}elseif($stime<=$t&&$t<=$etime){
					$st=2;
					$ut=$etime-$t;
				}else{
					$st=0;
					$ut=0;
				}
				$view->assign('ut', $ut);
				$view->assign('st', $st);

				$ct=$etime-$stime;
				$view->assign('ct', $ct);
			}
		}
		if(IS_POAT&&IS_AJAX){
			$data['info']='访问出错~';
			$num=intval($_POST['m']);
			$safecode=trim($_POST['safecode']);
			if(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
				$data['info']='安全码验证失败~';
			}elseif($num){
				switch($st){
					case 0:
						$data['info']='秒杀已结束~';
					break;

					case 1:
						$data['info']='秒杀还未开始~';
					break;

					case 2:
						if(intval($_CFG['seckill_num'])==0||$num>$_CFG['seckill_num']){
							$data['info']='对不起！库存不足~';
						}else{
							$money=$num*$_CFG['seckill_price'];
							if($uinfo['user_money']<$money){
								$data['info']='对不起！余额不足~';
							}else{
								if($db->Execute('update mcs_users a,mcs_configs b set a.user_money=a.user_money-'.$money.',a.pay_money=a.pay_money+'.$num.',b.value=b.value-'.$num.' where a.user_id='.$uinfo['user_id'].' and b.pid=4 and b.code="seckill_num"')){
									$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$money."','秒杀".$num."个刷点','存款日志',".($uinfo['user_money']-$money).",'payde')");//存款日志

									$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','".$money."元秒杀刷点','".$num."','刷点日志',".($uinfo['pay_money']+$num).",'logpoint')");//刷点日志
									$data['info']='恭喜您，成功秒杀'.$num.'刷点~';
									$data['state']=true;
								}
							}
						}
					break;
				}
			}else{
				$data['info']='对不起！麦点秒杀1个起售~';
			}
			echo json_encode($data);
			exit;
		}
        $view->display('user/seckill');
        break;

    case 'rechange':
        require 'user/user_rechange.php';
    break;

    case 'ensure':
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			$opt=trim($_GET['opt']);
			switch($opt){
				case 'add':
					$safecode=trim($_POST['safecode']);
					if(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
						$data['info']='安全码验证失败~';
					}else{
						if($uinfo['business']>0){
							$data['info']='您已是商保用户~';
						}elseif($uinfo['user_money']<$_CFG['business_money']){
							$data['info']='对不起,您的存款不足~';
						}else{
							if($db->Execute('update mcs_users set user_money=user_money-'.$_CFG['business_money'].',business='.$_CFG['business_money'].' where user_id='.$uinfo['user_id'])){
								$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$_CFG['business_money']."','加入商保服务','存款日志',".($uinfo['user_money']-$_CFG['business_money']).",'payde')");//存款日志
								$data['info']='恭喜，您已经是商保用户~';
							}
						}
					}
				break;

				case 'destroy':
					if($uinfo['business']==0){
						$data['info']='您尚未加入商保~';
					}elseif($uinfo['business_time']>0){
						$data['info']='您已申请过退保服务，平台处理中~';
					}else{
						if($db->Execute('update mcs_users set business_time='.time().' where user_id='.$uinfo['user_id'])){
							//$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','".$uinfo['business']."','退出商保服务','存款日志',".($uinfo['user_money']+$uinfo['business']).",'payde')");//存款日志
							$data['info']='您已申请退出商保服务，平台处理中~';
						}
					}
				break;
			}
			echo json_encode($data);
			exit;
		}
		$freezetime=$db->getRow("select mcs_member_set.freeze as freezetime,mcs_users.business_time as business_time from mcs_users join mcs_user_rank on mcs_user_rank.rank_id=mcs_users.user_rank join mcs_member_set on mcs_user_rank.rank_name=mcs_member_set.rank_name where mcs_users.user_id=".$uinfo['user_id']);
		// pre($freezetime);die;
		$view->assign('freezetime', $freezetime['freezetime']);
        $view->display('user/ensure');
    break;

	case 'headimg':
		for($i=1;$i<=20;$i++){
			$img[]=$i.'.jpg';
		}
		$view->assign('img', $img);
		if(IS_POST&&IS_AJAX){
			$data['info']='修改失败~';
			$i=trim($_POST['img']);
			if(in_array($i,$img)){
				$db->Execute('update mcs_users set headimg="'.$i.'" where user_id='.$uinfo['user_id']);
				$data['src']=$i;
			}else{
				$data['info']='头像不存在~';
			}
			echo json_encode($data);
			exit;
		}
        $view->display('user/headimg');
    break;

	case 'userjob':
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			$type=intval($_POST['type']);
			$opt=trim($_GET['opt']);
			if($opt=='a'){
				if($uinfo['reward']>0){
					$data['info']='很抱歉，您目前有任务还在进行中，请先完成或取消后再接其他任务~';
				}else{
					if($db->getCount('mcs_task_reward','id='.$type)){
						if($db->Execute('update mcs_users set reward='.$type.',reward_time='.time().' where user_id='.$uinfo['user_id'])){
							$data['info']='任务接手成功~';
							$data['state']=1;
						}else{
							$data['info']='很抱歉，任务接手失败~';
						}
					}else{
						$data['info']='很抱歉，您要接手的任务不存在~';
					}
				}
			}elseif($uinfo['reward']>0&&$uinfo['reward']==$type){
				$re=$db->getRow('select * from mcs_task_reward where id='.$uinfo['reward']);
				if($re['id']){
					switch($opt){
						case 'schedule':
							$reward_zieo=strtotime(date('Y-m-d',$uinfo['reward_time']));//接手日期零时
							$before_dawn=strtotime(date('Y-m-d'));//今日零时

							$info['reward_time']=date('Y-m-d H:i:s',$uinfo['reward_time']);//接手日期
							$info['before_dawn']=date('Y-m-d 00:00:00',$uinfo['reward_time']+7*86400);// 任务结束日期

							$info['week_out']=$db->getCount('mcs_task_taobao','process=4 and get_time>'.$reward_zieo.' and uid='.$uinfo['user_id']);//本周已发任务
							$info['week_in']=$db->getCount('mcs_task_taobao a, mcs_member_bindacc b','a.process=4 and a.get_time>'.$reward_zieo.' and a.get_user=b.id and b.uid='.$uinfo['user_id']);//本周已接任务

							$info['today_out']=$db->getCount('mcs_task_taobao','process=4 and get_time>'.$before_dawn.' and uid='.$uinfo['user_id']);//今日已发任务
							$info['today_in']=$db->getCount('mcs_task_taobao a, mcs_member_bindacc b','a.process=4 and a.get_time>'.$before_dawn.' and a.get_user=b.id and b.uid='.$uinfo['user_id']);//今日已接任务
							$day=($before_dawn-$reward_zieo)/86400;
							$info['day']=count_tm($day,$reward_zieo,$re['releases'],$re['takeover'],$uinfo['user_id'],$db);
							$info['reward']=$re['reward'];
							$view->assign('info',$info);
							$view->display('user/schedule');
							exit;
						break;

						case 'ok':
							$reward_zieo=strtotime(date('Y-m-d',$uinfo['reward_time']));//接手日期零时
							$before_dawn=strtotime(date('Y-m-d'));//今日零时

							$day=($before_dawn-$reward_zieo)/86400;
							if($day==7){
								$num=count_tm($day,$reward_zieo,$re['releases'],$re['takeover'],$uinfo['user_id'],$db);
								if($num==7){
									if($db->Execute('update mcs_users set reward=0,reward_time=0,pay_money=pay_money+'.$re['reward'].' where user_id='.$uinfo['user_id'])){
										$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','完成平台信誉任务，奖励刷点','".$re['reward']."','刷点日志',".($uinfo['pay_money']+$re['reward']).",'logpoint')");//刷点日志
										$data['info']='奖励领取成功~';
										$data['state']=1;
									}else{
										$data['info']='很抱歉，奖励领取失败~';
									}
								}else{
									$data['info']='很抱歉，您未完成此任务~';
								}
							}else{
								$data['info']='很抱歉，您还未达到领取奖励的条件~';
							}
						break;

						case 'over':
							if($db->Execute('update mcs_users set reward=0,reward_time=0 where user_id='.$uinfo['user_id'])){
								$data['info']='任务取消成功~';
								$data['state']=1;
							}
						break;
					}
				}else{
					$data['info']='任务不存在~';
				}

			}else{
				$data['info']='您未接手此任务~';
			}
			echo json_encode($data);
			exit;
		}
		$reward=$db->getAll('select * from mcs_task_reward');
		//date("Y-m-d",strtotime("+1 week"))
		if($uinfo['reward']){
			$re=$db->getRow('select * from mcs_task_reward where id='.$uinfo['reward']);
			if($re['id']){
				$reward_time=strtotime(date('Y-m-d',$uinfo['reward_time']));//接手日期零时
				$before_dawn=strtotime(date('Y-m-d'));//今日零时
				$day=($before_dawn-$reward_time)/86400;
				if($day<7){
					$static=array('reward'=>$re['id'],'state'=>'schedule');
				}elseif($day==7){
					$num=count_tm($day,$reward_time,$re['releases'],$re['takeover'],$uinfo['user_id'],$db);
					if($num<7){
						$static=array('reward'=>$re['id'],'state'=>'no');
					}else{
						$static=array('reward'=>$re['id'],'state'=>'ok');
					}
				}else{
					$static=array('reward'=>$re['id'],'state'=>'no');
				}

			}
		}
		$view->assign('static',$static);
		$view->assign('reward',$reward);
		$view->display('user/userjob');
	break;

    case 'exam':
		 if($uinfo['isem']==0){
			if(IS_POST){
				$curid = isset($_POST['curid']) ? intval($_POST['curid']) : 0;
				if($curid == 1){
					if($db->Execute("update mcs_users set isem=1,pay_money=pay_money+1 where user_id='{$_SESSION['user_id']}'")){
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','完成新手考试，奖励刷点','1','刷点日志',".($uinfo['pay_money']+1).",'logpoint')");//刷点日志
						echo json_encode(array('status'=>1, 'info'=>'完成'));
						exit;
					}else{
						echo json_encode(array('status'=>2, 'info'=>'失败'));
						exit;
					}
				}
				exit;
			}
			$menu=array('一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四','十五','十六','十七','十八','十九','二十');
			$acc=array('A'=>0,'B'=>1,'C'=>2,'D'=>3,'E'=>4);
			$list=$db->getAll('select * from mcs_question order by shownum asc,id asc limit 12');
			$num=count($list);
			if($num){
				foreach($list as $k => $v){
					$i=$k+1;
					$question[$i]=$v;
					$topic=unserialize($v['topic']);
					if(count($topic)){
						foreach($topic as $key => $val){
							$topics[$key]['acc']=$acc[$key];
							$topics[$key]['val']=$val;
						}
					}
					$question[$i]['topic']=$topics;
					$question[$i]['num']=$menu[$k];
					$question[$i]['count']=$num-$k-1;
				}
			}
			$view->assign('question',$question);
			$view->assign('len',count($question));
			$view->display('user/exam');
	  }else{
			echo '<script type="text/javascript">alert("您已完成新手考试");location.href="user.php";</script>';exit;
	  }
     break;

    case 'setotlog':
        $otlog = isset($_POST['otlog']) ? intval($_POST['otlog']) : 0;
        echo $db->Execute("update mcs_users set otlog=$otlog where user_id='{$_SESSION['user_id']}'") ? 1 : 0;
        break;

    case 'anquan':
		$i=0;
		if($uinfo['mobile_phone']){
			$i++;
		}
		if($uinfo['safepass']){
			$i++;
		}
		if($uinfo['isdc']){
			$i++;
		}
		if($uinfo['otlog']){
			$i++;
		}
		if($i==3){
			$i=1;
		}elseif($i==4){
			$i=2;
		}else{
			$i=0;
		}
		$aq=array('低级','中级','高级');
		$hot_bbs=$db->getAll('select * from mcs_forum_post where pid=0 order by views desc limit 5');
		$view->assign('hot_bbs', $hot_bbs);
		$view->assign('mobile',substr_replace($uinfo['mobile_phone'],'****',3,4));
		$view->assign('aq',$i);
		$view->assign('aqjb',$aq[$i]);
      $view->display('user/anquan');
      break;

    case 'addcard':
        if(IS_POST)
        {
            $bank_name = intval($_POST['bank_name']);
            $bank_user = trim($_POST['bank_user']);
            $bank_num = trim($_POST['bank_num']);
            $smscode = trim($_POST['smscode']);

            if(empty($bank_user) || empty($bank_num) || empty($smscode))
            {
                echo json_encode(array('code'=>101, 'info'=>'信息不全'));
                exit;
            }
			$sms=$db->getRow('select code,id from mcs_message where phone="'.$uinfo['mobile_phone'].'" and sendtime>'.($t-600).' and state=0 order by sendtime desc');
			if(empty($sms['code'])){
				echo json_encode(array('code'=>101, 'info'=>'验证码已过期，请重新发送~'));
                exit;
			}elseif($smscode != $sms['code']){
			    echo json_encode(array('code'=>101, 'info'=>'你输入的验证码不正确~'));
                exit;
            }

            if(empty($_SESSION['user_id'])){
			    echo json_encode(array('code'=>101, 'info'=>'您的信息已过期，请重新登录~'));
                exit;
            }

            $db->Execute("insert into mcs_user_bank(uid, bank_name, bank_num, bank_user) values('{$_SESSION['user_id']}', '$bank_name', '$bank_num', '$bank_user')");
			$db->Execute('update mcs_message set state=1 where id='.$sms['id']);
			echo json_encode(array('code'=>0, 'info'=>'添加成功~'));
            exit;

        }
		$phone=substr_replace($uinfo['mobile_phone'],'****',3,4);
		$view->assign('phone', $phone);
        $view->display('user/addcard');
        break;

    case 'cksafepass':
        if(IS_POST)
        {
            $passwd = trim($_POST['passwd']);

            if(empty($passwd))
            {
                echo json_encode(array('status'=>101, 'info'=>'安全密码不能为空'));
                exit;
            }

            $passwd = cipherStr($passwd);

            if(!$db->getCount('mcs_users', "user_id='{$_SESSION['user_id']}' and safepass='$passwd'"))
            {
                echo json_encode(array('status'=>102, 'info'=>'您输入的安全码不正确'));
                exit;
            }

            $_SESSION['safepass'] = true;

            echo json_encode(array('status'=>200, 'info'=>'安全码验证成功'));
            exit;
        }
        break;

    case 'operate':
		if(!empty($uinfo['safepass'])){
			Redirect('user.php');
		}
        if(IS_POST)
        {
            $passwd = trim($_POST['passwd']);

            if(empty($passwd))
            {
                echo json_encode(array('status'=>101, 'info'=>'安全密码不能为空'));
                exit;
            }

            $passwd = cipherStr($passwd);

            if($db->getCount('mcs_users', "user_id='{$_SESSION['user_id']}' and password='$passwd'"))
            {
                echo json_encode(array('status'=>102, 'info'=>'安全密码不能与登录密码相同'));
                exit;
            }

            $db->Execute("update mcs_users set safepass='$passwd' where user_id='{$_SESSION['user_id']}'");

            echo json_encode(array('status'=>200, 'info'=>'密码设置成功'));
            exit;
        }
        $view->display('user/operate');

        break;

    case 'topup':

		if($_GET['action']=='taobao'&&IS_POST&&IS_AJAX){
			$name=trim($_POST['tid']);
			$pass=trim($_POST['mm']);
			if($name==''||$pass==''){
				$data['info']='请填写完整的充值卡信息';
			}else{
				$info=$db->getRow('select * from mcs_topup where name="'.$name.'"');
				if($info['id']){
					if($info['pass']==$pass){
						if($info['state']==0){
							$db->Execute('update mcs_users set user_money=user_money+'.$info['money'].' where user_id='.$uinfo['user_id']);
							$db->Execute('update mcs_topup set state=1 where id='.$info['id']);
							$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','".$info['money']."','淘宝购卡充值','存款日志',".($uinfo['user_money']+$info['money']).",'payde')");//存款日志
							//$db->Execute("delete from mcs_topup where name = '".$name."' ");
							$data['info']='充值成功~';
							$data['state']=1;

							//双倍积分充值--

							$rank=$db->getField("mcs_configs","value","code='integral_money' ");
							$sta=$db->getAll("select * from mcs_card where uid = '".$uinfo['user_id']."' and endtime > '".time()."' ");

							if($sta){
								$rank=($rank*2);
							}

							$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.' where user_id='.$uinfo['user_id']);
							$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','充值金额积分','积分日志',".$rank.",'logcredit')");//积分日志


							//--


							//卡密充值通知
							$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
							$resul=unserialize($resulta['mess_set']);
							$resl=$resul['f_charge_success'];
							if($resl['website'] == 1 ){
								$time=date('Y-m-d H:i ',time());
								$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}充值".$info['money']."元,充值成功','0','".time()."') ");
								$info =1;
							}

						}else{
							$data['info']='抱歉，该充值卡已使用~';
						}
					}else{
						$data['info']='抱歉，您输入的充值卡密码不正确~';
					}
				}else{
					$data['info']='抱歉，您输入的充值卡不存在~';
				}
			}
			if($info != 1){
				//卡密充值通知
				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
				$resul=unserialize($resulta['mess_set']);
				$resl=$resul['f_charge_error'];
				if($resl['website'] == 1 ){
					$time=date('Y-m-d H:i ',time());
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}充值失败','0','".time()."') ");
				}
			}
			echo json_encode($data);exit;
		}
		//qq
		$bank=$db->getField("mcs_configs",'value',"type = '0' ");
		$bank=unserialize($bank);
		$alipay=$db->getField("mcs_configs",'value',"type = '1' ");
		$alipay=unserialize($alipay);
		$caifutong=$db->getField("mcs_configs",'value',"type = '3' ");
		$caifutong=unserialize($caifutong);
		$view->assign('bank',$bank);
		$view->assign('alipay',$alipay);
		$view->assign('caifutong',$caifutong);
		//是否开启4个模块
		$results=$db->getAll("select * from mcs_configs where id >913 and id <918");
		$view->assign('results',$results);
        $view->display('user/topup');
        break;

	case 'specialty':
		$week=date('w')==0?7:date('w');
		$monday=strtotime(date('Y-m-d'))-(($week-1)*86400);
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			if($_GET['receive']==1){
				$safecode=trim($_POST['safecode']);
				if(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
					$data['info']='安全码验证失败~';
				}else{
					$receive=$db->getRow('select id,money,receive from mcs_user_brush where uid='.$uinfo['user_id'].' and addtime='.$monday.' and state=0');

					if($receive['id']){
						if($receive['receive']==1){
							$db->Execute('update mcs_users set pay_money=pay_money+'.$receive['money'].' where user_id='.$uinfo['user_id']);
							$db->Execute('insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value('.$uinfo['user_id'].','.time().',"领取'.date('Y-m-d',$monday).'周刷客奖励，您得到'.$receive['money'].'元存款",'.$receive['money'].',"刷点日志",'.($uinfo['pay_money']+$receive['money']).',"logpoint")');//日志
						}else{
							$db->Execute('update mcs_users set user_money=user_money+'.$receive['money'].' where user_id='.$uinfo['user_id']);
							$db->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value('.$uinfo['user_id'].','.time().','.$receive['money'].',"领取'.date('Y-m-d',$monday).'周刷客奖励，您得到'.$receive['money'].'元存款","存款日志",'.($uinfo['user_money']+$receive['money']).',"payde")');
						}
                        $db->Execute('update mcs_user_brush set state=1 where id=' . $receive['id']);
						$data['info']='本周奖励领取成功~';
					}else{
						$data['info']='您本周奖励已领取~';
					}
				}
			}else{
				$a = $db->getRow('select * from mcs_configs where id=709');

				if($uinfo['brush_time']>0){
					$data['info']='您已经是好会刷的职业刷客了！快去接任务赚刷点吧~';
				}elseif($uinfo['rank_points'] < $a['value']){
					$data['info']="抱歉！你的积分不足（平台限制刷客的申请条件为积分大于等于".$a['value']."点）";
				}elseif($db->getCount('mcs_task_appeal','aid='.$uinfo['user_id'].' and pid=0 and state=1')){
					$data['info']='抱歉！你有有效投诉记录，不能申请职业刷客~';
				}else{
					$value=$db->getRow("select value from mcs_configs where code = 'integral_brush' ");
					$db->Execute('update mcs_users set brush_time='.strtotime(date('Y-m-d')).',rank_points=(rank_points-'.$value['value'].') where user_id='.$uinfo['user_id']);
					setcookie("fangpian_cookie",'');
					$sess->destroy_session();
					$data['info']='职业刷客申请成功，请重新登录~';
					$data['state']=1;
				}
			}
			echo json_encode($data);
			exit;
		}
		$brush=$db->getAll('select code,name,value from mcs_configs where pid=9 order by id asc');
		$info=unserialize($db->getField('mcs_user_rank','param','rank_id=2'));
		foreach($brush as $k => $v){
			$brush[$k]['rank']=$info[substr($v['code'],6)];
		}
		if($uinfo['brush_time']){
			$view->assign('brush_time',date('Y-m-d',$uinfo['brush_time']+30*86400));
		}
		$user['brush']=date('Y-m-d',$uinfo['brush_time']);
		$user['brush_end']=date('Y-m-d',$uinfo['brush_time']+30*86400);
		$in_task=$db->getAll('select a.id,a.appeal from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=b.uid and a.get_user=b.id and b.uid='.$uinfo['user_id'].' and b.acc_type="tb" and a.get_time>='.$monday);
		$i=0;
		if($in_task){
			foreach($in_task as $a){
				$i++;
				if($a['appeal']>0){
					$state=$db->getField('mcs_task_appeal','state','task_id='.$a['id'].' and pid=0');
					if($state==1){
						$i--;
					}
				}
			}
		}
		$user['in_task']=count($in_task);
		$user['in_tasks']=$i;
		$user['receive']=$db->getRow('select id,money,receive from mcs_user_brush where uid='.$uinfo['user_id'].' and addtime='.$monday.' and state=0');
		$result=$db->getRow("select * from mcs_configs where code = 'integral_brush' ");
		$view->assign('integral_brush',$result['value']);
		$view->assign('brush', $brush);
		$view->assign('user', $user);
		$view->display('user/specialty');
    break;

	case 'vip':
		$vip=$db->getAll('select * from mcs_user_rank where special=1 order by rank_id asc');
		$class=array('1','4','5');
		foreach($vip as $k => $v){
			$vip[$k]['class']=$class[$k];
			foreach($mount as $key => $val){
				$vip[$k]['months'][$key]=$val.':'.($viparr[$v['rank_id']][$key]).'元';
			}
		}
		$user=$db->getAll('select a.user_name,a.headimg,b.price from mcs_users a,mcs_user_rank b where a.user_rank>5 and a.user_rank=b.rank_id order by a.user_rank desc limit 4');
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			$rank=intval($_POST['rank']);
			$num=intval($_POST['num']);
			$vipinfo=$db->getRow('select * from mcs_user_rank where special=1 and rank_id='.$rank);
			if($uinfo['brush_time']>0){
				$data['info']='对不起，您是职业刷客，必须到期后才能购买VIP特权~';
			}elseif(!empty($vipinfo)){
				if(!empty($mount[$num])){
					$money=$viparr[$vipinfo['rank_id']][$num];
					if($uinfo['user_money']>=$money){
						$st='购买';
						if($rank==$uinfo['user_rank']){
							$st='续费';
							$time=$uinfo['rank_expiry']+$num*30*86400;//续费
						}else{
							$time = strtotime("{$num}months", time());
						}
						$sql = 'update mcs_users set user_money=user_money-'.$money.', user_rank='.$rank.', rank_expiry='.$time.' where user_id='.$uinfo['user_id'];
						if($db->Execute($sql))
						{
							$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$money."','".$st.$vipinfo['rank_name'].$mount[$num]."','存款日志',".($uinfo['user_money']-$money).",'payde')");//存款日志
							$data['info']='购买成功~';
						}
					}else{
						$data['info']='抱歉，您的余额不足，请<a href="user.php?act=topup" style="color:red">充值</a>~';
					}
				}else{
					$data['info']='抱歉，没有此选项~';
				}
			}else{
				$data['info']='你要购买的选项不存在~';
			}
			echo json_encode($data);
			exit;
		}
		$view->assign('user', $user);
		$view->assign('vip', $vip);
		$view->display('user/vip');
    break;

    case 'payment':

		// pre($uinfo['rank_points']);die;
		$banks = $db->getAll("select * from mcs_user_bank where uid='{$_SESSION['user_id']}' order by state desc");
        foreach($banks as $key => $val)
        {
            $banks[$key]['lastnum'] = substr($val['bank_num'], -4);
        }
        $view->assign('banks', $banks);

		$yesmoney=intval($uinfo['user_money']);
		$view->assign('yesmoney',$yesmoney);//可提现金额
		$today=$db->getCount('mcs_member_logs','uid='.$uinfo['user_id'].' and type="logpayment" and createtime>='.strtotime(date('Y-m-d')));

		$today_num=$uinfo['params']['mrtxcs']-$today;
		$view->assign('today_num', $today_num);//今日可体现次数

		//提现手续费
		$teshu=$db->getRow("select param from mcs_user_rank where  rank_id = " .$uinfo['user_rank'] );
		$tx=unserialize($teshu['param']);
		$txsxf=$tx['txsxf'];


		if(IS_POST&&IS_AJAX){
			$opt=trim($_GET['opt']);
			switch($opt){
				case 'state':
					$bank=intval($_POST['bank']);
					if($bank){
						$db->Execute('update mcs_user_bank set state=0 where state=1 and uid='.$uinfo['user_id']);
						if($db->Execute('update mcs_user_bank set state=1 where state=0 and uid='.$uinfo['user_id'].' and id='.$bank)){
							$data['state']=1;
						}
					}
				break;
				case 'del':
					$bank=intval($_POST['bank']);
					if($bank){
						if($db->Execute('delete from mcs_user_bank where uid='.$uinfo['user_id'].' and id='.$bank)){
							$data['state']=1;
						}
					}
				break;
				case 'xcont':
					$data['info']='修改失败~';
					$bank=$db->getField('mcs_user_bank','id','uid='.$uinfo['user_id'].' and id='.intval($_POST['bank']));
					$cont=trim($_POST['cont']);
					$type=intval($_POST['type']);
					if($bank==0){
						$data['info']='你要修改的银行卡不存在~';
					}elseif($type<13&&!preg_match('/\d{16,20}/', $cont)){
						$data['info']='请填写正确的银行卡号~';
					}elseif($type==13&&empty($cont)){
						$data['info']='请填写正确的支付宝账户~';
					}else{
						if($db->Execute('update mcs_user_bank set bank_num="'.$cont.'" where uid='.$uinfo['user_id'].' and id='.$bank)){
							$data['info']='修改成功~';
						}
					}
				break;

				case 'mention':

					$safecode=trim($_POST['safecode']);
					$mo=intval($_POST['mo']);
					$sms=intval($_POST['sms']);
					$bank_id=intval($_POST['bank']);
					$txmin=$db->getRow("select mcs_user_rank.TXmin from mcs_users join mcs_user_rank on mcs_users.user_rank=mcs_user_rank.rank_id where mcs_users.user_id='".$uinfo['user_id']."'");
					$data['aa']=$_POST['payment_app_sms'];
					if($txmin['TXmin']>$uinfo['rank_points']){
						$data['info']='对不起，您的积分不够,需要'.$txmin['TXmin']."积分才能提现";
					}elseif($today_num==0){
						$data['info']='对不起，您今日提现次数已用完~';
					}elseif(empty($safecode)||cipherStr($safecode)!=$uinfo['safepass']){
						$data['info']='安全码验证失败~';
					}elseif($mo<=$txsxf){
						$data['info']="对不起，提现金额不能少于等于".$txsxf."元~";
					}elseif($mo>intval($uinfo['user_money'])){
						$data['info']='对不起，您填写的提现金额大于可提现余额~';
					}else{
						$bank_arr=array('中国工商银行','中国银行','中国建设银行','中国招商银行','中国交通银行','中国农业银行','中国邮政银行','浦东银行','广发银行','兴业银行','华夏银行','光大银行','民生银行','支付宝');
						$bank=$db->getRow('select * from mcs_user_bank where uid='.$uinfo['user_id'].' and id='.$bank_id);
						if(intval($bank['id'])==0){
							$data['info']='对不起，您的提现银行卡不存在~';
						}else{
							$tmoney=$mo<100?$mo-$txsxf:$mo;

							$db->Execute('update mcs_users set user_money=user_money-'.$mo.' where user_id='.$uinfo['user_id']);//扣款
							$abc=explode(' ',microtime());
							$iid=$abc[1].$abc[0]*1000000;
							/*
							$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$mo."','通过银行卡提现','存款日志',".($uinfo['user_money']-$mo).",'payde')");//存款日志

							$db->Execute("insert into mcs_member_logs(oid,uid,createtime,user_money,info,logtype,num,type,bid,bank,name) value('TX".$iid."',".$uinfo['user_id'].",'".time()."','".$tmoney."','通过银行卡提现','提现日志',".$mo.",'logpayment','".$bank['bank_num']."','".$bank_arr[$bank['bank_name']]."','".$bank['bank_user']."')");//添加提现记录
							$data['status']=1;
							$data['info']='提现申请成功，请等待处理~';

							//充值提现通知

							$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
							$resul=unserialize($resulta['mess_set']);
							$resl=$resul['f_apply_money'];
							if($resl['website'] == 1 ){
								$time=date('Y-m-d H:i ',time());
								$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}通过{$bank_arr[$bank['bank_name']]}{$iid}提取{$mo}','0','".time()."') ");
							}

							if($sms== 1){
								header("location:http://hhs.lianmon.com/plugins.php?act=notify&type=141225&phone=
								{$uinfo['mobile_phone']}&bank={$bank_arr[$bank['bank_name']]}&mesid={$iid}&price={$mo}");
							}
							*/

							//充值提现通知

							$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
							$resul=unserialize($resulta['mess_set']);
							$resl=$resul['f_apply_money'];
							if($resl['website'] == 1 ){
								$time=date('Y-m-d H:i ',time());
								$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}通过{$bank_arr[$bank['bank_name']]}{$iid}提取{$mo}','0','".time()."') ");
							}

							if($sms== 1){
								//header("location:http://bbs.lianmon.com/plugins.php?act=notify&type=141225&phone=
								//{$uinfo['mobile_phone']}&bank={$bank_arr[$bank['bank_name']]}&mesid={$iid}&price={$mo}");
								$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type,is_show) value(".$uinfo['user_id'].",'".time()."','-".$mo."','通过银行卡提现','存款日志',".($uinfo['user_money']-$mo).",'payde','1')");//存款日志

								$db->Execute("insert into mcs_member_logs(oid,uid,createtime,user_money,info,logtype,num,type,bid,bank,name,is_show) value('TX".$iid."',".$uinfo['user_id'].",'".time()."','".$tmoney."','通过银行卡提现','提现日志',".$mo.",'logpayment','".$bank['bank_num']."','".$bank_arr[$bank['bank_name']]."','".$bank['bank_user']."','1')");//添加提现记录
								$data['status']=1;
								$data['info']='提现申请成功，请等待处理~';
							}else{
								$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$mo."','通过银行卡提现','存款日志',".($uinfo['user_money']-$mo).",'payde')");//存款日志

								$db->Execute("insert into mcs_member_logs(oid,uid,createtime,user_money,info,logtype,num,type,bid,bank,name) value('TX".$iid."',".$uinfo['user_id'].",'".time()."','".$tmoney."','通过银行卡提现','提现日志',".$mo.",'logpayment','".$bank['bank_num']."','".$bank_arr[$bank['bank_name']]."','".$bank['bank_user']."')");//添加提现记录
								$data['status']=1;
								$data['info']='提现申请成功，请等待处理~';
							}
						}
					}
				break;
			}
			echo json_encode($data);
			exit;
		}
        $score = $db->getField("mcs_configs","value"," code = 'integral_withdrawals'");
		$view->assign('txsxf',$txsxf);
		$view->assign('score',  $score);
        $view->display('user/payment');
        break;

	case 'payment_list':
		$money=$db->getRow('select sum(user_money) as money from mcs_member_logs where uid='.$uinfo['user_id'].' and type="logpayment" and state=1');

		$page=$db->page('select * from mcs_member_logs where uid='.$uinfo['user_id'].' and type="logpayment" order by createtime desc',15,5);
		$lists=$page['record'];
		$statearr=array('处理中','成功');
		$stateclass=array('blue','green','red');
		foreach($lists as $key => $val){
			$lists[$key]['createtime']=date('Y-m-d H:i:s',$val['createtime']);
			if($val['state']==2){
				$lists[$key]['state']='失败：'.$val['error'];
			}else{
				$lists[$key]['state']=$statearr[$val['state']];
			}
			$lists[$key]['class']=$stateclass[$val['state']];
			$lists[$key]['from']=$val['bank'].'...'.substr($val['bid'], -4);
		}
		$view->assign('money', intval($money['money']));
		$view->assign('page', $page);
		$view->assign('lists', $lists);
		$view->assign('num', count($lists));
        $view->display('user/payment_list');
        break;

    case 'logout':

        setcookie("fangpian_cookie",'');
        setcookie('qq_name','',time()-170000,'/','.lianmon.com');
        setcookie('qq_auth','',time()-170000,'/','.lianmon.com');
        $sess->destroy_session();
        Redirect('home.php');
        break;

    case 'regdetect':   //注册检测
        switch($_POST['ck'])
        {
            case 'qq':
                $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';
                echo $db->getCount('mcs_users', "qq='$qq'");
                break;

            case 'phone':
                $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
                echo $db->getCount('mcs_users', "mobile_phone='$phone'");
                break;

            case 'uname':
                $name = isset($_POST['name']) ? trim($_POST['name']) : '';

                $lock = array('admin', 'administrator');

                if(in_array($name, $lock))
                {
                    echo -2; exit;
                }

                if($db->getCount('mcs_users', "user_name='$name'"))
                {
                    echo -3; exit;
                }
                break;

            case 'email':
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';

                if(!preg_match('/\w{3,16}@\w+\.[a-z]{2,4}/i', $email))
                {
                    echo -4; exit;
                }

                if($db->getCount('mcs_users', "email='$email'"))
                {
                    echo -6; exit;
                }
             break;

			 case 'parent':
				$name=trim($_POST['name']);
				if(!empty($name)){
					if($db->getCount('mcs_users', "user_name='$name'"))
					{
						echo -3; exit;
					}
				}else{
					echo 1; exit;
				}
			break;
        }
        break;

    case 'reg': //注册
        if(IS_POST)
        {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $safepass = trim($_POST['safepass']);
            $telphone = trim($_POST['mobilephone']);
            $qq = trim($_POST['qq']);
            $email = trim($_POST['email']);
            $parent = trim($_POST['parent']);
			if(!empty($parent)){
				$extension=$db->getField('mcs_users','user_id','user_name="'.$parent.'"');
				if(intval($extension)==0){
					JSMessage('可选推荐人不存在~');
				}
			}elseif(!empty($_COOKIE['spread_name'])){
				$extension=$db->getField('mcs_extension','uid','code="'.$_COOKIE['spread_name'].'"');
			}
            if(empty($username) || empty($password) || empty($telphone))
            {
                JSMessage('请填写完整的注册资料');
            }elseif($db->getCount('mcs_users','user_name="'.$username.'"')){
				 JSMessage('用户已存在wa');
			}elseif($password!=$safepass){
				 JSMessage('密码不一致');
			}elseif($db->getCount('mcs_users','mobile_phone="'.$telphone.'"')){
				 JSMessage('手机号码已注册');
			}

            $password = cipherStr($password);

			if($_COOKIE['qq_auth'] == 1){ //qq登陆的用户
				$qq_id=$db->getField("mcs_qq","id","qq_name = '".$_COOKIE['qq_name']."' ");
				$sql = "insert into mcs_users(user_name, password, qq_id,mobile_phone, qq, email, add_time,extension) values('$username', '$password','$qq_id' ,'$telphone', '$qq', '$email', '". time() ."','".$extension."')";
			}else{
				$sql = "insert into mcs_users(user_name, password, mobile_phone, qq, email, add_time,extension) values('$username', '$password', '$telphone', '$qq', '$email', '". time() ."','".$extension."')";
			}

            if($db->Execute($sql))
            {
                $result=$db->getRow("select * from mcs_qq as a ,mcs_users as b where a.id=b.qq_id and a.qq_name = '".$_COOKIE['qq_name']."' ");
                if($result){
                    $_SESSION['user_id']=$result['user_id'];
                    Redirect('user.php');
                }
                unset($_SESSION['extensionuser']);
                JSMessage('注册成功');
            }
            else
            {
                JSMessage('注册失败，请检测您输入的注册信息是否完整');
            }

        }
		$view->assign('reg', 1);
		if(!empty($_COOKIE['spread_name'])){
			$view->assign('key',1);
		}
		$view->display('user/login');
        break;

    case 'login':   //登录
        if(IS_POST&&IS_AJAX){
			setcookie("fangpian_cookie",'');
			//sleep(1);
			$data['status']=0;
			$data['info']='访问出错';
			if($_SESSION['user_id']){
				$data['info']='您已登陆';
			}else{
				$username = trim($_POST['username']);
				$password = trim($_POST['password']);
				$question = trim($_POST['question']);
				$trouble = trim($_POST['trouble']);
				if(empty($username) || empty($password)) {
					$data['info']='账户或密码不能为空';
				}else{
					$row = $db->getRow("select * from mcs_users where user_name='$username'");
					if($row){
						if($row['statu']==0){
							$data['info']='该账户已被冻结，暂不能登录';
						}
						elseif(cipherStr($password)==$row['password']){
							if($row['brush_time']>0){
								if(($row['brush_time']+86400*30)<time()){
									$db->Execute('update mcs_users set brush_time=0 where user_id='.$row['user_id']);
								}
							}
							if($row['questiontype']>0&&!empty($row['question'])){
								if($question==0&&empty($trouble)){
									$data['trouble']=1;
									unset($data['status']);
									unset($data['info']);
								}else{
									if($question==$row['questiontype']&&$trouble==$row['question']){
										$_SESSION['user_id'] = $row['user_id'];
										$_SESSION['user_name'] = $row['user_name'];
										$last_ip=getRealIp();
										$db->Execute("update mcs_users set log_count=log_count+1, last_login='". time() ."', last_ip='".$last_ip."' where user_id='{$row['user_id']}'");
										$info=$row['user_name'].'登陆网站';
										$db->Execute("insert into mcs_member_logs(uid,createtime,type,logtype,info,ip) values(".$row['user_id'].",".time().",'logaccount','登陆网站sss','".$info."','".$last_ip."')");
										if(isset($_CFG['integral_login'])&&$row['last_login']<strtotime(date('Y-m-d'))){
											$db->Execute('update mcs_users set bbs_upper=0,rank_points=rank_points+'.$_CFG['integral_login'].',pay_points=pay_points+'.$_CFG['integral_login'].' where user_id='.$row['user_id']);
											$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$row['user_id'].",'".time()."','".($row['rank_points']+$_CFG['integral_login'])."','登陆积分','积分日志',".$_CFG['integral_login'].",'logcredit')");//积分日志
										}
										$data['status']=1;
									}else{
										$data['status']=-1;
										$data['info']='安全提问错误';
									}
								}
							}elseif($row['is_ok'] == 1){
								$data['status']=-2;
								$data['info']='该账户有违规操作，已被冻结，如有疑问请联系管理员！';
							}else{

								//没有安全问题的用户
								$_SESSION['user_id'] = $row['user_id'];
								$_SESSION['user_name'] = $row['user_name'];
								$last_ip=getRealIp();
								$db->Execute("update mcs_users set log_count=log_count+1, last_login='". time() ."', last_ip='".$last_ip."' where user_id='{$row['user_id']}'");
								$info=$row['user_name'].'登陆网站';
								$db->Execute("insert into mcs_member_logs(uid,createtime,type,logtype,info,ip) values(".$row['user_id'].",".time().",'logaccount','登陆网站','".$info."','".$last_ip."')");
								if(isset($_CFG['integral_login'])&&$row['last_login']<strtotime(date('Y-m-d'))){

									$statu=$db->getAll("select * from mcs_card where uid = '".$_SESSION['user_id']."' and endtime > '".time()."' ");

									if($statu){
										$rank=($_CFG['integral_login']*2);
										$db->Execute('update mcs_users set bbs_upper=0,rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.' where user_id='.$row['user_id']);
										$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$row['user_id'].",'".time()."','".($row['rank_points']+$rank)."','登陆积分','积分日志',".$rank.",'logcredit')");//积分日志

									}else{
										$db->Execute('update mcs_users set bbs_upper=0,rank_points=rank_points+'.$_CFG['integral_login'].',pay_points=pay_points+'.$_CFG['integral_login'].' where user_id='.$row['user_id']);
										$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$row['user_id'].",'".time()."','".($row['rank_points']+$_CFG['integral_login'])."','登陆积分','积分日志',".$_CFG['integral_login'].",'logcredit')");//积分日志
									}

								}
								$data['status']=1;
							}
						}else{
							$data['info']='账户或密码错误';
						}
					}else{
						$data['info']='用户不存在';
					}
				}
			}
			echo json_encode($data);
			exit;
        }
        if($_SESSION['extensionuser']){
        	$extensionusername=$db->getRow("select user_name from mcs_users where user_id='".$_SESSION['extensionuser']."'")['user_name'];
        	$view->assign("extensionuser",$extensionusername);
        }
        // echo $extensionusername;die;
		$view->display('user/login');
    break;

	case "test":


		var_Dump($rank);

	break;

	case 'thread':
		$thread=trim($_GET['thread']);
		switch($thread){
			case 'reply':
				$list=$db->page('select b.id,b.title,a.add_time from mcs_forum_post a,mcs_forum_post b where a.pid=b.id and a.uid='.$uinfo['user_id'].' group by b.id order by a.add_time desc',15,5);
				foreach($list['record'] as $k => $v){
					$list['record'][$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
				}
			break;

			case 'collection':
				if(IS_POST&&IS_AJAX){
					$data['str']='删除失败~';
					$id=intval($_POST['id']);
					if($id>0){
						$sql = 'delete from mcs_user_collection where uid='.$uinfo['user_id'].' and id='.$id;
						$db->Execute($sql);
						echo $id;exit;
					}
				}
				$list=$db->page('select a.id,b.id as did,a.title,a.add_time from mcs_forum_post a,mcs_user_collection b where a.pid=0 and a.id=b.fid and b.uid='.$uinfo['user_id'].' order by a.add_time desc',15,5);
				foreach($list['record'] as $k => $v){
					$list['record'][$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
				}
			break;

			default:
				$list=$db->page('select id,title,add_time from mcs_forum_post where pid=0 and uid='.$uinfo['user_id'],15,5);
				foreach($list['record'] as $k => $v){
					$list['record'][$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
				}
				$thread='theme';
			break;
		}

		$view->assign('thread', $thread);
		$view->assign('list', $list);

		$view->display('user/thread');
	break;


    default:
        $ipinfo = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='. getRealIp());
        $ipinfo = json_decode($ipinfo);
        $ip_area = $ipinfo->data->region . ' '. $ipinfo->data->city . ' ' . $ipinfo->data->isp;
        $ip_area = str_replace(' ', '', $ip_area) == false ? $ipinfo->data->country : $ip_area;
        $view->assign('ip_area', $ip_area);
         $view->assign('jyt', $uinfo['pay_points']*100/$uinfo['max_points']);

		$dt=$db->getAll('select logtype,createtime from mcs_member_logs where type="logtask" and uid='.$uinfo['user_id'].' order by createtime desc limit 10');
		foreach($dt as $k => $v){
			$dt[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
		}
		$view->assign('dt', $dt);
		/*论坛帖子*/
		/*$hot_bbs=$db->getAll('select * from mcs_forum_post where pid=0 and fid=1 order by views desc limit 3');*/
		$hot_bbs=$db->getAll('select * from mcs_forum_post where pid=0 and fid=1 order by add_time desc limit 2');
		if(count($hot_bbs)){
			foreach($hot_bbs as $k => $v){
				$hot_bbs[$k]['title']=cnsubstr($v['title'],18);
			}
		}
		$view->assign('hot_bbs', $hot_bbs);

		/*可处理任务数量*/
		$canhandle1=$db->getCount('mcs_task_taobao a,mcs_member_bindacc b','a.process>=0 and a.process<4 and a.uid!='.$uinfo['user_id'].' and a.get_user=b.id and b.uid='.$uinfo['user_id'].' and b.acc_type="tb"');

		$canhandle2=$db->getCount('mcs_task_taobao','((process>=0 and process<4) or (process=5)) and uid='.$uinfo['user_id'].' and get_user>0');
		if($canhandle1){$goto='taobao.php?mod=inTask';}
		if($canhandle2){$goto='taobao.php?mod=outTask';}
		$view->assign('canhandle', ($canhandle1+$canhandle2));
		$view->assign('goto',$goto);

		//$complaint=$db->getCount("mcs_task_appeal","(uid=$uinfo[user_id] and aid>0) or (aid=$uinfo[user_id] and uid>0) and state=0");//投诉信息
		$complaint=$db->getCount("mcs_task_appeal","((uid=$uinfo[user_id] and aid>0) or (aid=$uinfo[user_id] and uid>0)) and state=0");//投诉信息
		$view->assign('complaint', $complaint);

		$rank_expiry=$uinfo['rank_expiry']>0?date('Y-m-d',$uinfo['rank_expiry']):'无';//到期时间
		$view->assign('rank_expiry', $rank_expiry);
		$view->assign('model_type','user');

		//会员中心帮助
		$help=$db->getRow("select * from mcs_picture where menu = 'help' ");
		$view->assign("help",$help);
        $view->display('user/index');
        break;
}

?>
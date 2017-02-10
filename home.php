<?php
require 'mcscore/init.php';
$public_right=$db->getRow("select * from mcs_picture where menu = 'public_right' ORDER by id desc");
$view->assign("public_right",$public_right);
if($_COOKIE['qq_auth'] == 1){
    $status=$db->getRow("select * from mcs_qq as a ,mcs_users as b where a.id=b.qq_id and a.qq_name = '".$_COOKIE['qq_name']."'  ");
    if(!$status){
        //echo "<script type='text/javascript'>alert('请注册');</script>";
        header("location:user.php?act=reg");
    }else{
        $_SESSION['user_id']=$status['user_id'];

        //核心开始
        $uinfo = $db->getRow("select * from mcs_users where user_id='{$_SESSION['user_id']}'");
        if($uinfo)
        {
            if($uinfo['autoam']>0){
                $uinfo['autoam_time']=date('Y-m-d H:i',$uinfo['autoam']);
                if($uinfo['autoam']<time()){
                    $db->Execute('update mcs_users set autoam=0 where user_id='.$uinfo['user_id']);
                    $uinfo['autoam']=0;
                }
                $uinfo['autoam_attr'] = unserialize($uinfo['autoam_attr']);
            }
            if($uinfo['saninter']>0&&$uinfo['saninter']<time()){
                $db->Execute('update mcs_users set saninter=0 where user_id='.$uinfo['user_id']);
                $uinfo['saninter']=0;
            }
            $rank = $db->getRow("select * from mcs_user_rank where rank_id='{$uinfo['user_rank']}'");
            $uinfo['rank_name'] = $rank['rank_name'];
            $uinfo['verify'] = intval($db->getField('mcs_member_realname','state','uid='.$uinfo['user_id']));
            $uinfo['params'] = unserialize($rank['param']);
            if($uinfo['brush_time']>0){
                $uinfo['rank_name']='职业刷客';
                $brush=$db->getAll("select code,value from mcs_configs where pid=9 order by id asc");
                foreach($brush as $v){
                    $uinfo['params'][substr($v['code'],6)]=$v['value'];
                }
            }
            $uinfo['mess_set'] = unserialize($uinfo['mess_set']);
            $point_multiple=$uinfo['params']['ksjf'];//积分倍数
            if($uinfo['saninter']>0){
                $point_multiple=2;
            }
            $uinfo['max_points'] = $db->getField('mcs_user_rank','max_points','min_points<='.$uinfo['pay_points'].' and max_points>='.$uinfo['pay_points'].' and special=0');

            //if($uinfo['mprz']) $uinfo['mobile_phone'] = preg_replace('/(\d{3})\d{4}/', '\1****', $uinfo['mobile_phone']);

            if(empty($uinfo['safepass'])&&PHP_SELF!='/user.php'&&$_GET['act']!='operate'){
                Redirect('user.php?act=operate');
            }
            //$uinfo['read_num']=$db->getCount("mcs_member_message","tuid=".$uinfo['user_id']." and fuid>0 and state=0");
            $uinfo['read_num']=$db->getCount("mcs_member_message","tuid=".$uinfo['user_id']." and state=0");
        }
        $view->assign('uinfo', $uinfo);
        //核心结束
    }
}


switch($action)
{
	case 'addInfo':
		if(IS_POST){
			$data  = $_POST;
			$uid = $_SESSION['user_id'];
			$addtime = time();
			$exist = $db->getRow("select * from mcs_tuoguan_detail where uid = ".$uid);
			if($exist){
				$res = $db->Execute("update mcs_tuoguan_detail set shopUrl = '".$data['shopUrl']."',proUrl = '".$data['proUrl']."',QQ = ".$data['QQ'].",phone = ".$data['phone'].",oid = '".$data['oid']."',addtime = ".$addtime." where uid = ".$uid);
				if($res){
					JSMessage("修改成功","home.php?act=tuoguan");
				}
			}else{
				$res = $db->Execute("insert into mcs_tuoguan_detail (uid,shopUrl,proUrl,QQ,phone,addtime,oid) values (".$uid.",'".$data['shopUrl']."','".$data['proUrl']."',".$data['QQ'].",".$data['phone'].",".$addtime.",'".$data['oid']."')");
				if($res){
					JSMessage("添加成功","home.php?act=tuoguan");
				}
			}
		}
    break;


	case 'popularize':
		$num=-1;
		if($uinfo['user_id']){
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
			$num=$db->getSum('mcs_user_extension','point','point>0 and uid='.$uinfo['user_id']);
		}
		$line=$db->getAll('select a.user_name,b.money from mcs_users a,mcs_user_extension b where a.user_id=b.uid and b.type="user_money" limit 5');
		foreach($line as $k => $v){
			$line[$k]['user_name']=substr_replace($v['user_name'],'***',1,strlen($v['user_name'])-2);
		}
		$view->assign('num', $num);
		$view->assign('line', $line);
		if($code){$link='http://www.haohuisua.com/?reg='.$code;}
		$view->assign('link', $link);
        $view->display('home/popularize');
    break;


    case 'tuoguan':
        if(IS_POST)
        {
            $user = $db->getRow("select * from mcs_users where user_id='{$_SESSION['user_id']}'");
            if(!$user)
            {
                echo json_encode(array('code'=>0, 'info'=>'您还没有登录或登录超时，请先登录'));
                exit;
            }

            $itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;
            $info = $db->getRow("select * from mcs_tuoguan where id=$itemid");
            if(!$info)
            {
                echo json_encode(array('code'=>0, 'info'=>'请选择您要购买的套餐类型。'));
                exit;
            }

            if($user['user_money'] < $info['price'])
            {
                echo json_encode(array('code'=>0, 'info'=>'您的余额不足，请先充值'));
                exit;
            }

            $last = $db->getRow("select o.*, days from mcs_orders o, mcs_tuoguan t where o.gid=t.id and uid='{$_SESSION['user_id']}' and otype='tuoguan' order by add_time desc");

            if($last && $last['add_time'] + $last['days'] * 86400 > time())
            {
                echo json_encode(array('code'=>0, 'info'=>'您当前有一个套餐正在进行，不能重复购买'));
                exit;
            }

            $newoid = date('YmdHis'). mt_rand(1000, 9999);
            $sql = "insert into mcs_orders(oid, uid, otype, gid, add_time) values('$newoid', '{$_SESSION['user_id']}', 'tuoguan', '$itemid', '". time() ."')";

            if($db->Execute($sql))
            {
                $db->Execute("update mcs_users set user_money=user_money-'{$info['price']}' where user_id='{$_SESSION['user_id']}'");
                echo json_encode(array('code'=>1, 'info'=>'交易成功，刷新页面后查看'));
                exit;
            }
            else
            {
                echo json_encode(array('code'=>0, 'info'=>'交易失败，状态异常'));
                exit;
            }

            exit;
        }

        $tuoguanod = $db->getRow("select o.*, title, days from mcs_orders o, mcs_tuoguan t where o.gid=t.id and uid='{$_SESSION['user_id']}' and otype='tuoguan' order by add_time desc");

        if($tuoguanod && $tuoguanod['add_time'] + $tuoguanod['days'] * 86400 > time())
        {
            $ctime = $tuoguanod['days'] * 86400;
            $stime = time()-$tuoguanod['add_time'];

            if($ctime - $stime < 1000) $stime = $ctime;

            $tuoguanod['bl'] = round($stime / $ctime * 100, 2);

            $view->assign('tuoguanod', $tuoguanod);
        }

        $tglist = $db->getAll("select o.*, title, days, user_name from mcs_orders o, mcs_tuoguan t, mcs_users u where u.user_id=o.uid and o.gid=t.id and otype='tuoguan' order by add_time desc limit 10");
        $view->assign('tglist', $tglist);
		//完善托管
		$res=$db->getField("mcs_orders","oid","uid = '".$uinfo['user_id']."' ");
		if($res){
            $status=1;
        }
        $tuoguan=$db->getRow("select * from mcs_picture where menu = 'tuoguan' ");
        $tuoguan_big=$db->getRow("select * from mcs_picture where menu = 'tuoguan_big' ");
        $view->assign("tuoguan_big",$tuoguan_big);
        $view->assign("tuoguan",$tuoguan);
        $view->assign("status",$status);
        $view->assign('tgitem', $db->getAll("select * from mcs_tuoguan order by price asc"));
        $view->assign('model_type','tuoguan');
        $view->display('home/tuoguan');
        break;

    case 'soft':
        $downs = $db->getAll("select * from mcs_download");
		$picture=$db->getRow("select * from mcs_picture where types =1 order by id desc ");
        //$picture['path']=$_SERVER['SERVER_NAME'].'/'.$picture['path'];
        foreach($downs as $key => $val)
        {
            $val['key'] = $key+1;
            $downs[$key] = $val;
        }
        $view->assign('downs', $downs);
		$view->assign('picture',$picture);
		$view->assign('model_type','soft');
        $view->display('home/soft');
        break;


    case 'buypoint':

		//删除过期卡片
		$db->Execute("delete from mcs_card where  uid = '".$uinfo['user_id']."' and endtime < '".time()."' ");

        if(IS_POST)
        {
            $mod = isset($_POST['mod']) ? trim($_POST['mod']) : '';

            $user = $db->getRow("select * from mcs_users where user_id='{$_SESSION['user_id']}'");
            if(!$user)
            {
                echo json_encode(array('code'=>0, 'info'=>'您还没有登录或登录超时，请先登录'));
                exit;
            }

            switch($mod)
            {
                case 'card':
                   $card_arr=array(
						'A'=>array('pay_money'=>260,'user_money'=>156),
						'B'=>array('pay_money'=>501,'user_money'=>290),
						'C'=>array('pay_money'=>1001,'user_money'=>570),
						'D'=>array('pay_money'=>2001,'user_money'=>1080),
						'E'=>array('pay_money'=>5001,'user_money'=>2600),
						'F'=>array('pay_money'=>10001,'user_money'=>5000),
					);
					$card=trim($_POST['card']);
                    if(empty($card_arr[$card]))
                    {
                        echo json_encode(array('code'=>0, 'info'=>'请选择您要购买的套餐'));
                        exit;
                    }
					$price=$card_arr[$card]['user_money'];
					$num=$card_arr[$card]['pay_money'];
                    if($user['user_money'] < $price)
                    {
                        echo json_encode(array('code'=>0, 'info'=>'您的余额不足，请先充值'));
                        exit;
                    }

                    $sql = "update mcs_users set user_money=user_money-$price, pay_money=pay_money+$num where user_id='{$_SESSION['user_id']}'";

                    if($db->Execute($sql))
                    {
						$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$price."','购买".$card.'套餐，增加'.$num."个刷点','存款日志',".($uinfo['user_money']-$price).",'payde')");//存款日志

						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','购买".$card.'套餐，增加'.$num."个刷点','".$num."','刷点日志',".($uinfo['pay_money']+$num).",'logpoint')");//刷点日志

						extension_log($uinfo['user_id'],'buy',array('card'=>$card,'money'=>$price));
                        echo json_encode(array('code'=>1, 'info'=>'交易成功，刷新页面后查看'));


						//ABCDEF卡卖点通知
						$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
						$resul=unserialize($resulta['mess_set']);
						$resl=$resul['f_buy_maidian'];
						if($resl['website'] == 1 ){
							$time=date('Y-m-d H:i ',time());
							$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','购买".$card.'套餐，增加'.$num."个刷点','0','".time()."') ");
						}

                        exit;
                    }
                    else
                    {
                        echo json_encode(array('code'=>0, 'info'=>'交易失败，状态异常'));
                        exit;
                    }
                    break;

                case 'vip':

					$data['info']='访问出错~';
					$data['code']=0;
					if(IS_AJAX){
						$rank=intval($_POST['urank']);
						$num=intval($_POST['months']);
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
										$data['code']=1;

										//购买刷点通知
										$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
										$resul=unserialize($resulta['mess_set']);
										$resl=$resul['f_buy_maidian'];
										if($resl['website'] == 1 ){
											$time=date('Y-m-d H:i ',time());
											$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}购买".$mount[$num]."刷点,消耗".$money."元','0','".time()."') ");
										}

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
					echo json_encode($data);
					exit;
                    break;

                case 'points':     //上面的购买卖点

                    $num = intval($_POST['num']);
                    $price = $_CFG['unit_price'] * $num;

                    if($price <= 0)
                    {
                        echo json_encode(array('code'=>0, 'info'=>'请选择您要购买的数量'));
                        exit;
                    }

                    if($user['user_money'] < $price)
                    {
                        echo json_encode(array('code'=>0, 'info'=>'您的余额不足，请先充值'));
                        exit;
                    }

                    $sql = "update mcs_users set user_money=user_money-$price, pay_money=pay_money+$num where user_id='{$_SESSION['user_id']}'";

                    if($db->Execute($sql))
                    {
						$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$price."','购买".$num."个刷点','存款日志',".($uinfo['user_money']-$price).",'payde')");//存款日志

						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,logtype,num,type,error) value(".$uinfo['user_id'].",'".time()."','购买".$num."个刷点','".$num."','刷点日志',".($uinfo['pay_money']+$num).",'logpoint','message')");//刷点日志

						echo json_encode(array('code'=>1, 'info'=>'交易成功，刷新页面后查看'));
						//购买刷点通知
						$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$uinfo['user_id']."' ");
						$resul=unserialize($resulta['mess_set']);
						$resl=$resul['f_buy_maidian'];
						if($resl['website'] == 1 ){
							$time=date('Y-m-d H:i ',time());
							$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime) value ('".$uinfo['user_id']."','".$uinfo['user_id']."','你于{$time}购买".$num."刷点,消耗".$price."元','0','".time()."') ");
						}

						if($resl['mobile'] == 1){
							header("location:http://hhs.lianmon.com/plugins.php?act=notify&type=141226&phone={$uinfo['mobile_phone']}&price={$price}");
						}

                    }
                    else
                    {
                        echo json_encode(array('code'=>0, 'info'=>'交易失败，状态异常'));
                        exit;
                    }
                break;

				case 'cards':  //五个小卡片
					if(IS_AJAX){
						$title=trim($_POST['title']);
						switch($title){
							case 'saninter':
								$money=3;
								if($money<=$uinfo['user_money']){
									if($uinfo['saninter']==0){
										$saninter=time()+86400;
									}else{
										$saninter=$uinfo['saninter']+86400;
									}

									$sql = 'update mcs_users set user_money=user_money-'.$money.',saninter='.$saninter.' where user_id='.$_SESSION['user_id'];
									if($db->Execute($sql)){
										$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$money."','购买24小时双倍积分卡','存款日志',".($uinfo['user_money']-$money).",'payde')");
										$data['info']='您已成功购买24小时双倍积分卡';

										//积分卡设置
										$db->Execute("insert into mcs_card (uid,type,addtime,endtime) value ('".$_SESSION['user_id']."','1',".time().",".(time()+86400).") ");


									}
								}else{
									$data['info']='对不起，您的存款不足'.$money.'元，请先充值~';
								}
							break;
							case 'qiinter':
								$money=16;
								if($money<=$uinfo['user_money']){
									if($uinfo['saninter']==0){
										$saninter=time()+7*86400;
									}else{
										$saninter=$uinfo['saninter']+7*86400;
									}
									$sql = 'update mcs_users set user_money=user_money-'.$money.',saninter='.$saninter.' where user_id='.$_SESSION['user_id'];
									if($db->Execute($sql)){
										$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$money."','购买7天双倍积分卡','存款日志',".($uinfo['user_money']-$money).",'payde')");
										$data['info']='您已成功购买7天双倍积分卡';

										//积分卡设置
										$db->Execute("insert into mcs_card (uid,type,addtime,endtime) value ('".$_SESSION['user_id']."','7',".time().",".(time()+7*86400).") ");

									}
								}else{
									$data['info']='对不起，您的存款不足'.$money.'元，请先充值~';
								}
							break;
							case 'task': //任务定制
								$m=1;
								$num=intval($_POST['num']);
								if($num>0){
									$money=($m*$num);
									if($money<=$uinfo['user_money']){
										if($uinfo['autoam']==0){
											$autoam=time()+$num*86400;
										}else{
											$autoam=$uinfo['autoam']+$num*86400;
										}
										$sql = 'update mcs_users set user_money=user_money-'.$money.',autoam='.$autoam.' where user_id='.$_SESSION['user_id'];
										if($db->Execute($sql)){
											$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value(".$uinfo['user_id'].",'".time()."','-".$money."','购买".$num."天任务定制卡','存款日志',".($uinfo['user_money']-$money).",'payde')");
											$data['info']='您已成功购买任务定制卡'.$num.'天，是否前往定制任务？';
											$data['status']=1;
											$data['url']='user.php?act=autoam';
										}
									}else{
										$data['info']='对不起，您的存款不足'.$money.'元，请先充值~';
									}
								}else{
									$data['info']='请填写购买天数~';
								}
							break;
							case 'haoping': //好评清理卡
								$money=5;
								//$info=$db->getRow('select id,type from mcs_task_comm where uid='.$uinfo['user_id'].' and type>1 order by addtime desc');
								$info=$db->getRow('select id,type from mcs_task_comm where tuid='.$uinfo['user_id'].' and type>1 order by addtime desc');
								if($info['id']){
									$type=$info['type']==2?'中评':'差评';
									$last=mktime(0,0,0,date("m"),1,date("Y"));
									$data['info']=$last;
									if($uinfo['haoping']==0||($uinfo['haoping']>0&&$uinfo['haoping']<$last)){
										if($money<=$uinfo['user_money']){
											$db->Execute('update mcs_task_comm set type=0 where id='.$info['id']);
											$sql = 'update mcs_users set user_money=user_money-'.$money.',haoping='.time().' where user_id='.$_SESSION['user_id'];
											if($db->Execute($sql)){
												$db->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value("'.$uinfo['user_id'].'","'.time().'","-'.$money.'","购买平台好评卡,'.$type.'-1","存款日志",'.($uinfo['user_money']-$money).',"payde")');
												$data['info']='购买平台好评卡,'.$type.'-1';
											}
										}else{
											$data['info']='对不起，您的存款不足'.$money.'元，请先充值~';
										}
									}else{
										$data['info']='您本月已购买过平台好评卡~';
									}
								}else{
									$data['info']='您没有中评或差评，不需要购买~';
								}
							break;
							case 'tousu': //投诉清理卡
								$money=5;
								$info=$db->getRow('select id from mcs_task_appeal where aid='.$uinfo['user_id'].' and pid=0 and state=1 order by add_time desc');
								if($info['id']){
									$last=mktime(0,0,0,date("m"),1,date("Y"));
									if($uinfo['tousu']==0||($uinfo['tousu']>0&&$uinfo['tousu']<$last)){
										if($money<=$uinfo['user_money']){
											$db->Execute('update mcs_task_appeal set state=2 where id='.$info['id']);
											$sql = 'update mcs_users set user_money=user_money-'.$money.',tousu='.time().' where user_id='.$_SESSION['user_id'];
											if($db->Execute($sql)){
												$db->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value("'.$uinfo['user_id'].'","'.time().'","-'.$money.'","购买投诉清理卡","存款日志",'.($uinfo['user_money']-$money).',"payde")');
												$data['info']='成功清理一个有效投诉';
											}
										}else{
											$data['info']='对不起，您的存款不足'.$money.'元，请先充值~';
										}
									}else{
										$data['info']='您本月已购买过投诉清理卡~';
									}
								}else{
									$data['info']='您的记录良好，没有有效投诉，不需要购买~';
								}
							break;
						}
					}
					echo json_encode($data);exit;
				break;

                default:
                    echo json_encode(array('code'=>0, 'info'=>'请选择您要购买的项目'));
                    exit;
                    break;
            }

            exit;
        }
        $view->assign('model_type','buypoint');
        $view->display('home/buypoint');
        break;

    case 'test':

        $url ='https://item.taobao.com/item.htm?spm=a1z10.1-c-s.w5003-14708012092.3.h2XrUN&id=542666058694&scene=taobao_shop';
        $url=str_replace("@","&",$url);
        $array = get_headers($url,1);
        if(preg_match('/200/',$array[0])){
            $content = iconv('gbk','utf-8',file_get_contents($url));
            preg_match('/<em\s+class="tb-rmb-num">\s*(.+)\s*<\/em>/', $content, $arr);
            $price = explode('-', $arr[1]);
            $price = array_pop($price);
            echo 1;
            var_dump($array);
        }
        else{
            var_dump($url);
        }

        break;


    default:

        $index_bigPicture=$db->getAll("select * from mcs_picture where menu = 'index_bigPicture'");
        $view->assign("index_bigPicture",$index_bigPicture);

        $artlist = $db->getAll("select id, title, add_time from mcs_forum_post where pid=0 and fid=1 order by id desc limit 7");
        foreach($artlist as $key => $val)
        {
            $val['title'] = cnsubstr($val['title'], 20);
            $val['add_time'] = date('m-d', $val['add_time']);
            $artlist[$key] = $val;
        }
        $view->assign('artlist', $artlist);

		$sql="select a.addtime,b.user_name as susername from mcs_task_taobao a,mcs_users b where a.uid=b.user_id order by rand() desc limit 8";
		$now=$db->getAll($sql);
		$view->assign('now', $now);

        $newuser = $db->getAll("select user_name, add_time from mcs_users order by add_time desc limit 5");
        $view->assign('newuser', $newuser);
		$line=$db->getAll('select a.user_name,b.money from mcs_users a,mcs_user_extension b where a.user_id =b.uid and b.type="user_money" limit 5');
		foreach($line as $k => $v){
			$line[$k]['user_name']=substr_replace($v['user_name'],'***',1,strlen($v['user_name'])-2);
		}
		$view->assign('line', $line);

		$lines=$db->getAll('select uid,sum(money)+sum(point) as m from mcs_user_extension group by uid order by m desc limit 3');
		$ph=array('one','two','three');
		foreach($lines as $k => $v){
			$lines[$k]['user_name']=$db->getField('mcs_users','user_name','user_id='.intval($v['uid']));
			$lines[$k]['ph']=$ph[$k];
		}
		$view->assign('lines', $lines);
		$view->assign('model_type','index');
        $view->display('home/index');
        break;
}
?>
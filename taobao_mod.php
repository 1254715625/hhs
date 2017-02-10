<?php
// print_r($uinfo);die;
$user_ids = $_SESSION['user_id'];
$db->Execute("update mcs_task_taobao set process=0,timing=0 where process=5 and timing>0 and timing<".time());//延迟发布自动刷新
$db->Execute("update mcs_task_taobao set process=0,timing=0,get_user=0,finish='' where get_user>0 and process=0 and timing>0 and timing<".time());//审核未通过自动刷新
$db->Execute("update mcs_task_taobao set process=2,timing=0 where process=1 and timing>0 and timing<".time());//自动发货剩余时间
$db->Execute("update mcs_task_taobao set ddlOKDays=0 where process=2 and ddlOKDay>0 and ddlOKDays>0 and ddlOKDays<".time());//要求确认时间更新
//$db->Execute("delete from mcs_task_taobao  where addtime<'".strtotime(date('Y-m-d'))."' ");
// if($data=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_task_taobao.process=4 and mcs_member_bindacc.uid=".$_SESSION['user_id'])['count']){
// 	// $extensionuser=$db->getRow("select extension from mcs_users where user_id='".$uinfo['user_id']."'")['extension'];
// 	// print_r($extensionuser);die;
// 	$db->Execute("update mcs_users set extension_status='1' where user_id='".$uinfo['user_id']."'");
// }

require('task.php');
switch($mod)
{
	case 'autoam':
		if(IS_AJAX&&IS_POST){
			$data['attr']=$uinfo['autoam_attr'];
			if($uinfo['autoam']){
				$data['info']='您定制的任务正在匹配中，请勿关闭窗口，否则无法使用该功能~';
			}else{
				$data['info']='对不起，您还没有开通任务定制~';
				$data['status']=1;
			}
		}
		echo json_encode($data);exit;
	break;
	case 'gettask_list':
		if(IS_AJAX&&IS_POST){
			$sql='select a.*,b.user_name as add_user,b.rank_points,b.user_rank,c.special,c.rank_name from mcs_task_taobao a,mcs_users b,mcs_user_rank c where a.uid!='.$uinfo['user_id'].' and a.get_user=0 and a.appeal=0 and a.uid=b.user_id and b.user_rank=c.rank_id and a.process=0 order by a.addtime desc,c.rank_id desc,c.rwpmkq desc limit 32';
			$info=$db->getAll($sql);
			foreach($info as $k => $v){
				$info[$k]['attrs']=unserialize($v['attrs']);
				$info[$k]['task_other']=unserialize($v['task_other']);
			}

			echo json_encode($info);
		}
		exit;
	break;
	//猜你喜欢
	case 'aslike':
		$t_type=isset($_REQUEST['t_type'])?trim($_REQUEST['t_type']):'';//任务类型
		$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;//任务编号搜索
		$sp=isset($_REQUEST['sp'])?intval($_REQUEST['sp']):0;
		$ep=isset($_REQUEST['ep'])?intval($_REQUEST['ep']):0;
		$aslike=$db->getAll("SELECT task_type as aslike, COUNT(*) FROM mcs_task_taobao GROUP BY task_type order by count(*) desc")[0]['aslike'];
		
		$sql="select a.*,b.user_name as add_user,b.rank_points,b.user_rank,c.special,c.rank_name from mcs_task_taobao a,mcs_users b,mcs_user_rank c where a.uid=b.user_id and b.user_rank=c.rank_id and a.usid={$user_ids} and a.process=4 ";
		
		if($t_type){
			switch($t_type){
				case 'virtual'://虚拟任务
					$sql.=" and a.ddlOKDay=0";
				break;
				case 'entity'://实物任务
					$sql.=" and a.ddlOKDay>0";
				break;
			}
		}
		if($sp){$sql.=" and a.goods_price>=$sp";}
		if($ep){$sql.=" and a.goods_price<=$ep";}
		if($search){
			$sql.=" and a.id=".intval($search);
		}

		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'a.addtime';
		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
		$sql .=" order by {$order} {$desc},c.rank_id desc,c.rwpmkq desc";
		$array=$db->pagestrs($sql,5,1,'getTask');
		/*排序部分*/
		foreach ($array['record'] as $v){
			$arr[$v['goods_price']][]=$v;
		}
		krsort($arr);$array2=array();
		foreach($arr as $v){
			$array2=array_merge($array2,$v);
		}
		$array['record']=$array2;
		/*排序部分*/
		$lists=$array['record'];
		foreach($lists as $key => $val){
			$lists[$key]['addtime']=date('H:i:s',$val['addtime']);
			$lists[$key]['attrs']=unserialize($val['attrs']);
			$lists[$key]['task_other']=unserialize($val['task_other']);
			switch($val['task_type']){
				case 1:
					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
					if($val['isSign']==1){$lists[$key]['task_types']=1;}
				break;
				case 2:
					$lists[$key]['task_types']=4;
				break;
				case 3:
					$lists[$key]['task_types']=3;
				break;
				case 4:
					$lists[$key]['task_types']=2;
				break;
				case 5:
					$lists[$key]['task_types']=1;
				break;
			}
			foreach($lists[$key]['task_other']['shopAll'] as $vals)
			{
				$lists[$key]['cbhp']+=$vals['cbhp'];
			
			}
		}
		$page=$array['pagestr'];
		$view->assign('lists', $lists);
		$count = count($lists);
		$view->assign('count',$count);
		$view->assign('page', $page);
		$view->display('taobao/aslike');
	break;
 
	case 'gettask'://大厅刷新

		$t_type=isset($_REQUEST['t_type'])?trim($_REQUEST['t_type']):'';//任务类型
		//$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;
				//任务编号搜索
		if($_REQUEST['search']){
			$searchs = $_REQUEST['search'];
			//配置模糊查询条件
			$search = "'%".$searchs."%'";
			$sql.=" and a.id like ".$search;
		}
		if($_REQUEST['search'] == 0){
			$searchs = $_REQUEST['search'];
			$search = "'%".$searchs."%'";
			$sql.=" and a.id like ".$search;;
		}
		//任务编号搜索
		$sp=isset($_REQUEST['sp'])?intval($_REQUEST['sp']):0;
		$ep=isset($_REQUEST['ep'])?intval($_REQUEST['ep']):0;
		$sql="select a.*,b.user_name as add_user,b.rank_points,b.user_rank,c.special,c.rank_name from mcs_task_taobao a,mcs_users b,mcs_user_rank c where a.get_user=0 and a.appeal=0 and a.uid=b.user_id and b.user_rank=c.rank_id and a.process=0 and ((a.timing<".time()." and a.showtime=0) or (a.showtime>0 and a.showtime<".time().")) and not task_type=10 and a.id like" .$search;
		
		
		if($t_type){
			switch($t_type){
				case 'virtual'://虚拟任务
					$sql.=" and a.ddlOKDay=0";
				break;
				case 'entity'://实物任务
					$sql.=" and a.ddlOKDay>0";
				break;
			}
		}
		if($sp){$sql.=" and a.goods_price>=$sp";}
		if($ep){$sql.=" and a.goods_price<=$ep";}
		//if($search){
		//	$sql.=" and a.id like % 2396720980553705%";
		//}
		// $
		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'a.addtime';
		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
		$sql .=" order by goods_price desc";
		// $sql .=" order by {$order} {$desc},c.rank_id desc,c.rwpmkq desc";
		$array=$db->pagestrs($sql,15,15,'getTask');
		/*排序部分*/
		foreach ($array['record'] as $v){
			$arr[$v['goods_price']][]=$v;
		}
		krsort($arr);$array2=array();
		foreach($arr as $v){
			$array2=array_merge($array2,$v);
		}
		$array['record']=$array2;
		/*排序部分*/
		$lists=$array['record'];
		foreach($lists as $key => $val){
			$lists[$key]['addtime']=date('H:i:s',$val['addtime']);
			$lists[$key]['attrs']=unserialize($val['attrs']);
			$lists[$key]['task_other']=unserialize($val['task_other']);
			switch($val['task_type']){
				case 1:
					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
					if($val['isSign']==1){$lists[$key]['task_types']=1;}
				break;
				case 2:
					$lists[$key]['task_types']=4;
				break;
				case 3:
					$lists[$key]['task_types']=3;
				break;
				case 4:
					$lists[$key]['task_types']=2;
				break;
				case 5:
					$lists[$key]['task_types']=1;
				break;
			}
			foreach($lists[$key]['task_other']['shopAll'] as $vals)
			{
				$lists[$key]['cbhp']+=$vals['cbhp'];
			
			}
		}

		$page=$array['pagestr'];
		$view->assign('lists', $lists);
		$view->assign('page', $page);
		$view->display('taobao/indexTasklist');
		break;


		case 'getinTask'://已接刷新
		$process=isset($_REQUEST['process'])?intval($_REQUEST['process']):1;//类型
		$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;//任务编号搜索
		switch($process){
			case 1://可处理
				$processs="a.process>=0 and a.process<4";
				break;
			case 2://已完成
				$processs="a.process=4";
				break;
			case 3://全部
				$processs="a.process<5";
				break;
		}
		$num=isset($_REQUEST['num'])?intval($_REQUEST['num']):-1;
		if($num>-1){
			$processs="a.process=".$num;
		}
		
		$payment=isset($_REQUEST['payment'])?trim($_REQUEST['payment']):0;//点击已付款
	
		if($payment){
			
			$isme=$db->getRow("select * from mcs_task_taobao a, mcs_member_bindacc b where not a.task_type=10 and a.id=$payment and a.process=0 and a.appeal=0 and a.get_user=b.id and b.uid=$uinfo[user_id]");
			if($isme['id']){
				
				// 接手人平台确认付款
				$r=$db->getRow("select uid ,get_user from  mcs_task_taobao where not task_type=10 and id  = " .$payment );
				$name=$db->getRow("select b.user_name from mcs_member_bindacc as a,mcs_users as b where a.uid = b.user_id and a.id = " .$r['get_user']);
				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$r['uid']."' ");
				$resul=unserialize($resulta['mess_set']); 
				$resl=$resul['jt_pay'];
				if($resl['website'] == 1 ){
					$re=$db->getRow("select a.uid,b.user_name from mcs_task_taobao as a ,mcs_users as b  where not task_type=10 and a.uid = b.user_id and a.id= ".$payment);
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$re['uid']."','".$re['uid']."','你的订单{$payment}已被{$name['user_name']}付款','0','".time()."') ");
				}
				
				$this_attr=unserialize($isme['attrs']);
				$this_finish=unserialize($isme['finish']);
				if($this_attr['isViewEnd']==1){
					if($_GET['f']!=1){
						echo 'need';
						exit;
					}else{
						if(!empty($this_finish['isViewEnd'])){
							$db->Execute("update mcs_task_taobao set process=1,timing=".(time()+1800)." where not task_type=10 id=$payment");
							echo 'ok';
						}
					}
				}else if($_GET['f']!=1){
					if($isme['ddlOKDay']>0){
						$t=(time()+10800);
					}else{
						$t=(time()+1800);
					}
					$db->Execute("update mcs_task_taobao set process=1,timing=".$t." where not task_type=10 and id=$payment");
					echo 'ok';
				}
			}
			exit;
		}

		

		$nopayment=isset($_REQUEST['nopayment'])?trim($_REQUEST['nopayment']):0;//取消已付款
		
		if($nopayment){
			$db->Execute("update mcs_task_taobao set process=0,get_time=".time().",timing=".(time()+900)." where not task_type=10 and id=$nopayment");
			exit;
		}

		$praise=isset($_REQUEST['praise'])?trim($_REQUEST['praise']):0;//已好评
		if($praise){
			
			$result=$db->getRow("select uid, get_user from mcs_task_taobao where not task_type=10 and id = " .$praise);
			$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
			$resul=unserialize($resulta['mess_set']); 
			$resl=$resul['jt_comment'];
			
			if($resl['website'] == 1 ){
				$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
			
				$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$praise}已被{$name['user_name']}确认好评','0','".time()."') ");
			}
			
			$db->Execute("update mcs_task_taobao set process=3 where not task_type=10 and id=$praise");
			exit;
		}
		$pinimage=isset($_REQUEST['pinimage'])?trim($_REQUEST['pinimage']):0;//上传好评图
		if($pinimage){
			$task=$db->getRow("select * from mcs_task_taobao a,mcs_member_bindacc b where not a.task_type=10 and  a.id=$pinimage and a.get_user=b.id and b.uid=$uinfo[user_id]  and a.process=2");
			if($task['id']){
				$attrs=unserialize($task['attrs']);
				$finish=unserialize($task['finish']);
				if($attrs['pinimage']==1&&(!empty($finish['pinimage']))){
					$db->Execute("update mcs_task_taobao set process=3 where not task_type=10 and id=$pinimage");
					echo 'ok';
					exit;
				}
			}
		}
		

		$sql="select a.* from mcs_task_taobao a,mcs_member_bindacc b where not a.task_type=10 and  $processs and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'";
		
		if($search){
			$sql.=" and a.id=".intval($search);
		}
		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'get_time';
		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
		$sql .=" order by {$order} {$desc}";
		// echo $sql;die;
		$array=$db->pagestrs($sql,15,15,'getinTask','process:'.$process);
		// pre($array);die;
		$lists=$array['record'];
		// pre($array);die;
		foreach($lists as $key => $val){
			$lists[$key]['add_user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
			$lists[$key]['add_time']=date('m-d H:i',$val['get_time']);
			$lists[$key]['qq']=$db->getField('mcs_users', 'qq', "user_id='$val[uid]'");
			$lists[$key]['nickname']=mb_substr($db->getField('mcs_member_bindacc', 'nickname', "id='$val[accid]' and acc_type='tb'"),0,3,'utf-8')."***";
			$lists[$key]['buyno']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[get_user]' and acc_type='tb'");
			
			switch($val['task_type']){
				case 1:
					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
					if($val['isSign']==1){$lists[$key]['task_types']=1;}
				break;
				case 2:
					$lists[$key]['task_types']=4;
				break;
				case 3:
					$lists[$key]['task_types']=3;
				break;
				case 4:
					$lists[$key]['task_types']=2;
				break;
				case 5:
					$lists[$key]['task_types']=1;
				break;
			}

			$lists[$key]['evaluation']=$db->getCount('mcs_task_comm',"uid=$uinfo[user_id] and tid=$val[id]");

			$attrs=unserialize($val['attrs']);
			$lists[$key]['attrs']=$attrs;
			$task_other=unserialize($val['task_other']);
			$lists[$key]['task_other']=$task_other;
			$finish=unserialize($val['finish']);
			$lists[$key]['finish']=$finish;
			$lists[$key]['buyer_credit'] = unserialize($db->getField('mcs_member_bindacc', 'value', "id='$val[get_user]' and acc_type='tb'"));
			$lists[$key]['buyer_credit_img']=$lists[$key]['buyer_credit']['buyer_credit_img'];
			$lists[$key]['buyer_credit']=$lists[$key]['buyer_credit']['buyer_credit'];

			
			$type_time=$lists[$key]['timing']-time();
			$lists[$key]['time']=$type_time>0?$type_time:0;
			$type_times=$lists[$key]['ddlOKDay']-time();
			$lists[$key]['times']=$type_times>0?$type_times:0;
			foreach($lists[$key]['task_other']['shopAll'] as $vals)
			{
				$lists[$key]['cbhp']+=$vals['cbhp'];
			
			}
			$lists[$key]['remind']='';

			if($attrs['txtRemind'])$lists[$key]['remind'].="请拍商品".$attrs['txtRemind']."件,&nbsp;";
			if($attrs['cbIsHiddenName'])$lists[$key]['remind'].="请匿名购买,&nbsp;";
			if($attrs['cbIsNoneAssess'])$lists[$key]['remind'].="请只收货等待默认好评,&nbsp;";
			if($attrs['txtAreaService'])$lists[$key]['remind'].="区服请填".$attrs['txtAreaService'].",&nbsp;";
			if($attrs['txtattrs'])$lists[$key]['remind'].="账号请填".$attrs['txtattrs'].",&nbsp;";
			if($attrs['txtSpecs'])$lists[$key]['remind'].="选择规格".$attrs['txtSpecs'].",&nbsp;";
			if($attrs['ddlPoints'])$lists[$key]['remind'].="动态评分大".$attrs['ddlPoints']."分,&nbsp;";
			if($attrs['ddlDeliver']!='请选择')$lists[$key]['remind'].="物流选择".$attrs['ddlDeliver'].",&nbsp;";
			if($attrs['txtRemind'])$lists[$key]['remind'].="提醒内容[".$attrs['txtRemind']."]";
			
			$page_amount+=$lists[$key]['goods_price'];//本页金额
			
			if($lists[$key]['process']<4){$page_wamount+=$lists[$key]['goods_price'];}else{$page_wamount+=0;}//本页未完成金额
			
			$page_mai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];//本页刷点
			
			if($lists[$key]['process']<4){$page_wmai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];}else{$page_wmai+=0;}//本页未完成刷点
			
			if($lists[$key]['process']<1){$page_wfu+=$lists[$key]['goods_price'];}else{$page_wfu+=0;}//本页未完成刷点
			
		}
		$view->assign('page_amount', floatval($page_amount));
		$view->assign('page_wamount', floatval($page_wamount));
		$view->assign('page_wmai', floatval($page_wmai));
		$view->assign('page_mai', floatval($page_mai));
		$view->assign('page_wfu', floatval($page_wfu));
		$page=$array['pagestr'];
		$view->assign('lists', $lists);
	
		
		$view->assign('page', $page);
		$view->display('taobao/inTasklist');
		break;

	// case 'getinTask'://已接刷新
	// 	$process=isset($_REQUEST['process'])?intval($_REQUEST['process']):1;//类型
	// 	$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;//任务编号搜索
	// 	switch($process){
	// 		case 1://可处理
	// 			$processs="a.process>=0 and a.process<4";
	// 			break;
	// 		case 2://已完成
	// 			$processs="a.process=4";
	// 			break;
	// 		case 3://全部
	// 			$processs="a.process<5";
	// 			break;
	// 	}
	// 	$num=isset($_REQUEST['num'])?intval($_REQUEST['num']):-1;
	// 	if($num>-1){
	// 		$processs="a.process=".$num;
	// 	}
		
	// 	$payment=isset($_REQUEST['payment'])?trim($_REQUEST['payment']):0;//点击已付款
	
	// 	if($payment){
			
	// 		$isme=$db->getRow("select * from mcs_task_taobao a, mcs_member_bindacc b where a.id=$payment and a.process=0 and a.appeal=0 and a.get_user=b.id and b.uid=$uinfo[user_id]");
	// 		if($isme['id']){
				
	// 			// 接手人平台确认付款
	// 			$r=$db->getRow("select uid ,get_user from  mcs_task_taobao where id  = " .$payment );
	// 			$name=$db->getRow("select b.user_name from mcs_member_bindacc as a,mcs_users as b where a.uid = b.user_id and a.id = " .$r['get_user']);
	// 			$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$r['uid']."' ");
	// 			$resul=unserialize($resulta['mess_set']); 
	// 			$resl=$resul['jt_pay'];
	// 			if($resl['website'] == 1 ){
	// 				$re=$db->getRow("select a.uid,b.user_name from mcs_task_taobao as a ,mcs_users as b  where a.uid = b.user_id and a.id= ".$payment);
	// 				$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$re['uid']."','".$re['uid']."','你的订单{$payment}已被{$name['user_name']}付款','0','".time()."') ");
	// 			}
				
	// 			$this_attr=unserialize($isme['attrs']);
	// 			$this_finish=unserialize($isme['finish']);
	// 			if($this_attr['isViewEnd']==1){
	// 				if($_GET['f']!=1){
	// 					echo 'need';
	// 					exit;
	// 				}else{
	// 					if(!empty($this_finish['isViewEnd'])){
	// 						$db->Execute("update mcs_task_taobao set process=1,timing=".(time()+1800)." where id=$payment");
	// 						echo 'ok';
	// 					}
	// 				}
	// 			}else if($_GET['f']!=1){
	// 				if($isme['ddlOKDay']>0){
	// 					$t=(time()+10800);
	// 				}else{
	// 					$t=(time()+1800);
	// 				}
	// 				$db->Execute("update mcs_task_taobao set process=1,timing=".$t." where id=$payment");
	// 				echo 'ok';
	// 			}
	// 		}
	// 		exit;
	// 	}

		

	// 	$nopayment=isset($_REQUEST['nopayment'])?trim($_REQUEST['nopayment']):0;//取消已付款
		
	// 	if($nopayment){
	// 		$db->Execute("update mcs_task_taobao set process=0,get_time=".time().",timing=".(time()+900)." where id=$nopayment");
	// 		exit;
	// 	}

	// 	$praise=isset($_REQUEST['praise'])?trim($_REQUEST['praise']):0;//已好评
	// 	if($praise){
			
	// 		$result=$db->getRow("select uid, get_user from mcs_task_taobao where id = " .$praise);
	// 		$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
	// 		$resul=unserialize($resulta['mess_set']); 
	// 		$resl=$resul['jt_comment'];
			
	// 		if($resl['website'] == 1 ){
	// 			$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
			
	// 			$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$praise}已被{$name['user_name']}确认好评','0','".time()."') ");
	// 		}
			
	// 		$db->Execute("update mcs_task_taobao set process=3 where id=$praise");
	// 		exit;
	// 	}
	// 	$pinimage=isset($_REQUEST['pinimage'])?trim($_REQUEST['pinimage']):0;//上传好评图
	// 	if($pinimage){
	// 		$task=$db->getRow("select * from mcs_task_taobao a,mcs_member_bindacc b where a.id=$pinimage and a.get_user=b.id and b.uid=$uinfo[user_id]  and a.process=2");
	// 		if($task['id']){
	// 			$attrs=unserialize($task['attrs']);
	// 			$finish=unserialize($task['finish']);
	// 			if($attrs['pinimage']==1&&(!empty($finish['pinimage']))){
	// 				$db->Execute("update mcs_task_taobao set process=3 where id=$pinimage");
	// 				echo 'ok';
	// 				exit;
	// 			}
	// 		}
	// 	}
		

	// 	$sql="select a.* from mcs_task_taobao a,mcs_member_bindacc b where $processs and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'";
		
	// 	if($search){
	// 		$sql.=" and a.id=".intval($search);
	// 	}
	// 	$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'get_time';
	// 	$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
	// 	$sql .=" order by {$order} {$desc}";
	// 	// echo $sql;die;
	// 	$array=$db->pagestrs($sql,15,15,'getinTask','process:'.$process);
	// 	// pre($array);die;
	// 	$lists=$array['record'];
	// 	// pre($array);die;
	// 	foreach($lists as $key => $val){
	// 		$lists[$key]['add_user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
	// 		$lists[$key]['add_time']=date('m-d H:i',$val['get_time']);
	// 		$lists[$key]['qq']=$db->getField('mcs_users', 'qq', "user_id='$val[uid]'");
	// 		$lists[$key]['nickname']=mb_substr($db->getField('mcs_member_bindacc', 'nickname', "id='$val[accid]' and acc_type='tb'"),0,3,'utf-8')."***";
	// 		$lists[$key]['buyno']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[get_user]' and acc_type='tb'");
			
	// 		switch($val['task_type']){
	// 			case 1:
	// 				if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
	// 				if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
	// 				if($val['isSign']==1){$lists[$key]['task_types']=1;}
	// 			break;
	// 			case 2:
	// 				$lists[$key]['task_types']=4;
	// 			break;
	// 			case 3:
	// 				$lists[$key]['task_types']=3;
	// 			break;
	// 			case 4:
	// 				$lists[$key]['task_types']=2;
	// 			break;
	// 			case 5:
	// 				$lists[$key]['task_types']=1;
	// 			break;
	// 		}

	// 		$lists[$key]['evaluation']=$db->getCount('mcs_task_comm',"uid=$uinfo[user_id] and tid=$val[id]");

	// 		$attrs=unserialize($val['attrs']);
	// 		$lists[$key]['attrs']=$attrs;
	// 		$task_other=unserialize($val['task_other']);
	// 		$lists[$key]['task_other']=$task_other;
	// 		$finish=unserialize($val['finish']);
	// 		$lists[$key]['finish']=$finish;
	// 		$lists[$key]['buyer_credit'] = unserialize($db->getField('mcs_member_bindacc', 'value', "id='$val[get_user]' and acc_type='tb'"));
	// 		$lists[$key]['buyer_credit_img']=$lists[$key]['buyer_credit']['buyer_credit_img'];
	// 		$lists[$key]['buyer_credit']=$lists[$key]['buyer_credit']['buyer_credit'];

			
	// 		$type_time=$lists[$key]['timing']-time();
	// 		$lists[$key]['time']=$type_time>0?$type_time:0;
	// 		$type_times=$lists[$key]['ddlOKDay']-time();
	// 		$lists[$key]['times']=$type_times>0?$type_times:0;
	// 		foreach($lists[$key]['task_other']['shopAll'] as $vals)
	// 		{
	// 			$lists[$key]['cbhp']+=$vals['cbhp'];
			
	// 		}
	// 		$lists[$key]['remind']='';

	// 		if($attrs['txtRemind'])$lists[$key]['remind'].="请拍商品".$attrs['txtRemind']."件,&nbsp;";
	// 		if($attrs['cbIsHiddenName'])$lists[$key]['remind'].="请匿名购买,&nbsp;";
	// 		if($attrs['cbIsNoneAssess'])$lists[$key]['remind'].="请只收货等待默认好评,&nbsp;";
	// 		if($attrs['txtAreaService'])$lists[$key]['remind'].="区服请填".$attrs['txtAreaService'].",&nbsp;";
	// 		if($attrs['txtattrs'])$lists[$key]['remind'].="账号请填".$attrs['txtattrs'].",&nbsp;";
	// 		if($attrs['txtSpecs'])$lists[$key]['remind'].="选择规格".$attrs['txtSpecs'].",&nbsp;";
	// 		if($attrs['ddlPoints'])$lists[$key]['remind'].="动态评分大".$attrs['ddlPoints']."分,&nbsp;";
	// 		if($attrs['ddlDeliver']!='请选择')$lists[$key]['remind'].="物流选择".$attrs['ddlDeliver'].",&nbsp;";
	// 		if($attrs['txtRemind'])$lists[$key]['remind'].="提醒内容[".$attrs['txtRemind']."]";
			
	// 		$page_amount+=$lists[$key]['goods_price'];//本页金额
			
	// 		if($lists[$key]['process']<4){$page_wamount+=$lists[$key]['goods_price'];}else{$page_wamount+=0;}//本页未完成金额
			
	// 		$page_mai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];//本页刷点
			
	// 		if($lists[$key]['process']<4){$page_wmai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];}else{$page_wmai+=0;}//本页未完成刷点
			
	// 		if($lists[$key]['process']<1){$page_wfu+=$lists[$key]['goods_price'];}else{$page_wfu+=0;}//本页未完成刷点
			
	// 	}
	// 	$view->assign('page_amount', floatval($page_amount));
	// 	$view->assign('page_wamount', floatval($page_wamount));
	// 	$view->assign('page_wmai', floatval($page_wmai));
	// 	$view->assign('page_mai', floatval($page_mai));
	// 	$view->assign('page_wfu', floatval($page_wfu));
	// 	$page=$array['pagestr'];
	// 	$view->assign('lists', $lists);
	
		
	// 	$view->assign('page', $page);
	// 	$view->display('taobao/inTasklist');
	// 	break;

	case 'yzsuccess':
		if($db->Execute("update mcs_task_taobao set process=1 where id=".$_POST['taskid']." and process=0 and goods_url='".$_POST['url']."'")){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'getoutTask'://已发刷新
		$process=isset($_REQUEST['process'])?intval($_REQUEST['process']):1;//任务类型
		$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;//任务搜索
		switch($process){
			case 1://可处理
				$processs="process>=0 and process<4";
				break;
			case 2://已完成
				$processs="process=4";
				break;
			case 3://全部
				$processs="process<=5";
				break;
			case 4://暂停
				$processs="process=5";
				break;
		}
		$num=isset($_REQUEST['num'])?intval($_REQUEST['num']):-1;
		if($num>-1){
			$processs="process=".$num;
		}

		$addtime=isset($_POST['addtime'])?trim($_POST['addtime']):0;//为对方加时间
		if($addtime){
			$isme=$db->getCount("mcs_task_taobao","id=$addtime and process=0 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
			if($isme){
				$db->Execute("update mcs_task_taobao set timing=timing+600 where id=$addtime and uid=$uinfo[user_id]");
				echo 1;
			}
			exit;
		}

		$stop=isset($_REQUEST['stop'])?trim($_REQUEST['stop']):0;//暂停
		if($stop){
			$isme=$db->getCount("mcs_task_taobao","id=$stop and process=0 and appeal=0 and get_user=0 and uid=$uinfo[user_id]");
			if($isme){
				$db->Execute("update mcs_task_taobao set process=5 where id=$stop and uid=$uinfo[user_id]");
			}
			exit;
		}
		$yifa=isset($_REQUEST['yifa'])?trim($_REQUEST['yifa']):0;//已发货  2
		
		if($yifa){
			$isme=$db->getCount("mcs_task_taobao","id=$yifa and process=1 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
			if($isme){
				$attrs=$db->getField("mcs_task_taobao","ddlOKDay","id=$yifa");
				$ddlOKDays=0;
				if($attrs){
					$ddlOKDays=$attrs*86400+time();
				}
				$db->Execute("update mcs_task_taobao set process=2,ddlOKDays=$ddlOKDays where id=$yifa and uid=$uinfo[user_id]");
				
				//确认发货通知
				
				$result=$db->getRow("select uid, get_user from mcs_task_taobao where id = " .$yifa);
				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
				$resul=unserialize($resulta['mess_set']); 
				$resl=$resul['ft_ship'];
				
				if($resl['website'] == 1 ){
					$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
				
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$yifa}已发货','0','".time()."') ");
				}
			}
			exit;
		}
		
		$pin=isset($_REQUEST['pin'])?trim($_REQUEST['pin']):0;//评图
		if($pin){
			$isme=$db->getCount("mcs_task_taobao","id=$pin and process=3 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
			if($isme){
				$opt=isset($_REQUEST['opt'])?trim($_REQUEST['opt']):'';
				$attrs=$db->getField('mcs_task_taobao',"attrs","id=$pin");
				$attrs=unserialize($attrs);
				$finish=$db->getField('mcs_task_taobao',"finish","id=$pin");
				$finish=unserialize($finish);
				if(strlen($finish['pinimage'])>2){
					$img['url']=$finish['pinimage'];
					if($opt=='h'){echo json_encode($img);exit;}
					if($opt=='y'){
						$attrs['haoping']=1;
						$attrs=serialize($attrs);
						$db->Execute("update mcs_task_taobao set attrs='$attrs' where id=$pin and uid=$uinfo[user_id]");
						echo 'ok';exit;
					}
					if($opt=='n'){
						@unlink($attrs['pinimage']);
						$attrs['pinimage']=1;
						unset($attrs['haoping']);
						$attrs=serialize($attrs);
						$db->Execute("update mcs_task_taobao set attrs='$attrs',process=2 where id=$pin and uid=$uinfo[user_id]");
						exit;
					}
				}
				
			}
			exit;
		}

		$queren=isset($_REQUEST['queren'])?trim($_REQUEST['queren']):0;//确认收货完成任务  4
		if($queren){
			$userinfo=$db->getRow("select * from mcs_users where user_id='".$uinfo['user_id']."'");
			$task=$db->getRow('select * from mcs_task_taobao where id='.$queren.' and process=3 and appeal=0 and get_user>0 and uid='.$uinfo['user_id']);
			if($task['id']){
				$attrs=unserialize($task['attrs']);
				$finish=unserialize($task['finish']);
				
				//确认收货完成任务通知
				
				$result=$db->getRow("select uid, get_user from mcs_task_taobao where id = " .$queren);
				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
				$resul=unserialize($resulta['mess_set']); 
				$resl=$resul['jt_shouhuo'];
				
				if($resl['website'] == 1 ){
					$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
				
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$praise}已被{$name['user_name']}确认好评','0','".time()."') ");
				}
				
				$db->Execute('update mcs_task_taobao set process=4,get_time='.time().' where id='.$queren.' and uid='.$uinfo['user_id']);

				$tasks=$db->getRow('select * from mcs_task_taobao where id='.$queren);
				$attrs=unserialize($tasks['attrs']);
				$goods_price=floatval($tasks['goods_price']);

				$fuser=$db->getRow('select a.nickname,a.uid,b.user_rank,b.user_money,b.rank_points,b.pay_money from mcs_member_bindacc a,mcs_users b where a.id='.$tasks['get_user'].' and a.acc_type="tb" and a.uid=b.user_id');

				$user_uid=$fuser['uid'];
				$integral_intask=$_CFG['integral_intask']/$point_multiple*$_CFG['user_rank'][$fuser['user_rank']]['param']['ksjf'];

				//$db->Execute('update mcs_users set rank_points=rank_points+'.$integral_intask.',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分

				$db->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.$goods_price.',"'.$fuser['nickname'].'完成任务TB'.$queren.'增加'.$goods_price.'元",'.$queren.',"存款日志",'.($fuser['user_money']+$goods_price).',"payde")');//存款日志
				
				/*
				$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_outtask'].',pay_points=pay_points+'.$_CFG['integral_outtask'].' where user_id='.$uinfo['user_id']);//自己增加存款积分

				$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.$_CFG['integral_outtask'].',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']).',"logcredit")');//积分日志
				*/
				
				//等级卡片定制
				$res=$db->getRow("select * from mcs_card where addtime < '".time()."' and endtime > '".time()."' and type ='1' or type = '7' and  uid = " .$uinfo['user_id']  );
				if($userinfo['extension']){
					if($userinfo['extension_status']!=1){
						$extension_intask_money=$db->getRow("select value from mcs_configs where pid=8 and code='extension_intask_money'")['value'];
						// $extension_intask_point=$db->getRow("select value from mcs_configs where pid=8 and code='extension_intask_point'")['value'];
						$db->Execute("update mcs_users set user_money=user_money+".$extension_intask_money." where user_id='".$userinfo['extension']."'");
						// file_put_contents('log3.txt',"update mcs_users set user_money=user_money+".$extension_intask_money." ,rank_points=rank_points+".$extension_intask_point." where user_id='".$userinfo['extension']."'");
						// file_put_contents('log2.txt',"update mcs_users set extension_status=1 where user_id='".$uinfo['user_id']."'");
					}
				}
				if($res){
					
					$db->Execute('update mcs_users set rank_points=rank_points+'.($integral_intask * 2 ).',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分
					
					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.($integral_intask * 2 ).',"接手的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($fuser['rank_points']+($integral_intask * 2 )).',"logcredit")');//接手积分日志
					
					$db->Execute('update mcs_users set rank_points='.($uinfo['rank_points']+($_CFG['integral_outtask'] )).',pay_points=pay_points+'.($_CFG['integral_outtask']).' where user_id='.$uinfo['user_id']);//自己增加积分和经验
					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.($_CFG['integral_outtask']).',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']).',"logcredit")');//发布积分日志
				}else{
				
					$db->Execute('update mcs_users set rank_points=rank_points+'.$integral_intask.',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分
				
					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.$integral_intask.',"接手的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($fuser['rank_points']+$integral_intask).',"logcredit")');//积分日志
					
				
					$db->Execute('update mcs_users set rank_points=rank_points+'.($_CFG['integral_outtask']/2).',pay_points=pay_points+'.($_CFG['integral_outtask']/2).' where user_id='.$uinfo['user_id']);//自己增加积分和经验
					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.($_CFG['integral_outtask']/2).',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']/2).',"logcredit")');//积分日志
				}
				
				



				if($tasks['cbxIsSB']){//商保加点
					$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
				}
				if($tasks['txtMinMPrice']){//基本刷点
					$mai+=$tasks['txtMinMPrice'];
				}
				if($tasks['pointExt']){//悬赏刷点
					$mai+=$tasks['pointExt'];
				}
				if($attrs['isZgh']){//审核账户信息
					$mai+=$task_set['isZgh'];
				}
				if($attrs['cbxIsAudit']){//审核对象
					$mai+=$task_set['cbxIsAudit'];
				}
				if($attrs['cbxIsWW']){//需要旺旺聊天
					$mai+=$task_set['cbxIsWW'];
				}
				if($attrs['cbxIsLHS']){//旺旺确认收货
					$mai+=$task_set['cbxIsLHS'];
				}
				if($attrs['cbxIsMsg']){//规定好评
					$mai+=$task_set['cbxIsMsg'];
				}
				if($attrs['cbxIsAddress']){//规定收货地址
					$mai+=$task_set['cbxIsAddress'];
				}
				if($attrs['shopcoller']){//购物收藏
					$mai+=$task_set['shopcoller'];
				}
				if($attrs['pinimage']){//好评截图
					$mai+=$task_set['pinimage'];
				}
				if($attrs['isShare']){//购物分享
					$mai+=$task_set['isShare'];
				}
				if($attrs['txtTaoG']){//淘金币
					$mai+=($attrs['txtTaoG']/10)*$task_set['txtTaoG'];
				}
				if($attrs['cbxIsSetTime1']||$attrs['cbxIsSetTime2']){//延时
					$mai+=$task_set['cbxIsSetTime'];
				}
				if($attrs['cbxIsFMinGrade']){//过滤
					$mai+=$task_set['cbxIsFMinGrade'];
				}
				if($attrs['cbxIsFMaxBBC']){//过滤
					$mai+=$task_set['cbxIsFMinGrade'];
				}
				if($attrs['cbxIsFMaxABC']){//过滤
					$mai+=$task_set['cbxIsFMinGrade'];
				}
				if($attrs['cbxIsFMaxCredit']){//过滤
					$mai+=$task_set['cbxIsFMinGrade'];
				}
				if($attrs['cbxIsFMaxBTSCount']){//过滤
					$mai+=$task_set['cbxIsFMinGrade'];
				}
				if($attrs['isViewEnd']){//完整浏览
					$mai+=$task_set['isViewEnd'];
				}
				$exp_bl = $_CFG['user_rank'][$fuser['user_rank']]['param']['rwxhbl']/100;//任务消耗比例
				$exp_money=$exp_bl*$mai;//消耗
				$pay_point=$mai-$exp_money;//实际收

				

				$db->Execute('update mcs_users set pay_money=pay_money+'.$pay_point.' where user_id='.$user_uid);//增加刷点

				$db->Execute('insert into mcs_member_logs(uid,createtime,info,taskid,pay_point,logtype,num,exp_money,type) value('.$user_uid.','.time().',"'.$fuser['nickname'].'完成任务TB'.$queren.'增加刷点'.$mai.',消耗刷点'.$exp_money.',实加刷点'.$pay_point.'",'.$queren.','.$pay_point.',"刷点日志",'.($fuser['pay_money']+$pay_point).','.$exp_money.',"logpoint")');//买号日志

				extension_log($user_uid,'task',array('type'=>'in','name'=>'TB','id'=>$queren));
				extension_log($uinfo['user_id'],'task',array('type'=>'out','name'=>'TB','id'=>$queren));
			}
			exit;
		}

		$huifu=isset($_REQUEST['huifu'])?trim($_REQUEST['huifu']):0;//恢复
		if($huifu){
			$db->Execute("update mcs_task_taobao set process=0 where id=$huifu");
			exit;
		}

		$sql="select * from mcs_task_taobao where $processs and uid=$uinfo[user_id]";

		if($search){
			$sql.=" and id=".intval($search);
		}

		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'get_time';
		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
		$sql .=" order by {$order} {$desc}";
		$array=$db->pagestrs($sql,15,15,'getoutTask','process:'.$process);
		$lists=$array['record'];
		foreach($lists as $key => $val){
			$lists[$key]['attrs']=unserialize($val['attrs']);
			$lists[$key]['appex']=$db->getField("mcs_task_express",'id',"task_id=$val[id]");
			$lists[$key]['add_user']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[accid]'");
			switch($val['task_type']){
				case 1:
					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
					if($val['isSign']==1){$lists[$key]['task_types']=1;}
				break;
				case 2:
					$lists[$key]['task_types']=4;
				break;
				case 3:
					$lists[$key]['task_types']=3;
				break;
				case 4:
					$lists[$key]['task_types']=2;
				break;
				case 5:
					$lists[$key]['task_types']=1;
				break;
			}
			$lists[$key]['express']=$db->getCount("mcs_task_express","task_id=".$val['id']);
			$lists[$key]['add_time']=date('m-d H:i',$val['addtime']);
			$lists[$key]['get_time']=date('Y-m-d H:i:s',$val['get_time']);
			$user_uid=$db->getField('mcs_member_bindacc', 'uid', "id=".$val['get_user']." and acc_type='tb'");
			$lists[$key]['qq']=$db->getField('mcs_users', 'qq', "user_id='$user_uid'");
			
			$lists[$key]['nickname']=$db->getField('mcs_users a,mcs_member_bindacc b', 'user_name', "a.user_id=b.uid and b.id='$val[get_user]' and acc_type='tb'");
			$lists[$key]['buyno']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[get_user]' and acc_type='tb'");

			$lists[$key]['evaluation']=$db->getCount('mcs_task_comm',"uid=$uinfo[user_id] and tid=$val[id]");
			$lists[$key]['attrs']=unserialize($val['attrs']);
			$lists[$key]['task_other']=unserialize($val['task_other']);
			$lists[$key]['buyer_credit'] = unserialize($db->getField('mcs_member_bindacc', 'value', "uid='$val[get_user]' and acc_type='tb'"));
			$lists[$key]['buyer_credit_img']=$lists[$key]['buyer_credit']['buyer_credit_img'];
			$lists[$key]['buyer_credit']=$lists[$key]['buyer_credit']['buyer_credit'];
			$type_time=$lists[$key]['timing']-time();
			$lists[$key]['time']=$type_time>0?$type_time:0;
			$type_times=$lists[$key]['ddlOKDay']-time();
			$lists[$key]['times']=$type_times>0?$type_times:0;
			$finish=unserialize($val['finish']);
			$lists[$key]['finish']=$finish;
			foreach($lists[$key]['task_other']['shopAll'] as $vals)
			{
				$lists[$key]['cbhp']+=$vals['cbhp'];
			
			}
			$page_amount+=$lists[$key]['goods_price'];//本页金额
			if($lists[$key]['process']<4){$page_wamount+=$lists[$key]['goods_price'];}else{$page_wamount+=0;}//本页未完成金额
			$page_mai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];//本页刷点
			if($lists[$key]['process']<4){$page_wmai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];}else{$page_wmai+=0;}//本页未完成刷点
			if($lists[$key]['process']<1){$page_wfu+=$lists[$key]['goods_price'];}else{$page_wfu+=0;}//本页未完成刷点
		}
		
		foreach($lists as $k => $V){
			if($lists[$k]['usid']){
				$infoval = $db->getRow("select * from mcs_users where user_id=".$lists[$k]['usid']);
				$lists[$k]['addsss'] = $infoval['send_address'];
				$lists[$k]['username'] = $infoval['user_name'];
			}else{
				$lists[$k]['addsss'] = '';
				$lists[$k]['username'] = '';
			}
}
// print_r($lists);die;
		$view->assign('lists', $lists);
		$view->assign('page_amount', floatval($page_amount));
		$view->assign('page_wamount', floatval($page_wamount));
		$view->assign('page_wmai', floatval($page_wmai));
		$view->assign('page_mai', floatval($page_mai));
		$view->assign('page_wfu', floatval($page_wfu));
		$view->display('taobao/outTasklist');
		break;


// 	case 'getoutTask'://已发刷新
// 		$process=isset($_REQUEST['process'])?intval($_REQUEST['process']):1;//任务类型
// 		$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;//任务搜索
// 		switch($process){
// 			case 1://可处理
// 				$processs="process>=0 and process<4";
// 				break;
// 			case 2://已完成
// 				$processs="process=4";
// 				break;
// 			case 3://全部
// 				$processs="process<=5";
// 				break;
// 			case 4://暂停
// 				$processs="process=5";
// 				break;
// 		}
// 		$num=isset($_REQUEST['num'])?intval($_REQUEST['num']):-1;
// 		if($num>-1){
// 			$processs="process=".$num;
// 		}

// 		$addtime=isset($_POST['addtime'])?trim($_POST['addtime']):0;//为对方加时间
// 		if($addtime){
// 			$isme=$db->getCount("mcs_task_taobao","id=$addtime and process=0 and not task_type=10 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
// 			if($isme){
// 				$db->Execute("update mcs_task_taobao set timing=timing+600 where not task_type=10 and id=$addtime and uid=$uinfo[user_id]");
// 				echo 1;
// 			}
// 			exit;
// 		}

// 		$stop=isset($_REQUEST['stop'])?trim($_REQUEST['stop']):0;//暂停
// 		if($stop){
// 			$isme=$db->getCount("mcs_task_taobao","id=$stop and process=0 and not task_type=10 and appeal=0 and get_user=0 and uid=$uinfo[user_id]");
// 			if($isme){
// 				$db->Execute("update mcs_task_taobao set process=5 where not task_type=10 and id=$stop and uid=$uinfo[user_id]");
// 			}
// 			exit;
// 		}
// 		$yifa=isset($_REQUEST['yifa'])?trim($_REQUEST['yifa']):0;//已发货  2
		
// 		if($yifa){
// 			$isme=$db->getCount("mcs_task_taobao","id=$yifa and process=1 and not task_type=10 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
// 			if($isme){
// 				$attrs=$db->getField("mcs_task_taobao","ddlOKDay","id=$yifa and not task_type=10");
// 				$ddlOKDays=0;
// 				if($attrs){
// 					$ddlOKDays=$attrs*86400+time();
// 				}
// 				$db->Execute("update mcs_task_taobao set process=2,ddlOKDays=$ddlOKDays where not task_type=10 and id=$yifa and uid=$uinfo[user_id]");
				
// 				//确认发货通知
				
// 				$result=$db->getRow("select uid, get_user from mcs_task_taobao where not task_type=10 and id = " .$yifa);
// 				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
// 				$resul=unserialize($resulta['mess_set']); 
// 				$resl=$resul['ft_ship'];
				
// 				if($resl['website'] == 1 ){
// 					$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
				
// 					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$yifa}已发货','0','".time()."') ");
// 				}
// 			}
// 			exit;
// 		}
		
// 		$pin=isset($_REQUEST['pin'])?trim($_REQUEST['pin']):0;//评图
// 		if($pin){
// 			$isme=$db->getCount("mcs_task_taobao","id=$pin and not task_type=10 and process=3 and appeal=0 and get_user>0 and uid=$uinfo[user_id]");
// 			if($isme){
// 				$opt=isset($_REQUEST['opt'])?trim($_REQUEST['opt']):'';
// 				$attrs=$db->getField('mcs_task_taobao',"attrs","id=$pin and not task_type=10");
// 				$attrs=unserialize($attrs);
// 				$finish=$db->getField('mcs_task_taobao',"finish","id=$pin and not task_type=10");
// 				$finish=unserialize($finish);
// 				if(strlen($finish['pinimage'])>2){
// 					$img['url']=$finish['pinimage'];
// 					if($opt=='h'){echo json_encode($img);exit;}
// 					if($opt=='y'){
// 						$attrs['haoping']=1;
// 						$attrs=serialize($attrs);
// 						$db->Execute("update mcs_task_taobao set attrs='$attrs' where id=$pin and not task_type=10 and uid=$uinfo[user_id]");
// 						echo 'ok';exit;
// 					}
// 					if($opt=='n'){
// 						@unlink($attrs['pinimage']);
// 						$attrs['pinimage']=1;
// 						unset($attrs['haoping']);
// 						$attrs=serialize($attrs);
// 						$db->Execute("update mcs_task_taobao set attrs='$attrs',process=2 where not task_type=10 and id=$pin and uid=$uinfo[user_id]");
// 						exit;
// 					}
// 				}
				
// 			}
// 			exit;
// 		}

// 		$queren=isset($_REQUEST['queren'])?trim($_REQUEST['queren']):0;//确认收货完成任务  4
// 		if($queren){
// 			$task=$db->getRow('select * from mcs_task_taobao where not task_type=10 and id='.$queren.' and process=3 and appeal=0 and get_user>0 and uid='.$uinfo['user_id']);
// 			if($task['id']){
// 				$attrs=unserialize($task['attrs']);
// 				$finish=unserialize($task['finish']);
				
// 				//确认收货完成任务通知
				
// 				$result=$db->getRow("select uid, get_user from mcs_task_taobao where not task_type=10 and id = " .$queren);
// 				$resulta=$db->getRow("select mess_set from mcs_users where user_id = '".$result['uid']."' ");
// 				$resul=unserialize($resulta['mess_set']); 
// 				$resl=$resul['jt_shouhuo'];
				
// 				if($resl['website'] == 1 ){
// 					$name=$db->getRow("select b.user_name from mcs_member_bindacc as a ,mcs_users as b where a.uid =b.user_id and a.id = " .$result['get_user']);
				
// 					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$result['uid']."','".$result['uid']."','你的订单{$praise}已被{$name['user_name']}确认好评','0','".time()."') ");
// 				}
				
// 				$db->Execute('update mcs_task_taobao set process=4,get_time='.time().' where not task_type=10 and id='.$queren.' and uid='.$uinfo['user_id']);

// 				$tasks=$db->getRow('select * from mcs_task_taobao where not task_type=10 and id='.$queren);
// 				$attrs=unserialize($tasks['attrs']);
// 				$goods_price=floatval($tasks['goods_price']);

// 				$fuser=$db->getRow('select a.nickname,a.uid,b.user_rank,b.user_money,b.rank_points,b.pay_money from mcs_member_bindacc a,mcs_users b where a.id='.$tasks['get_user'].' and a.acc_type="tb" and a.uid=b.user_id');

// 				$user_uid=$fuser['uid'];
// 				$integral_intask=$_CFG['integral_intask']/$point_multiple*$_CFG['user_rank'][$fuser['user_rank']]['param']['ksjf'];

// 				//$db->Execute('update mcs_users set rank_points=rank_points+'.$integral_intask.',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分

// 				$db->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.$goods_price.',"'.$fuser['nickname'].'完成任务TB'.$queren.'增加'.$goods_price.'元",'.$queren.',"存款日志",'.($fuser['user_money']+$goods_price).',"payde")');//存款日志
				
// 				/*
// 				$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_outtask'].',pay_points=pay_points+'.$_CFG['integral_outtask'].' where user_id='.$uinfo['user_id']);//自己增加存款积分

// 				$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.$_CFG['integral_outtask'].',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']).',"logcredit")');//积分日志
// 				*/
				
// 				//等级卡片定制
// 				$res=$db->getRow("select * from mcs_card where addtime < '".time()."' and endtime > '".time()."' and type ='1' or type = '7' and  uid = " .$uinfo['user_id']  );
// 				if(res){
					
// 					$db->Execute('update mcs_users set rank_points=rank_points+'.($integral_intask * 2 ).',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分
					
// 					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.($integral_intask * 2 ).',"接手的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($fuser['rank_points']+($integral_intask * 2 )).',"logcredit")');//接手积分日志
					
// 					$db->Execute('update mcs_users set rank_points='.($uinfo['rank_points']+($_CFG['integral_outtask'] )).',pay_points=pay_points+'.($_CFG['integral_outtask']).' where user_id='.$uinfo['user_id']);//自己增加积分和经验
// 					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.($_CFG['integral_outtask']).',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']).',"logcredit")');//发布积分日志
// 				}else{
				
// 					$db->Execute('update mcs_users set rank_points=rank_points+'.$integral_intask.',pay_points=pay_points+'.$integral_intask.',user_money=user_money+'.$goods_price.' where user_id='.$user_uid);//买号增加存款积分
				
// 					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$user_uid.','.time().','.$integral_intask.',"接手的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($fuser['rank_points']+$integral_intask).',"logcredit")');//积分日志
					
				
// 					$db->Execute('update mcs_users set rank_points=rank_points+'.($_CFG['integral_outtask']/2).',pay_points=pay_points+'.($_CFG['integral_outtask']/2).' where user_id='.$uinfo['user_id']);//自己增加积分和经验
// 					$db->Execute('insert into mcs_member_logs(uid,createtime,integral,info,taskid,logtype,num,type) value('.$uinfo['user_id'].','.time().','.($_CFG['integral_outtask']/2).',"发布的任务TB'.$queren.'[完成]",'.$queren.',"积分日志",'.($uinfo['rank_points']+$_CFG['integral_outtask']/2).',"logcredit")');//积分日志
// 				}
				
				



// 				if($tasks['cbxIsSB']){//商保加点
// 					$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
// 				}
// 				if($tasks['txtMinMPrice']){//基本刷点
// 					$mai+=$tasks['txtMinMPrice'];
// 				}
// 				if($tasks['pointExt']){//悬赏刷点
// 					$mai+=$tasks['pointExt'];
// 				}
// 				if($attrs['isZgh']){//审核账户信息
// 					$mai+=$task_set['isZgh'];
// 				}
// 				if($attrs['cbxIsAudit']){//审核对象
// 					$mai+=$task_set['cbxIsAudit'];
// 				}
// 				if($attrs['cbxIsWW']){//需要旺旺聊天
// 					$mai+=$task_set['cbxIsWW'];
// 				}
// 				if($attrs['cbxIsLHS']){//旺旺确认收货
// 					$mai+=$task_set['cbxIsLHS'];
// 				}
// 				if($attrs['cbxIsMsg']){//规定好评
// 					$mai+=$task_set['cbxIsMsg'];
// 				}
// 				if($attrs['cbxIsAddress']){//规定收货地址
// 					$mai+=$task_set['cbxIsAddress'];
// 				}
// 				if($attrs['shopcoller']){//购物收藏
// 					$mai+=$task_set['shopcoller'];
// 				}
// 				if($attrs['pinimage']){//好评截图
// 					$mai+=$task_set['pinimage'];
// 				}
// 				if($attrs['isShare']){//购物分享
// 					$mai+=$task_set['isShare'];
// 				}
// 				if($attrs['txtTaoG']){//淘金币
// 					$mai+=($attrs['txtTaoG']/10)*$task_set['txtTaoG'];
// 				}
// 				if($attrs['cbxIsSetTime1']||$attrs['cbxIsSetTime2']){//延时
// 					$mai+=$task_set['cbxIsSetTime'];
// 				}
// 				if($attrs['cbxIsFMinGrade']){//过滤
// 					$mai+=$task_set['cbxIsFMinGrade'];
// 				}
// 				if($attrs['cbxIsFMaxBBC']){//过滤
// 					$mai+=$task_set['cbxIsFMinGrade'];
// 				}
// 				if($attrs['cbxIsFMaxABC']){//过滤
// 					$mai+=$task_set['cbxIsFMinGrade'];
// 				}
// 				if($attrs['cbxIsFMaxCredit']){//过滤
// 					$mai+=$task_set['cbxIsFMinGrade'];
// 				}
// 				if($attrs['cbxIsFMaxBTSCount']){//过滤
// 					$mai+=$task_set['cbxIsFMinGrade'];
// 				}
// 				if($attrs['isViewEnd']){//完整浏览
// 					$mai+=$task_set['isViewEnd'];
// 				}
// 				$exp_bl = $_CFG['user_rank'][$fuser['user_rank']]['param']['rwxhbl']/100;//任务消耗比例
// 				$exp_money=$exp_bl*$mai;//消耗
// 				$pay_point=$mai-$exp_money;//实际收

				

// 				$db->Execute('update mcs_users set pay_money=pay_money+'.$pay_point.' where user_id='.$user_uid);//增加刷点

// 				$db->Execute('insert into mcs_member_logs(uid,createtime,info,taskid,pay_point,logtype,num,exp_money,type) value('.$user_uid.','.time().',"'.$fuser['nickname'].'完成任务TB'.$queren.'增加刷点'.$mai.',消耗刷点'.$exp_money.',实加刷点'.$pay_point.'",'.$queren.','.$pay_point.',"刷点日志",'.($fuser['pay_money']+$pay_point).','.$exp_money.',"logpoint")');//买号日志

// 				extension_log($user_uid,'task',array('type'=>'in','name'=>'TB','id'=>$queren));
// 				extension_log($uinfo['user_id'],'task',array('type'=>'out','name'=>'TB','id'=>$queren));
// 			}
// 			exit;
// 		}

// 		$huifu=isset($_REQUEST['huifu'])?trim($_REQUEST['huifu']):0;//恢复
// 		if($huifu){
// 			$db->Execute("update mcs_task_taobao set process=0 where not 0000000000task_type=10 and id=$huifu");
// 			exit;
// 		}

// 		$sql="select * from mcs_task_taobao where not 0000000000task_type=10 and $processs and uid=$uinfo[user_id]";

// 		if($search){
// 			$sql.=" and id=".intval($search);
// 		}

// 		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'get_time';
// 		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
// 		$sql .=" order by {$order} {$desc}";
// 		$array=$db->pagestrs($sql,15,15,'getoutTask','process:'.$process);
// 		$lists=$array['record'];
// 		foreach($lists as $key => $val){
// 			$lists[$key]['attrs']=unserialize($val['attrs']);
// 			$lists[$key]['appex']=$db->getField("mcs_task_express",'id',"task_id=$val[id]");
// 			$lists[$key]['add_user']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[accid]'");
// 			switch($val['task_type']){
// 				case 1:
// 					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
// 					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
// 					if($val['isSign']==1){$lists[$key]['task_types']=1;}
// 				break;
// 				case 2:
// 					$lists[$key]['task_types']=4;
// 				break;
// 				case 3:
// 					$lists[$key]['task_types']=3;
// 				break;
// 				case 4:
// 					$lists[$key]['task_types']=2;
// 				break;
// 				case 5:
// 					$lists[$key]['task_types']=1;
// 				break;
// 			}
// 			$lists[$key]['express']=$db->getCount("mcs_task_express","task_id=".$val['id']);
// 			$lists[$key]['add_time']=date('m-d H:i',$val['addtime']);
// 			$lists[$key]['get_time']=date('Y-m-d H:i:s',$val['get_time']);
// 			$user_uid=$db->getField('mcs_member_bindacc', 'uid', "id=".$val['get_user']." and acc_type='tb'");
// 			$lists[$key]['qq']=$db->getField('mcs_users', 'qq', "user_id='$user_uid'");
			
// 			$lists[$key]['nickname']=$db->getField('mcs_users a,mcs_member_bindacc b', 'user_name', "a.user_id=b.uid and b.id='$val[get_user]' and acc_type='tb'");
// 			$lists[$key]['buyno']=$db->getField('mcs_member_bindacc', 'nickname', "id='$val[get_user]' and acc_type='tb'");

// 			$lists[$key]['evaluation']=$db->getCount('mcs_task_comm',"uid=$uinfo[user_id] and tid=$val[id]");
// 			$lists[$key]['attrs']=unserialize($val['attrs']);
// 			$lists[$key]['task_other']=unserialize($val['task_other']);
// 			$lists[$key]['buyer_credit'] = unserialize($db->getField('mcs_member_bindacc', 'value', "uid='$val[get_user]' and acc_type='tb'"));
// 			$lists[$key]['buyer_credit_img']=$lists[$key]['buyer_credit']['buyer_credit_img'];
// 			$lists[$key]['buyer_credit']=$lists[$key]['buyer_credit']['buyer_credit'];
// 			$type_time=$lists[$key]['timing']-time();
// 			$lists[$key]['time']=$type_time>0?$type_time:0;
// 			$type_times=$lists[$key]['ddlOKDay']-time();
// 			$lists[$key]['times']=$type_times>0?$type_times:0;
// 			$finish=unserialize($val['finish']);
// 			$lists[$key]['finish']=$finish;
// 			foreach($lists[$key]['task_other']['shopAll'] as $vals)
// 			{
// 				$lists[$key]['cbhp']+=$vals['cbhp'];
			
// 			}
// 			$page_amount+=$lists[$key]['goods_price'];//本页金额
// 			if($lists[$key]['process']<4){$page_wamount+=$lists[$key]['goods_price'];}else{$page_wamount+=0;}//本页未完成金额
// 			$page_mai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];//本页刷点
// 			if($lists[$key]['process']<4){$page_wmai+=$lists[$key]['txtMinMPrice']+$lists[$key]['pointExt'];}else{$page_wmai+=0;}//本页未完成刷点
// 			if($lists[$key]['process']<1){$page_wfu+=$lists[$key]['goods_price'];}else{$page_wfu+=0;}//本页未完成刷点
// 		}
		
// 		foreach($lists as $k => $V){
// 			if($lists[$k]['usid']){
// 				$infoval = $db->getRow("select * from mcs_users where user_id=".$lists[$k]['usid']);
// 				$lists[$k]['addsss'] = $infoval['send_address'];
// 				$lists[$k]['username'] = $infoval['user_name'];
// 			}else{
// 				$lists[$k]['addsss'] = '';
// 				$lists[$k]['username'] = '';
// 			}
// }
// 		$view->assign('lists', $lists);
// 		$view->assign('page_amount', floatval($page_amount));
// 		$view->assign('page_wamount', floatval($page_wamount));
// 		$view->assign('page_wmai', floatval($page_wmai));
// 		$view->assign('page_mai', floatval($page_mai));
// 		$view->assign('page_wfu', floatval($page_wfu));
// 		$view->display('taobao/weixinoutTasklist');
// 		break;
	
	case 'didan'://申请底单
		if($uinfo['user_money']<2){echo "您的余额不足！";exit;}
		$task_id=intval($_REQUEST['task_id']);
		if($task_id){
			$is_end=$db->getField("mcs_task_taobao","id","uid=$uinfo[user_id] and process=4 and appeal=0 and id=$task_id");
			if($is_end){
				if($db->getField("mcs_task_express","task_id","task_id=$task_id")){echo 3;}
				$task_id=trim($_REQUEST['task_id']);
				$address=trim($_REQUEST['address']);
				$add_uer=trim($_REQUEST['add_uer']);
				$add_phone=trim($_REQUEST['add_phone']);
				$add_time=trim($_REQUEST['add_time']);
				$add_pay=trim($_REQUEST['add_pay']);
				$money=trim($_REQUEST['money']);
				$time=time();
				$db->Execute("insert into mcs_task_appex(uid,addtime,task_id,address,add_uer,add_phone,add_time,add_pay,money) values($uinfo[user_id],$time,$task_id,'$address','$add_uer','$add_phone','$add_time','$add_pay','$money')");
				
				$db->Execute("update from mcs_users set user_money=user_money-2 where user_id=$uinfo[user_id]");//申请底单扣款
				
				$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,taskid,logtype,num,type) value($uinfo[user_id],'".time()."','-2','完成实物任务TB".$task_id."申请底单扣除2元',".$task_id.",'存款日志',".$uinfo['user_money'].",'payde')");//买号日志

				echo "底单申请成功！";exit;
			}
		}
		echo "申请失败";
		exit;
	break;

	case 'gmdh'://购买单号
		$task_id=trim($_REQUEST['task_id']);
		
		if($task_id){
			$is_end=$db->getField("mcs_task_taobao","id","uid=$uinfo[user_id] and process=1 and appeal=0 and id=$task_id");
			$db->Execute('update mcs_task_taobao set process = 2 where id ='.$is_end);
			if($is_end){
				if($db->getField("mcs_task_express","task_id","task_id=$task_id")){echo 3;}
				$wl=trim($_REQUEST['wl']);
				$addname=trim($_REQUEST['addname']);
				$send_add=trim($_REQUEST['send_add']);
				$to_add=trim($_REQUEST['to_add']);
				$sendname=trim($_REQUEST['sendname']);
				$phone=trim($_REQUEST['phone']);
				$time=time();
				$db->Execute("insert into mcs_task_express(addtime,task_id,wl,addname,send_add,to_add,sendname,phone,type) values($time,$task_id,'$wl','$addname','$send_add','$to_add','$sendname',$phone,2)");

				$db->Execute("update mcs_users set user_money=user_money-2 where user_id=$uinfo[user_id]");//申请底单扣款
				
				$db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,taskid,logtype,num,type) value($uinfo[user_id],'".time()."','-2','实物任务TB".$task_id."申请底单扣除2元',".$task_id.",'存款日志',".$uinfo['user_money'].",'payde')");//买号日志

				echo "底单申请成功！";exit;
			}
		}
		echo "申请失败";
		exit;
	break;

	case 'hb'://货比三家
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$id=trim($_POST['id']);
			if($id){
				$info=$db->getRow("select a.* from mcs_task_taobao a,mcs_member_bindacc b where a.id=$id and a.process=0 and a.get_user=b.id and b.acc_type='tb' and b.uid=$uinfo[user_id] and b.buyno=0");
				if($info){
					$info['attrs']=unserialize($info['attrs']);
					$info['task_other']=unserialize($info['task_other']);
					$info['nickname']=mb_substr($db->getField('mcs_member_bindacc', 'nickname', "id='$info[accid]' and acc_type='tb'"),0,3,'utf-8')."***";
					if($info['attrs']['contrast']==1){$view->display('taobao/hb/one');}
					if($info['attrs']['contrast']==2){$view->display('taobao/hb/two');}
					if($info['attrs']['contrast']==3){$view->display('taobao/hb/three');}
					exit;
				}
			}
		}
		exit;
	break;
	
	case 'hbfile'://货比三家上传
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$id=trim($_POST['id']);
			$contrast=intval($_POST['contrast']);
			if($id){
				if($contrast){
					$info=$db->getRow("select a.* from mcs_task_taobao a,mcs_member_bindacc b where a.id=$id and a.process=0 and a.get_user=b.id and b.acc_type='tb' and b.uid=$uinfo[user_id] and b.buyno=0");
					if($info){
						$info['attrs']=unserialize($info['attrs']);
						$info['task_other']=unserialize($info['task_other']);
						$info['finish']=unserialize($info['finish']);
						if(isset($_FILES['file'])&&$_FILES['error']==0&&$_FILES['file']['size']>0){
							$picname = $_FILES['file']['name'];
							$picsize = $_FILES['file']['size'];
							
							if ($picname != "") {
								if ($picsize > 1024000) {
									echo '图片大小不能超过1M';
									exit;
								}
								$type = strtolower(strstr($picname, '.'));
								if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
									echo '图片格式不对！';
									exit;
								}
								$rand = rand(100, 999);
								$pics = date("YmdHis") . $rand . $type;
								$pic_path = $_SERVER['DOCUMENT_ROOT']."/uploads/task/". $pics;
								move_uploaded_file($_FILES['file']['tmp_name'], $pic_path);
								$img[$contrast]='/uploads/task/'. $pics;
								if(isset($info['finish'])){
									if(isset($info['finish']['contrast'])&&is_array($info['finish']['contrast'])){
										if(isset($info['finish']['contrast'][$contrast])){
											@unlink($_SERVER['DOCUMENT_ROOT'].$info['finish']['contrast'][$contrast]);
										}
									}
								}
								$info['finish']['contrast'][$contrast]=$img[$contrast];
								$info['finish']=serialize($info['finish']);
								$db->Execute("update mcs_task_taobao set finish='".$info['finish']."' where id=".$id);
							}
							$arr = array('pic'=>$pics);
							echo json_encode($arr);exit;
						}else{
							switch($_FILES['file']['error']) {   
								case 1: 
									echo '文件大小超出了服务器的空间大小';exit;
								break;    
								case 2:
									echo '要上传的文件大小超出浏览器限制';exit; 
								break;    
							   
								case 3:
									echo '文件仅部分被上传';exit;   
									break;    
							   
								case 4:
									echo '没有找到要上传的文件';exit;    
									break;    
							   
								case 5:
									echo '服务器临时文件夹丢失';exit;   
									break;    
							   
								case 6:
									echo '文件写入到临时文件夹出错';exit;
									break;    
							}
						}
					}
				}
			}
		}
	break;

	case 'yz'://商品地址验证
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$id=trim($_POST['id']);
			if($id){
				$info=$db->getRow("select a.*,b.nickname as zgnick from mcs_task_taobao a,mcs_member_bindacc b where a.id=$id and a.process=0 and a.get_user=b.id and b.acc_type='tb' and b.uid=$uinfo[user_id] and b.buyno=0");
				// pre($info);die;
				if($info){
					$info['attrs']=unserialize($info['attrs']);
					$info['task_other']=unserialize($info['task_other']);
					$info['finish']=unserialize($info['finish']);
					if(count($info['finish']['contrast'])==$info['attrs']['contrast']){
						//$info['nickname']=mb_substr($db->getField('mcs_member_bindacc', 'nickname', "id='$info[accid]' and acc_type='tb'"),0,3,'utf-8')."***";
						$info['nickname']=mb_substr($db->getField('mcs_member_bindacc', 'nickname', "id='$info[accid]' and acc_type='tb'"),0,10,'utf-8');
						$view->assign('info', $info);
						// pre($info);die;
						$view->display('taobao/check');
					}
					exit;
				}
			}
		}
		exit;
	break;

	case 'task_out'://退出任务
			$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
			if($id){
				if($db->getField('mcs_task_taobao a,mcs_member_bindacc b', 'process', "a.id=$id and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'")==0){
					$tasks=$db->getRow('select * from mcs_task_taobao where id='.$id);
					$user_uid=$db->getField('mcs_member_bindacc', 'uid', "id=".$tasks['get_user']." and acc_type='tb'");
					$user_name=$db->getField('mcs_member_bindacc', 'nickname', "id=".$tasks['get_user']." and acc_type='tb'");
					
					$db->Execute("update mcs_task_taobao set process=0,get_user=0,get_time=0,timing=0,finish='' where id=$id");

					$db->Execute("insert into mcs_member_logs(uid,createtime,info,taskid,logtype,type) value('$user_uid','".time()."','任务退出',$id,'任务退出','logtask')");//买号日志

					$db->Execute("insert into mcs_member_logs(uid,createtime,info,taskid,logtype,type) value('$tasks[uid]','".time()."','接受方".$user_name."退出任务TB".$id."',$id,'任务退出','logtask')");//发布方日志

				}
				exit;
			}
	break;

	case 'getTaobaourl'://查看淘宝网址
			$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
			if($id){
				echo $db->getField('mcs_task_taobao', 'goods_url', "id=$id");
				exit;
			}
	break;

	case 'substitution'://换接手方
		$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
		if($id){
			if($db->getField('mcs_task_taobao', 'process', "id=$id and uid=$uinfo[user_id]")==0){
				$db->Execute("update mcs_task_taobao set process=0,get_user=0,get_time=0 where id=$id");
				echo "ok";
			}
			exit;
		}
	break;
	
	case 'examine'://审核
		$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
		if($id){
			$task=$db->getRow("select * from mcs_task_taobao where id=$id and uid=$uinfo[user_id]");
			if($task){
				$attrs=unserialize($task['attrs']);
				if($attrs['cbxIsAudit']==1){
					$finish=unserialize($task['finish']);
					$finish['cbxIsAudit']=1;
					$finish=serialize($finish);
					$db->Execute("update mcs_task_taobao set finish='".$finish."',timing=".(time()+900)." where id=$task[id]");
					echo "ok";
				}
			}
			exit;
		}
	break;

	case 'pingjia'://评价
		$id=trim($_REQUEST['id']);
		if(IS_POST&&IS_AJAX){
			$grade=intval($_POST['grade']);
			$remark=trim($_POST['remark']);
			$isHide=intval($_POST['isHide']);
			$info=$db->getRow("select * from mcs_task_taobao where id=$id");
			if($info['uid']==$uinfo[user_id]){ 
			//发布人评价
				$tuid=$db->getField("mcs_member_bindacc a,mcs_users b","user_id","a.id=$info[get_user] and a.uid=b.user_id");
			}else{
			//接手人评价
				$tuid=$info['uid'];
			}
			
			$uid=$uinfo['user_id'];
			
			$db->Execute("insert into mcs_task_comm(tid,uid,tuid,addtime,type,content,isHide) values($info[id],$uid,$tuid,".time().",$grade,'$remark',$isHide)");
			echo 'ok';
			exit;

		}

		if($id){
			$info=$db->getRow("select * from mcs_task_taobao where id=$id");
				if($info['uid']==$uinfo['user_id']){
					$get='发布方：';
					$get.=$db->getField("mcs_users","user_name","user_id=$info[uid]");;
					$put='接手方：';
					$put.=$db->getField("mcs_users a,mcs_member_bindacc b","user_name","b.id=$info[get_user] and a.user_id=b.uid");
				}else{
					$get='接手方：';
					$get.=$db->getField("mcs_users a,mcs_member_bindacc b","user_name","b.id=$info[get_user] and a.user_id=b.uid");
					$put='发布方：';
					$put.=$db->getField("mcs_users","user_name","user_id=$info[uid]");
				}
			$view->assign('get', $get);
			$view->assign('put', $put);
			$view->assign('info', $info);
			$view->display('taobao/pingjia');
		}
		exit;
		
	break;

	case 'qiang'://接任务
		if($uinfo['mprz']==0){
			echo '请先激活手机！';
			exit;
		}elseif($uinfo['isem']==0){
			echo '请先完成新手考试！';
			exit;
		}
		if($_REQUEST['gid']&&$_REQUEST['gid']=='undefined'){
			echo "没有选中买号";die;
		}



		// $buyid=$db->getRow("select count(*) as num from mcs_member_bindacc where is_lock=0 and is_hang=0 and state=1 and buyno=1 and uid=".$_SESSION['user_id'])['num'];
		// if($buyid<=0){
		// 	echo '您没有可用买号';die;
		// }
		$area=$db->getRow("select eqarea from mcs_task_taobao where id=".$_REQUEST['id'])['eqarea'];//商户地址
		$userarea=unserialize($db->getRow("select chg_address from mcs_users where user_id=".$_SESSION['user_id'])['chg_address']);
		$shprvo=unserialize($db->getRow("select attrs from mcs_task_taobao where id=".$_REQUEST['id'])['attrs'])['Province'];
		$shprvo= explode(",",$shprvo);
		$areaok=false;
		foreach($shprvo as $v){
			if(in_array($v,$userarea)){
				$areaok=true;
				break;
			}else{
				$areaok=false;
			}
		}
		foreach($userarea as $v){
			$areas[]=$v['prov'];
		}
		// if(!is_numeric($area)&&(!in_array($area,$userarea)||$areaok)&&$area != ''){
		// 	echo '商家不接受您的收货地址';die; 
		// }   
		if((!is_numeric($area)&&(!in_array($area,$userarea))&&$area != '')||$areaok){
			echo '商家不接受您的收货地址';die; 
		} 
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
		$week=date("w",time());
		$weekstart=strtotime(date("Y-m-d",(time()-($week-1)*24*3600)));
		$weekend=$weekstart+7*3600*24;
		// echo $nextmonth;die;
		$getdaynum=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and get_time<=$tomorrow and get_time>=$today");
		$getweeknum=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and get_time<=$weekend and get_time>=$weekstart");
		$getmonthnum=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and get_time<=$nextmonth and get_time>=$thismonth");
		$getmax=$db->getRow("select mcs_member_set.* from mcs_users join mcs_user_rank on mcs_users.user_rank=mcs_user_rank.rank_id join mcs_member_set on mcs_user_rank.rank_name=mcs_member_set.rank_name where mcs_users.user_id=".$_SESSION['user_id']);
		// pre($getmonthnum);die; 
		if($getmonthnum['count']>=$getmax['monthgetmax']){
			echo '这个月接的太多了';die;
		}
		if($getweeknum['count']>=$getmax['weekgetmax']){
			echo '本周接的太多了';die;
		}
		if($getdaynum['count']>=$getmax['daygetmax']){
			echo '今日接的太多了，明天再接吧';die;
		}

		
		
		$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
		
		$issb=$db->getRow("select cbxIsSB from mcs_task_taobao where id=".$_REQUEST['id'])['cbxIsSB'];
		if($issb==1){
			if($num=$db->getRow("select count(*) as num from mcs_users where business>0 and business_time=0 and user_id=".$uinfo['user_id'])['num']==0){
				echo '卖家只允许商保用户接手';die;
			}
		}
		
		$uid=$db->getField('mcs_task_taobao', 'uid', "id='$id'");
		if($uid==$uinfo['user_id']){
			echo '不允许接自己发布的任务';
			exit;
		}
		$limits=$db->getRow("select * from mcs_task_taobao where id=".$_REQUEST['id']);
		if($limits['fmingrade']!=null&&$uinfo['rank_points']<$limits['fmingrade']){
			echo "卖家设定积分大于".$limits['fmingrade'].'才可以接取';die;
		}
		$blacknum=$db->getRow("select count(*) as blacknum from mcs_member_black where uid=".$uinfo['user_id'])['blacknum'];
		if($limits['fmaxbbc']!=null&&$limits['fmaxbbc']!=0&&$blacknum>=$limits['fmaxbbc']){
			echo "关于您的黑名单太多了,该商家不与合作";die;
		}
		$complaint=$db->getRow("select count(*) as complaintnum from mcs_task_appeal where aid=".$uinfo['user_id'])['complaintnum'];
		if($limits['fmaxbtsc']!=null&&$limits['fmaxbtsc']!=0&&$complaint>=$limits['fmaxbtsc']){
			echo "关于您的投诉太多了,该商家不与合作";die;
		}
		$bindaccinfo=$db->getRow("select * from mcs_task_taobao where id='".$_REQUEST['id']."'");
		$getsday=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and mcs_task_taobao.get_time<=$tomorrow and mcs_task_taobao.get_time>=$today and mcs_task_taobao.uid='".$bindaccinfo['uid']."'")['count'];
		$getsweek=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and mcs_task_taobao.get_time<=$weekend and mcs_task_taobao.get_time>=$weekstart and mcs_task_taobao.uid='".$bindaccinfo['uid']."'")['count'];
		$getsmonth=$db->getRow("select count(*) as count from mcs_task_taobao join mcs_member_bindacc on mcs_task_taobao.get_user=mcs_member_bindacc.id where mcs_member_bindacc.uid=".$_SESSION['user_id']." and mcs_task_taobao.get_time<=$nextmonth and mcs_task_taobao.get_time>=$thismonth and mcs_task_taobao.uid='".$bindaccinfo['uid']."'")['count'];
		switch($bindaccinfo['fmaxmc']){
			case 1:
				if($getsday>=1){
					echo "卖家限接每天只能接一个";die;
				}
			break;
			case 2:
				if($getsday>=2){
					echo "卖家限接每天只能接2个";die;
				}
			break;
			case 3:
				if($getsweek>=1){
					echo "卖家限接每周只能接一个";die;
				}
			break;
			case 4:
				if($getsmonth>=1){
					echo "卖家限接每月只能接一个";die;
				}
			break;
		}
		// print_r($getsday);die;
		// pre($uinfo,$limits);die;
		
		// if(){

		// }
		
		//是否被发布方拉黑用户
		$is_black=$db->getCount("mcs_task_taobao a,mcs_member_black b","a.id=$id and a.uid=b.uid and b.accid=$uinfo[user_id] and b.usertype='ublack'");
		if($is_black){
			echo '您已被发布方拉黑，将不能接此任务！';
			exit;
		}
		//同时接任务
		$yijie=$db->getCount("mcs_task_taobao a,mcs_member_bindacc b","a.process!=4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		if($yijie>=$uinfo['params']['tsjrws']&&$yijie>0){
			echo "您现在还有".$yijie."个任务未完成，您是".$uinfo['rank_name']."会员，最多只能同时接".$uinfo['params']['tsjrws']."个任务！";
			exit;
		}
		$gid=isset($_REQUEST['gid'])?trim($_REQUEST['gid']):0;
		
		if($gid){
			
				if($db->getField('mcs_task_taobao', 'get_user', "id=$id")>0){
					echo '您慢了一步，任务已经被别人抢去了！';
					exit;
				}
				
				//是否被发布方拉黑用户
				$is_black=$db->getCount("mcs_task_taobao a,mcs_member_black b","a.id=$id and a.uid=b.uid and b.accid=$gid and b.usertype='taobao'");
				if($is_black){
					echo '此买号已被发布方拉黑，将不能接此任务！';
					exit;
				}
				//接受任务成功
				$db->Execute("update mcs_task_taobao set get_user=$gid,get_time=".time().",timing=".(time()+600).",usid=$user_ids where id=$id");
				
				echo "<div class='strong'><span class='red'>您已经绑定了买号，如果您在淘宝上给对方支付了金额，请务必在平台的15分钟读秒完成之前点击【已经支付】，否则您将可能损失在淘宝上支付给对方的金额</span><br><br><span class='blue'>本信息在您完成5个接手任务后不再提示</span></div>";
				
				//接手人通知
				$r=$db->getRow("select uid from mcs_task_taobao where id = " .$id);
				$results=$db->getRow("select mess_set from mcs_users where user_id = '".$r['uid']."' ");
				$result=unserialize($results['mess_set']);
				$res=$result['jt_take'];
				if($res['website'] == 1) {
					$result=$db->getRow("select uid from mcs_task_taobao where id = " .$id);
					$uid=$result['uid'];
					$ress=$db->getRow("select * from mcs_member_bindacc where id = ".$gid);
					$re=$ress['uid'];
					$name=$db->getRow("select user_name from  mcs_users where user_id = " .$re);
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$uid."','".$uid."','你的订单{$id}已被{$name['user_name']}接手','0','".time()."') ");
				
				}
				
				
				//买号相关通知
				$rs=$db->getRow("select uid from mcs_task_taobao where id = " .$id);
				$resu=$db->getRow("select mess_set from mcs_users where user_id = '".$rs['uid']."' ");
				$resultt=unserialize($resu['mess_set']);
				$resl=$resultt['ft_buyer'];
				if($resl['website'] == 1 ){
					
					$resultsf=$db->getRow("select uid from mcs_task_taobao where id = " .$id);
					$uid=$resultsf['uid'];
					$ressf=$db->getRow("select * from mcs_member_bindacc where id = ".$gid);
					$rea=$ressf['uid'];
					$time=date('Y-m-d H:i');
					$names=$db->getRow("select user_name ,mobile_phone ,qq from  mcs_users where user_id = " .$rea);
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$rs['uid']."','".$rs['uid']."','{$names['user_name']} 于".$time."购买了你的订单".$id." 手机号是 ".$names['mobile_phone']."qq是 ".$names['qq']." ','0','".time()."') ");
				}
				
				exit;
		}
		
		if($id){
			
			$lists = $db->getAll("select * from mcs_task_taobao where id=$id");
			
			foreach($lists as $key => $val){
				$lists[$key]['add_user']=$db->getField('mcs_users', 'user_name', "user_id='$val[uid]'");
				$lists[$key]['attrs']=unserialize($val['attrs']);
				if($lists[$key]['attrs']['isReal']){
					$isReal=1;
				}
				$lists[$key]['task_other']=unserialize($val['task_other']);
				foreach($lists[$key]['task_other']['shopAll'] as $vals)
				{
					$lists[$key]['cbhp']+=$vals['cbhp'];
				}
			}

		}
		
		$sql = "select * from mcs_member_bindacc where acc_type='tb' and uid={$uinfo[user_id]} and buyno=0 and is_hang=0 and is_lock=0 and state=1";
		if($isReal){
			$sql.=' and sm=2';
		}else{
			$sql.=' and sm=0';
		}
		$mai = $db->getAll($sql);
		
		$sqls = "select * from mcs_member_bindacc where acc_type='tb' and uid={$uinfo[user_id]} and buyno=0 and is_hang=0 and is_lock=0 and state=1 and sm=1";
		$mais = $db->getAll($sqls);
		
		if(count($mai)<1&&count($mais)<1){
			echo 'no';exit;
		}
		foreach($mai as $key => $val){
			$value=unserialize($val['value']);
			$mai[$key]['buyer_credit']= intval($value['buyer_credit']);//买号信誉
			$mai[$key]['week']= $db->getCount("mcs_task_taobao","get_user=$val[id] and get_time>=".strtotime('last monday'));
			$mai[$key]['today']= $db->getCount("mcs_task_taobao","get_user=$val[id] and get_time>=".strtotime(date("Y-m-d")));
		}
		foreach($mais as $key => $val){
			$value=unserialize($val['value']);
			$mais[$key]['buyer_credit']= intval($value['buyer_credit']);//买号信誉
			$mais[$key]['week']= $db->getCount("mcs_task_taobao","get_user=$val[id] and get_time>=".strtotime('last monday'));
			$mais[$key]['today']= $db->getCount("mcs_task_taobao","get_user=$val[id] and get_time>=".strtotime(date("Y-m-d")));
		}
		$db->Execute("update mcs_task_taobao set getuserip='".$_SERVER['REMOTE_ADDR']."' where id='".$_REQUEST['id']."'");
		$view->assign('lists', $lists);
		$view->assign('mai', $mai);
		$view->assign('con_mai', count($mai));
		$view->assign('mais', $mais);
		$view->assign('con_mais', count($mais));
		$view->display('taobao/qiang');
	break;

	case 'remarks'://任务备注
		$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
		$remarks=isset($_REQUEST['remarks'])?trim($_REQUEST['remarks']):'';
		if($id){
			
				$db->Execute("update mcs_task_taobao set remarks='{$remarks}' where id=$id");
				exit;
			
		}
		break;
	case 'appeal'://任务申诉
		$id=isset($_REQUEST['id'])?trim($_REQUEST['id']):0;
		$has=$db->getField("mcs_task_appeal","task_id","task_id=$id and uid=$uinfo[user_id] and task_type='tb'");
		if($has){
			echo "您已投诉过！";
			exit;
		}
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错';
			if($has){
				$data['info']='您已投诉过！';
			}else{
				$info=trim($_POST['info']);
				$content=trim($_POST['content']);
				if(empty($info)){
					$data['info']='请选择投诉类型~';
				}elseif(strpos($content,'<img')===false){
					$data['info']='投诉必须上传图片~';
				}else{
					//htmlspecialchars(iconv('UTF-8','GB2312',$_POST['content']),ENT_QUOTES,'gb2312');
					$aid=$db->getField('mcs_task_taobao','uid',"id=".$id);
					if($aid){
						$db->Execute("insert into mcs_task_appeal(uid,aid,task_id,info,content,add_time,task_type) values($uinfo[user_id],$aid,$id,'".$info."','".$content."',".time().",'tb')");
						$db->Execute("update mcs_task_taobao set appeal=1 where id=$id");
						$data['info']='投诉成功!';
						$data['state']=1;
					}else{
						$data['info']='您要投诉的任务不存在~';
					}
					
				}
			}
			
			echo json_encode($data);
			exit;
		}
		if($id){
			$list=$db->getRow("select * from mcs_task_taobao where id=$id");
			$list['respondent']=$db->getField("mcs_users","user_name","user_id=$list[uid]");
			$view->assign('list',$list);
		}
		$view->display('taobao/appeal');
		break;

	case 'inTask'://已接任务
		 //公告任务
		 $result=$db->getRow("select * from mcs_notice order by id desc");
		
		 $canhandle=$db->getRow("select count(*) as canhandle from mcs_task_taobao a,mcs_member_bindacc b where a.process>=0 and a.process<4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('canhandle', $canhandle);

		 $complete=$db->getRow("select count(*) as complete from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('complete', $complete);

		 $alltask=$db->getRow("select count(*) as alltask from mcs_task_taobao a,mcs_member_bindacc b where a.process<5 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('alltask', $alltask);

		 $fukuan=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=0 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('fukuan', $fukuan);

		 $fahuo=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=1 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('fahuo', $fahuo);

		 $shouhuo=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=2 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('shouhuo', $shouhuo);

		 $fangkuan=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=3 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb'");
		 $view->assign('fangkuan', $fangkuan);
			
		$m=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id]  and b.acc_type='tb' and a.get_time > ".strtotime(date("Y-m")));
		$view->assign('m', $m);

		$w=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id]  and b.acc_type='tb' and a.get_time > ".mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y")));
		$view->assign('w', $w);

		$d=$db->getRow("select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id]  and b.acc_type='tb' and a.get_time > ".strtotime(date("Y-m-d")));
		$view->assign('d', $d);
		$view->assign('result',$result);
// print_r($d);die;
		$view->display('taobao/inTask');
	break;

	case 'outTask'://已发任务
	
		//公告任务
		 $result=$db->getRow("select * from mcs_notice order by id desc");
		 
		 $canhandle=$db->getRow("select count(*) as canhandle from mcs_task_taobao where process>=0 and process<4 and uid=$uinfo[user_id] ");
		 $view->assign('canhandle', $canhandle);

		 $complete=$db->getRow("select count(*) as complete from mcs_task_taobao where process=4 and uid=$uinfo[user_id] ");
		 $view->assign('complete', $complete);

		 $alltask=$db->getRow("select count(*) as alltask from mcs_task_taobao where process>=0 and process<=5 and uid=$uinfo[user_id] ");
		 $view->assign('alltask', $alltask);

		 $pause=$db->getRow("select count(*) as pause from mcs_task_taobao where process=5 and uid=$uinfo[user_id] ");
		 $view->assign('pause', $pause);


		 $fukuan=$db->getRow("select count(*) as num from mcs_task_taobao where process=0 and uid=$uinfo[user_id] ");
		 $view->assign('fukuan', $fukuan);

		 $fahuo=$db->getRow("select count(*) as num from mcs_task_taobao where process=1 and uid=$uinfo[user_id] ");
		 $view->assign('fahuo', $fahuo);

		 $shouhuo=$db->getRow("select count(*) as num from mcs_task_taobao where process=2 and uid=$uinfo[user_id] ");
		 $view->assign('shouhuo', $shouhuo);

		 $fangkuan=$db->getRow("select count(*) as num from mcs_task_taobao where process=3 and uid=$uinfo[user_id] ");
		 $view->assign('fangkuan', $fangkuan);

		
		$m=$db->getRow("select count(*) as num from mcs_task_taobao where process=4 and uid=$uinfo[user_id]  and get_time > ".strtotime(date("Y-m")));
		$view->assign('m', $m);

		$w=$db->getRow("select count(*) as num from mcs_task_taobao where process=4 and uid=$uinfo[user_id]  and get_time > ".mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y")));
		$view->assign('w', $w);

		$d=$db->getRow("select count(*) as num from mcs_task_taobao where process=4 and uid=$uinfo[user_id]  and get_time > ".strtotime(date("Y-m-d")));
		$view->assign('d', $d);
		$view->assign('result',$result);
		$view->display('taobao/outTask');

	break;

    case 'index'://淘宝大厅
		
        $view->display('taobao/index');
	break;
	case 'underimg':
	// print_r($_FILES);die;
	//     die; die;
		if($_FILES['underimg']&&$_GET['id']){
			if(!is_dir("uploads/".date("Y-m-d",time()))){
				mkdir("uploads/".date("Y-m-d",time()),777,true);
			}
			$uppath="uploads/".date("Y-m-d",time())."/".date("Y-m-d",time()).time().".".pathinfo($_FILES['underimg']['name'])['extension'];
			if(move_uploaded_file($_FILES['underimg']['tmp_name'],$uppath)){
				$sql="update mcs_task_taobao set underimg='".$uppath."' ,process=process+1 where id=".$_GET['id'];
				$db->Execute($sql);
			}
		}
		echo "<script>location.href='taobao.php?mod=inTask';</script>";
	break;





    //获取商品价格
    case 'getgoodsprice':
        $url = isset($_GET['url']) ? trim($_GET['url']) : '';
        $url=str_replace("@","&",$url);
		$array = get_headers($url,1);
		if(preg_match('/200/',$array[0])){
			$content = iconv('gbk','utf-8',file_get_contents($url));
			preg_match('/<em\s+class="tb-rmb-num">\s*(.+)\s*<\/em>/', $content, $arr);
			$price = explode('-', $arr[1]);
			$price = array_pop($price);
			echo $price;
		}
		else{ 
			echo "notfind"; 
		}
        break;

    case 'getbuyaccount'://获取买号掌柜列表
		if(IS_POST&&IS_AJAX){
			$opt=trim($_GET['opt']);
			switch($opt){
				case 'state':
					$data=intval($_POST['bin']);
					$status=intval($_POST['status']);
					if($status>1){$status=1;}
					if($data){
						$db->Execute('update mcs_member_bindacc set state='.$status.' where id='.$data.' and acc_type="tb" and uid='.$uinfo['user_id'].' and buyno=0');
					}
				break;
				case 'order':
					$data=intval($_POST['bin']);
					$order=intval($_POST['order']);
					if($data){
						$db->Execute('update mcs_member_bindacc set shownum='.$order.' where id='.$data.' and acc_type="tb" and uid='.$uinfo['user_id'].' and buyno=0');
					}
				break;
				case 'del':
					$data=intval($_POST['bin']);
					if($data){
						$db->Execute('update mcs_member_bindacc set state=2 where id='.$data.' and acc_type="tb" and uid='.$uinfo['user_id'].' and buyno=0');
						echo 1;exit;
					}
				break;
				case 'hf':
					$data=intval($_POST['bin']);
					if($data){
						$db->Execute('update mcs_member_bindacc set state=0 where id='.$data.' and acc_type="tb" and uid='.$uinfo['user_id'].' and buyno=0');
						echo 1;exit;
					}
				break;
			}
			
		}
		//$db->Execute('set names gbk');
        $sql = "select * from mcs_member_bindacc where acc_type='tb' and uid={$uinfo[user_id]} and buyno=0 order by shownum desc,state asc";
        $_SERVER['QUERY_STRING']='mod=bindBuyer';
		if($_GET['page']){
			$_SERVER['QUERY_STRING'].='&page='.$_GET['page'];
		}
		$page = $db->page($sql);
		$acclist=$page['record'];
        foreach($acclist as $key => $val)
        {
            $acclist[$key]['value'] = unserialize($val['value']);
            $acclist[$key]['add_time'] = date('Y-m-d H:i', $val['add_time']);
            $acclist[$key]['today'] = $db->getCount('mcs_task_taobao','process=4 and get_user='.$val['id'].' and get_time>'.strtotime(date('Y-m-d')));
			$acclist[$key]['week'] = $db->getCount('mcs_task_taobao','process=4 and get_user='.$val['id'].' and get_time>'.strtotime('last monday'));
			$acclist[$key]['all'] = $db->getCount('mcs_task_taobao','process=4 and get_user='.$val['id']);
        }
		$view->assign('page', $page);
		$view->assign('acclist', $acclist);
        $view->display('taobao/bindbuy_acc_list');
    break;

	case 'getaccount'://获取买号掌柜列表
   
        $sql = "select * from mcs_member_bindacc where acc_type='tb' and uid={$uinfo[user_id]} and buyno=1";
		$page = $db->page($sql);
		$acclist=$page['record'];
        foreach($acclist as $key => $val)
        {
            $acclist[$key]['add_time'] = date('Y-m-d H:i', $val['add_time']);
        }
		$view->assign('acclist', $acclist);
		$view->assign('page', $page);
        $view->display('taobao/bind_acc_list');
        break;

    case 'bindacc'://绑定买号掌柜
        $nickname = isset($_REQUEST['nickname'])?trim($_REQUEST['nickname']):'';
        $type = $acc_type[trim($_REQUEST['type'])];
        if(!$type)  die('帐号类型不明');
		if($type==2){
			$type=0;
		}
        if(empty($nickname)){die('请填写您要绑定的帐号~');exit;}
        
        if($db->getCount('mcs_member_bindacc', "nickname='$nickname' and acc_type='tb' and buyno='$type'"))
        {
            die('此帐号已被绑定~');
        }

        $name = $nickname;

        $url = "http://www.taochabao.com/?a=search&nick=$name";
        $content = file_get_contents($url);
        if(preg_match('/不存在此淘宝账户/', $content))
        {
            die('不存在此淘宝账户！');
        }
        $user = array();

        preg_match('/<h1>淘宝卖家/U', $content, $arr);
        if($type == 1 && !$arr) //die("当前不是卖家帐号~");

        preg_match('/<li>.*卖家信用.*<span>(.*)<\/span>.*(<img.*>).*<\/li>/U', $content, $arr);
        $user['seller_credit'] = $arr[1];
        $user['seller_credit_img'] = $arr[2];
            
        preg_match('/<li>.*买家信用.*<span>(.*)<\/span>.*(<img.*>).*<\/li>/U', $content, $arr);
        $user['buyer_credit'] = $arr[1];
        $user['buyer_credit_img'] = $arr[2];

        $value = addslashes(serialize($user));
		if($type==0){//绑定买号数量
			$zg=$db->getCount("mcs_member_bindacc","uid=$uinfo[user_id] and buyno=0 and acc_type='tb'");
			if($zg>=$uinfo['params']['bdmhsl']){
				echo "您是".$uinfo['rank_name']."会员，最多只能绑定".$uinfo['params']['bdmhsl']."个买号！";
				exit;
			}
		}
		if($type==1){//绑定掌柜数量
			$zg=$db->getCount("mcs_member_bindacc","uid=$uinfo[user_id] and buyno=1 and acc_type='tb'");
			if($zg>=$uinfo['params']['bdzgsl']){
				echo "您是".$uinfo['rank_name']."会员，最多只能绑定".$uinfo['params']['bdzgsl']."个掌柜！";
				exit;
			}
		}
        $sql = "insert into mcs_member_bindacc(nickname, acc_type, buyno, uid, add_time, is_lock, value,state) values('$nickname', 'tb', '$type', '{$uinfo[user_id]}', '". time() ."', 0, '$value',1)";
            
        if($db->Execute($sql))
        {
            die('ok');
        } 

        //die($content);
        break;

    case 'bindseller'://掌柜
		$vipbd=$db->getField("mcs_user_rank","param","rank_id>0 order by rank_id desc");//最高可以绑定多少
		
		if($vipbd!=''){
			$vipbd=unserialize($vipbd);
			$view->assign('vipbd', $vipbd);
		}
        $view->display('taobao/bindseller');
        break;

	case 'bindBuyer'://买号
		$view->assign('pages', $_GET['page']);
		$view->display('taobao/bindBuyer');
        break; 

	case 'searchTask'://搜索任务
		
		//同时发任务
		$yifa=$db->getCount("mcs_task_taobao","process!=4 and uid=$uinfo[user_id]");
		if($yifa>=$uinfo['params']['tsfrws']){
			$a="您还有".$yifa."个任务已发布任务未完成，您是".$uinfo['rank_name']."会员，最多只能同时发".$uinfo['params']['tsfrws']."个任务！";
			echo '<script type="text/javascript">alert("'.$a.'");history.back();</script>';
			exit;
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // pre($_POST);die;
			$uid = $uinfo['user_id'];
			$tmpname = trim($_POST['tmpname']);
			$accid = intval($_POST['accid']);
            $goods_url = trim($_POST['goodsurl']);
			$goods_price = floatval($_POST['goods_price']);
			$chssp = intval($_POST['chssp']);
			$cbxIsGJ = intval($_POST['cbxIsGJ']);
			$cbxIsSB = intval($_POST['cbxIsSB']);
			$txtMinMPrice = floatval($_POST['txtMinMPrice']);
			$pointExt = floatval($_POST['pointExt']);
			$ddlOKDay = intval($_POST['ddlOKDay']);
			$isNoword = intval($_POST['isNoword']);
			$isSign = intval($_POST['isSign']);
			$Express = floatval($_POST['Express']);
			$txtFCount = intval($_POST['txtFCount'])>0?intval($_POST['txtFCount']):1;
            $attrs = $_POST['attrs'];
			$attrs['Province'] = implode(',',$_POST['Province']);
            $task_type = intval($_POST['task_type']);
            $task_other = $_POST['task_other'];

			$task_other['file']=$_SERVER['DOCUMENT_ROOT']."/uploads/file".$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$real['file']);
			$task_other['file']=str_replace($_SERVER['DOCUMENT_ROOT'],'hhtp://member.haohuisua.com/',$task_other['file']);


			if($goods_price*$txtFCount>$uinfo['user_money']){
				echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
				exit;
			}
			if(isset($task_other)&&$task_other!=''){
				foreach($task_other as $val){
					$goods+=$val['txtprice'];
				}
				if($goods*$txtFCount>$uinfo['user_money']){
					echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
					exit;
				}
				$goods_price=$goods>0?$goods:$goods_price;
			}
			$goods_price*=$txtFCount;
			//刷点统计
			$total_points=0;
			if(isset($task_other['ddlMealType'])&&$task_other['ddlMealType']>0){
				switch($task_other['ddlMealType']){
					case '1':
						$total_points+=$task_set['ddlMealType1'];
					break;
					case '2':
						$total_points+=$task_set['ddlMealType2'];
					break;
					default:
					break;
				}
			}
			// if(isset($ddlOKDay)){
			// 	$total_points+=$txtMinMPrice*1.5+$ddlOKDay-1;
			// }

			if(isset($task_other['visitWay'])&&$task_other['visitWay']>0){
				$total_points+=$task_set['s_visitWay'];
			}
			
			if(isset($cbxIsSB)&&$cbxIsSB>0){
				$total_points+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
				$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
			}
			if($pointExt){
				$total_points+=$pointExt;
				$mai+=$pointExt;
			}
			if(isset($isSign)&&$isSign>0){
				if(isset($Express)&&$Express==1)$total_points+=$task_set['Express1'];
				if(isset($Express)&&$Express==2)$total_points+=$task_set['Express2'];
			}
			
			if(isset($txtMinMPrice)&&$txtMinMPrice>0){
				$total_points+=$txtMinMPrice;
				$mai+=$txtMinMPrice;
			}
			$timing=0;
			foreach($attrs as $key =>$val){
				switch($key){
					case 'isZgh':
						$total_points+=$task_set['isZgh'];
						$mai+=$task_set['isZgh'];
						break;
					case 'isYanchi':
						switch($attrs['yanchi_state']){
							case 3:
								$total_points+=$task_set['yanchi_state3'];
								break;
							case 24:
								$total_points+=$task_set['yanchi_state24'];
								break;
						}
					break;
					case 'isBuyerFen':
						$total_points+=$task_set['buyerJifen'.$attrs['BuyerJifen']];
					break;
					case 'cbxIsAudit':
						$total_points+=$task_set['cbxIsAudit'];
						$mai+=$task_set['cbxIsAudit'];
						break;

					case 'isMobile':
						$total_points+=$task_set['isMobile'];
						break;

					case 'cbxIsWX':
						$total_points+=$task_set['cbxIsWX'];
						break;

					case 'cbxIsWW':
						$total_points+=$task_set['cbxIsWW'];
						$mai+=1;
						break;

					case 'cbxIsLHS':
						$total_points+=$task_set['cbxIsLHS'];
						$mai+=1;
						break;

					case 'cbxIsMsg':
						$total_points+=$task_set['cbxIsMsg'];
						$mai+=$task_set['cbxIsMsg'];
						break;

					case 'cbxIsAddress':
						$total_points+=$task_set['cbxIsAddress'];
						$mai+=$task_set['cbxIsAddress'];
						break;

					case 'shopcoller':
						$total_points+=$task_set['shopcoller'];
						$mai+=$task_set['shopcoller'];
						break;

					case 'pinimage':
						$total_points+=$task_set['pinimage'];
						$mai+=$task_set['pinimage'];
						break;				

					case 'isShare':
						$total_points+=$task_set['isShare'];
						$mai+=$task_set['isShare'];
						break;

					case 'cbxIsFMaxMCount':
						switch($attrs['fmaxmc']){
							case 1:
								$total_points+=$task_set['fmaxmc1'];
								break;
							case 2:
								$total_points+=$task_set['fmaxmc2'];
								break;
							case 3:
								$total_points+=$task_set['fmaxmc3'];
								break;
							case 4:
								$total_points+=$task_set['fmaxmc4'];
								break;
							default:
								break;
						}
						break;					

					case 'isReal':
						$total_points+=$task_set['isReal'];
						break;					

					case 'cbxIsTaoG':
						
						$txtTaoG=isset($attrs['txtTaoG'])?$attrs['txtTaoG']:'';
						
						if($txtTaoG%10==0){
							$total_points+=($txtTaoG/10)*$task_set['txtTaoG'];
							$mai+=($txtTaoG/10)*$task_set['txtTaoG'];
						}
						else{
							echo '<script type="text/javascript">alert("您的淘金币值不符合要求！");history.go(-1);</script>';
							exit;
						}
						break;	
						
					case 'isLimitCity':
						$total_points+=$task_set['isLimitCity'];
						break;

					case 'cbxIsSetTime1':
						$wait=1;
						if($attrs['txtSetTime']<1){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=time()+$attrs['txtSetTime']*60;
						if(isset($attrs['cbxIsSetTime2'])&&$attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;	

					case 'cbxIsSetTime2':
						$wait=1;
						if(strtotime($attrs['txtdelaydate'])<time()+60){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=strtotime($attrs['txtdelaydate']);
						if(isset($attrs['cbxIsSetTime1'])&&$attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;
					
					case 'cbxIsFMinGrade':
						$total_points+=$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;

					case 'cbxIsFMaxBBC':
						$total_points+=$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;

					case 'cbxIsFMaxABC':
						$total_points+=$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;
						
					case 'cbxIsFMaxCredit':
						$total_points+=$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;

					case 'cbxIsFMaxBTSCount':
						$total_points+=$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
					break;

					case 'isCompare':
						$total_points+=$task_set['isCompare']*$attrs['contrast'];
						break;
					break;

					case 'stopDsTime':
						switch($attrs['stopTime']){
							case 1:
								$total_points+=$task_set['stopTime1'];
								break;
							case 2:
								$total_points+=$task_set['stopTime2'];
								break;
							case 3:
								$total_points+=$task_set['stopTime3'];
								break;
							default:
								break;
						}
						break;
					
					case 'isViewEnd':
						$total_points+=$task_set['isViewEnd'];
						$mai+=$task_set['isViewEnd'];
						break;
					case 'shopBrGoods':
						switch($attrs['lgoods']){
							case 1:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 2:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 3:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							default:
								break;
						}
					default:
						break;
				}
			
			}

			$template=$attrs['tplTo'];
			$attrs = serialize($attrs);
			$task_other = serialize($task_other);
			$member_point=$db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'");
			$goods_price=$goods_price/$txtFCount;
			if($member_point < $txtFCount*$total_points)
            {
                $onum=intval($member_point/$total_points);
				echo '<script type="text/javascript">alert("您的刷点不足,只能发布此类型任务'.$onum.'次！");history.go(-1);</script>';
				exit;
            }
			else{	
				for($i=1;$i<=$txtFCount;$i++){
					if(isset($task_type)&&$task_type>0){
						$iid = '';
						$a = mt_rand(10000000,99999999);
						$c= mt_rand(10000000,99999999);
						$iid = $a.$c;
						$aid=$db->getRow('select id from mcs_task_taobao where id='.$iid.' order by id desc');
						if($aid['id']){$iid=$aid['id']+1;}
						$process=0;
						if($wait){$process=5;}

						$sql="insert into mcs_task_taobao(id,uid,addtime,tmpname,accid,goods_url,goods_price,chssp,cbxIsGJ,cbxIsSB,txtMinMPrice,pointExt,ddlOKDay,isNoword,isSign,Express,attrs,total_points,task_type,task_other,process,timing) value('$iid',$uid','".time()."','$tmpname','$accid','$goods_url','$goods_price','$chssp','$cbxIsGJ','$cbxIsSB','$txtMinMPrice','$pointExt','$ddlOKDay','$isNoword','$isSign','$Express','$attrs','$total_points','$task_type','$task_other',$process,$timing)";
					
						$db->Execute($sql);
						
						$zg=$db->getField('mcs_member_bindacc','nickname','id='.$accid);
						$lx='实物';
						if($ddlOKDay==0){
							$lx='虚拟';
						}
						$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value('$uid','".time()."','$iid','".$zg.",成功发布淘宝".$lx."任务TB".$iid."','发布任务！','logtask')");//日志

						$db->Execute("update mcs_users set pay_money=pay_money-$total_points where user_id='$uid'");

						$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$total_points).",".$iid.",'刷点日志',".$member_point.",'logpoint')");//日志

						$db->Execute("update mcs_users set user_money=user_money-$goods_price where user_id='$uid'");

						$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$goods_price).",'存款日志','$member_point','payde')");//日志

					}
				}	
				
				$attrs=unserialize($attrs);
				if(isset($attrs['isTpl'])&&isset($attrs['tplTo'])&&!empty($attrs['tplTo'])){
					//可保存模板数
					$m=$db->getCount("mcs_task_template","uid=$uinfo[user_id] and tem_type='tb'");
					if($m>=$uinfo['params']['kbcmbsl']){
						$a="您是".$uinfo['rank_name']."会员，最多只能绑定".$uinfo['params']['kbcmbsl']."个模板！";
						echo '<script type="text/javascript">alert("'.$a.'");history.back();</script>';
						exit;
					}
					$attrs=serialize($_POST);
					$sql="insert into mcs_task_template(uid,name,value,type,tem_type) value('$uid','$template','$attrs','$mod','tb')";
					$db->Execute($sql);
					echo '<script type="text/javascript">alert("模板保存成功！");</script>';
				}
				
				echo '<script type="text/javascript">alert("任务发布成功！");location.href="/#index";</script>';
				exit;
			} 
        }


		$date =  $db->getAll("select * from mcs_task_template where uid={$uinfo[user_id]} and type='$mod' and tem_type='tb'");
		$view->assign('date', $date);

		$member_point = $db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'");
		$view->assign('member_point', $member_point);
			
		$accs = $db->getAll("select * from mcs_member_bindacc where uid={$uinfo[user_id]} and acc_type='tb' and buyno = 1");
		$view->assign('accs', $accs);

		$view->display('taobao/searchTask');
        break;
    
	//case 'addTask'://单个任务
	//case 'lailuTask'://来路任务
	
	case 'mealTask'://套餐任务
	
	//来路任务，删除购买延长开始
	case 'lailuTask'://来路任务
		if($uinfo['mprz']==0){
			echo '<script type="text/javascript">alert("请先激活手机！");location.href="user.php";</script>';
			exit;
		}elseif($uinfo['isem']==0){
			echo '<script type="text/javascript">alert("请先完成新手考试！");location.href="user.php";</script>';
			exit;
		}
		//同时发任务
		$yifa=$db->getCount("mcs_task_taobao","process!=4 and uid=$uinfo[user_id]",'id');
		if($yifa>=$uinfo['params']['tsfrws']){
			$a="您还有".$yifa."个任务已发布任务未完成，您是".$uinfo['rank_name']."会员，最多只能同时发".$uinfo['params']['tsfrws']."个任务！";
			echo '<script type="text/javascript">alert("'.$a.'");history.back();</script>';
			exit;
		}
		
		//数据处理
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // die;
			$uid = $uinfo['user_id'];
			$tmpname = trim($_POST['tmpname']);
			$accid = intval($_POST['accid']);
            $goods_url = trim($_POST['goodsurl']);
			$goods_price = floatval($_POST['goods_price']);//担保价格
			$chssp = intval($_POST['chssp']);
			$cbxIsGJ = intval($_POST['cbxIsGJ']);
			$cbxIsSB = intval($_POST['cbxIsSB']);
			$txtMinMPrice = floatval($_POST['txtMinMPrice']);
			$pointExt = floatval($_POST['pointExt']);
			$ddlOKDay = intval($_POST['ddlOKDay']);
			$isNoword = intval($_POST['isNoword']);
			$isSign = intval($_POST['isSign']);
			$Express = floatval($_POST['Express']);
			$txtFCount = intval($_POST['txtFCount'])>0?intval($_POST['txtFCount']):1;
            $attrs = $_POST['attrs'];
			$attrs['Province'] = implode(',',$_POST['Province']);
            $task_type = $_POST['task_type'];
            $task_other = $_POST['task_other'];
			$task_other['file']=$_SERVER['DOCUMENT_ROOT']."/uploads/file".$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$real['file']);
			$task_other['file']=str_replace($_SERVER['DOCUMENT_ROOT'],'hhtp://member.haohuisua.com/',$task_other['file']);

			if($goods_price*$txtFCount>$uinfo['user_money']){
				echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
				exit;
			}
			if(isset($task_other)&&$task_other!=''){
				foreach($task_other['shopAll'] as $val){
					$goods+=$val['txtprice'];
				}
				if($goods*$txtFCount>$uinfo['user_money']){
					echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
					exit;
				}
				$goods_price=$goods>0?$goods:$goods_price;
			}
			$goods_price*=$txtFCount;
			//刷点统计
			$total_points=0;
			if(isset($task_other['ddlMealType'])&&$task_other['ddlMealType']>0){
				switch($task_other['ddlMealType']){
					case '1':
						$total_points+=$task_set['ddlMealType1'];
					break;
					case '2':
						$total_points+=$task_set['ddlMealType2'];
					break;
					default:
					break;
				}
			}
			if(isset($ddlOKDay)){
				$total_points+=$txtMinMPrice*1.5+$ddlOKDay-1;
			}
			if(isset($task_other['visitWay'])&&$task_other['visitWay']>0){
				$total_points+=$task_set['visitWay'];
			}
			if(isset($cbxIsSB)&&$cbxIsSB>0){
				$total_points+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
				$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
			}
			if($tpointExt){
				$total_points+=$tpointExt;
				$mai+=$tpointExt;
			}
			if(isset($isSign)&&$isSign>0){
				if(isset($Express)&&$Express==1)$total_points+=$task_set['Express1'];
				if(isset($Express)&&$Express==2)$total_points+=$task_set['Express2'];
			}
			
			if(isset($txtMinMPrice)&&$txtMinMPrice>0){
				$total_points+=$txtMinMPrice;
				$mai+=$txtMinMPrice;
			}
			$timing=0;
			foreach($attrs as $key =>$val){
				switch($key){
					case 'isZgh':
						$total_points+=$task_set['isZgh'];
						$mai+=$task_set['isZgh'];
						break;
					case 'isYanchi':
						switch($attrs['yanchi_state']){
							case 3:
								$total_points+=$task_set['yanchi_state3'];
								break;
							case 24:
								$total_points+=$task_set['yanchi_state24'];
								break;
						}
					break;
					case 'cbxIsAudit':
						$total_points+=$task_set['cbxIsAudit'];
						$mai+=$task_set['cbxIsAudit'];
						break;

					case 'isMobile':
						$total_points+=$task_set['isMobile'];
						break;

					case 'cbxIsWX':
						$total_points+=$task_set['cbxIsWX'];
						break;

					case 'cbxIsWW':
						$total_points+=$task_set['cbxIsWW'];
						$mai+=$task_set['cbxIsWW'];
						break;

					case 'cbxIsLHS':
						$total_points+=$task_set['cbxIsLHS'];
						$mai+=$task_set['cbxIsLHS'];
						break;

					case 'cbxIsMsg':
						$total_points+=$task_set['cbxIsMsg'];
						$mai+=$task_set['cbxIsMsg'];
						break;

					case 'cbxIsAddress':
						$total_points+=$task_set['cbxIsAddress'];
						$mai+=$task_set['cbxIsAddress'];
						break;
					case 'shopcoller':
						$total_points+=$task_set['shopcoller'];
						$mai+=$task_set['shopcoller'];
						break;

					case 'pinimage':
						$total_points+=$task_set['pinimage'];
						$mai+=$task_set['pinimage'];
						break;				

					case 'isShare':
						$total_points+=$task_set['isShare'];
						$mai+=$task_set['isShare'];
						break;

					case 'cbxIsFMaxMCount':
						switch($attrs['fmaxmc']){
							case 1:
								$total_points+=$task_set['fmaxmc1'];
								break;
							case 2:
								$total_points+=$task_set['fmaxmc2'];
								break;
							case 3:
								$total_points+=$task_set['fmaxmc3'];
								break;
							case 4:
								$total_points+=$task_set['fmaxmc4'];
								break;
							default:
								break;
						}
						break;					

					case 'isReal':
						$total_points+=$task_set['isReal'];
						break;					

					case 'cbxIsTaoG':
						
						$txtTaoG=isset($attrs['txtTaoG'])?$attrs['txtTaoG']:'';
						
						if($txtTaoG%10==0){
							$total_points+=($txtTaoG/10)*$task_set['cbxIsTaoG'];
							$mai+=($txtTaoG/10)*$task_set['cbxIsTaoG'];
						}
						else{
							echo '<script type="text/javascript">alert("您的淘金币值不符合要求！");history.go(-1);</script>';
							exit;
						}
						break;	
						
					case 'isLimitCity':
						$total_points+=$task_set['isLimitCity'];
						break;

					case 'cbxIsSetTime1':
						$wait=1;
						if($attrs['txtSetTime']<1){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=time()+$attrs['txtSetTime']*60;
						if(isset($attrs['cbxIsSetTime2'])&&$attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;	

					case 'cbxIsSetTime2':
						$wait=1;
						if(strtotime($attrs['txtdelaydate'])<time()+60){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=strtotime($attrs['txtdelaydate']);
						if(isset($attrs['cbxIsSetTime1'])&&$attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;
					
					case 'cbxIsFMinGrade':
						$total_points+$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;

					case 'cbxIsFMaxBBC':
						$total_points+=$task_set['cbxIsFMaxBBC'];
						$mai+=$task_set['cbxIsFMaxBBC'];
						break;

					case 'cbxIsFMaxABC':
						$total_points+=$task_set['cbxIsFMaxABC'];
						$mai+=$task_set['cbxIsFMaxABC'];
						break;
						
					case 'cbxIsFMaxCredit':
						$total_points+=$task_set['cbxIsFMaxCredit'];
						$mai+=$task_set['cbxIsFMaxCredit'];
						break;

					case 'cbxIsFMaxBTSCount':
						$total_points+=$task_set['cbxIsFMaxBTSCount'];
						$mai+=$task_set['cbxIsFMaxBTSCount'];
						break;

					case 'isCompare':
						$total_points+=$task_set['isCompare']*$attrs['contrast'];
						break;
					break;

					case 'stopDsTime':
						switch($attrs['stopTime']){
							case 1:
								$total_points+=$attrs['stopTime1'];
								break;
							case 2:
								$total_points+=$attrs['stopTime2'];
								break;
							case 3:
								$total_points+=$attrs['stopTime3'];
								break;
							default:
								break;
						}
						break;
					
					case 'isViewEnd':
						$total_points+=$task_set['isViewEnd'];
						$mai+=$task_set['isViewEnd'];
						break;
					case 'shopBrGoods':
						switch($attrs['lgoods']){
							case 1:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 2:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 3:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							default:
								break;
						}
					default:
						break;
				}
			
			}
			$template=$attrs['tplTo'];
			$attrs = serialize($attrs);
			$task_other = serialize($task_other);
			$member_point=$db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'");
			$goods_price=$goods_price/$txtFCount;
            if($member_point < $txtFCount*$total_points)
            {
                $onum=intval($member_point/$total_points);
				echo '<script type="text/javascript">alert("您的刷点不足,只能发布此类型任务'.$onum.'次！");history.go(-1);</script>';
				exit;
            }
			else{
				for($i=1;$i<=$txtFCount;$i++){
					if(isset($task_type)&&$task_type>0){
						
							$iid = '';
						$a = mt_rand(10000000,99999999);
						$c= mt_rand(10000000,99999999);
						$iid = $a.$c;
						$aid=$db->getRow('select id from mcs_task_taobao where id='.$iid.' order by id desc');
						if($aid['id']){$iid=$aid['id']+1;}
						$process=0;
						if($wait){$process=5;}
						
						$sql="insert into mcs_task_taobao(id,uid,addtime,tmpname,accid,goods_url,goods_price,chssp,cbxIsGJ,cbxIsSB,txtMinMPrice,pointExt,ddlOKDay,isNoword,isSign,Express,attrs,total_points,task_type,task_other,process,timing) value('$iid','$uid','".time()."','$tmpname','$accid','$goods_url','$goods_price','$chssp','$cbxIsGJ','$cbxIsSB','$txtMinMPrice','$pointExt','$ddlOKDay','$isNoword','$isSign','$Express','$attrs','$total_points','$task_type','$task_other',$process,$timing)";
						$db->Execute($sql);
						
						$zg=$db->getField('mcs_member_bindacc','nickname','id='.$accid);
						$lx='实物';
						if($ddlOKDay==0){
							$lx='虚拟';
						}
						$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value('$uid','".time()."','$iid','".$zg.",成功发布淘宝".$lx."任务TB".$iid."','发布任务！','logtask')");//日志

						$db->Execute("update mcs_users set pay_money=pay_money-$total_points where user_id='$uid'");

						$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$total_points).",".$iid.",'刷点日志',".$member_point.",'logpoint')");//日志

						$db->Execute("update mcs_users set user_money=user_money-$goods_price where user_id='$uid'");

						$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$goods_price).",'存款日志','$member_point','payde')");//日志
					}
				}	
				$attrs=unserialize($attrs);
				if(isset($attrs['isTpl'])&&isset($attrs['tplTo'])&&!empty($attrs['tplTo'])){
					//可保存模板数
					$m=$db->getCount("mcs_task_template","uid=$uinfo[user_id] and tem_type='tb'");
					if($m>=$uinfo['params']['kbcmbsl']){
						$a="您是".$uinfo['rank_name']."会员，最多只能绑定".$uinfo['params']['kbcmbsl']."个模板！";
						echo '<script type="text/javascript">alert("'.$a.'");</script>';
						exit;
					}
					$attrs=serialize($_POST);
					$sql="insert into mcs_task_template(uid,name,value,type,tem_type) value('$uid','$template','$attrs','$mod','tb')";
					$db->Execute($sql);
					echo '<script type="text/javascript">alert("模板保存成功！");</script>';
				}
				echo '<script type="text/javascript">alert("任务发布成功！");location.href="/#index";</script>';
				exit;
			} 
        }


		$date =  $db->getAll("select * from mcs_task_template where uid={$uinfo[user_id]} and type='$mod' and tem_type='tb'");
		$view->assign('date', $date);

		$member_point = $uinfo['pay_money'];

		
        $accs = $db->getAll("select * from mcs_member_bindacc where uid={$uinfo[user_id]} and acc_type='tb' and buyno = 1");

		$view->assign('accs', $accs);
        $view->display('taobao/addtasktest');
        break;
		//来路任务，删除购买延长结束
		
		
	case 'addTask'://单个任务	
	case 'shopTask'://购物车任务
		if($uinfo['mprz']==0){
			echo '<script type="text/javascript">alert("请先激活手机！");location.href="user.php";</script>';
			exit;
		}elseif($uinfo['isem']==0){
			echo '<script type="text/javascript">alert("请先完成新手考试！");location.href="user.php";</script>';
			exit;
		}
		//同时发任务
		$yifa=$db->getCount("mcs_task_taobao","process!=4 and uid=$uinfo[user_id]",'id');
		if($yifa>=$uinfo['params']['tsfrws']){
			$a="您还有".$yifa."个任务已发布任务未完成，您是".$uinfo['rank_name']."会员，最多只能同时发".$uinfo['params']['tsfrws']."个任务！";
			echo '<script type="text/javascript">alert("'.$a.'");history.back();</script>';
			exit;
		}
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
		$week=date("w",time());
		$weekstart=strtotime(date("Y-m-d",(time()-($week-1)*24*3600)));
		$weekend=$weekstart+7*3600*24;
		$todayadd=$db->getRow("select count(*) as count from mcs_task_taobao where addtime>=$today and addtime<=$tomorrow and uid = '".$uinfo['user_id']."' ");
		$weekadd=$db->getRow("select count(*) as count from mcs_task_taobao where addtime>=$weekstart and addtime<=$weekend and uid = '".$uinfo['user_id']."' ");
		$mounthadd=$db->getRow("select count(*) as count from mcs_task_taobao where addtime>=$thismonth and addtime<=$nextmonth");
		$getmax=$db->getRow("select mcs_member_set.* from mcs_users join mcs_user_rank on mcs_users.user_rank=mcs_user_rank.rank_id join mcs_member_set on mcs_user_rank.rank_name=mcs_member_set.rank_name where mcs_users.user_id=".$_SESSION['user_id']);
		if($mounthadd['count']>=$getmax['monthtomax']){
			echo '<script>alert("这个月发的太多了");location.href="./taobao.php";</script>';die;
		}
		if($weekadd['count']>=$getmax['weektomax']){
			echo '<script>alert("这周发的太多了");location.href="./taobao.php";</script>';die;
		}
		if($todayadd['count']>=$getmax['daytomax']){
			echo '<script>alert("今日发的太多了，明天再发吧");location.href="./taobao.php";</script>';die;
		}
		//发布限制

  			//
		//数据处理
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {	
           	// pre($_POST);die;
			$uid = $uinfo['user_id'];
			$tmpname = trim($_POST['tmpname']);
			$accid = intval($_POST['accid']);
            $goods_url = trim($_POST['goodsurl']);
			$goods_price = floatval($_POST['goods_price']);//担保价格
			$chssp = intval($_POST['chssp']);
			$cbxIsGJ = intval($_POST['cbxIsGJ']);
			$cbxIsSB = intval($_POST['cbxIsSB']);
			$cbxIsLook = intval($_POST['cbxIsLook']);
			$txtMinMPrice = floatval($_POST['txtMinMPrice']);
			$pointExt = floatval($_POST['pointExt']);
			$ddlOKDay = intval($_POST['ddlOKDay']);
			$isNoword = intval($_POST['isNoword']);
			$isSign = intval($_POST['isSign']);
			$Express = $_POST['Express'];
			$txtFCount = intval($_POST['txtFCount'])>0?intval($_POST['txtFCount']):1;
            $attrs = $_POST['attrs'];
			$attrs['Province'] = implode(',',$_POST['Province']);
            $task_type = $_POST['task_type'];
            $task_other = $_POST['task_other'];
			$task_other['file']=$_SERVER['DOCUMENT_ROOT']."/uploads/file".$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$real['file']);
			$task_other['file']=str_replace($_SERVER['DOCUMENT_ROOT'],'hhtp://member.haohuisua.com/',$task_other['file']);
			// $showtime=strtotime($_POST['attrs']['txtdelaydate']);
			if(!$attrs['fmaxmc']){
				$fmaxmc=0;
			}else{
				$fmaxmc=$attrs['fmaxmc'];	
			}
			// print_r($attrs['fmaxmc']);die;
			$nowtime=time();
			if($_POST['attrs']['txtSetTime']){
				$showtime=$nowtime+intval($_POST['attrs']['txtSetTime'])*60;
			}
			if($goods_price*$txtFCount>$uinfo['user_money']){
				echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
				exit;
			}
			if(isset($task_other)&&$task_other!=''){
				foreach($task_other['shopAll'] as $val){
					$goods+=$val['txtprice'];
				}
				if($goods*$txtFCount>$uinfo['user_money']){
					echo "<script type=text/javascript>alert('您的保证金不足！');history.go(-1);</script>";
					exit;
				}
				$goods_price=$goods>0?$goods:$goods_price;
			}
			$goods_price*=$txtFCount;
			//刷点统计
			$total_points=0;
			if(isset($task_other['ddlMealType'])&&$task_other['ddlMealType']>0){
				switch($task_other['ddlMealType']){
					case '1':
						$total_points+=$task_set['ddlMealType1'];
					break;
					case '2':
						$total_points+=$task_set['ddlMealType2'];
					break;
					default:
					break;
				}
			}

			// if(isset($ddlOKDay)){
			// 	// $total_points+=$txtMinMPrice*1.5+$ddlOKDay-1;
			// 	$total_points+=$txtMinMPrice;
			// }
			if(isset($task_other['visitWay'])&&$task_other['visitWay']>0){
				$total_points+=$task_set['visitWay'];
			}

			// if(isset($cbxIsSB)&&$cbxIsSB>0){
			// 	$total_points+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
			// 	$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
			// }

			if(isset($cbxIsSB)&&$cbxIsSB>0){
				// $total_points+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
				$total_points+=$cbxIsSB;
				$mai+=(($goods_price%$task_set['superposition'])+1)*$task_set['cbxIsSB'];
			}

			if($pointExt){
				$total_points+=$pointExt;
				$mai+=$pointExt;
			}
			if(isset($isSign)&&$isSign>0){
				if(isset($Express)&&$Express==1)$total_points+=$task_set['Express1'];
				if(isset($Express)&&$Express!=1)$total_points+=$task_set['Express2'];
			}
			
			if(isset($txtMinMPrice)&&$txtMinMPrice>0){
				$total_points+=$txtMinMPrice;
				$mai+=$txtMinMPrice;
			}
			if(!$cbxIsLook){
				$cbxIsLook=0;
			}
			// pre($_POST);die;
			// pre($txtMinMPrice);die;
			$timing=0;
			foreach($attrs as $key =>$val){
				switch($key){
					case 'isZgh':
						$total_points+=$task_set['isZgh'];
						$mai+=$task_set['isZgh'];
						break;
					case 'isYanchi':
						switch($attrs['yanchi_state']){
							case 3:
								$total_points+=$task_set['yanchi_state3'];
								break;
							case 24:
								$total_points+=$task_set['yanchi_state24'];
								break;
						}
					break;
					case 'cbxIsAudit':
						$total_points+=$task_set['cbxIsAudit'];
						$mai+=$task_set['cbxIsAudit'];
						break;

					case 'isMobile':
						$total_points+=$task_set['isMobile'];
						break;

					case 'cbxIsWX':
						$total_points+=$task_set['cbxIsWX'];
						break;

					case 'cbxIsWW':
						$total_points+=$task_set['cbxIsWW'];
						$mai+=$task_set['cbxIsWW'];
						break;

					case 'cbxIsLHS':
						$total_points+=$task_set['cbxIsLHS'];
						$mai+=$task_set['cbxIsLHS'];
						break;

					case 'cbxIsMsg':
						$total_points+=$task_set['cbxIsMsg'];
						$mai+=$task_set['cbxIsMsg'];
						break;

					case 'cbxIsAddress':
						$total_points+=$task_set['cbxIsAddress'];
						$mai+=$task_set['cbxIsAddress'];
						break;
					case 'shopcoller':
						$total_points+=$task_set['shopcoller'];
						$mai+=$task_set['shopcoller'];
						break;

					case 'pinimage':
						$total_points+=$task_set['pinimage'];
						$mai+=$task_set['pinimage'];
						break;				

					case 'isShare':
						$total_points+=$task_set['isShare'];
						$mai+=$task_set['isShare'];
						break;

					case 'cbxIsFMaxMCount':
						switch($attrs['fmaxmc']){
							case 1:
								$total_points+=$task_set['fmaxmc1'];
								break;
							case 2:
								$total_points+=$task_set['fmaxmc2'];
								break;
							case 3:
								$total_points+=$task_set['fmaxmc3'];
								break;
							case 4:
								$total_points+=$task_set['fmaxmc4'];
								break;
							default:
								break;
						}
						break;					

					case 'isReal':
						$total_points+=$task_set['isReal'];
						break;					

					case 'cbxIsTaoG':
						
						$txtTaoG=isset($attrs['txtTaoG'])?$attrs['txtTaoG']:'';
						
						if($txtTaoG%10==0){
							$total_points+=($txtTaoG/10)*$task_set['cbxIsTaoG'];
							$mai+=($txtTaoG/10)*$task_set['cbxIsTaoG'];
						}
						else{
							echo '<script type="text/javascript">alert("您的淘金币值不符合要求！");history.go(-1);</script>';
							exit;
						}
						break;	
						
					case 'isLimitCity':
						$total_points+=$task_set['isLimitCity'];
						break;

					case 'cbxIsSetTime1':
						$wait=1;
						if($attrs['txtSetTime']<1){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=time()+$attrs['txtSetTime']*60;
						if(isset($attrs['cbxIsSetTime2'])&&$attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;	

					case 'cbxIsSetTime2':
						$wait=1;
						if(strtotime($attrs['txtdelaydate'])<time()+60){
							echo '<script type="text/javascript">alert("定时发布任务时间，不能小于当前时间！");history.go(-1);</script>';
							exit;
						}
						$timing=strtotime($attrs['txtdelaydate']);
						if(isset($attrs['cbxIsSetTime1'])&&$attrs['cbxIsSetTime1']>0){$total_points+=$task_set['cbxIsSetTime']/2;$mai+=$task_set['cbxIsSetTime']/2;}
						else if($attrs['cbxIsSetTime2']>0){$total_points+=$task_set['cbxIsSetTime'];$mai+=$task_set['cbxIsSetTime'];}
						break;
					
					case 'cbxIsFMinGrade':
						$total_points+$task_set['cbxIsFMinGrade'];
						$mai+=$task_set['cbxIsFMinGrade'];
						break;

					case 'cbxIsFMaxBBC':
						$total_points+=$task_set['cbxIsFMaxBBC'];
						$mai+=$task_set['cbxIsFMaxBBC'];
						break;

					case 'cbxIsFMaxABC':
						$total_points+=$task_set['cbxIsFMaxABC'];
						$mai+=$task_set['cbxIsFMaxABC'];
						break;
						
					case 'cbxIsFMaxCredit':
						$total_points+=$task_set['cbxIsFMaxCredit'];
						$mai+=$task_set['cbxIsFMaxCredit'];
						break;

					case 'cbxIsFMaxBTSCount':
						$total_points+=$task_set['cbxIsFMaxBTSCount'];
						$mai+=$task_set['cbxIsFMaxBTSCount'];
						break;

					case 'isCompare':
						$total_points+=$task_set['isCompare']*$attrs['contrast'];
						break;
					break;

					case 'stopDsTime':
						switch($attrs['stopTime']){
							case 1:
								$total_points+=$attrs['stopTime1'];
								break;
							case 2:
								$total_points+=$attrs['stopTime2'];
								break;
							case 3:
								$total_points+=$attrs['stopTime3'];
								break;
							default:
								break;
						}
						break;
					
					case 'isViewEnd':
						$total_points+=$task_set['isViewEnd'];
						$mai+=$task_set['isViewEnd'];
						break;
					case 'shopBrGoods':
						switch($attrs['lgoods']){
							case 1:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 2:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							case 3:
								$total_points+=$task_set['lgoods']*$attrs['lgoods'];
								break;
							default:
								break;
						}
					default:
						break;
				}
			
			}
			$pointtype=$_POST["point"];
			$need=$_POST['txtMinMPrice']+$_POST['pointExt'];
			if($_POST['isSign']){
				if($_POST['Express']=='1'){
					$need+=$pointtype['qg'];
				}else{
					$need+=$pointtype['qs'];
				}
			}
			$need=sumpoint($_POST['cbxIsSB'],$pointtype['sb'],$need);
			$need=sumpoint($attrs['cbxIsAudit'],$pointtype['sh'],$need);
			$need=sumpoint($attrs['isMobile'],$pointtype['sj'],$need);
			$need=sumpoint($attrs['cbxIsWX'],$pointtype['wx'],$need);
			$need=sumpoint($attrs['cbxIsWW'],$pointtype['ww'],$need);
			$need=sumpoint($attrs['cbxIsLHS'],$pointtype['qrsh'],$need);
			$need=sumpoint($attrs['cbxIsMsg'],$pointtype['hp'],$need);
			$need=sumpoint($attrs['cbxIsAddress'],$pointtype['gdsh'],$need);
			$need=sumpoint($attrs['shopcoller'],$pointtype['gwsc'],$need);
			$need=sumpoint($attrs['isShare'],$pointtype['fx'],$need);
			$need=sumpoint($attrs['pinimage'],$pointtype['jt'],$need);
			switch($attrs['fmaxmc']){
				case 1:$need+=$pointtype['js1'];break;
				case 2:$need+=$pointtype['js2'];break;
				case 3:$need+=$pointtype['js3'];break;
				case 4:$need+=$pointtype['js4'];break;
			}
			switch($attrs['stopTime']){
				case 1:$need+=$pointtype['stop1'];break;
				case 2:$need+=$pointtype['stop2'];break;
				case 3:$need+=$pointtype['stop3'];break;
			}
			switch($attrs['yanchi_state']){
				case 3:$need+=$pointtype['state3'];break;
				case 24:$need+=$pointtype['state24'];break;
			}
			// $need=sumpoint($attrs['fmaxmc1'],$pointtype['js1'],$need);
			// $need=sumpoint($attrs['fmaxmc2'],$pointtype['js2'],$need);
			// $need=sumpoint($attrs['fmaxmc3'],$pointtype['js3'],$need);
			// $need=sumpoint($attrs['fmaxmc4'],$pointtype['js4'],$need);
			// $need=sumpoint($attrs['stopTime1'],$pointtype['stop1'],$need);
			// $need=sumpoint($attrs['stopTime2'],$pointtype['stop2'],$need);
			// $need=sumpoint($attrs['stopTim3'],$pointtype['stop3'],$need);
			// $need=sumpoint($attrs['yanchi_state3'],$pointtype['state3'],$need);
			// $need=sumpoint($attrs['yanchi_state24'],$pointtype['state24'],$need);
			$need=sumpoint($attrs['isReal'],$pointtype['sm'],$need);
			$need=sumpoint($attrs['cbxIsTaoG'],$pointtype['tjb']*($attrs['txtTaoG']/10),$need);
			$need=sumpoint($attrs['cbxIsSetTime1'],$pointtype['ds'],$need);
			$need=sumpoint($attrs['cbxIsSetTime2'],$pointtype['ds'],$need);
			if($attrs['cbxIsFMaxBTSCount']||$attrs['cbxIsFMaxBBC']||$attrs['cbxIsFMinGrade']){
				$need+=$pointtype['gl'];
			}
			// $need=sumpoint($attrs['cbxIsFMinGrade'],$pointtype['gl'],$need);
			$need=sumpoint($attrs['isBuyerFen'],$pointtype['gldj'],$need);
			$need=sumpoint($attrs['isViewEnd'],$pointtype['ll'],$need);
			// pre($need);die;
			
			$template=$attrs['tplTo'];
			$attrs = serialize($attrs);
			$task_other = serialize($task_other);
			$member_point=$db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'");
			$goods_price=$goods_price/$txtFCount;
			$total_points=$need;
			$sb=$_POST['cbxIsSB'];
            if($member_point < $txtFCount*$total_points)
            {
                $onum=intval($member_point/$total_points);
				echo '<script type="text/javascript">alert("您的刷点不足,只能发布此类型任务'.$onum.'次！");history.go(-1);</script>';
				exit;
            }
			else{
				for($i=1;$i<=$txtFCount;$i++){
					if(isset($task_type)&&$task_type>0){
						$iid = '';
						$a = mt_rand(10000000,99999999);
						$c= mt_rand(10000000,99999999);
						$iid = $a.$c;
						//$dataaa[$i] = $iid;
						$aid=$db->getRow('select id from mcs_task_taobao where id='.$iid.' order by id desc');
						if($aid['id']){$iid=$aid['id']+1;}
						$process=0;
						if($wait){$process=5;}
						$stopTimes=$db->getAll("select value from mcs_configs where code='task_stopTime1' or code='task_stopTime2' or code='task_stopTime3'");
						if($addp=$stopTimes[$_POST['attrs']['stopTime']-1]['value']){
							$total_points+=$addp;
						}
						if($_POST['attrs']['cbxIsFMaxBTSCount']==1||$_POST['attrs']['cbxIsFMinGrade']==1||$_POST['attrs']['cbxIsFMaxBBC']==1){
							$total_points+=$db->getRow("select value from mcs_configs where code='task_cbxIsFMinGrade'")['value'];
						}
						if($_POST['attrs']['isBuyerFen']==1){
							$buyer=$db->getAll("select value from mcs_configs where code='task_buyerJifen3' or code='task_buyerJifen11' or code='task_buyerJifen5' or code='task_buyerJifen4' or code='task_buyerJifen1' or code='task_buyerJifen2' or code='task_buyerJifen12' or code='task_buyerJifen13' or code='task_buyerJifen14' or code='task_buyerJifen15' order by id");
								$total_points+=$buyer[$_POST['attrs']['BuyerJifen']-1]['value'];
						}
						$total_points=$need;
						//批量发布任务
						if($_POST['attrs']['txtdelaydate']){
							$show=strtotime($_POST['attrs']['txtdelaydate']);
							for($i=0;$i<$txtFCount;$i++){
								$showtime=$show+$i*$_POST['txtFTime'];
								$iid=number_format($db->getRow("select id from mcs_task_taobao order by id desc")['id']+2, 0, '', '');
								// echo $iid;die;
								$sql="insert into mcs_task_taobao(id,uid,addtime,tmpname,accid,goods_url,goods_price,chssp,cbxIsGJ,cbxIsSB,cbxIsLook,txtMinMPrice,pointExt,ddlOKDay,isNoword,isSign,eqarea,attrs,total_points,task_type,task_other,process,timing,Express,pinimage,needimg,fmingrade,fmaxbbc,fmaxabc,fmaxcredit,fmaxbtsc,showtime,fmaxmc) values('$iid','$uid','".$showtime."','$tmpname','$accid','$goods_url','$goods_price','$chssp','$cbxIsGJ','$sb','$cbxIsLook','$txtMinMPrice','$pointExt','$ddlOKDay','$isNoword','$isSign','$Express','$attrs','$total_points','$task_type','$task_other',$process,$timing,0,'".$_POST['attrs']['pinimage']."','".$_POST['attrs']['needimg']."','".$_POST['attrs']['fmingrade']."','".$_POST['attrs']['fmaxbbc']."','".$_POST['attrs']['fmaxabc']."','".$_POST['attrs']['fmaxcredit']."','".$_POST['attrs']['fmaxbtsc']."','$showtime','$fmaxmc')";
								// echo $sql;continue;
								if($db->Execute($sql)){
									$excuteresult=true;
									$zg=$db->getField('mcs_member_bindacc','nickname','id='.$accid);
									$lx='实物';
									if($ddlOKDay==0){
										$lx='虚拟';
									}
									$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value('$uid','".time()."','$iid','".$zg.",成功发布淘宝".$lx."任务TB".$iid."','发布任务！','logtask')");//日志

									$db->Execute("update mcs_users set pay_money=pay_money-$total_points where user_id='$uid'");

									$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
									$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$total_points).",".$iid.",'刷点日志',".$member_point.",'logpoint')");//日志

									$db->Execute("update mcs_users set user_money=user_money-$goods_price where user_id='$uid'");

									$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
									$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$goods_price).",'存款日志','$member_point','payde')");
								}else{
									$excuteresult=false;
									break;
								}
							}
							if($excuteresult){
								echo '<script type="text/javascript">alert("任务发布成功！");location.href="taobao.php";</script>';
								exit;
							}else{
								echo '<script type="text/javascript">alert("任务发布失败！");location.href="taobao.php";</script>';
								exit;
							}
						}else{
							$show=time();
							for($i=0;$i<$txtFCount;$i++){
								$showtime=$show+$i*$_POST['txtFTime'];
								$iid=number_format($db->getRow("select id from mcs_task_taobao order by id desc")['id']+2, 0, '', '');
								// echo $iid;die;
								$sql="insert into mcs_task_taobao(id,uid,addtime,tmpname,accid,goods_url,goods_price,chssp,cbxIsGJ,cbxIsSB,cbxIsLook,txtMinMPrice,pointExt,ddlOKDay,isNoword,isSign,eqarea,attrs,total_points,task_type,task_other,process,timing,Express,pinimage,needimg,fmingrade,fmaxbbc,fmaxabc,fmaxcredit,fmaxbtsc,showtime,fmaxmc) values('$iid','$uid','".$showtime."','$tmpname','$accid','$goods_url','$goods_price','$chssp','$cbxIsGJ','$sb','$cbxIsLook','$txtMinMPrice','$pointExt','$ddlOKDay','$isNoword','$isSign','$Express','$attrs','$total_points','$task_type','$task_other',$process,$timing,0,'".$_POST['attrs']['pinimage']."','".$_POST['attrs']['needimg']."','".$_POST['attrs']['fmingrade']."','".$_POST['attrs']['fmaxbbc']."','".$_POST['attrs']['fmaxabc']."','".$_POST['attrs']['fmaxcredit']."','".$_POST['attrs']['fmaxbtsc']."','$showtime','$fmaxmc')";
								// echo $sql;continue;
								if($db->Execute($sql)){
									$excuteresult=true;
									$zg=$db->getField('mcs_member_bindacc','nickname','id='.$accid);
									$lx='实物';
									if($ddlOKDay==0){
										$lx='虚拟';
									}
									$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value('$uid','".time()."','$iid','".$zg.",成功发布淘宝".$lx."任务TB".$iid."','发布任务！','logtask')");//日志

									$db->Execute("update mcs_users set pay_money=pay_money-$total_points where user_id='$uid'");

									$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
									$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$total_points).",".$iid.",'刷点日志',".$member_point.",'logpoint')");//日志

									$db->Execute("update mcs_users set user_money=user_money-$goods_price where user_id='$uid'");

									$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
									$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$goods_price).",'存款日志','$member_point','payde')");
								}else{
									$excuteresult=false;
									break;
								}
							}
							if($excuteresult){
								echo '<script type="text/javascript">alert("任务发布成功！");location.href="taobao.php";</script>';
								exit;
							}else{
								echo '<script type="text/javascript">alert("任务发布失败！");location.href="taobao.php";</script>';
								exit;
							}
						}
						$total_points=$need;
						$sql="insert into mcs_task_taobao(id,uid,addtime,tmpname,accid,goods_url,goods_price,chssp,cbxIsGJ,cbxIsSB,cbxIsLook,txtMinMPrice,pointExt,ddlOKDay,isNoword,isSign,eqarea,attrs,total_points,task_type,task_other,process,timing,Express,pinimage,needimg,fmingrade,fmaxbbc,fmaxabc,fmaxcredit,fmaxbtsc,showtime,fmaxmc) values('$iid','$uid','".time()."','$tmpname','$accid','$goods_url','$goods_price','$chssp','$cbxIsGJ','$sb','$cbxIsLook','$txtMinMPrice','$pointExt','$ddlOKDay','$isNoword','$isSign','$Express','$attrs','$total_points','$task_type','$task_other',$process,$timing,0,'".$_POST['attrs']['pinimage']."','".$_POST['attrs']['needimg']."','".$_POST['attrs']['fmingrade']."','".$_POST['attrs']['fmaxbbc']."','".$_POST['attrs']['fmaxabc']."','".$_POST['attrs']['fmaxcredit']."','".$_POST['attrs']['fmaxbtsc']."','$showtime','$fmaxmc')";
						// echo $sql;d ie;
						// pre($sql);die;
						$db->Execute($sql);
						
						$zg=$db->getField('mcs_member_bindacc','nickname','id='.$accid);
						$lx='实物';
						if($ddlOKDay==0){
							$lx='虚拟';
						}
						$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value('$uid','".time()."','$iid','".$zg.",成功发布淘宝".$lx."任务TB".$iid."','发布任务！','logtask')");//日志
						$total_points=$need;
						$db->Execute("update mcs_users set pay_money=pay_money-$total_points where user_id='$uid'");

						$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$total_points).",".$iid.",'刷点日志',".$member_point.",'logpoint')");//日志

						$db->Execute("update mcs_users set user_money=user_money-$goods_price where user_id='$uid'");

						$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','".$zg.",成功发布淘宝".$lx."任务TB".$iid."',".(0-$goods_price).",'存款日志','$member_point','payde')");//日志
					}
				}
				//print_r($dataaa);die;
				$attrs=unserialize($attrs);
				if(isset($attrs['isTpl'])&&isset($attrs['tplTo'])&&!empty($attrs['tplTo'])){
					//可保存模板数
					$m=$db->getCount("mcs_task_template","uid=$uinfo[user_id] and tem_type='tb'");
					if($m>=$uinfo['params']['kbcmbsl']){
						$a="您是".$uinfo['rank_name']."会员，最多只能绑定".$uinfo['params']['kbcmbsl']."个模板！";
						echo '<script type="text/javascript">alert("'.$a.'");</script>';
						exit;
					}
					$attrs=serialize($_POST);
					$sql="insert into mcs_task_template(uid,name,value,type,tem_type) value('$uid','$template','$attrs','$mod','tb')";
					$db->Execute($sql);
					echo '<script type="text/javascript">alert("模板保存成功！");</script>';
				}
				echo '<script type="text/javascript">alert("任务发布成功！");location.href="taobao.php";</script>';
				exit;
			} 
        }


		$date =  $db->getAll("select * from mcs_task_template where uid={$uinfo[user_id]} and type='$mod' and tem_type='tb'");
		$view->assign('date', $date);

		$member_point = $uinfo['pay_money'];

		
        $accs = $db->getAll("select * from mcs_member_bindacc join mcs_users on mcs_member_bindacc.uid=mcs_users.user_id where uid={$uinfo[user_id]} and acc_type='tb' and buyno = 1");
        if(!$accs[0]["send_address"]){
        	$accs[0]["send_address"]="0";
        }
		$view->assign('accs', $accs);
		// pre($task_set);die;
        $view->display('taobao/addtask');
        break;
	
	case 'verification'://淘宝商品地址与掌柜验证
		$data['ok']=false;
		$accid = intval($_REQUEST['accid']);
		$goodsurl = trim($_REQUEST['goodsurl']);
		$content=iconv('gbk','utf-8',file_get_contents($goodsurl));
		$manager=$db->getField("mcs_member_bindacc","nickname","id=$accid");
		preg_match_all('/<a\s+class="tb-seller-name".*title="(.*)">/iU', $content, $arr);
		/*if($arr[1][0]==''){
			//<a class="shop-name-link" href="//shop135365134.taobao.com?spm=2013.1.0.0.J8UtKX" target="_blank" data-goldlog-id="/tbwmdd.1.044" data-spm-anchor-id="2013.1.0.0">东麒新商城</a>
			preg_match_all('/<a class="shop-name-link".*?>(.*?)<\/a>/iU',$content,$arr);
		}*/
		$arr[1][0]=str_replace('掌柜:','',$arr[1][0]);
		if($arr[1][0]==$manager){
			$data['ok']=true;
		}else{
			$data['info']="淘宝地址对应的掌柜名与您所选的掌柜不一致~";
		}
		echo json_encode($data);
		exit;
	break;

	case 'task_cancel'://退出任务
		$id=trim($_REQUEST['task_id']);
		if($id){
			$cancel=$db->getRow("select * from mcs_task_taobao where uid=$uinfo[user_id] and appeal=0 and id=$id");
			if($cancel['process']>0&&$cancel['process']<5){
				$data['info']="当前状态下不可取消！";
				$data['ok']="false";
			}else{
				
				$uid=$uinfo[user_id];
				$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value($uid,".time().",".$cancel['id'].",'取消任务TB".$cancel['id']."，退还".$cancel['total_points']."刷点','取消任务！','logtask')");//日志
				

				$total_points=$cancel['total_points']-$_CFG['task_cancel'];
				$db->Execute("update mcs_users set pay_money=pay_money+$total_points where user_id='$uid'");

				$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
				$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'取消任务TB".$cancel['id']."，扣除".$_CFG['task_cancel']."刷点，返还".$total_points."刷点',".$total_points.",".$cancel['id'].",'刷点日志',".$member_point.",'logpoint')");//日志

				$db->Execute("update mcs_users set user_money=user_money+$cancel[goods_price] where user_id='$uid'");

				$member_point=$db->getField('mcs_users', 'user_money', "user_id='$uinfo[user_id]'");
				$db->Execute("insert into mcs_member_logs(uid,createtime,info,user_money,logtype,num,type) value('$uid','".time()."','取消任务TB".$cancel['id']."退还金额".$cancel['goods_price']."',".$cancel['goods_price'].",'存款日志','$member_point','payde')");//日志
				$db->Execute("delete from mcs_task_taobao where uid=$uinfo[user_id] and id=$id");
				$data['info']="取消成功！";
				$data['ok']="true";
			}
			
		}
		$data['info']=$data['info'];
		$data['ok']=$data['ok'];
		echo json_encode($data);
		exit;
		
		
	break;

	case 'task_addpay'://追加刷点
		$id=trim($_REQUEST['task_id']);
		$point=intval($_REQUEST['point']);
		if($id){
			$cancel=$db->getRow("select * from mcs_task_taobao where uid=$uinfo[user_id] and appeal=0 and id=$id");
			if($cancel['process']>0&&$cancel['process']<5){
				$data['info']="当前状态下不可加刷点！";
				$data['ok']="false";
			}else{
				if($point>$uinfo['pay_money']){
					$data['info']="您的刷点不足以此次追加！";
					$data['ok']="false";
				}else{ 
					if($point>0&&$point<20){
						$uid=$uinfo['user_id'];
						$db->Execute("update mcs_task_taobao set pointExt=pointExt+$point,total_points=total_points+$point,timing=0 where uid=$uinfo[user_id] and id=$id");

						$db->Execute("insert into mcs_member_logs(uid,createtime,taskid,info,logtype,type) value($uid,".time().",".$cancel['id'].",'对任务TB".$cancel['id']."，追加".$point."刷点','修改任务！','logtask')");//日志

						$db->Execute("update mcs_users set pay_money=pay_money-$point where user_id='$uid'");

						$member_point=floatval($db->getField('mcs_users', 'pay_money', "user_id='$uinfo[user_id]'"));
						$db->Execute("insert into mcs_member_logs(uid,createtime,info,pay_point,taskid,logtype,num,type) value($uinfo[user_id],".time().",'修改任务TB".$cancel['id']."，追加".$point."刷点',".$point.",".$cancel['id'].",'刷点日志',".$member_point.",'logpoint')");//日志

						$data['info']="追加成功！";
						$data['ok']="true";
					}else{
						$data['info']="追加数量不正确！";
						$data['ok']="false";
					}
				}
			}
		}
		$data['info']=$data['info'];
		$data['ok']=$data['ok'];
		echo json_encode($data);
		exit;
	break;

	case 'photourl'://店铺链接位置截图
		if($_SERVER['REQUEST_METHOD']=="POST"){
			if(isset($_FILES['file'])&&$_FILES['error']==0&&$_FILES['file']['size']>0){
				$picname = $_FILES['file']['name'];
				$picsize = $_FILES['file']['size'];
				$old=$_POST['PhotoUrl'];
				if ($picname != "") {
					if ($picsize > 1024000) {
						echo '图片大小不能超过1M';
						exit;
					}
					$type = strtolower(strstr($picname, '.'));
					if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
						echo '图片格式不对！';
						exit;
					}
					$rand = rand(100, 999);
					$pics = date("YmdHis") . $rand . $type;
					$pic_path = $_SERVER['DOCUMENT_ROOT']."/uploads/task/". $pics;
					move_uploaded_file($_FILES['file']['tmp_name'],$pic_path);
					$img='/uploads/task/'.$pics;
					if($old){
						@unlink($_SERVER['DOCUMENT_ROOT'].$old);
					}
				}
				$arr = array('pic'=>$img);
				echo json_encode($arr);exit;
			}else{
				switch($_FILES['file']['error']) {   
					case 1: 
						echo '文件大小超出了服务器的空间大小';exit;
					break;    
					case 2:
						echo '要上传的文件大小超出浏览器限制';exit; 
					break;    
				   
					case 3:
						echo '文件仅部分被上传';exit;   
						break;    
				   
					case 4:
						echo '没有找到要上传的文件';exit;    
						break;    
				   
					case 5:
						echo '服务器临时文件夹丢失';exit;   
						break;    
				   
					case 6:
						echo '文件写入到临时文件夹出错';exit;
						break;    
				}
			}
		}
		exit;
	break;
	case 'shopurl'://来路任务验证商品地址
		$url=trim($_GET['url']);
		$id=trim($_GET['id']);
		if($id){
			$goods_url=$db->getField("mcs_task_taobao a,mcs_member_bindacc b","a.goods_url","a.process=0 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb' and a.id=".$id);
			if($goods_url){
				if($goods_url==$url){
					$finish=$db->getField("mcs_task_taobao a,mcs_member_bindacc b","a.finish","a.process=0 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb' and a.id=".$id);
					$finish=unserialize($finish);
					$finish['goods_url']=$goods_url;
					$finish=serialize($finish);
					$db->Execute("update mcs_task_taobao set finish='".$finish."' where id=".$id);
					$arr['info']='商品地址验证成功！';
				}else{
					$arr['error']='您输入的商品地址有误，请重新查看发布方给出的提醒找到宝贝地址进行验证。<br>如果来路地址有误，请联系发布方QQ沟通，或者联系平台客服。';
				}
			}else{
				$arr['error']='任务不存在！';
			}
			echo json_encode($arr);exit;
		}
		exit;
		
	break;
	case 'istrueurl':
		$sql="select id from mcs_task_taobao where id=".$_POST['id']." and goods_url='".$_POST['data']."'";
		if($db->getRow($sql)){
			// $db->Execute("update ");
			echo "1";
		}else{
			echo "0";
		}
		break;
	case 'jt'://店内浏览其他商品
		$shopBrGoods=trim($_GET['shopBrGoods']);
		$id=trim($_GET['id']);
		$arr['error']=$id;
		echo json_encode($arr);exit;
		if($id){
			$id=$db->getField("mcs_task_taobao a,mcs_member_bindacc b","a.id","a.process=0 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb' and a.id=".$id);
			if($id){
				if($shopBrGoods){
					$shopBrGoods=$shopBrGoods;
					if($shopBrGoods){
						$finish=$db->getField("mcs_task_taobao a,mcs_member_bindacc b","a.finish","a.process=0 and a.uid!=$uinfo[user_id] and a.get_user=b.id and b.uid=$uinfo[user_id] and b.acc_type='tb' and a.id=".$id);
						$finish=unserialize($finish);
						$finish['shopBrGoods']=$shopBrGoods;
						$finish=serialize($finish);
						if($db->Execute("update mcs_task_taobao set finish='".$finish."' where id=".$id)){
							$arr['info']='验证通过，请付款！';
						}
					}
				}else{
					$arr['error']='此任务需要额外上传该店内其他商品的截图，才能验证地址！';
				}
			}else{
				$arr['error']='任务不存在！';
			}
			echo json_encode($arr);exit;
		}
		exit;
		
	break;

	case 'taskTemplate':
		$list=$db->getAll('select * from mcs_task_template where uid='.$uinfo['user_id'].' and tem_type="tb"');
	    if(count($list)){
			foreach($list as $k => $v){
				$list[$k]['value']=unserialize($v['value']);
				if($list[$k]['value']['accid']){
					$list[$k]['value']['nickname']=$db->getField('mcs_member_bindacc','nickname','uid='.$uinfo['user_id'].' and acc_type="tb"');
				}
				if($list[$k]['value']['ddlOKDay']){
					$list[$k]['value']['ddlOKDays']=$list[$k]['value']['ddlOKDay']*24;
				}
				
			}
		}
		$view->assign('list', $list);
		$view->display('taobao/taskTemplate');
	break;
	
	case 'showweixin':
		$view->assign('model_type','weixin');
		$view->display('taobao/weixinindex');
	break;
	case 'getweixintask':
		$t_type=isset($_REQUEST['t_type'])?trim($_REQUEST['t_type']):'';//任务类型
		//$search=isset($_REQUEST['search'])?trim($_REQUEST['search']):0;
				//任务编号搜索
		if($_REQUEST['search']){
			$searchs = $_REQUEST['search'];
			//配置模糊查询条件
			$search = "'%".$searchs."%'";
			$sql.=" and a.id like ".$search;
		}
		if($_REQUEST['search'] == 0){
			$searchs = $_REQUEST['search'];
			$search = "'%".$searchs."%'";
			$sql.=" and a.id like ".$search;;
		}
		//任务编号搜索
		$sp=isset($_REQUEST['sp'])?intval($_REQUEST['sp']):0;
		$ep=isset($_REQUEST['ep'])?intval($_REQUEST['ep']):0;
		$sql="select a.*,b.user_name as add_user,b.rank_points,b.user_rank,c.special,c.rank_name from mcs_task_taobao a,mcs_users b,mcs_user_rank c where a.get_user=0 and a.appeal=0 and a.uid=b.user_id and b.user_rank=c.rank_id and a.process=0 and ((a.timing<".time()." and a.showtime=0) or (a.showtime>0 and a.showtime<".time().")) and task_type=10 and a.id like" .$search;
		
		
		if($t_type){
			switch($t_type){
				case 'virtual'://虚拟任务
					$sql.=" and a.ddlOKDay=0";
				break;
				case 'entity'://实物任务
					$sql.=" and a.ddlOKDay>0";
				break;
			}
		}
		if($sp){$sql.=" and a.goods_price>=$sp";}
		if($ep){$sql.=" and a.goods_price<=$ep";}
		//if($search){
		//	$sql.=" and a.id like % 2396720980553705%";
		//}
		// $
		$order=isset($_REQUEST['order'])?trim($_REQUEST['order']):'a.addtime';
		$desc=isset($_REQUEST['desc'])?trim($_REQUEST['desc']):'desc';
		$sql .=" order by {$order} {$desc},c.rank_id desc,c.rwpmkq desc";
		$array=$db->pagestrs($sql,16,16,'getweixinTask');
		
		/*排序部分*/
		foreach ($array['record'] as $v){
			$arr[$v['goods_price']][]=$v;
		}
		krsort($arr);$array2=array();
		foreach($arr as $v){
			$array2=array_merge($array2,$v);
		}
		$array['record']=$array2;
		/*排序部分*/
		$lists=$array['record'];
		foreach($lists as $key => $val){
			$lists[$key]['addtime']=date('H:i:s',$val['addtime']);
			$lists[$key]['attrs']=unserialize($val['attrs']);
			$lists[$key]['task_other']=unserialize($val['task_other']);
			switch($val['task_type']){
				case 1:
					if($val['ddlOKDay']<2){$lists[$key]['task_types']=5;}
					if($val['ddlOKDay']>1){$lists[$key]['task_types']=6;}
					if($val['isSign']==1){$lists[$key]['task_types']=1;}
				break;
				case 2:
					$lists[$key]['task_types']=4;
				break;
				case 3:
					$lists[$key]['task_types']=3;
				break;
				case 4:
					$lists[$key]['task_types']=2;
				break;
				case 5:
					$lists[$key]['task_types']=1;
				break;
			}
			foreach($lists[$key]['task_other']['shopAll'] as $vals)
			{
				$lists[$key]['cbhp']+=$vals['cbhp'];
			
			}
		}

		$page=$array['pagestr'];
		// pre($page);die;
		$view->assign('lists', $lists);
		$view->assign('page', $page);
		$view->display('taobao/weixinindexTasklist');
		break;
	break;
	case 'del_taskTemplate':
		$id=trim($_GET['id']);
	    $arr['str']='任务不存在！';
		$arr['state']=false;
		if($id){
			$info=$db->getField('mcs_task_template','id','uid='.$uinfo['user_id'].' and tem_type="tb" and id='.$id);
			if(!empty($info)){
				if($db->Execute('delete from mcs_task_template where uid='.$uinfo['user_id'].' and tem_type="tb" and id='.$id)){
					$arr['state']=true;
				}
			}
			
		}
		echo json_encode($arr);exit;
	break;

	default:
	
		$view->display('taobao/index');
	break;
}
function sumpoint($type,$content,$num){
	if($type){
		$num+=$content;
	}
	return $num;
}
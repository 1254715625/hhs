<?php
require 'mcscore/init.php';

if(intval($_SESSION['user_id'])==0){
	setcookie('safepass','',time()-1);
	Redirect('user.php?act=login');
}
$view->assign('model_type', 'single');

$mod=$_REQUEST['mod']?$_REQUEST['mod']:'single';

switch($mod){
	case 'search':
		$data['info']='访问出错~';
		$data['state']=false;
		if(IS_POST&&IS_AJAX){
			$id=intval($_POST['data']);
			if($id){
				$info=$db->getRow('select eid,wl from mcs_task_express where eid!="" and wl!="" and type=0 and num>0 and used<num and id='.$id);
				if($info['eid']){
					$AppKey='c22f356f0041e1f8';
					$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.trim($info['wl']).'&nu='.trim($info['eid']).'&show=2&muti=1&order=asc';
					 $curl = curl_init();
					  curl_setopt ($curl, CURLOPT_URL, $url);
					  curl_setopt ($curl, CURLOPT_HEADER,0);
					  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
					  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
					  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
					  $data['state']=true;
					  $data['info'] = curl_exec($curl).'查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';;
					  curl_close ($curl);
				}else{
					$data['info']='抱歉，您查询的快递不存在~';
				}
			}else{
				$data['info']='抱歉，您查询的快递不存在~';
			}
		}
		echo json_encode($data);
		exit;
	break;

	case 'single':
		$num=0;
		$today_num=$db->getCount('mcs_task_express_user','uid='.$uinfo['user_id'].' and pay_time>='.strtotime(date('Y-m-d')));
		if($uinfo['params']['mfkddh']>0&&$uinfo['params']['mfkddh']>$today_num){
			$num=$uinfo['params']['mfkddh']-$today_num;
		}
		$view->assign('num', $num);


		$where='type=0 and num>0 and used<num and id not in(select eid from mcs_task_express_user where uid='.$uinfo['user_id'].')';
		if(IS_POST&&$_POST['search']==1){
			$send=trim($_POST['send']);
			$to=trim($_POST['to']);
			$etime=trim($_POST['etime']);
			
			if($send){
				$where.=' and send_add like \'%'.$send.'%\'';
				$view->assign('send', $send);
			}
			if(!empty($to)){
				$where.=' and to_add like \'%'.$to.'%\'';
				$view->assign('to', $to);
			}
		}
		if(IS_POST&&IS_AJAX){
			$id=intval($_POST['express']);
			if($id){
				$express=$db->getRow('select * from mcs_task_express where type=0 and num>0 and used<num and id='.$id);
				if(empty($express['id'])){
					$data['info']='快递单不存在~';
					
				}elseif($db->getCount('mcs_task_express_user','uid='.$uinfo['user_id'].' and eid='.$id)){
					$data['info']='抱歉，此快递单已购买~';
				}else{
					if($num){
						if($db->Execute('update mcs_task_express set used=used+1 where id='.$express['id'])){
							$db->Execute('insert into mcs_task_express_user(uid,pay_time,eid) value('.$uinfo['user_id'].','.time().',"'.$express['id'].'")');
							$data['info']='购买成功~';
							$data['state']=true;
						}else{
							$data['info']='购买失败~';
						}
					}else{
						if($uinfo['user_money']>=$uinfo['params']['kddhgm']){
							$user_money = $uinfo['user_money']-$uinfo['params']['kddhgm'];
							$db->Execute('update mcs_users set user_money=user_money-'.$uinfo['params']['kddhgm'].' where user_id='.$uinfo['user_id']);
							$db->Execute("insert into mcs_member_logs(uid, createtime, user_money, info, taskid, logtype, num, type) value('{$uinfo['user_id']}','".time()."', -".$uinfo['params']['kddhgm'].",'购买快递单号', '".$send."','存款日志',".$user_money.",'payde')");

							$db->Execute('update mcs_task_express set used=used+1 where id='.$express['id']);
							$db->Execute('insert into mcs_task_express_user(uid,pay_time,eid) value('.$uinfo['user_id'].','.time().',"'.$express['id'].'")');
							$data['info']='购买成功~';
							$data['state']=true;
						}else{
							$data['info']='余额不足~';
						}
					}
				}
			}else{
				$data['info']='访问出错~';
			}
			echo json_encode($data);
			exit;
		}
		$sql='select * from mcs_task_express where '.$where.' order by addtime desc,id desc';
		$list = $db->page($sql,12,4);
		if(count($list['record'])){
			foreach($list['record'] as $k => $v){
				$n=strlen($v['eid']);
				if($n>0){
					if($n<5){
						$list['record'][$k]['eid']=substr_replace($v['eid'],str($n-1),1);
					}else{
						$list['record'][$k]['eid']=substr_replace($v['eid'],str($n-1),2,$n-3);
					}
				}
				$list['record'][$k]['send_adds']=cnsubstr($v['send_add'],22);
				$list['record'][$k]['to_adds']=cnsubstr($v['to_add'],22);
			}
		}
		
		$view->assign('list', $list);
		$view->assign('listnum',count($list['record'] ));
	break;

	case 'bag':
		$default_express=intval($db->getField('mcs_express','id','state=1 and id='.intval($uinfo['default_express'])));
		if($default_express){
			$express=$db->getAll('select * from mcs_express where state=1 and id!='.$default_express.' order by shownum asc,id asc');
			$mr=$db->getRow('select * from mcs_express where state=1 and id='.$default_express);
			array_unshift($express,$mr);
		}else{
			$express=$db->getAll('select * from mcs_express where state=1 order by shownum asc,id asc');
		}
		
		
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			$act=trim($_GET['act']);
			switch($act){
				case 'set_default':
					$did=intval($_POST['did']);
					if($did){
						if($did==intval($mr['id'])){
							$data['info']='您当前已设置 <font color="green">'.$mr['title'].'</font> 为默认快递~';
						}else{
							$info=$db->getRow('select title,id from mcs_express where state=1 and id='.$did);
							if($info['id']){
								if($db->Execute('update mcs_users set default_express='.$info['id'].' where user_id='.$uinfo['user_id'])){
									$data['info']='您当前已设置 <font color="green">'.$info['title'].'</font> 为默认快递~';
									$data['state']=true;
									$data['mr']='<span id="onwo">已设置默认快递：</span><span id="woyo">您当前已设置 <font color="green">'.$info['title'].'</font> 为默认快递</span>';
								}else{
									$data['info']='很抱歉，设置失败~';
								}
							}else{
								$data['info']='亲，您选择的快递不存在或已暂停使用~';
							}
						}
					}
				break;
				case 'add_default':
					$did=intval($_POST['did']);
					$data['info']='设置失败~';
					if($did){
						if($db->Execute('update mcs_member_address set state=0 where uid='.$uinfo['user_id'].' and state=1')){
							if($db->Execute('update mcs_member_address set state=1 where uid='.$uinfo['user_id'].' and id='.$did)){
								$data['info']='设置成功~';
							}
						}
					}
				break;

				case 'submit':
					$express=intval($_POST['express']);
					$address=trim($_POST['address']);
					$express=$db->getField('mcs_express','title','state=1 and id='.$express);
					if($uinfo['user_money']<$uinfo['params']['zsdhgm']){
						$data['info']='余额不足~';
					}elseif(empty($express)){
						$data['info']='该快递不存在~';
					}else{
						if(empty($address)){
							$data['info']='收货地址不能为空~';
						}else{
							$data['info']='提交失败~';
							if($db->Execute('insert into mcs_task_express(uid,addtime,wl,to_add,type) values("'.$uinfo['user_id'].'","'.time().'","'.$express.'","'.$address.'",1)')){
								if($db->Execute('update mcs_users set user_money=user_money-'.$uinfo['params']['zsdhgm'].' where user_id='.$uinfo['user_id'])){
									$user_money = $uinfo['user_money']-$uinfo['params']['zsdhgm'];
									$db->Execute("insert into mcs_member_logs(uid, createtime, user_money, info, logtype, num, type) value('{$uinfo['user_id']}','".time()."', -".$uinfo['params']['zsdhgm'].",'提交真实快递','存款日志',".$user_money.",'payde')");
									$data['info']='提交成功~';
									$data['state']=true;
								}
							}
						}
					}
				break;
			}
			echo json_encode($data);
			exit;
		}
		
		
		$address=$db->getAll('select * from mcs_member_address where uid='.$uinfo['user_id'].' order by state desc,id desc');
		$view->assign('default_express', $default_express);
		$view->assign('express', $express);
		$view->assign('address', $address);
	break;

	case 'deliver':
		$deliver_num=15;
		$del=intval($_GET['del']);
		$m=intval($_GET['m']);
		if($del){
			$db->Execute('delete from mcs_member_address where uid='.$uinfo['user_id'].' and id='.$del);
		}
		if($m){
			$db->Execute('update mcs_member_address set state=0 where uid='.$uinfo['user_id'].' and state=1');
			$db->Execute('update mcs_member_address set state=1 where uid='.$uinfo['user_id'].' and id='.$m);
		}
		$list=$db->getAll('select * from mcs_member_address where uid='.$uinfo['user_id'].' order by state desc,id desc');
		$list_num=count($list);
		if(IS_POST&&IS_AJAX){
			$data['info']='访问出错~';
			$act=trim($_GET['act']);
			switch($act){
				case 'address':
					$user=trim($_POST['user']);
					$address=trim($_POST['address']);
					$zipcode=intval($_POST['zipcode']);
					$phone=trim($_POST['phone']);
					if(empty($user)){
						$data['info']='联系人不能为空~';
						$data['obj']='user';
					}elseif(empty($address)){
						$data['info']='发货地址不能为空~';
						$data['obj']='address';
					}elseif(!preg_match("/^[1-9][0-9]{5}$/i",$zipcode)){
						$data['info']='邮编格式不正确~';
						$data['obj']='zipcode';
					}elseif(!preg_match("/^1(3|4|5|7|8)\d{9}$/i",$phone)){
						$data['info']='手机号码格式不正确~';
						$data['obj']='phone';
					}else{
						$has=$db->getCount('mcs_member_address','user="'.$user.'" and address="'.$address.'" and zipcode="'.$zipcode.'" and phone="'.$phone.'" and uid='.$uinfo['user_id']);
						if($has){
							$data['info']='请不要重复添加~';
						}else{
							if($list_num>$deliver_num){
								$data['info']='您的发货地址已达到上限，请先删除~';
							}else{
								if($db->Execute('insert into mcs_member_address(uid,user,address,zipcode,phone) values('.$uinfo['user_id'].',"'.$user.'","'.$address.'",'.$zipcode.','.$phone.')')){
									$data['info']='添加成功~';
									$data['state']=true;
								}
							}
						}
					}
				break;
			}
			echo json_encode($data);
			exit;
		}
		$view->assign('list', $list);
		$view->assign('deliver_num', $deliver_num);

	break;

	case 'wait':
		$sql='select * from mcs_task_express where type=1 and uid='.$uinfo['user_id'].' and status=0 order by addtime desc,id desc';
		$list = $db->page($sql,12,4);
		if(count($list['record'])){
			foreach($list['record'] as $k => $v){
				$list['record'][$k]['addtime']=date('Y-m-d H:i',$v['addtime']);
			}
		}
		$view->assign('list', $list);
	break;

	case 'already':
		$sql='select * from mcs_task_express where type=1 and uid='.$uinfo['user_id'].' and status=1 order by addtime desc,id desc';
		$list = $db->page($sql,12,4);
		if(count($list['record'])){
			foreach($list['record'] as $k => $v){
				$list['record'][$k]['addtime']=date('Y-m-d H:i',$v['addtime']);
			}
		}
		$view->assign('list', $list);
	break;
	
	case 'kuaidi':
		$kuaidi=$_GET['kd'];
		$eid=$_GET['eid'];
		$result=header("location:/api/kuaidi100/get.php?com=".$kuaidi."&nu=".$eid." ");
		var_dump($result);
	break;

	case 'apply':
		//引入转换类
		require_once "/api/kuaidi100/zhuanhuan.php";
		$ajax=new ajax();
		
		
		if(IS_POST&&IS_AJAX){
			$data['info']='底单申请失败~';
			if($uinfo['user_money']<$uinfo['params']['ddgm']){
				$data['info']='余额不足~';
			}else{
				$sid=intval($_POST['sid']);
				$type=$db->getRow('select * from mcs_task_express where status=1 and id='.$sid);
				if($type['id']){
					if($type['type']==1&&$type['uid']==$uinfo['user_id']){
						$db->Execute('update mcs_task_express set apply=1 where status=1 and apply=0 and uid='.$uinfo['user_id'].' and id='.$type['id']);
					}elseif($type['type']==0){
						$db->Execute('update mcs_task_express_user set apply=1 where apply=0 and uid='.$uinfo['user_id'].' and eid='.$type['id']);
					}
					$user_money = $uinfo['user_money']-$uinfo['params']['ddgm'];
					$db->Execute('update mcs_users set user_money=user_money-'.$uinfo['params']['ddgm'].' where user_id='.$uinfo['user_id']);
					$db->Execute('insert into mcs_member_logs(uid, createtime, user_money, info, taskid, logtype, num, type) value('.$uinfo['user_id'].','.time().', -'.$uinfo['params']['ddgm'].',"购买底单", '.$type['id'].',"存款日志",'.$user_money.',"payde")');
					$data['info']='底单申请成功，请等待上传底图~';
					$data['state']=true;
				}else{
					$data['info']='抱歉，您要申请的底单不存在~';
				}
			}
			echo json_encode($data);
			exit;
		}
		$sql='select * from mcs_task_express where (type=1 and uid='.$uinfo['user_id'].') or (type=0 and id in (select eid from mcs_task_express_user where uid='.$uinfo['user_id'].')) order by addtime desc,id desc';
		$list = $db->page($sql,12,4);
		if(count($list['record'])){
			foreach($list['record'] as $k => $v){
				$list['record'][$k]['send_adds']=cnsubstr($v['send_add'],30);
				$list['record'][$k]['to_adds']=cnsubstr($v['to_add'],30);
				$list['record'][$k]['addtime']=date('y-m-d H时',$v['addtime']);
				$list['record'][$k]['types']=$v['type']==1?'<font color="green">真实快递</font>':'<font color="blue">虚拟快递</font>';
				
				$list['record'][$k]['kd']=$ajax->check_encodeAction($v['wl']);
				
				if($v['type']==0){
					$u=$db->getRow('select apply,pic,info from mcs_task_express_user where uid='.$uinfo['user_id'].' and eid='.$v['id']);
					$v['apply']=$u['apply'];
					$v['pic']=$u['pic'];
					$v['info']=$u['info'];
				}
				if($v['apply']){
					if(!empty($v['info'])){
						$list['record'][$k]['todo']='<a class="btn_jc gm jj" style="color:red" data="'.$v['info'].'">已拒绝</a>';
					}elseif(empty($v['pic'])){
						$list['record'][$k]['todo']='<a class="btn_jc gm" style="color:#ffcc66">底单申请中</a>';
					}else{
						$list['record'][$k]['todo']='<a class="btn_jc gm see" pic="uploads/express/'.$v['pic'].'" style="#99ff66">查看底单</a>';
					}
				}else{
					$list['record'][$k]['todo']='<a class="btn_jc gm send" data="'.$v['id'].'">申请底单</a>';
				}
				if($v['type']==1){
					if($v['status']==0){
						$list['record'][$k]['todo']='<a class="btn_jc gm">等待发货</a>';
					}else{
						//$list['record'][$k]['todo']='<a class="btn_jc gm">已发货</a>';
					}
				}
				
			}
		}
		//var_dump($list);
		$view->assign('list', $list);
	break;
}

$font_size=$db->getField('mcs_configs','value',"code = 'font_size' ");
$view->assign('font_size',$font_size);
$view->assign('mod', $mod);
// die;
$view->display('single/index');

function str($num){
	$num=intval($num);
	$str='';
	if($num){
		for($i=0;$i<$num;$i++){
			$str.='*';
		}
	}
	return $str;
}
?>
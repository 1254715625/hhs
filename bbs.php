<?php
require 'mcscore/init.php';

switch($action)
{
	case 'collection':
		if(IS_POST&&IS_AJAX){
			$data['str']='收藏失败~';
			if($uinfo['user_id']>0){
				$id=intval($_POST['id']);
				if($id>0){
					$form=$db->getField('mcs_forum_post','id','pid=0 and id='.$id);
					if($form>0){
						$has=$db->getField('mcs_user_collection','id','uid='.$uinfo['user_id'].' and fid='.$id);
						if($has>0){
							$data['str']='您已收藏~';
						}else{
							$sql = 'insert into mcs_user_collection(uid,fid) values('.$uinfo['user_id'].','.$id.')';
							$db->Execute($sql);
							$data['str']='收藏成功~';
						}
					}else{
						$data['str']='抱歉，您要收藏的帖子不存在~';
					}
				}
			}else{
				$data['str']='请先登录~';
				$data['url']='user.php?act=login';
			}
		}
		echo json_encode($data);exit;
	break;

    case 'search':
        $keys = isset($_GET['keys']) ? trim($_GET['keys']) : '';
        $sql = "select user_name, user_id, p.id, fid, title, forum_name, views, (select count(*) from mcs_forum_post where pid=p.id) as reply, p.add_time from mcs_users u, mcs_forum_post p, mcs_forum f where u.user_id=p.uid and p.fid=f.id and title like '%$keys%' and pid=0 order by id desc";
        $list = $db->pageStr($sql);

        foreach($list['record'] as $key => $val)
        {
            $val['add_time'] = date("Y-m-d", $val['add_time']);
            $list['record'][$key] = $val;
        }
        $view->assign('list', $list);

        $view->display('bbs/search');
        break;

    case 'post':
        if(empty($_SESSION['user_id'])) Redirect('user.php?act=login');
        $fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;
		
        $cur_forum = $db->getRow("select * from mcs_forum where id=$fid");
        if(!$cur_forum) Redirect('bbs.php');
        if(IS_POST)
        {
			if($fid == 1  ){
				if($uinfo['bbs'] == 1 || $_COOKIE['auth'] == 1){
					$title = trim($_POST['title']);
					$message = $_POST['message'];
					if(empty($title) || empty($message)) jsMessage("请完整的输入帖子信息");

					$sql = "insert into mcs_forum_post(fid, title, uid, add_time, content) values('$fid', '$title', '{$_SESSION['user_id']}', '". time() ."', '$message')";

					$db->Execute($sql);

					if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
						$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_post'].',pay_points=pay_points+'.$_CFG['integral_post'].',bbs_upper=bbs_upper+'.$_CFG['integral_post'].' where user_id='.$uinfo['user_id']);
						$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$_CFG['integral_post'])."','论坛积分','积分日志',".$_CFG['integral_post'].",'logcredit')");//积分日志
					}
					Redirect('?act=list&fid='. $fid);
				}else{
					JSMessage('没有权限');
				}
			}else{
				
				$title = trim($_POST['title']);
				$message = $_POST['message'];
				if(empty($title) || empty($message)) jsMessage("请完整的输入帖子信息");

				$sql = "insert into mcs_forum_post(fid, title, uid, add_time, content) values('$fid', '$title', '{$_SESSION['user_id']}', '". time() ."', '$message')";

				$db->Execute($sql);
				
				/* 原来的
					if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
					$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_post'].',pay_points=pay_points+'.$_CFG['integral_post'].',bbs_upper=bbs_upper+'.$_CFG['integral_post'].' where user_id='.$uinfo['user_id']);
					$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$_CFG['integral_post'])."','论坛积分','积分日志',".$_CFG['integral_post'].",'logcredit')");//积分日志
					}
					Redirect('?act=list&fid='. $fid);
					*/
				
				
				//发帖双倍积分 --
				$rank=$db->getField('mcs_configs','value',"code ='integral_post' ");
				$sta=$db->getAll("select * from mcs_card where uid = '".$uinfo['user_id']."' and endtime > '".time()."' ");
				if($sta){
					$rank=($rank*2);
					if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
					$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.',bbs_upper=bbs_upper+'.$rank.' where user_id='.$uinfo['user_id']);
					$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','论坛积分','积分日志',".$rank.",'logcredit')");//积分日志
					}
					Redirect('?act=list&fid='. $fid);
					
				}else{
					if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
					$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.',bbs_upper=bbs_upper+'.$rank.' where user_id='.$uinfo['user_id']);
					$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','论坛积分','积分日志',".$rank.",'logcredit')");//积分日志
					}
					Redirect('?act=list&fid='. $fid);
				}
				//--！
				
			}
			
            
        }

        $forum = $db->getAll("select * from mcs_forum order by sorting asc");
        $view->assign('forum', $forum);
        
        $view->assign('cur_forum', $cur_forum);

        $view->display('bbs/post');
        break;

    case 'view':
		
        $tid = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $sql = "select p.*, user_name,user_rank,rank_expiry,headimg, user_id, forum_name, (select count(*) from mcs_forum_post where pid=p.id) as reply, p.add_time from mcs_users u, mcs_forum_post p, mcs_forum f where u.user_id=p.uid and p.fid=f.id and  pid=0 and p.id=$tid";
        $subject = $db->getRow($sql);
        if(!$subject) Redirect('bbs.php');
        $subject['add_time'] = date("Y-m-d H:i", $subject['add_time']);

		if($subject['user_rank'] && $subject['rank_expiry'] > time()){
			$rank = $db->getRow("select rank_name from mcs_user_rank where rank_id='{$subject['user_rank']}'");
			$subject['rank_name'] = $rank['rank_name'];
		}else{
			$rank = $db->getRow("select rank_name from mcs_user_rank where min_points<='{$subject['rank_points']}' and '{$subject['rank_points']}'<=max_points order by max_points desc");
			$subject['rank_name'] = $rank['rank_name'];
		}
		
        if(IS_POST){
            if(empty($_SESSION['user_id'])) Redirect('user.php?act=login');
            $message = $_POST['message'];
			//实体转意,去除字符串
			$messages=strip_tags($message);
            if(empty($message)) jsMessage("请填写回复内容");
			
			
			//私人短信
			$forum_name=$db->getField('mcs_forum','forum_name',"id = '".$subject['fid']."' ");
			$title=$db->getField("mcs_forum_post",'title',"id = '".$tid."' ");
			$uid=$db->getField("mcs_forum_post",'uid',"id = '".$tid."' ");
			//$has=$db->getField('mcs_member_message','id','tuid='.$uinfo['user_id'].' and fuid='.$uinfo['user_id'].' and guid='.$forum_name.'   and pid=0');
			$has=$db->getField("mcs_member_message",'id',"tuid= '".$uinfo['user_id']."' and fuid = '".$uinfo['user_id']."' and guid = '".$forum_name."' and pid =0 ");
			$state=0;
			if(empty($has)){
				$has=0;
			}
            //老的写法
			/*$db->Execute("insert mcs_member_message(pid,tuid,fuid,guid,content,gettime,state) value('".$has."',".$uinfo['user_id'].",'0','".$uinfo['user_id']."','你的帖子  ".$title." 有新回复:".$messages."  ',".time().",".$state.")");*/

            $db->Execute('insert mcs_member_message(pid,tuid,fuid,guid,content,gettime,state) value('.$has.','.$uid.',0,'.$uid.',"你的帖子 '.$title.'有新回复'.$messages.'  ",'.time().','.$state.')');
			
            $sql = "insert into mcs_forum_post(pid, fid, uid, add_time, content) values('$tid', '{$subject['fid']}', '{$_SESSION['user_id']}', '". time() ."', '$message')";
			
            $db->Execute($sql);
			
			if($_CFG['integral_back']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
				
				//双倍回帖积分
				$rank=$db->getField("mcs_configs","value","code = 'integral_back' ");
				$statu=$db->getAll("select * from mcs_card where uid = '".$_SESSION['user_id']."' and endtime > '".time()."' ");
				if($statu){
					$rank=($rank*2);
				}
				
				$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.',bbs_upper=bbs_upper+'.$rank.' where user_id='.$uinfo['user_id']);
				$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','论坛积分','积分日志',".$rank.",'logcredit')");//积分日志
				
				
			}

            Redirect('?act=view&id='.$tid."&page=".$page);
        }
		$subject['user_id']=$_SESSION['user_id'];
		$subject['user_rank']=$uinfo['user_rank'];
		$subject['rank_name']=$uinfo['rank_name'];
		// print_r($uinfo);die;
        $view->assign('subject', $subject);
        $sql = "select p.*, user_name,user_rank,rank_expiry,headimg, user_id,  forum_name from mcs_users u, mcs_forum_post p, mcs_forum f where u.user_id=p.uid and p.fid=f.id and pid=$tid order by id asc";
        $list = $db->pageStr($sql,5,10);

        foreach($list['record'] as $key => $val){	
			if($page ==1){
				$val['floor'] = ($key + 1);
			}else{
				$val['floor'] = ($page - 1) * 10 + $key +1 ;
			}
            $val['add_time'] = date("Y-m-d H:i", $val['add_time']);
			if($val['user_rank'] && $val['rank_expiry'] > time())
			{
				$rank = $db->getRow("select rank_name from mcs_user_rank where rank_id='{$val['user_rank']}'");
				$val['rank_name'] = $rank['rank_name'];
			}else{
				$rank = $db->getRow("select rank_name from mcs_user_rank where min_points<='{$val['rank_points']}' and '{$val['rank_points']}'<=max_points order by max_points desc");
				$val['rank_name'] = $rank['rank_name'];
			}
			$list['record'][$key] = $val;
        }
        if($_COOKIE['auth']){
        	$view->assign('isadmin', true);
        }
        $view->assign('list', $list);
        $db->Execute("update mcs_forum_post set views=views+1 where id=$tid");
        $view->display('bbs/view');
        break;

    case 'list':
        $fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;
        $cur_forum = $db->getRow("select * from mcs_forum where id=$fid");
        if(!$cur_forum) Redirect('bbs.php');
        $view->assign('cur_forum', $cur_forum);

        $sql = "select user_name, user_id, p.id, fid,global_top,top,essence,hot, title, forum_name, views, (select count(*) from mcs_forum_post where pid=p.id) as reply, p.add_time from mcs_users u, mcs_forum_post p, mcs_forum f where u.user_id=p.uid and p.fid=f.id and fid=$fid and pid=0 order by global_top desc,top desc,essence desc,add_time desc";
        $list = $db->pageStr($sql);

        foreach($list['record'] as $key => $val)
        {
            $val['add_time'] = date("Y-m-d", $val['add_time']);
            $list['record'][$key] = $val;
        }
        $view->assign('list', $list);

        $view->display('bbs/list');
        break;
	
	case 'moderator':
		if($uinfo['bbs']){
			if(IS_POST&&IS_AJAX){
				$id=intval($_POST['id']);
				$data=trim($_POST['data']);
				if($id){
					switch($data){
						case 'top_cancel':
							$db->Execute('update mcs_forum_post set top=0 where top=1 and id='.$id);
						break;

						case 'top_add':
							$db->Execute('update mcs_forum_post set top=1 where top=0 and id='.$id);
						break;

						case 'essence_cancel':
							$db->Execute('update mcs_forum_post set essence=0 where essence=1 and id='.$id);
						break;

						case 'essence_add':
							$db->Execute('update mcs_forum_post set essence=1 where essence=0 and id='.$id);
						break;

						case 'del':
							$db->Execute('delete from mcs_forum_post where id='.$id.' and pid='.$id);
						break;
					}
				}
			}
		}
	break;

	case 'dele':
		if($uinfo['bbs']){

				$id=intval($_GET['id']);

				if($id){

					$db->Execute('delete from mcs_forum_post where id='.$id);
					JSMessage('删除成功','bbs.php?act=view');
				}
		}else{
            //自己可以删除自己回复别人的评论
            $id=$_GET['id'];
            $id=intval($id);
            if($id){
                $db->Execute('delete from mcs_forum_post where id='.$id);
                header("location:bbs.php?act=view");
            }
        }die;
	break;
	//删除自己帖子
	case 'del':
		$id=$_GET['id'];
        if($id){
            $title=$db->getField("mcs_forum_post","title","id = '".$id."' ");
            $db->Execute('insert into mcs_member_message (tuid,guid,content,state,gettime) VALUE  ('.$uinfo['user_id'].','.$uinfo['user_id'].'," 你的帖子'.$title.' 已删除 ",0,'.time().')');
            $status=$db->Execute("delete from mcs_forum_post where id = ".$id);

            if($status){
                JSMessage('删除成功','bbs.php?act=list');
            }
        }
		break;
		
	case 'edit':
		$id=$_GET['id'];
		
		$tid = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $sql = "select p.*, user_name,user_rank,rank_expiry,headimg, user_id, forum_name, (select count(*) from mcs_forum_post where pid=p.id) as reply, p.add_time from mcs_users u, mcs_forum_post p, mcs_forum f where u.user_id=p.uid and p.fid=f.id and  pid=0 and p.id=$tid";
        $subject = $db->getRow($sql);
        if(!$subject) Redirect('bbs.php');
        $subject['add_time'] = date("Y-m-d H:i", $subject['add_time']);

		if($subject['user_rank'] && $subject['rank_expiry'] > time()){
			$rank = $db->getRow("select rank_name from mcs_user_rank where rank_id='{$subject['user_rank']}'");
			$subject['rank_name'] = $rank['rank_name'];
		}else{
			$rank = $db->getRow("select rank_name from mcs_user_rank where min_points<='{$subject['rank_points']}' and '{$subject['rank_points']}'<=max_points order by max_points desc");
			$subject['rank_name'] = $rank['rank_name'];
		}
		
        if(IS_POST){
            if(empty($_SESSION['user_id'])) Redirect('user.php?act=login');
            $message = $_POST['message'];
			$content=$message;
			$message=strip_tags($message);
            if(empty($message)) jsMessage("请填写回复内容");
			$id=$_GET['id'];
			$sql="update mcs_forum_post set title = '".$message."',content ='".$content."' where id =".$id;
            //$sql = "insert into mcs_forum_post(pid, fid, uid, add_time, content) values('$tid', '{$subject['fid']}', '{$_SESSION['user_id']}', '". time() ."', '$message')";

            $db->Execute($sql);
			
			/*if($_CFG['integral_back']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
				$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_back'].',pay_points=pay_points+'.$_CFG['integral_back'].',bbs_upper=bbs_upper+'.$_CFG['integral_back'].' where user_id='.$uinfo['user_id']);
				$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$_CFG['integral_back'])."','论坛积分','积分日志',".$_CFG['integral_back'].",'logcredit')");//积分日志
			}*/

           // Redirect('?act=view&id='.$tid."&page=".$page);
            Redirect('?act=list');
        }
		$subject['user_id']=$_SESSION['user_id'];
        $view->assign('subject', $subject);
        $db->Execute("update mcs_forum_post set views=views+1 where id=$tid");
		
		$view->display('bbs/edit');
		break;
		// case 'delete':
		// 	if($db->Execute("delete from mcs_forum where id='".$_GET['id']."'")){
		// 		echo 1;
		// 	}else{
		// 		echo 0;
		// 	}
		// die;

		// case 'postedit':
  //       if(empty($_SESSION['user_id'])) Redirect('user.php?act=login');
  //       $fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;
		
  //       $cur_forum = $db->getRow("select * from mcs_forum where id=$fid");
  //       if(!$cur_forum) Redirect('bbs.php');
  //       if(IS_POST)
  //       {
		// 	if($fid == 1  ){
		// 		if($uinfo['bbs'] == 1 || $_COOKIE['auth'] == 1){
		// 			$title = trim($_POST['title']);
		// 			$message = $_POST['message'];
		// 			if(empty($title) || empty($message)) jsMessage("请完整的输入帖子信息");

		// 			$sql = "insert into mcs_forum_post(fid, title, uid, add_time, content) values('$fid', '$title', '{$_SESSION['user_id']}', '". time() ."', '$message')";

		// 			$db->Execute($sql);

		// 			if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
		// 				$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_post'].',pay_points=pay_points+'.$_CFG['integral_post'].',bbs_upper=bbs_upper+'.$_CFG['integral_post'].' where user_id='.$uinfo['user_id']);
		// 				$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$_CFG['integral_post'])."','论坛积分','积分日志',".$_CFG['integral_post'].",'logcredit')");//积分日志
		// 			}
		// 			Redirect('?act=list&fid='. $fid);
		// 		}else{
		// 			JSMessage('没有权限');
		// 		}
		// 	}else{
				
		// 		$title = trim($_POST['title']);
		// 		$message = $_POST['message'];
		// 		if(empty($title) || empty($message)) jsMessage("请完整的输入帖子信息");

		// 		$sql = "insert into mcs_forum_post(fid, title, uid, add_time, content) values('$fid', '$title', '{$_SESSION['user_id']}', '". time() ."', '$message')";

		// 		$db->Execute($sql);
				
		// 		 原来的
		// 			if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
		// 			$db->Execute('update mcs_users set rank_points=rank_points+'.$_CFG['integral_post'].',pay_points=pay_points+'.$_CFG['integral_post'].',bbs_upper=bbs_upper+'.$_CFG['integral_post'].' where user_id='.$uinfo['user_id']);
		// 			$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$_CFG['integral_post'])."','论坛积分','积分日志',".$_CFG['integral_post'].",'logcredit')");//积分日志
		// 			}
		// 			Redirect('?act=list&fid='. $fid);
					
				
				
		// 		//发帖双倍积分 --
		// 		$rank=$db->getField('mcs_configs','value',"code ='integral_post' ");
		// 		$sta=$db->getAll("select * from mcs_card where uid = '".$uinfo['user_id']."' and endtime > '".time()."' ");
		// 		if($sta){
		// 			$rank=($rank*2);
		// 			if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
		// 			$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.',bbs_upper=bbs_upper+'.$rank.' where user_id='.$uinfo['user_id']);
		// 			$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','论坛积分','积分日志',".$rank.",'logcredit')");//积分日志
		// 			}
		// 			Redirect('?act=list&fid='. $fid);
					
		// 		}else{
		// 			if($_CFG['integral_post']&&$uinfo['bbs_upper']<$_CFG['integral_upper']){
		// 			$db->Execute('update mcs_users set rank_points=rank_points+'.$rank.',pay_points=pay_points+'.$rank.',bbs_upper=bbs_upper+'.$rank.' where user_id='.$uinfo['user_id']);
		// 			$db->Execute("insert into mcs_member_logs(uid,createtime,num,info,logtype,integral,type) value(".$uinfo['user_id'].",'".time()."','".($uinfo['rank_points']+$rank)."','论坛积分','积分日志',".$rank.",'logcredit')");//积分日志
		// 			}
		// 			Redirect('?act=list&fid='. $fid);
		// 		}
		// 		//--！
				
		// 	}
			
            
  //       }

  //       $forum = $db->getAll("select * from mcs_forum order by sorting asc");
  //       $view->assign('forum', $forum);
        
  //       $view->assign('cur_forum', $cur_forum);
  //       $content=$db->getRow("select * from mcs_forum_post where id='".$_GET['id']."'");
  //       // print_r($content);die;
  //       $view->assign('content',$content);
  //       $view->display('bbs/postedit');
  //       break;
	// case 'editforum':
        
 //        $content=$db->getRow("select * from mcs_forum_post where id='".$_GET['id']."'");
 //        // print_r($content);die;
 //        $view->assign('content',$content);
 //        $view->display('bbs/postedit');
 //        break;

	// case 'delforum':
	// 	if($db->Execute("delete from mcs_forum_post where id='".$_GET['id']."'")){
	// 		echo 1;
	// 	}else{
	// 		echo 0;
	// 	}
	// 	die;
	// break;

    default:
        $forum = $db->getAll("select * from mcs_forum order by sorting asc");
        foreach($forum as $key => $val)
        {
            $val['count'] = $db->getCount('mcs_forum_post', "fid=$val[id] and add_time>".strtotime(date('Y-m-d')));
            $val['sortings'] =  $val['sorting']%8==0?1:$val['sorting']%8;
            $val['last'] = $db->getRow("select id, title, user_name, p.add_time, views from mcs_users u, mcs_forum_post p where u.user_id=p.uid and pid=0 and fid=$val[id] order by id desc");

            if($val['last']['add_time']) $val['last']['add_time'] = date('Y-m-d H:i', $val['last']['add_time']);

            $forum[$key] = $val;
        }

		$recently = $db->getAll("select * from mcs_forum_post where pid=0 order by add_time desc limit 8");
		foreach($recently as $k => $v){
			$recently[$k]['title']=cnsubstr($v['title'],14);
		}
		$essence = $db->getAll("select * from mcs_forum_post where pid=0 and essence=1 order by add_time desc limit 8");
		foreach($essence as $k => $v){
			$essence[$k]['title']=cnsubstr($v['title'],14);
		}
		
        $view->assign('recently', $recently);
        $view->assign('essence', $essence);
        $view->assign('forum', $forum);
        $view->display('bbs/index');
        break;
}
?>
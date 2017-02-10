<?php
require 'init.php';

switch($action)
{
	case 'post':
		if(IS_POST&&IS_AJAX){
			$id=intval($_POST['data']);
			$alt=intval($_POST['alt']);
			if($alt==0){
				$alt=1;
			}else{
				$alt=0;
			}
			
			$opt=trim($_POST['opt']);
			switch($opt){
				case 'global_top':
					$set='global_top='.$alt;
				break;
				case 'top':
					$set='top='.$alt;
				break;
				case 'essence':
					$set='essence='.$alt;
				break;
				case 'hot':
					$set='hot='.$alt;
				break;
			}
			$img=array('template/images/no.gif','template/images/yes.gif');			
			if(!empty($set)){
				if($db->Execute('update mcs_forum_post set '.$set.' where id='.$id)){
					$data['state']=1;
					$data['alt']=$alt;
					$data['img']=$img[$alt];
				}
			}
			echo json_encode($data);
			exit;
		}
		$del=intval($_GET['dropid']);
		$db->Execute('delete from mcs_forum_post where id='.$del);
		$sql = "select p.id, title,global_top,top,essence,hot, add_time, views, forum_name from mcs_forum_post p, mcs_forum f where p.fid=f.id and pid=0 order by global_top desc,top desc,essence desc,add_time desc";
        $list = $db->pageStr($sql);
        foreach($list['record'] as $key => $val)
        {
            $val['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
            $val['repnum'] = $db->getCount('mcs_forum_post', "pid='{$val['id']}'");
            $list['record'][$key] = $val;
        }
        $view->assign('list', $list);
        $view->display('forum_post');
	break;

	case 'info':
		if(IS_POST){
			$forum_name=trim($_POST['forum_name']);
			$id=intval($_POST['id']);
			$sorting=intval($_POST['sorting']);

			if($_FILES['img']['size']){
				$picname = $_FILES['img']['name'];
				$picsize = $_FILES['img']['size'];
				if($picsize > 1024000){
					Message('图片大小不能超过1M',0,'forum.php?act=info');
				}
				$type = strtolower(strstr($picname, '.'));
				if($type != ".gif" && $type != ".jpg"  && $type != ".png") {
					Message('图片格式不对！',0,'forum.php?act=info');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../uploads/form/". $pics;
				@move_uploaded_file($_FILES['img']['tmp_name'], $pic_path);
				$pic=',img="'.$pic_path.'"';
			}
			if($id){
				$db->Execute('update mcs_forum set forum_name="'.$forum_name.'",sorting='.$sorting.$pic.' where id='.$id);
				Message('信息保存成功！',0,'forum.php');
			}else{
				$db->Execute('insert into mcs_forum(forum_name,sorting,img) values("'.$forum_name.'",'.$sorting.',"'.$pic_path.'")');
				Message('信息保存成功！',0,'forum.php');
			}
		}
		$info=$db->getRow('select * from mcs_forum where id='.intval($_GET['fid']));
		$view->assign('info', $info);
		$view->display('forum_info');
	break;

	case 'infoget':
		if(IS_POST&&IS_AJAX){
			$list=$db->getAll('select * from mcs_users where bbs=0');
			$view->assign('list', $list);
			$view->display('forum_infoget');
		}
	break;

	case 'moderator':
		if(IS_POST&&IS_AJAX){
			$select=$_POST['select'];
			if(is_array($select)&&count($select)){
				foreach($select as $v){
					$db->Execute('update mcs_users set bbs=1 where bbs=0 and user_id='.intval($v));
				}
			}
			exit;
		}
		if($_GET['did']){
			$db->Execute('update mcs_users set bbs=0 where bbs=1 and user_id='.intval($_GET['did']));
		}
		$list=$db->getAll('select * from mcs_users where bbs=1');
		foreach($list as $key => $val)
        {
            $val['add_time'] = date('Y-m-d H:i:s');

            if($val['user_rank'] && $val['rank_expiry'] > time())
            {
                $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "rank_id='{$val['user_rank']}'");
            }
            else
            {
                $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "min_points<='{$val['rank_points']}' and '{$val['rank_points']}'<=max_points order by max_points desc"); 
            }

            $list[$key] = $val;
        }
		$view->assign('list', $list);
		$view->display('forum_moderator');
	break;

    default:
		$del=intval($_GET['did']);
		$db->Execute('delete from mcs_forum where id='.$del);
        $sql = "select * from mcs_forum order by sorting asc,id asc";
        $list = $db->getAll($sql);
        $view->assign('list', $list);
        $view->display('forum');
        break;
}
?>
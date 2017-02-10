<?php
require 'init.php';

switch($action)
{
	case 'edit':
		if(IS_POST){
			$id=intval($_POST['id']);
			$title = trim($_POST['title']);
            $file_path = trim($_POST['file_path']);
            $intro = trim($_POST['intro']);
			if($_FILES['img']['size']){
				$picname = $_FILES['img']['name'];
				$picsize = $_FILES['img']['size'];
				if($picsize > 1024000){
					Message('图片大小不能超过1M',0,'download.php?act=info');
				}
				$type = strtolower(strstr($picname, '.'));
				if($type != ".gif" && $type != ".jpg"  && $type != ".png") {
					Message('图片格式不对！',0,'download.php?act=info');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../uploads/form/". $pics;
				@move_uploaded_file($_FILES['img']['tmp_name'], $pic_path);
				$pic=',img="'.$pic_path.'"';
			}
			$sql = 'update mcs_download set title="'.$title.'", file_path="'.$file_path.'", intro="'.$intro.'"'.$pic.' where id='.$id;
			$db->Execute($sql);
			Redirect('download.php');
		}
		$id=intval($_GET['id']);
		if($id){
			$info=$db->getRow('select * from mcs_download where id='.$id);
			if($info['id']){
				 $view->assign('info',$info);
				 $view->display('down_edit');
				 break;
			}
		}
		Message('您要编辑的内容不存在',0,'download.php?act=list');
	break;
    case 'info':
        if(IS_POST){
            $title = trim($_POST['title']);
            $file_path = trim($_POST['file_path']);
            $intro = trim($_POST['intro']);
			if($_FILES['img']['size']){
				$picname = $_FILES['img']['name'];
				$picsize = $_FILES['img']['size'];
				if($picsize > 1024000){
					Message('图片大小不能超过1M',0,'download.php?act=info');
				}
				$type = strtolower(strstr($picname, '.'));
				if($type != ".gif" && $type != ".jpg"  && $type != ".png") {
					Message('图片格式不对！',0,'download.php?act=info');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "../uploads/form/". $pics;
				@move_uploaded_file($_FILES['img']['tmp_name'], $pic_path);
				$sql = "insert into mcs_download(title, file_path, intro,img) values('$title', '$file_path', '$intro', '$pic_path')";
				$db->Execute($sql);
				Redirect('download.php');
			}
			Message('请上传图片',0,'download.php?act=info');
        }
        $view->display('down_info');
    break;

    default:
        $dpid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dpid)
        {
            $db->Execute("delete from mcs_download where id=$dpid");
            Redirect('?act=list');
        }
        $sql = "select * from mcs_download";
        $list = $db->getAll($sql);
        $view->assign('list', $list);
        $view->display('down_list');
        break;
}
?>
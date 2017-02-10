<?php
require 'mcscore/init.php';

if($uinfo['user_id']){
$payment=isset($_REQUEST['payment'])?intval($_REQUEST['payment']):0;//点击已付款
$pid=isset($_REQUEST['pid'])?intval($_REQUEST['pid']):0;//上传好评
if($payment){
	$this_attr=$db->getRow("select * from mcs_task_paipai a,mcs_member_bindacc b where a.id=$payment and a.get_user=b.id and b.uid=$uinfo[user_id]  and a.process=0");
	if($this_attr){
		$attr=unserialize($this_attr['attrs']);
		$finish=unserialize($this_attr['finish']);
		if($attr['isViewEnd']==1){
			$picname = $_FILES['mypic']['name'];
			$picsize = $_FILES['mypic']['size'];
			if ($picname != "") {
				if ($picsize > 1024000) {
					echo '图片大小不能超过1M';
					exit;
				}
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					echo '图片格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "uploads/task/". $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
				@unlink($_SERVER['DOCUMENT_ROOT'].$finish['isViewEnd']);
				$finish['isViewEnd']=$pic_path;
				$finish=serialize($finish);
				$db->execute("update mcs_task_paipai set finish='".$finish."' where id=$payment");
				$size = round($picsize/1024,2);
				$arr = array('name'=>$picname,'pic'=>$pics,'size'=>$size);
				echo json_encode($arr);
			}
		}
	}
}
if($pid){
	$this_attr=$db->getRow("select * from mcs_task_paipai a,mcs_member_bindacc b where a.id=$pid and a.get_user=b.id and b.uid=$uinfo[user_id]  and a.process=2");
	if($this_attr['id']){
		$attrs=unserialize($this_attr['attrs']);
		$finish=unserialize($this_attr['finish']);
		if($attrs['pinimage']==1){
			$picname = $_FILES['mypic']['name'];
			$picsize = $_FILES['mypic']['size'];
			if ($picname != "") {
				if ($picsize > 1024000) {
					echo '图片大小不能超过1M';
					exit;
				}
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
					echo '图片格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				//上传路径
				$pic_path = "uploads/task/". $pics;
				move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
				@unlink($_SERVER['DOCUMENT_ROOT'].'/'.$finish['pinimage']);
				$finish['pinimage']=$pic_path;
				$finish=serialize($finish);
				$db->execute("update mcs_task_paipai set finish='".$finish."' where id=$pid");
				$size = round($picsize/1024,2);
				$arr = array('name'=>$picname,'pic'=>$pics,'size'=>$size);
				echo json_encode($arr);
			}
			
		}
	}
}
}
?>
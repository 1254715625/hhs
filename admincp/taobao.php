<?php
require 'init.php';
if($_GET['del']){
	$id=intval($_GET['del']);
		//$rel=$db->Execute("delete from mcs_task_express where id=$id");
		$rel=$db->Execute("delete from mcs_topup where id=$id");
		if($rel){
			echo "<script type='text/javascript'>alert('删除成功');</script>";
		}
}
if(isset($_GET['act'])&&$_GET['act']=='change'&&IS_AJAX&&IS_POST){
	$user	=trim($_POST['user']); 
	$pass	=trim($_POST['pass']); 
	$money	=intval($_POST['money']); 
	$time	=$_POST['time'];
	$num	=$_POST['num'];
	if($user==''||$pass==''||$money==0){
		$data['info']='信息不完整~';
	}else{
		if($db->getCount('mcs_topup','name="'.$user.'"')){
			$data['info']='充值卡已有记录，请勿重复添加~';
		}else{
			
			for($i=1;$i<=$num;$i++){
				$cardes=mt_rand( pow(10,($user-1)),(pow(10,$user)-1 ) );
				$passes=mt_rand( pow(10,($pass-1)),(pow(10,$pass)-1 ) );
				$rand=mt_rand(1,9);
				//$moneyes=mt_rand( pow(10,($money-1)),(pow(10,$money)-1 ) );
				$moneyes=$rand*(pow(10,$money-1) ) ;
				$time=date(time()+86400*7);
				//$data['info']=$cardes;
				$db->Execute("insert into mcs_topup (name,pass,money,state,endtime)values('".$cardes."','".$passes."','".$moneyes."','0','".$time."')");
			}
			
		}
	}
	$data['info']='成功';
	echo json_encode($data);exit;
}
if(IS_POST){
	    include_once("excel/reader.php");
	    $tmp = $_FILES['file']['tmp_name'];
		if (empty ($tmp)) {
			echo '请选择要导入的Excel文件！';
			exit;
		}
		
		$save_path = "temp/";
		$file_name = $save_path.date('Ymdhis') . ".xls";
		if (copy($tmp, $file_name)) {
			$xls = new Spreadsheet_Excel_Reader();
			$xls->setOutputEncoding('utf-8');
			$xls->read($file_name);
			$num=0;
			$str='';
			for ($i=2; $i<=$xls->sheets[0]['numRows']; $i++) {
				$user = trim($xls->sheets[0]['cells'][$i][1]);
				$pass = trim($xls->sheets[0]['cells'][$i][2]);
				$money = intval($xls->sheets[0]['cells'][$i][3]);
				if($nums<1){$nums=1;}
				$str.='第'.($i-1).'条记录 ';
				$j=0;
				if(empty($user)){
					$str.=' 充值卡号'.$user.'为空';
					$j=1;
				}
				if($db->getCount("mcs_topup", 'name="'.$user.'"')){
					$str.=' 充值卡号'.$user.'已存在';
					$j=1;
				}
				if(empty($pass)){
					$str.=' 充值卡密码为空';
					$j=1;
				}
				if($money==0){
					$str.=' 充值卡金额不正确';
					$j=1;
				}
				if($j==0){
					if($db->Execute('insert into mcs_topup(name,pass,money) values("'.$user.'","'.$pass.'","'.$money.'")')){
						$num++;
						$str.=' 导入成功！';
					}else{
						$str.=' 数据库导入失败！';
					}
				}
				$str.='\\r';
				
			}
			$str.="共".($i-2)."条数据，";
			$str.="成功导入".$num."条数据！";
			echo '<script type="text/javascript">alert("'.$str.'");location.href="taobao.php";</script>';
		}
}
if(isset($_GET['type'])){
	if($_GET['type'] == 'no' ){
		
		$sql="select * from mcs_topup where state=0 ";
	}
	if($_GET['type'] == 'yes'){
		
		$sql="select * from mcs_topup where state=1 ";
	}
	if($_GET['type'] == 'fei'){
		$sql="select * from mcs_topup where endtime < '".time()."' order by id desc";
	}
}else{
	$sql="select * from mcs_topup 	";
}

$list = $db->page($sql,12,4);
$view->assign('list', $list);
$view->assign('listnum',count($list['record'] ));
$view->display('taobao');
?>
<?php
require 'init.php';
if($_GET['del']){
	$id=intval($_GET['del']);
		$rel=$db->Execute("delete from mcs_task_express where id=$id");
		if($rel){
			echo "<script type='text/javascript'>alert('删除成功');</script>";
		}
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
				/*
				$eid = trim($xls->sheets[0]['cells'][$i][1]);
				//$send_add = trim($xls->sheets[0]['cells'][$i][2]);
				$to_add = trim($xls->sheets[0]['cells'][$i][2]);
				//$phone = trim($xls->sheets[0]['cells'][$i][3]);
				$wl = trim($xls->sheets[0]['cells'][$i][3]);
				$nums = intval($xls->sheets[0]['cells'][$i][4]);
				*/
				$eid = trim($xls->sheets[0]['cells'][$i][1]);
				$send_add = trim($xls->sheets[0]['cells'][$i][2]);
				$to_add = trim($xls->sheets[0]['cells'][$i][3]);
				//$phone = trim($xls->sheets[0]['cells'][$i][3]);
				$wl = trim($xls->sheets[0]['cells'][$i][4]);
				$nums = intval($xls->sheets[0]['cells'][$i][5]);
				if($nums<1){$nums=1;}
				$str.='第'.($i-1).'条记录 ';
				$j=0;
				if(empty($eid)){
					$str.=' 快递单号'.$eid.'为空';
					$j=1;
				}
				if($db->getCount("mcs_task_express", 'eid="'.$eid.'"')){
					$str.=' 快递单号'.$eid.'已存在';
					$j=1;
				}
				if(empty($send_add)){
					$str.=' 发货地址为空';
					$j=1;
				}
				if(empty($to_add)){
					$str.=' 收货地址为空';
					$j=1;
				}
				/*if(empty($phone)){
					$str.=' 收货电话为空';
					$j=1;
				}*/
				if(empty($wl)){
					$str.=' 快递类型为空';
					$j=1;
				}
				if($j==0){
					if($db->Execute('insert into mcs_task_express (eid,addtime,to_add,wl,status,num,send_add) values("'.$eid.'",'.time().',"'.$to_add.'","'.$wl.'",1,'.$nums.',"'.$send_add.'")')){
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
			echo '<script type="text/javascript">alert("'.$str.'");location.href="express_virtual.php";</script>';
		}
}
$sql="select * from mcs_task_express where type=0 order by addtime desc";
$list = $db->page($sql,12,4);
if(count($list['record'])){
	foreach($list['record'] as $k => $v){
		$list['record'][$k]['to_adds']=$v['to_add'];
		$list['record'][$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
	}
}
$view->assign('list', $list);
$view->assign('listnum',count($list['record'] ));
$view->display('express_virtual');
?>
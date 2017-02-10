<?php
require 'init.php';

if(IS_POST)
{
	$eid=intval($_POST['eid']);
	$title = trim($_POST['title']);
	$shownum = intval($_POST['shownum']);
	$content = trim($_POST['content']);

	$id=$db->getField('mcs_express','id','id='.$eid);
	if($id){
		if(empty($title)){
			Message('请填写快递名称~');
		}else{
			if($db->getCount('mcs_express','title="'.$title.'" and id!='.$id)){
				Message('快递已存在~');
			}
			if($shownum==0){
				$shownum=$db->getField('mcs_express','shownum','id='.$id);
			}
			$content=htmlspecialchars($content,ENT_QUOTES,'utf-8');
			if($db->Execute('update mcs_express set title="'.$title.'",shownum='.$shownum.',content="'.$content.'" where id='.$id)){
				Message('修改成功~');
			}
		}
	}else{
		if(empty($title)){
			Message('请填写快递名称~');
		}else{
			if($db->getCount('mcs_express','title="'.$title.'"')){
				Message('快递已存在~');
			}
			if($shownum==0){
				$shownum=$db->getRow('select max(shownum) as shownum from mcs_express');
				$shownum=$shownum['shownum']+10;
			}
			$content=htmlspecialchars($content,ENT_QUOTES,'utf-8');
			if($db->Execute('insert into mcs_express(title,shownum,content,state) values("'.$title.'",'.$shownum.',"'.$content.'",1)')){
				Message('添加成功~');
			}
		}
	}
}
$eid=intval($_GET['eid']);
if($eid){
	$params = $db->getRow('select * from mcs_express where id='.$eid);
	$params['content']=htmlspecialchars_decode($params['content'],ENT_QUOTES);
	if($params['id']){
		$view->assign('params', $params);
	}
}
$view->assign('eid', $eid);
$view->display('express_info');
?>
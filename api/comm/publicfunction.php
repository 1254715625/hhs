<?php
function pre(){
	if(func_num_args()==0){
		return false;
	}
	echo "<pre>";
	if(func_num_args()==1){
		print_r(func_get_arg(0));
	}else{
		print_r(func_get_args());
	}	
	echo "</pre>";
}
function view($page){
	global $view;
	// global $data;
	// if($data){
	// 	$view->assign("data",$data);
	// }
	// if(!$view->display($page.".dwt")){
	// 	if(!$view->display($page.".html")){
	// 		if(!$view->display($page.".htm")){
				$view->display($page);
	// 			$view->display($page.".php");
	// 		}
	// 	}
	// }
}
function mysql_array($result){
	while($info=mysql_fetch_array($result)){
		$arr[]=$info;
	}
	if($arr){
		return $arr;
	}
}
function select($database,$table,$area,$where=null){
	$link=mysqli_connect("localhost","root","",$database);
	$sql="select ".$area." from ".$table." ".$where." ";
	$sql=mysqli_query($link,$sql);
	if(!$sql){
		return false;
	}
	while($info=mysqli_fetch_assoc($sql)){
		$query[]=$info;
	}
	return $query;
}
function pageselect($nums,$page,$database,$table,$area,$where=null){
	$page=floor($page);
	$num=select($database,$table,"count(*) as num",$where)[0]['num'];
	$pages=ceil($num/$nums);
	if(!($page<=$pages&&$page>=1)){
		$page=1;
	}
	$start=$nums*$page-$nums;
	$arr['result']=select($database,$table,"*",$where." limit ".$start.",".$nums);
	$arr['num']=$num;
	$arr['pages']=$pages;
	if($page==1){
		$arr['before']=1;
	}else{
		$arr['before']=$page-1;
	}
	if($page==$pages){
		$arr['after']=$pages;
	}else{
		$arr['after']=$page+1;
	}
	return $arr;
}


function get_zip_centent($zipfilepath,$filepath){
	$zip=new ZipArchive();
	$zip->open($zipfilepath);
	$zip->extractTo("cache");
	$zip->close();
	$content=txtfile("cache/".$filepath);
	deletedir("cache");
	return $content;
}
function deletedir($dirpath){
	if(!is_dir($dirpath)){
		return false;
	}
	$dir=opendir($dirpath);
	$file=readdir($dir);
	$file=readdir($dir);
	while ($file=readdir($dir)) {
		if(is_dir($dirpath."/".$file)){
			deletedir($dirpath."/".$file);
		}else{
			unlink($dirpath."/".$file);
		}	
	}
	closedir($dir);
	rmdir($dirpath);
}
function txtfile($path,$txt){
	if(isset($txt)){
		file_put_contents($path,$txt);
	}else if(isset($path)){
		if(file_get_contents($path)){
			return htmlspecialchars(file_get_contents($path));
		}
	}
}
function zip_add_file($zipfilepath,$filepath){
	$zip=new ZipArchive();
	if($zip->open($zipfilepath)!=1){
		file_put_contents($zipfilepath,"");
		$zip->open($zipfilepath);
	}
	function add_dir($filepath){
		$dir=opendir($filepath);
		$file=readdir($dir);
		$file=readdir($dir);
		while($file=readdir($dir)){
			if(is_dir($filepath."/".$file)){
				$arr[]=add_dir($filepath."/".$file);
			}else{
				$arr[]=$filepath."/".$file;
			}		
		}
		closedir($dir);
		return $arr;
	}	
	if(is_dir($filepath)){
		$arr=add_dir($filepath);
		function arrto($arr,$zip){
			foreach($arr as $v){
				if(is_array($v)){
					arrto($v,$zip);
				}else{
					$zip->addFile($v);
				}
			}
		}
		arrto($arr,$zip);	
	}else{
		$zip->addFile($filepath);
	}
	$zip->close();
}
function zip_update_file($zipfilepath,$filepath,$content){
	$zip=new ZipArchive();
	$zip->open($zipfilepath);
	$zip->extractTo(pathinfo($zipfilepath)['filename']);
	$arr=explode("/",pathinfo($filepath)['dirname']);
	$path="";
	foreach ($arr as $value) {
		$path.=$value;
		if(!is_dir($path)){
			mkdir($path);
		}	
		$path.="/";
	}
	copy(pathinfo($zipfilepath)['filename']."/".$path.pathinfo($filepath)['basename'],$path.pathinfo($filepath)['basename']);
	file_put_contents($path.pathinfo($filepath)['basename'],$content);
	$zip->addFile($path.pathinfo($filepath)['basename']);
	$zip->close();
	deletedir(pathinfo($zipfilepath)['filename']);
	deletedir($arr[0]);
}
function copydir($dirpath,$path){
	if(!is_dir($dirpath)){
		return false;
	}
	$dir=opendir($dirpath);
	$file=readdir($dir);
	$file=readdir($dir);
	if(!is_dir($path)){
		$arr=explode("/",$path);
		$url="";
		foreach ($arr as $value) {
			if(!is_dir($url.$value)){
	 			mkdir($url.$value);			
			}	
			$url=$url.$value."/";
		}
	}
	while($file=readdir($dir)){
		if(is_dir($dirpath."/".$file)){
			if(!is_dir($path."/".$file)){
				mkdir($path."/".$file);
			}
			copydir($dirpath."/".$file,$path."/".$file);
		}else{
			copy($dirpath."/".$file,$path."/".$file);
		}
	}
}
function cutdir($dirpath,$path){
	copydir($dirpath,$path);
	deletedir($dirpath);
}
function dirinfo($dirpath){
	$dir=opendir($dirpath);
	$file=readdir($dir);
	$file=readdir($dir);
	$arr="";
	while ($file=readdir($dir)) {
		if(is_dir($dirpath."/".$file)){	
			$url=explode("/",$dirpath."/".$file);	
			$arr[$url[count($url)-1]]=dirinfo($dirpath."/".$file);	
		}else{
			if(filesize($dirpath."/".$file)>0){
				$arr[$file]=filesize($dirpath."/".$file)."Byte";
			}else{
				$arr[$file]="空文件";
			}
		}
	}
	if($arr!=""){
		return $arr;
	}else{
		return "空目录";
	}
}
function changeextension($path,$extension,$newextension,$all=true){
	$dir=opendir($path);
	while($file=readdir($dir)){
		if($file=="."||$file==".."){
			continue;
		}
		if(is_dir($path."/".$file)){
			if(!$all){
				continue;
			}
			changeextension($path."/".$file,$extension,$newextension,$all);
		}
		if(pathinfo($file)['extension']!=$extension){
			continue;
		}
		$newname=pathinfo($file)['filename'].".".$newextension;
		rename($path."/".$file,$path."/".$newname);
	}
	closedir($dir);
}
function updatecontent($path,$content,$newcontent,$all=true){
	$dir=opendir($path);
	while($file=readdir($dir)){
		if($file=="."||$file==".."){
			continue;
		}
		if(is_dir($path."/".$file)){
			if(!$all){
				continue;
			}
			updatecontent($path."/".$file,$content,$newcontent,$all);
		}else{
			$read=file_get_contents($path."/".$file);
			$read=preg_replace($content, $newcontent,$read);
			file_put_contents($path."/".$file,$read);
		}
	}
	closedir($dir);
}
function alert($data){
	if(!$data||$data===true){
		$data='数据为空或不合法';
	}
	echo "<script>alert('".$data."');</script>";
}
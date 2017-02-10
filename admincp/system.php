<?php
require 'init.php';

switch($action)
{	
	case 'messageRecord':
		$where = "1=1";
		if($_REQUEST['phone']){
			$where .=" and phone = '".$_REQUEST['phone']."'";
			$view->assign('phone',$_REQUEST['phone']);
		}
		$data = $db->page("select * from mcs_message where ".$where." order by sendtime desc",15,5);
		foreach($data['record'] as $k => $v){
			$data['record'][$k]['user_name'] = $db->getField("mcs_users","user_name","mobile_phone = '".$v['phone']."'");
			$data['record'][$k]['type'] = get_message_type($v['type']);
			$data['record'][$k]['sendtime'] = date("Y-m-d H:i:s",$v['sendtime']);
			$data['record'][$k]['status'] = $v['state'] == 1 ? "成功" : "<span style='color:red;'>失败</span>";
		}
		$view->assign('data',$data);
		$view->display('message_record'); 
	break;

	case 'sendAllMessage':
		require ROOT_PATH . 'mcscore/ccpsms.class.php';	
		$cfgs = $db->getField('mcs_configs', 'value', "code='sms'");
		$cfgs = unserialize($cfgs);
		$accountSid = $cfgs['accountSid'];	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountToken = $cfgs['accountToken'];
		$appId = $cfgs['appId'];
		$serverIP = $cfgs['serverIP'];
		$serverPort = $cfgs['serverPort'];
		$softVersion = $cfgs['softVersion'];
		$savetime = $cfgs['savetime'];
		$rest = new REST($serverIP, $serverPort, $softVersion);
		$rest->setAccount($accountSid, $accountToken);
		$rest->setAppId($appId);
		
		if(IS_POST){
			$content = $_POST['content'];
			if(!$content){
				Message("请填写短信内容，请不要发送相关的敏感词汇！");
			}
			$data = $db->getAll("select user_name,mobile_phone from mcs_users group by mobile_phone");
			foreach($data as $v){
				if(empty($v['mobile_phone'])){
					return false;
				}
				//$rest->sendTemplateSMS($v['mobile_phone'], array($content, $cfgs['savetime']), );
			}
			Message('信息发送成功！');
		}else{
			$view->display('send_all_message'); 
		} 
	break;
	
    case 'shengpay':
        $params = array('Name'=>array('name'=>'API名称', 'input'=>'text', 'note'=>''), 
			'Version'=>array('name'=>'版本号', 'input'=>'text', 'note'=>''), 
			'Charset'=>array('name'=>'发送字符集', 'input'=>'text', 'note'=>''), 
			'MsgSender'=>array('name'=>'发送编号', 'input'=>'text', 'note'=>''),
			'setKey'=>array('name'=>'密钥', 'input'=>'text', 'note'=>''),        
			'PayType'=>array('name'=>'支付类型', 'input'=>'text', 'note'=>'没有请留空'), 
			'InstCode'=>array('name'=>'InstCode', 'input'=>'text', 'note'=>'没有请留空'), 
			'PageUrl'=>array('name'=>'回调页面', 'input'=>'text', 'note'=>'请不要随意修改'), 
			'NotifyUrl'=>array('name'=>'异步页面', 'input'=>'text', 'note'=>'请不要随意修改'), 
			'ProductName'=>array('name'=>'产品名称', 'input'=>'text', 'note'=>'用于支付的订单名称'), 
			'SignType'=>array('name'=>'加密方式', 'input'=>'text', 'note'=>''), 
			'poundage'=>array('name'=>'手续费', 'input'=>'text', 'size'=>6, 'unit'=>'%'), 
		);

        if(IS_POST)
        {
            $param = serialize($_POST['param']);

            $db->Execute("update mcs_configs set value='$param' where code='shengpay'");

            Message('信息保存成功！');
        }

        $info = $db->getField('mcs_configs', 'value', "code='shengpay'");
        $info = unserialize($info);

        $view->assign('info', $info);
        $view->assign('params', $params);
        $view->display('system_shengpay');
        break;

    case 'sms':
        $params = array('accountSid'=>array('name'=>'Account Sid', 'input'=>'text'), 
                        'accountToken'=>array('name'=>'Account Token', 'input'=>'text'), 
                        'appId'=>array('name'=>'App ID', 'input'=>'text'), 
                        'serverIP'=>array('name'=>'Server IP', 'input'=>'text'), 
                        'serverPort'=>array('name'=>'Server Port', 'input'=>'text'), 
                        'softVersion'=>array('name'=>'Soft Version', 'input'=>'text'), 
                        'savetime'=>array('name'=>'Save Time', 'input'=>'text'), 
                    );

        if(IS_POST)
        {
            $param = serialize($_POST['param']);

            $db->Execute("update mcs_configs set value='$param' where code='sms'");

            Message('信息保存成功！');
        }

        $info = $db->getField('mcs_configs', 'value', "code='sms'");
        $info = unserialize($info);

        $view->assign('info', $info);
        $view->assign('params', $params);
        $view->display('system_sms');
        break;

    case 'points':
        if(IS_POST)
        {
            $param = $_POST['param'];

            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }


        $params = $db->getAll("select * from mcs_configs where pid=4 order by id asc");
        foreach($params as $key => $val)
        {
            if($val['type'] == 'radio')
            {
                $opt = explode(',', $val['options']);

                $val['options'] = array();
                foreach($opt as $v)
                {
                    $val['options'][] = array('value'=>$v, 'note'=>$_LANG[$val['code']][$v]);
                }
            }

            $params[$key] = $val;
        }

        $view->assign('params', $params);
        $view->display('system_points');
    break;

	case 'integral':
        if(IS_POST)
        {
            $param = $_POST['param'];
            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }


        $params = $db->getAll("select * from mcs_configs where pid=7 order by id asc");
        foreach($params as $key => $val)
        {
            if($val['type'] == 'radio')
            {
                $opt = explode(',', $val['options']);

                $val['options'] = array();
                foreach($opt as $v)
                {
                    $val['options'][] = array('value'=>$v, 'note'=>$_LANG[$val['code']][$v]);
                }
            }

            $params[$key] = $val;
        }


        $all_zone=array(
            array("id"=>"R001","name"=>"东城区"),
            array("id"=>"R002","name"=>"西城区"),
            array("id"=>"R003","name"=>"朝阳区"),
            array("id"=>"R004","name"=>"海淀区"),
            array("id"=>"R005","name"=>"昌平区"),
            array("id"=>"R006","name"=>"丰台区"),
            array("id"=>"R007","name"=>"通州区"),
            array("id"=>"","name"=>""),
            array("id"=>"R008","name"=>"大兴区"),
        );
        //自定义函数，去除包含某一个值得数组
        function delValue($arr)
        {
            foreach ($arr as $key=>$value){
                if($value=="708"||$value==""){
                    return false;
                }
                return true;
            }
        }
        $params=array_filter($params,"delValue");
        sort($params);//重新生成索引下标
        //print_r($reArr);die;
        $view->assign('params', $params);
        $view->display('system_integral');
	break;

	case 'extension':
		if(IS_POST)
        {
            $param = $_POST['param'];
            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }
        $params = $db->getAll("select * from mcs_configs where pid=8 order by id asc");
        foreach($params as $key => $val)
        {
            if($val['type'] == 'radio')
            {
                $opt = explode(',', $val['options']);

                $val['options'] = array();
                foreach($opt as $v)
                {
                    $val['options'][] = array('value'=>$v, 'note'=>$_LANG[$val['code']][$v]);
                }
            }

            $params[$key] = $val;
        }

        $view->assign('params', $params);
        $view->display('system_extension');
	break;
	
	//下载中心
	case 'down':

		/*require_once('../mcscore/image.class.php');
		if(IS_POST){
			$image=new image();
			$photo=$_FILES['photo'];
			$path=$image->myupload($photo);
			if($path){
				$db->Execute("update mcs_configs set value = '".'/'.$path."',unit='".$photo['name']."' where code = 'picture'");
				Message('信息保存成功！');
			}
		}
		$picture=$db->getRow("select * from mcs_configs where code ='picture' limit 0,1");

		$view->assign('picture', $picture);*/
		$results=$db->getAll("select * from mcs_picture where types = 1 ");
		$view->assign('results',$results);
		
		$view->display('system_down');
		
	break;

    case 'set_down_add':

        require_once('../mcscore/image.class.php');
        if(IS_POST){
            $image=new image();
            $photo=$_FILES['photo'];
            $menu=$_POST['select'];
            $link=$_POST['link'];
            $path=$image->myupload($photo);
            if($path){
                if($link == '' ){
                    $db->Execute("insert into mcs_picture (menu,path,types)value('".$menu."','".$path."',1)");
                }else{
                    $db->Execute("insert into mcs_picture (menu,path,link,types)value('".$menu."','".$path."','".$link."',1)");
                }
                Message('插入成功',0,'system.php?act=down');
            }
        }

        $view->display('set_down_add');

        break;

    case 'set_down_save':
        require_once('../mcscore/image.class.php');
        $id=$_GET['id'];
        $result=$db->getRow("select * from mcs_picture where id = ".$id);

        if(IS_POST){
            $id=$_GET['id'];

            $image=new image();
            $photo=$_FILES['photo'];
            $menu=$_POST['select'];
            $link=$_POST['link'];
            $path=$image->myupload($photo);
            if($path == ''){
                $path=$_POST['hidden'];
            }

            if($path){
                $status=$db->Execute("update mcs_picture set  path = '".$path."',link = '".$link."' where id = ".$id);
                if($status){
                    Message('更新成功',0,'system.php?act=down');
                }
            }
        }
        $view->assign('result',$result);
        $view->display('set_down_save');
        break;

    case 'down_del':
        $id=$_GET['id'];
        $status=$db->Execute("delete from mcs_picture where id =" .$id);
        if($status){
            Message('删除成功',0,'system.php?act=down');
        }
        break;






	//论坛图片设置
	case 'picture':
	
		
		if(IS_POST){
			$box=$_POST['box'];
			$size=$_POST['size']*1024;
			if(isset($box[0])){
				$pic['png']='.png';
			}
			if(isset($box[1])){
				$pic['jpg']='.jpg';
			}
			if(isset($box[2])){
				$pic['jpeg']='.jpeg';
			}
			if(isset($box[3])){
				$pic['gif']='.gif';
			}
			foreach($pic as $pi){
				$v.=$pi;
				
			}
			$v=json_encode($v);
			$size=json_encode($size);
			if(isset($box)){
				
					$status=$db->Execute("update mcs_configs set value =".$v." where code ='picture_system' ");

			}
			
			if(isset($size)){
				$db->Execute("update mcs_configs set value = ".$size." where  code = 'picture_size' ");
			}
			Message('更新成功');
		}

		$view->display('system_picture');
		break;
		
	case 'set_image':
		
		$results=$db->getAll("select * from mcs_picture where types =0 ");
		$view->assign('results',$results);
		$view->display('set_image');
		
	break;
	
	case 'set_image_add':
	
		require_once('../mcscore/image.class.php');
		if(IS_POST){
			$image=new image();
			$photo=$_FILES['photo'];
			$menu=$_POST['select'];
			$link=$_POST['link'];
			$path=$image->myupload($photo);
			if(path){
                if($link == '' ){
                    $db->Execute("insert into mcs_picture (menu,path)value('".$menu."','".$path."')");
                }else{
                    $db->Execute("insert into mcs_picture (menu,path,link)value('".$menu."','".$path."','".$link."')");
                }
				Message('插入成功',0,'system.php?act=set_image');
			}
		}
		
		$view->display('set_image_add');
		
		break;
		
	case 'set_image_save':
		require_once('../mcscore/image.class.php');
		$id=$_GET['id'];
		$result=$db->getRow("select * from mcs_picture where id = ".$id);
		
		if(IS_POST){
			$id=$_GET['id'];

			$image=new image();
			$photo=$_FILES['photo'];
			$menu=$_POST['select'];
			$link=$_POST['link'];
			$path=$image->myupload($photo);
            if($path == ''){
                $path=$_POST['hidden'];
            }

			if($path){
				$status=$db->Execute("update mcs_picture set  path = '".$path."',link = '".$link."' where id = ".$id);
				if($status){
					Message('更新成功',0,'system.php?act=set_image');
				}
			}
		}
		$view->assign('result',$result);
		$view->display('set_image_save');
		break;
		
	case 'image_del':
		$id=$_GET['id'];
		$status=$db->Execute("delete from mcs_picture where id =" .$id);
		if($status){
			Message('删除成功',0,'system.php?act=set_image');
		}
		break;	
		
	//短信金额
	case 'massage_money':
		$data=$db->getAll("select * from mcs_configs where id > 911 and id < 914");
		$view->assign('data',$data);
		$view->display('massage_money');
		break;
		
	//短信金额修改
	case 'massage_money_save':
		$id=$_GET['id'];
		$params=$db->getRow("select name,value from mcs_configs where id = " .$id);
		if(IS_POST){
			$id=$_GET['id'];
			$message=$_POST['message'];
			$status=$db->Execute("update mcs_configs set value = '".$message."' where  id = " .$id);
			if($status){
				Message('更新成功',0,'system.php?act=massage_money');
			}
		}
		$view->assign('params',$params);
		$view->assign('id',$id);
		$view->display("massage_money_save");
		break;
	//提现中心
	case 'tixian_center':
		$results=$db->getAll("select * from mcs_configs where id >913 and id <918");
		$view->assign('results',$results);
		$view->display('tixian_center');
		
		break;
	//提现中心修改
	case 'tixian_center_save':
		$id=$_GET['id'];
		$result=$db->getRow("select * from mcs_configs where id = " .$id);
		if(IS_POST){
			$id=$_GET['id'];
			$name=$_POST['name'];
			$value=$_POST['value'];
			$status=$db->Execute("update mcs_configs set name = '".$name."',value = '".$value."' where id = " .$id);
			
			if($status){
				Message('更新成功',0,'system.php?act=tixian_center');
			}else{
				Message('更新成功',0,'system.php?act=tixian_center');
			}
		}
		$view->assign('id',$id);
		$view->assign('result',$result);
		$view->display('tixian_center_save');
		break;
		
	//提现qq
	case 'tixian_qq':
		$results=$db->getAll("select * from mcs_configs where id >924 and id<928");
		foreach($results as $key=>$val){
			$results[$key]['value']=unserialize($val['value']);
			
		}
		$view->assign('results',$results);
		$view->display('tixian_qq');
		break;
	
	//添加和修改
	case 'tixian_qq_add': //0
		$id=$_GET['id'];
		$code=$db->getRow("select code ,type from mcs_configs  where  id = " .$id);
		if(IS_POST){
			$qq=$_POST['qq'];
			$select=$_POST['select'];
			$result=$db->getField("mcs_configs",'name',"options = '".$select."' ");
			$status=$db->getRow("select * from mcs_configs where code = '".$result."' ");
			if($status){
				$arr=explode(',',$qq);
				$qq=serialize($arr);
				$status=$db->Execute("update mcs_configs set value = '".$qq."' where type = '".$select."' ");
				if($status){
					Message("更新成功",0,'system.php?act=tixian_qq');
				}
			}else{
				$arr=explode(',',$qq);
				$qq=serialize($arr);
				$option=$_POST['select'];
				$name=$db->getField('mcs_configs','name',"options = '".$option."' ");
				$status=$db->Execute("insert into mcs_configs (code,pid,name,type,value) value ('".$name."','10','qq','".$option."','".$qq."')");
				if($status){
					Message('添加成功',0,'system.php?act=tixian_qq');
				}
			}
		}
		$view->assign('code',$code);
		$view->display('tixian_qq_add');
		break;
		
	case 'gonggao':
		$results=$db->getAll("select * from mcs_notice ");
		$view->assign("results",$results);
		$view->display('gonggao');
		break;
	
	case 'gonggao_add':
		if(IS_POST){
			$content=$_POST['content'];
			$status=$db->Execute("insert into mcs_notice (content,time,status) value('".$content."','".time()."','1') ");
			if($status){
				Message('添加成功',0,'system.php?act=gonggao');
			}
		}else{
			$view->display('gonggao_add');
		}
		break;
		
	case 'gonggao_save':
		$id=$_GET['id'];
		if(IS_POST){
			$content=$_POST['content'];
			$time=time();
			$status=$db->Execute("update mcs_notice set content = '".$content."',time = '".$time."' where id = " .$id);
			if($status){
				Message("更新成功",0,'system.php?act=gonggao');
			}
		}else{
			$view->display('gonggao_save');
		}
		$view->assign('id',$id);
		break;
		
	case 'gonggao_delete':
		$id= $_GET['id'];
		$status=$db->Execute("delete from mcs_notice where id = " .$id);
		if($status){
			Message('删除成功',0,'system.php?act=gonggao');
		}
		break;
		
	case 'font_size':
		$result=$db->getRow("select * from mcs_configs where code = 'font_size' ");
		$view->assign("item",$result);
		$view->display('font_size');
		break;
	
	case 'set_font_size':

		$status=$db->getRow("select * from mcs_configs where code = 'font_size' ");

		if(IS_POST){
			
			$size=$_POST['size'];

			if($status){
				$re=$db->Execute("update mcs_configs set value = '".$size."' where code = 'font_size'  ");
				if($re){
					Message("修改成功",0,'system.php?act=font_size');
				}
			}else{
				$re=$db->Execute("insert into mcs_configs (pid,code,name,type,value)value(10,font_size,'字体大小',text,'".$size."')");
				if($re){
					Message("插入成功",0,'system.php?act=font_size');
				}
				
			}
			
			
		}else{

			$view->assign("font_size",$status['value']);
			$view->display('set_font_size');
		}
		break;
		
	case 'send_all_message':
			if(IS_POST){
				$content=$_POST['content'];
				$results=$db->getAll("select * from mcs_users");
				foreach($results as $k=>$v){
					$db->Execute("insert into mcs_member_message (tuid,guid,content,state,gettime)value('".$v['user_id']."','".$v['user_id']."','".$content."','0','".time()."')");
				}
				Message('发送成功',0,'system.php?act=send_all_message');
			}else{
				$view->display('send_all_message');
			}
		break;
		
	
    default:
        if(IS_POST)
        {
            $param = $_POST['param'];

            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }


        $params = $db->getAll("select * from mcs_configs where pid=1 order by id asc");
        foreach($params as $key => $val)
        {
            if($val['type'] == 'radio')
            {
                $opt = explode(',', $val['options']);

                $val['options'] = array();
                foreach($opt as $v)
                {
                    $val['options'][] = array('value'=>$v, 'note'=>$_LANG[$val['code']][$v]);
                }
            }

            $params[$key] = $val;
        }

        $view->assign('params', $params);
        $view->display('system_base');
        break;
}
?>
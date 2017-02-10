<?php
require 'init.php';

switch($action)
{	case 'userinfo':
		if(IS_POST){
			$data = $_POST;
			if(empty($data)){
				JSMessage("非法参数"."user.php");
			}
			$res = $db->Execute("update mcs_users set is_ok = ".$data['is_ok']." where user_id = ".$data['user_id']);
			if($res){
				JSMessage("修改成功","user.php");
			}else{
				JSMessage("修改失败","user.php");
			}
		}else{
			$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
			if(!$uid){
				JSMessage("非法参数","user.php");
			}
			$data = $db->getRow("select user_name,user_id,mobile_phone,qq,email,user_rank,rank_expiry,mobile_phone,user_money,pay_money,rank_points,pay_points,is_ok from mcs_users where user_id =".$uid);
			//var_dump($data);
			if($data['user_rank'] && $data['rank_expiry'] > 0){
				$data['user_rank'] = $db->getField("mcs_user_rank","rank_name","rank_id = ".$data['user_rank']);
			}
			$view->assign("data",$data);
			$view->display('user_info');
		}
    break;
	case 'userfrozen':
        $sql="update mcs_users set statu=0 where user_id=".$_GET['id'];
        if($db->Execute($sql)){
            echo 1;
        }else{
            echo 0;
        }
    break;
    case 'unfrozen':
    	$sql="update mcs_users set statu=1 where user_id=".$_GET['id'];
        if($db->Execute($sql)){
            echo 1;
        }else{
            echo 0;
        }

    break;
    case 'info':
        $rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
        $info = $db->getRow("select * from mcs_user_rank where rank_id=$rid");
        if($info)
        {
            $rank_param = unserialize($info['param']);
            $info = array_merge($info, $rank_param);
        }
        else
        {
            $rid = 0; $info = array();
        }

        if(IS_POST)
        {
            $rank_name = trim($_POST['rank_name']);
            $min_points = intval($_POST['min_points']);
            $max_points = intval($_POST['max_points']);
            $special = isset($_POST['special']) ? 1 : 0;
            $price = floatval($_POST['price']);
            $param = serialize($_POST['param']);

            if($rid)
            {
                $sql = "update mcs_user_rank set rank_name='$rank_name', min_points='$min_points', max_points='$max_points', special='$special', price='$price', param='$param' where rank_id=$rid";
            }
            else
            {
                $sql = "insert into mcs_user_rank(rank_name, min_points, max_points, special, price, param) values('$rank_name', '$min_points', '$max_points', '$special', '$price', '$param')";
            }
            $db->Execute($sql);
            
            Redirect('?act=list');

        }
		//var_dump($info);
        $view->assign('info', $info);
        $view->assign('params', $rank_params);
        $view->display('user_rankinfo');
        break;

    default:        
        $sql = "select * from mcs_users order by add_time desc";
        $users = $db->getAll($sql);
        foreach($users as $key => $val)
        {
            $val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);

            // if($val['user_rank'] && $val['rank_expiry'] > time())
            // {
            //     $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "rank_id='{$val['user_rank']}'");
            // }
            // else
            // {
            //     $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "min_points<='{$val['rank_points']}' and '{$val['rank_points']}'<=max_points order by max_points desc"); 
            // }
            //原内容


            $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "rank_id='{$val['user_rank']}'");
            //修改后的gq

			if($val['is_ok'] == 0){
				$val['is_ok'] = "正常";
			}else{
				$val['is_ok'] = "<span style='color:red;'>冻结</span>";
			}

            $users[$key] = $val;
        }
        // pre($users);die;
        $view->assign('users', $users);
        $view->display('user_list');
        break;
}
?>
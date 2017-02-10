<?php
require 'init.php';

switch($action)
{
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
        $view->assign('info', $info);
        $view->assign('params', $rank_params);
        $view->display('user_rankinfo');
        break;
    case 'add':
        if(IS_POST){
            if($db->Execute('update mcs_users set user_money=user_money-'.$_CFG['business_money'].',business='.$_CFG['business_money'].' where user_id='.$_POST['id'])){
                $db->Execute("insert into mcs_member_logs(uid,createtime,user_money,info,logtype,type) value(".$_POST['id'].",'".time()."','-".$_CFG['business_money']."','加入商保服务','存款日志','payde')");//存款日志
                echo 1;
            }
        }else{
            $list=$db->getAll("select user_id,user_name,statu,add_time from mcs_users where not business>0");
            $view->assign("users",$list);
            // pre($_CFG);die;
            $view->display('user_businessadd');
        }
    break;
    default:        
        $sql = "select * from mcs_users where business>0 order by add_time desc";
        $users = $db->getAll($sql);
        foreach($users as $key => $val)
        {
            $val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);

            if($val['user_rank'] && $val['rank_expiry'] > time())
            {
                $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "rank_id='{$val['user_rank']}'");
            }
            else
            {
                $val['rank_name'] = $db->getField('mcs_user_rank', 'rank_name', "min_points<='{$val['rank_points']}' and '{$val['rank_points']}'<=max_points order by max_points desc"); 
            }

            $users[$key] = $val;
        }
        $view->assign('users', $users);
        $view->display('user_list');
        break;
}
?>
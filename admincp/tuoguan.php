<?php
require 'init.php';

switch($action)
{
    case 'info':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $info = $db->getRow("select * from mcs_tuoguan where id=$id");
        if(!$info) $id = 0;

        if(IS_POST)
        {
            $title = trim($_POST['title']);
            $price = intval($_POST['price']);
            $days = trim($_POST['days']);

            if($id)
            {
                $sql = "update mcs_tuoguan set title='$title', price='$price', days='$days' where id=$id";
            }
            else
            {
                $sql = "insert into mcs_tuoguan(title, price, days) values('$title', '$price', '$days')";
            }

            $db->Execute($sql);

            Redirect('?act=list');
        }
        $view->assign('info', $info);
        $view->display('tuoguan_info');
        break;

    default:
        $dpid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dpid)
        {
            $db->Execute("delete from mcs_tuoguan where id=$dpid");
            Redirect('?act=list');
        }
        $sql = "select * from mcs_tuoguan";
        $list = $db->getAll($sql);
        $view->assign('list', $list);
        $view->display('tuoguan_list');
        break;
}
?>
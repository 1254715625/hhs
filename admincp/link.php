<?php
require 'init.php';

switch($action)
{
    case 'info':
        $rid = isset($_REQUEST['rid']) ? intval($_REQUEST['rid']) : 0;
        $info = $db->getRow("select * from mcs_link where id=$rid");
        if(IS_POST)
        {
            $name = trim($_POST['name']);
            $link = trim($_POST['link']);
            $shownum = trim($_POST['shownum']);

            if($rid){
                $sql = "update mcs_link set name='$name',link='$link',shownum='$shownum' where id=$rid";
            }else{
                $sql = "insert into mcs_link(name, link, shownum) values('$name', '$link', '$shownum')";
            }
            $db->Execute($sql);
            
            Redirect('?act=list');

        }
        $view->assign('info', $info);
        $view->display('link_info');
        break;

    default:
        $dropid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dropid)
        {
            $db->Execute("delete from mcs_link where id=$dropid");
            Redirect('?act=list');
        }
        
        $sql = "select * from mcs_link order by shownum asc, id asc";
        $ranks = $db->getAll($sql);

        $view->assign('ranks', $ranks);
        $view->display('link_list');
        break;
}
?>
<?php
require 'init.php';

switch($action)
{
    case 'info':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $info = $db->getRow("select * from mcs_task_reward where id=$id");
        if(!$info){$id = 0;}

        if(IS_POST)
        {
            $releases = intval($_POST['releases']);
            $takeover = intval($_POST['takeover']);
            $reward = intval($_POST['reward']);
			if($releases==0&&$takeover==0){
				echo '<script type="text/javascript">alert("每天发布任务与接手任务不能同时为0~");history.back();</script>';exit;
			}
			if($reward==0){
				echo '<script type="text/javascript">alert("请填写任务奖励~");history.back();</script>';exit;
			}
            if($id)
            {
                $sql = "update mcs_task_reward set releases=$releases, takeover=$takeover, reward=$reward where id=$id";
            }
            else
            {
                $sql = "insert into mcs_task_reward(releases, takeover, reward) values($releases, $takeover, $reward)";
            }

            $db->Execute($sql);

            Redirect('?act=list');
        }
        $view->assign('info', $info);
        $view->display('reward_info');
        break;

    default:
        $dpid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dpid)
        {
            $db->Execute("delete from mcs_task_reward where id=$dpid");
            Redirect('?act=list');
        }
        $sql = "select * from mcs_task_reward";
        $list = $db->getAll($sql);
        $view->assign('list', $list);
        $view->display('reward_list');
        break;
}
?>
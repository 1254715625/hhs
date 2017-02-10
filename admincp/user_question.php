<?php
require 'init.php';

switch($action)
{
    case 'info':
        $rid = isset($_REQUEST['rid']) ? intval($_REQUEST['rid']) : 0;
        $info = $db->getRow("select * from mcs_question where id=$rid");
        if(IS_POST)
        {
            $title = trim($_POST['title']);
            $prompt = trim($_POST['prompt']);
            $shownum = intval($_POST['shownum']);
			$answer = trim($_POST['answer']);
			$topic = serialize($_POST['topic']);

            if($rid){
                $sql = "update mcs_question set title='$title',prompt='$prompt',shownum='$shownum',answer='$answer',topic='$topic' where id=$rid";
            }else{
                $sql = "insert into mcs_question(title, prompt, shownum, answer, topic) values('$title', '$prompt', '$shownum', '$answer', '$topic')";
            }
            $db->Execute($sql);
            
            Redirect('?act=list');

        }
		if($info['topic']){$info['topic']=unserialize($info['topic']);}
		if($info['shownum']==''){$info['shownum']=$db->getField('mcs_question','shownum','id>0 order by shownum desc')+10;}
        $view->assign('info', $info);
        $view->display('question_info');
        break;

    default:
        $dropid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dropid)
        {
            $db->Execute("delete from mcs_question where id=$dropid");
            Redirect('?act=list');
        }
        
        $sql = "select * from mcs_question order by shownum asc, id asc";
        $ranks = $db->getAll($sql);

        $view->assign('ranks', $ranks);
        $view->display('question_list');
        break;
}
?>
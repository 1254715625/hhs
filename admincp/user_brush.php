<?php
require 'init.php';

$week=date('w')==0?7:date('w');
$monday=strtotime(date('Y-m-d'))-(($week-1)*86400);
switch($action)
{
	case 'search':
		
		$data = $db->getAll("select * from mcs_exam ");
		//var_dump($data);
		$view->assign('data', $data);
        $view->display('user_search');
	break;
	
	
	case 'brush':
		if(IS_POST&&IS_AJAX){
			$data=intval($_POST['data']);
			$receive=$_POST['state']==2?2:1;
			$num=intval($_POST['num']);
			$uid=$db->getField('mcs_users','user_id','user_id='.$data.' and brush_time>0');
			if($uid>0&&$num>0){
				$has=$db->getCount('mcs_user_brush','uid='.$uid.' and addtime='.$monday);
				if(intval($has)==0){
					$db->Execute('insert into mcs_user_brush(uid,addtime,money,receive) values('.$uid.','.$monday.','.$num.','.$receive.')');
					$receive=$receive==1?'刷点：'.$num.'点':'存款：'.$num.'元';
					sys_message($uid,'你的'.date('Y-m-d',$monday).'周刷客任务奖励'.$receive.',已发放，请尽快前往<a href=\'user.php?act=specialty\'>职业刷客</a>领取');
				}
			}
		}
		exit;
	break;

    case 'info':
        if(IS_POST)
        {
            $param = $_POST['param'];
            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }
        $params = $db->getAll("select * from mcs_configs where pid=9 order by id asc");
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
        $view->display('user_brushset');
        break;

    default:
       
        $sql = "select * from mcs_users where brush_time>0 order by brush_time desc";
        $users = $db->getAll($sql);
        foreach($users as $k => $v)
        {
			if($db->getCount('mcs_user_brush','uid='.$v['user_id'].' and addtime='.$monday)){
				continue;
			}
            $v['brush']=date('Y-m-d',$v['brush_time']);
            $v['brush_end']=date('Y-m-d',$v['brush_time']+30*86400);
            $in_task=$db->getAll('select a.id,a.appeal from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=b.uid and a.get_user=b.id and b.uid='.$v['user_id'].' and b.acc_type="tb" and a.get_time>='.$monday);
            $i=0;
			if($in_task){
				foreach($in_task as $a){
					$i++;
					if($a['appeal']>0){
						$state=$db->getField('mcs_task_appeal','state','task_id='.$a['id'].' and pid=0');
						if($state==1){
							$i--;
						}
					}
				}
			}
			$one_buy=$db->getRow('select count(*) as num from mcs_task_taobao a,mcs_member_bindacc b where a.process=4 and a.uid!=b.uid and a.get_user=b.id and b.uid='.$v['user_id'].' and b.acc_type="tb" and a.get_time>='.$monday.' group by a.accid order by num desc');
			$v['in_task']=count($in_task);
			$v['in_tasks']=$i;
			$v['one_buy']=intval($one_buy['num']);
			$user[$k]=$v;
        }

        $view->assign('user', $user);
        $view->display('user_brush');
        break;
}
?>
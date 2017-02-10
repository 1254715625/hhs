<?php
require 'mcscore/init.php';
$act=$_REQUEST['act']?$_REQUEST['act']:'info';
switch($act){
	case 'vip':
		$rank_params = array(
			'rwpmkq'  =>array('name'=>'任务排名靠前', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
			'txyxcl'  =>array('name'=>'提现优先处理', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')),
			'bdzgsl'  =>array('name'=>'绑定掌柜数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'), 
			'kbcmbsl' =>array('name'=>'可保存模版数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'),	
			'ssyxjj'  =>array('name'=>'申述优先解决', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
			'gkvipbz' =>array('name'=>'更酷VIP标志', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
			'kfyxfw'  =>array('name'=>'客服优先服务', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
			'rwfz'    =>array('name'=>'任务复制', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')),
			'ksjf'    =>array('name'=>'快速积分', 'color'=>'#333', 'input'=>'text', 'unit'=>'倍'), 
			'tsjrws'  =>array('name'=>'同时接任务数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
			'tsfrws'  =>array('name'=>'同时发任务数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'),
			'mrtxcs'  =>array('name'=>'每日提现次数', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'次'), 
			'rwxhbl'  =>array('name'=>'任务消耗比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
			'mfdx'    =>array('name'=>'免费短信', 'color'=>'#333', 'input'=>'text', 'unit'=>'条/月'), 
			// 'fsdxjg'  =>array('name'=>'发送短信价格', 'color'=>'#333', 'input'=>'text', 'unit'=>'元'), 
			'sdhsjg'  =>array('name'=>'刷点回收价格', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元'), 
			'bdmhsl'  =>array('name'=>'绑定买号数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'), 
			//'tgyhtc'  =>array('name'=>'推广用户提成', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 		
			'kfpjcs'  =>array('name'=>'客服评价次数', 'color'=>'#333', 'input'=>'text', 'unit'=>'次/月'), 		
			'mhhmdgs' =>array('name'=>'买号黑名单个数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
			'yhhmdgs' =>array('name'=>'用户黑名单个数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
			'ckmhip'  =>array('name'=>'查看买号IP', 'color'=>'#333', 'input'=>'radio', 'value'=>array('无', '无限制')),
			'wyczsxf' =>array('name'=>'网银充值手续费', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
			'kddhgm'  =>array('name'=>'快递单号购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
			'zsdhgm'  =>array('name'=>'真实单号购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
			'ddgm'  =>array('name'=>'底单购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
			'mfkddh'  =>array('name'=>'免费快递单号', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个/天'),
			'xsrwbl'  =>array('name'=>'悬赏任务比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
			'wdmmbl'  =>array('name'=>'网店买卖比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
			'rjxhbl'  =>array('name'=>'软件消耗比例', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 
			'rjhyzjbl'=>array('name'=>'软件会员整加比例', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 
			'mhgqs'  =>array('name'=>'买号挂起数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个/天'), 
			'mhsds'  =>array('name'=>'买号锁定数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个/月'),
		);
		$width=array(126,108,101,119,109,87,79);
		$info=$db->getAll('select * from mcs_user_rank order by rank_id asc');
		$a=0;
		foreach($info as $k => $v){
			$info[$k]['param']=unserialize($v['param']);
			$info[$k]['width']=$width[$a];
			$a++;
		}
		$view->assign('info', $info);
		$view->assign('rank_params', $rank_params);
		$view->display('info/vip');
	break;
	case 'info':
		$uname=trim($_GET['uname']);
		$arr=array(1=>'好评',2=>'中评',3=>'差评');
		$arrclass=array(1=>'hao',2=>'',3=>'cha');
		$haoping='暂无评论信息';
		$type=array(1=>0,2=>0,3=>0);
		if(!empty($uname)){
			$info=$db->getRow('select * from mcs_users where user_name="'.$uname.'"');
			if(intval($info['user_id'])==0){
				die('<script type="text/javascript">alert("会员不存在~");window.opener=null;window.open("","_self");window.close();</script>');
			}
			$info['add_time']=date('Y-m-d',$info['add_time']);
			$comm=$db->page("select a.*,b.user_name from mcs_task_comm a,mcs_users b where a.uid=".intval($info['user_id'])." and b.user_id=a.tuid and a.type>0 order by a.addtime desc",10,5);
			$num=count($comm['record']);
			$info['black']=$db->getCount('mcs_member_black','accid='.$info['user_id']);
			if($num){
				foreach($comm['record'] as $k => $v){
					$comm['record'][$k]['user_name']=substr_replace($v['user_name'],'***',1,(strlen($v['user_name'])-2));
					if(empty($v['content'])){
						$comm['record'][$k]['content']='默认'.$arr[$v['type']];
					}
					$comm['record'][$k]['type']=$arr[$v['type']];
					$comm['record'][$k]['typeclass']=$arrclass[$v['type']];
					$comm['record'][$k]['addtime']=date('Y-m-d',$v['addtime']);
					$type[$v['type']]+=1;
				}
				$haoping=sprintf("%0.2f",(floatval($type[1]/$num)*100)).'%';
			}
		}
		$hot_bbs=$db->getAll('select * from mcs_forum_post where pid=0 order by views desc limit 7');
		if(count($hot_bbs)){
			foreach($hot_bbs as $k => $v){
				$hot_bbs[$k]['add_time']=date('m-d',$v['add_time']);
			}
		}
		$view->assign('info', $info);
		$view->assign('comm', $comm);
		$view->assign('type', $type);
		$view->assign('hot_bbs', $hot_bbs);
		$view->assign('haoping', $haoping);
		$view->display('info/info');
	break;

	case 'rank':
		$ranks['money']=$db->getAll('select sum(abs(a.user_money)) as money,b.user_name from mcs_member_logs a,mcs_users b where a.type="payde" and a.uid=b.user_id group by a.uid order by money desc limit 10');//消费金额

		$last=strtotime(date('Y-m-d'))-date('w')*86400;

		$ranks['out']=$db->getAll('select count(a.id) as num,b.user_name from mcs_task_taobao a,mcs_users b where a.uid=b.user_id and a.addtime>'.$last.' limit 10');//发任务

		$ranks['in']=$db->getAll('select count(a.id) as num,b.user_name from mcs_task_taobao a,mcs_users b,mcs_member_bindacc c where c.uid=b.user_id and c.buyno=0 and c.acc_type="tb" and c.id=a.get_user and a.addtime>'.$last.' limit 10');//接任务

		$ranks['points']=$db->getAll('select user_name,rank_points from mcs_users order by rank_points desc limit 10');
		$line=$db->getAll('select count(user_id) as num,extension from mcs_users where add_time>'.$last.' and extension>0 group by extension order by num desc limit 10');
		foreach($line as $k => $v){
			$line[$k]['user_name']=$db->getField('mcs_users','user_name','user_id='.intval($v['extension']));
			$line[$k]['money']=$v['num']*5;
			$line[$k]['key']=$k+1;
		}
		$lines=$db->getAll('select count(user_id) as num,extension from mcs_users where extension>0 group by extension order by num desc limit 10');
		foreach($lines as $k => $v){
			$lines[$k]['user_name']=$db->getField('mcs_users','user_name','user_id='.intval($v['extension']));
			$lines[$k]['money']=$v['num']*5;
			$lines[$k]['key']=$k+1;
		}
		$view->assign('line', $line);
		$view->assign('lines', $lines);
		$view->assign('ranks', $ranks);
		$view->display('info/rank');
	break;

	default:
		Redirect('home.php');
	break;
}
?>
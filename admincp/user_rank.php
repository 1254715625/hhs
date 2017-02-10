<?php
require 'init.php';


/*$rank_params = array(
		'mhgqs'  =>array('name'=>'买号挂起数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个/天'), 
		'mhsds'  =>array('name'=>'买号锁定数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个/月'), 
		'rwpmkq'  =>array('name'=>'任务排名靠前', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
		'txyxcl'  =>array('name'=>'提现优先处理', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')),
        'ssyxjj'  =>array('name'=>'申述优先解决', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
		'gkvipbz' =>array('name'=>'更酷VIP标志', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
		'kfyxfw'  =>array('name'=>'客服优先服务', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
		'rwfz'    =>array('name'=>'任务复制', 'color'=>'#333', 'input'=>'radio', 'value'=>array('否', '是')), 
		'ckmhip'  =>array('name'=>'查看买号IP', 'color'=>'#333', 'input'=>'radio', 'value'=>array('无', '无限制')), 
		'bdzgsl'  =>array('name'=>'绑定掌柜数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'), 
		'bdmhsl'  =>array('name'=>'绑定买号数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'), 
		'kddhgm'  =>array('name'=>'快递单号购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
		'zsdhgm'  =>array('name'=>'真实单号购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
		'ddgm'  =>array('name'=>'底单购买', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元/个'), 
		'mfkddh'  =>array('name'=>'免费快递单号', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个/天'), 
		'kbcmbsl' =>array('name'=>'可保存模版数量', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'个'),		
		'ksjf'    =>array('name'=>'快速积分', 'color'=>'#333', 'input'=>'text', 'unit'=>'倍'), 
		'tsjrws'  =>array('name'=>'同时接任务数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
		'tsfrws'  =>array('name'=>'同时发任务数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
		'mrtxcs'  =>array('name'=>'每日提现次数', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'次'), 
		'rwxhbl'  =>array('name'=>'任务消耗比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
		'mfdx'    =>array('name'=>'免费短信', 'color'=>'#333', 'input'=>'text', 'unit'=>'条/月'), 
		'fsdxjg'  =>array('name'=>'发送短信价格', 'color'=>'#333', 'input'=>'text', 'unit'=>'元'), 
		'sdhsjg'  =>array('name'=>'刷点回收价格', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'元'), 
		'tgyhtc'  =>array('name'=>'推广用户提成', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 
		'kfpjcs'  =>array('name'=>'客服评价次数', 'color'=>'#333', 'input'=>'text', 'unit'=>'次/月'), 
		'mhhmdgs' =>array('name'=>'买号黑名单个数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
		'yhhmdgs' =>array('name'=>'用户黑名单个数', 'color'=>'#333', 'input'=>'text', 'unit'=>'个'), 
		'xsrwbl'  =>array('name'=>'悬赏任务比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
		'wdmmbl'  =>array('name'=>'网店买卖比例', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
		'rjxhbl'  =>array('name'=>'软件消耗比例', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 
		'rjhyzjbl'=>array('name'=>'软件会员整加比例', 'color'=>'#ff0000', 'input'=>'text', 'unit'=>'%'), 
		'wyczsxf' =>array('name'=>'网银充值手续费', 'color'=>'#333', 'input'=>'text', 'unit'=>'%'), 
);
*/
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
		//'fsdxjg'  =>array('name'=>'发送短信价格', 'color'=>'#333', 'input'=>'text', 'unit'=>'元'),
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
		'txsxf'  =>array('name'=>'提现手续费', 'color'=>'#333', 'input'=>'text', 'unit'=>'元/次'),

);
switch($action)
{
    case 'info':
        $rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
        $info = $db->getRow("select * from mcs_user_rank join mcs_member_set on mcs_member_set.rank_name=mcs_user_rank.rank_name where rank_id=$rid");
        // pre($info);die;
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
        	// pre($_POST);die;
            $rank_name = trim($_POST['rank_name']);
            $min_points = intval($_POST['min_points']);
            $max_points = intval($_POST['max_points']);
            $special = isset($_POST['special']) ? 1 : 0;
            $price = floatval($_POST['price']);
            $point = intval($_POST['point']);
            $param = serialize($_POST['param']);
			$rwpmkq = intval($_POST['param']['rwpmkq']);
			$daytomax   =$_POST['daytomax'];
			$daygetmax  =$_POST['daygetmax'];
			$weektomax  =$_POST['weektomax'];
			$weekgetmax =$_POST['weekgetmax'];
			$monthtomax =$_POST['monthtomax'];
			$monthgetmax=$_POST['monthgetmax'];
			$weixinmax  =$_POST['weixinmax'];

            $TXmin      =$_POST['TXmin'];

            if($rid)
            {
                $sql = "update mcs_user_rank set TXmin = '$TXmin', rank_name='$rank_name', min_points='$min_points', max_points='$max_points', special='$special', price='$price', param='$param', rwpmkq='$rwpmkq' ,point='$point' where rank_id=$rid";
                $sql2="update mcs_member_set set rank_name='$rank_name',daygetmax='$daygetmax',daytomax='$daytomax',weektomax='$weektomax',weekgetmax='$weekgetmax',monthgetmax='$monthgetmax',monthtomax='$monthtomax',weixinmax='$weixinmax' where rank_name='$rank_name'";
            }
            else
            {
                $sql = "insert into mcs_user_rank(TXmin,rank_name, min_points, max_points, special, price, param, rwpmkq, point) values('$TXmin','$rank_name', '$min_points', '$max_points', '$special', '$price', '$param', '$rwpmkq', '$point')";
                $sql2="insert into mcs_member_set(rank_name,daygetmax,weekgetmax,monthgetmax,daytomax,weektomax,monthtomax,weixinmax) values('$rank_name','$daygetmax','$weekgetmax','$monthgetmax','$daytomax','$weektomax','$monthtomax','weixinmax')";
            }
            // pre($sql2);die;
            $db->Execute($sql);
            $db->Execute($sql2);
            
            Redirect('?act=list');

        }
        $view->assign('info', $info);
        $view->assign('params', $rank_params);
        $view->display('user_rankinfo');
        break;

    default:
        $dropid = isset($_GET['dropid']) ? intval($_GET['dropid']) : 0;
        if($dropid)
        {
            $db->Execute("delete from mcs_user_rank where rank_id=$dropid");
            Redirect('?act=list');
        }
        
        $sql = "select * from mcs_user_rank order by special asc, price asc";
        $ranks = $db->getAll($sql);
        foreach($ranks as $key => $val)
        {
            
        }

        $view->assign('ranks', $ranks);
        $view->display('user_ranklist');
        break;
}
?>
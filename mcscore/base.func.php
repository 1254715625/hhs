<?php
function Redirect($url = '')
{
	header("location: $url");
	exit;
}

function JSRedirect($url = '')
{
	header("location: $url");
	exit;
}

function cipherStr($str, $short = false)
{
	return $short ? substr(md5($str), 8, 16) : md5($str);
}

function addslashesStr($value)
{
	if(empty($value)) return $value;

	return is_array($value) ? array_map('addslashesStr', $value) : addslashes($value);    
}

function getRealIp()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

function gzipEnabled()
{
    static $enabled_gzip = null;

    if($enabled_gzip === null)
    {
        $enabled_gzip = ($GLOBALS['_CFG']['enable_gzip'] && function_exists('ob_gzhandler'));
    }

    return $enabled_gzip;
}

function cnsubstr($str, $len)
{
    if(strlen($str) <= $len) return $str;

    $slen = 0;
    for($i=0; $i<$len; $i++)
    {
        $slen += ord(substr($str, $slen, 1)) > 0xa0 ? 3 : 1;        
    }

    return substr($str, 0, $slen) . '...';
}

function short($url,$id=0){
	$charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$key = "hhsbbs";
	$urlhash = md5($key . $url);
	$len = strlen($urlhash);
	$i=intval($id%7);
	$urlhash_piece = substr($urlhash, $i * $len / 7, $len / 4);
	$hex = hexdec($urlhash_piece) & 0x3fffffff;
	$short_url = "";
	for ($j = 0; $j <7; $j++) {
		$short_url .= $charset[$hex & 0x0000003d];
		$hex = $hex >> 3;
	}	
	return strtoupper($short_url);
}
function count_tm($day,$reward_time,$releases,$takeover,$uid,$db){
	$finish=0;
	if($day>6){$day=6;}
	for($i=0;$i<=$day;$i++){
		$t=$reward_time+($i*86400);
		$is_true=1;
		if($releases){//发布任务数
			$out=$db->getCount('mcs_task_taobao','process=4 and get_time>'.$t.' and get_time<'.($t+86400).' and uid='.$uid);//已发任务
			if(($out/$releases)<1){
				$is_true=0;
			}
		}
		if($takeover){
			$in=$db->getCount('mcs_task_taobao a, mcs_member_bindacc b','a.process=4 and a.get_time>'.$t.' and get_time<'.($t+86400).' and a.get_user=b.id and b.uid='.$uid);//已接任务
			if(($in/$takeover)<1){
				$is_true=0;
			}
		}
		if($is_true){
			$finish++;
		}
	}
	return $finish;
}

function extension_log($user_id,$type,$task=array()){
	if($user_id>0&&$type!=''){
		$user=$GLOBALS['db']->getRow('select a.user_name,b.user_id,b.user_money,b.rank_points from mcs_users a,mcs_users b where a.user_id='.intval($user_id).' and a.extension>0 and a.extension=b.user_id');
		if($user['user_id']){
			switch($type){
				case 'task':
					$task['id']=$task['id'];
					$e_money='extension_'.$task['type'].'task_money';
					$e_point='extension_'.$task['type'].'task_point';
					if($GLOBALS['_CFG'][$e_money]>0){
						$GLOBALS['db']->Execute('update mcs_users set user_money=user_money+'.$GLOBALS['_CFG'][$e_money].' where user_id='.$user['user_id']);
						$info=(($task['ddlOKDay']==0)?'虚拟任务':'实物任务').$task['name'].$task['id'];
						$GLOBALS['db']->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,logtype,taskid,num,type) value('.$user['user_id'].','.time().','.$GLOBALS['_CFG'][$e_money].',"推广用户'.$user['user_name'].'完成'.$info.'，您得到该任务'.$GLOBALS['_CFG'][$e_money].'元存款","存款日志",'.$task['id'].','.($user['user_money']+$GLOBALS['_CFG'][$e_money]).',"payde")');
						$GLOBALS['db']->Execute('insert into mcs_user_extension(uid,eid,money,task,type,addtime) value('.$user['user_id'].','.$user_id.','.$GLOBALS['_CFG'][$e_money].','.$task['id'].',"'.$task['type'].'task_money",'.time().')');
					}
					if($GLOBALS['_CFG'][$e_point]>0){
						$GLOBALS['db']->Execute('update mcs_users set rank_points=rank_points+'.$GLOBALS['_CFG'][$e_point].' where user_id='.$user['user_id']);
						$GLOBALS['db']->Execute('insert into mcs_user_extension(uid,eid,point,task,type,addtime) value('.$user['user_id'].','.$user_id.','.$GLOBALS['_CFG'][$e_point].','.$task['id'].',"'.$task['type'].'task_point",'.time().')');
					}
				break;
				case 'buy':
					if($GLOBALS['_CFG']['extension_user_money']){
						$m=$GLOBALS['db']->getSum('mcs_user_extension','money','uid='.$user['user_id'].' and eid='.$user_id);
						if(($GLOBALS['_CFG']['extension_user_cap']==0)||$GLOBALS['_CFG']['extension_user_cap']>0&&$m<$GLOBALS['_CFG']['extension_user_cap']){

							$money=$task['money']*($GLOBALS['_CFG']['extension_user_money']/100);

							$GLOBALS['db']->Execute('update mcs_users set user_money=user_money+'.$money.' where user_id='.$user['user_id']);

							$GLOBALS['db']->Execute('insert into mcs_member_logs(uid,createtime,user_money,info,logtype,num,type) value('.$user['user_id'].','.time().','.$money.',"推广用户'.$user['user_name'].'购买'.$task['card'].'套餐，您得到该卡'.$money.'元存款","存款日志",'.($user['user_money']+$money).',"payde")');

							$GLOBALS['db']->Execute('insert into mcs_user_extension(uid,eid,money,type,addtime) value('.$user['user_id'].','.$user_id.','.$money.',"user_money",'.time().')');	
						}
					}
				break;
			}
		}
	}
}

function sys_message($uid,$message){
	$uid=$GLOBALS['db']->getField('mcs_users','user_id','user_id='.intval($uid));
	if($uid>0&&$message!=''){
		$GLOBALS['db']->Execute('insert into mcs_member_message(tuid,guid,content,gettime) value('.$uid.','.$uid.',"'.$message.'",'.time().')');	
	}
}
?>
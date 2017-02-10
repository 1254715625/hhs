<?php
error_reporting(E_ALL);
if(__FILE__ == '') die('Fatal error code: 0');

define('IN_MCS', true);
define('ROOT_PATH', str_replace('mcscore/init.php', '', str_replace('\\', '/', __FILE__)));
define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST');
define('IS_AJAX',isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define('PHP_SELF', isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
define('CHARSET', 'UTF-8');

@ini_set('memory_limit',          '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);
@ini_set('date.timezone','Asia/Shanghai');

//网站地址
define('WEB_NAME','http://hhs.lianmon.com/');

if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path', '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path', '.:' . ROOT_PATH);
}

require ROOT_PATH . 'data/configs.php';

if(defined('DEBUG_MODE') == false) define('DEBUG_MODE', 0);
if (PHP_VERSION >= '5.1' && !empty($timezone)) date_default_timezone_set($timezone);

require ROOT_PATH . 'mcscore/root.class.php';

Root::loadFunc('base');
Root::loadFunc('common');

if(!get_magic_quotes_gpc())
{
    $_GET       = addslashesStr($_GET);
    $_POST      = addslashesStr($_POST);
    $_COOKIE    = addslashesStr($_COOKIE);
    $_REQUEST   = addslashesStr($_REQUEST);
}

$db = Root::loadClass('mysql');
$db->connect($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 载入系统参数 */
$_CFG = loadConfig();
require ROOT_PATH . 'langs/' . $_CFG['lang'] . '/common.php';
require ROOT_PATH.'api/comm/publicfunction.php';
require ROOT_PATH.'api/comm/publicclass.php';
if($_CFG['site_closed'] == 1)
{
    /* 商店关闭了，输出关闭的消息 */
    header('Content-type: text/html; charset='. CHARSET);

    die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . $_LANG['site_closed'] . '</p><p>' . $_CFG['close_comment'] . '</p></div>');
}

require ROOT_PATH . 'mcscore/session.class.php';
$sess = new session($db, 'mcs_sessions');
define('SESS_ID', $sess->getSessionId());

header('Cache-control: private');
header('Content-type: text/html; charset='. CHARSET);

$view = root::loadClass('view');

$view->cache_lifetime = $_CFG['cache_time'];
$view->template_dir   = ROOT_PATH . 'themes/' . $_CFG['template'] . '/';
$view->cache_dir      = ROOT_PATH . 'temp/caches/';
$view->compile_dir    = ROOT_PATH . 'temp/compiled/';

$view->direct_output = false;
$view->force_compile = true;

define('TMP_DIR', 'themes/' . $_CFG['template'] . '/');
$point_multiple=1;//默认积分倍数
//print_r($_CFG);

$view->assign('lang', $_LANG);

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 

defined('INIT_NO_SMARTY') && gzipEnabled() ? ob_start() : ob_start('ob_gzhandler');

$action = isset($_GET['act']) ? trim($_GET['act']) : (isset($_POST['act']) ? trim($_POST['act']) : '');

$db->Execute('update mcs_users a,mcs_user_rank b set a.user_rank=b.rank_id,a.rank_expiry=0 where (a.rank_expiry=0 or (a.rank_expiry>0 and a.rank_expiry<'.time().')) and a.pay_points>=b.min_points and a.pay_points<=b.max_points and b.special=0');

$uinfo = $db->getRow("select * from mcs_users where user_id='{$_SESSION['user_id']}'");
if($uinfo)
{
	if($uinfo['autoam']>0){
		$uinfo['autoam_time']=date('Y-m-d H:i',$uinfo['autoam']);
		if($uinfo['autoam']<time()){
			$db->Execute('update mcs_users set autoam=0 where user_id='.$uinfo['user_id']);
			$uinfo['autoam']=0;
		}
		$uinfo['autoam_attr'] = unserialize($uinfo['autoam_attr']);
	}
	if($uinfo['saninter']>0&&$uinfo['saninter']<time()){
		$db->Execute('update mcs_users set saninter=0 where user_id='.$uinfo['user_id']);
		$uinfo['saninter']=0;
	}
	$rank = $db->getRow("select * from mcs_user_rank where rank_id='{$uinfo['user_rank']}'");
	$uinfo['rank_name'] = $rank['rank_name'];
	$uinfo['verify'] = intval($db->getField('mcs_member_realname','state','uid='.$uinfo['user_id']));
	$uinfo['params'] = unserialize($rank['param']);
	if($uinfo['brush_time']>0){
		$uinfo['rank_name']='职业刷客';
		$brush=$db->getAll("select code,value from mcs_configs where pid=9 order by id asc");
		foreach($brush as $v){
			$uinfo['params'][substr($v['code'],6)]=$v['value'];
		}
	}
	$uinfo['mess_set'] = unserialize($uinfo['mess_set']);
	$point_multiple=$uinfo['params']['ksjf'];//积分倍数
	if($uinfo['saninter']>0){
		$point_multiple=2;
	 }
	$uinfo['max_points'] = $db->getField('mcs_user_rank','max_points','min_points<='.$uinfo['pay_points'].' and max_points>='.$uinfo['pay_points'].' and special=0');

    //if($uinfo['mprz']) $uinfo['mobile_phone'] = preg_replace('/(\d{3})\d{4}/', '\1****', $uinfo['mobile_phone']);

	if(empty($uinfo['safepass'])&&PHP_SELF!='/user.php'&&$_GET['act']!='operate'){
		Redirect('user.php?act=operate');
	}
	//$uinfo['read_num']=$db->getCount("mcs_member_message","tuid=".$uinfo['user_id']." and fuid>0 and state=0");
	$uinfo['read_num']=$db->getCount("mcs_member_message","tuid=".$uinfo['user_id']." and state=0");
}
$view->assign('uinfo', $uinfo);

$view->assign('links', $db->getAll('select * from mcs_link order by shownum asc,id asc'));

$mount=array(1=>'一个月',2=>'二个月',3=>'三个月',6=>'半年',12=>'一年',24=>'二年',);
$viparr = array(
	6=>array(
		1=>29,
		2=>56,
		3=>75,
		6=>138,
		12=>239,
		24=>429
	),
	7=>array(
		1=>49,
		2=>89,
		3=>129,
		6=>246,
		12=>456,
		24=>839
	),
	8=>array(
		1=>99,
		2=>189,
		3=>279,
		6=>568,
		12=>1058,
		24=>2046
	)
);
$points=array('integral_post','integral_back','integral_outtask','integral_intask','integral_money','integral_login');

foreach($points as $v){
	$_CFG[$v]=$point_multiple*$_CFG[$v];
}

$user_ranks=$db->getAll('select rank_id,rank_name,special,param from mcs_user_rank order by rank_id asc');
foreach($user_ranks as $k =>$v){
	$_CFG['user_rank'][$v['rank_id']]['param']=unserialize($v['param']);
}
$view->assign('cfg', $_CFG);
$view->assign('mount',$mount);
$view->assign('viparr',$viparr);

//所有图片设置
$logo=$db->getRow("select * from mcs_picture where menu = 'logo' order by id desc ");
$detail=$db->getAll("select * from mcs_picture where menu = 'detail' order by id desc ");
$view->assign('logo',$logo);
$view->assign('detail',$detail);
?>
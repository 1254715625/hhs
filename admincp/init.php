<?php
error_reporting(E_ALL);
if(__FILE__ == '') die('Fatal error code: 0');

define('IN_MCS', true);
define('ROOT_PATH', str_replace('admincp/init.php', '', str_replace('\\', '/', __FILE__)));
define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST');
define('IS_AJAX',$_SERVER['HTTP_HOST']==$_SERVER['SERVER_NAME']&&isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define('PHP_SELF', isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
define('CHARSET', 'UTF-8');

/* ³õÊ¼»¯ÉèÖÃ */
@ini_set('memory_limit',          '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);
@ini_set('date.timezone','Asia/Shanghai');

if(DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path',      '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path',      '.:' . ROOT_PATH);
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

require ROOT_PATH . 'mcscore/session.class.php';
require ROOT_PATH.'api/comm/publicfunction.php';
require ROOT_PATH.'api/comm/publicclass.php';
$sess = new session($db, 'mcs_sessions', 'MCSCP_ID');

$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';

$_CFG = loadConfig();

if($action == 'captcha')
{
    
}

require ROOT_PATH . 'langs/' . $_CFG['lang'] . '/admincp/common.php';
if(is_file(ROOT_PATH . 'langs/' . $_CFG['lang'] . '/admincp/' . basename(PHP_SELF)))
{
    require ROOT_PATH . 'langs/' . $_CFG['lang'] . '/admincp/' . basename(PHP_SELF);
}

if(!is_dir(ROOT_PATH . 'temp/caches'))
{
    @mkdir(ROOT_PATH . 'temp/caches', 0777, true);
    @chmod(ROOT_PATH . 'temp/caches', 0777);
}

if (!file_exists(ROOT_PATH . 'temp/compiled/admincp'))
{
    @mkdir(ROOT_PATH . 'temp/compiled/admincp', 0777, true);
    @chmod(ROOT_PATH . 'temp/compiled/admincp', 0777);
}

clearstatcache();

$view = root::loadClass('view');
$view->template_dir   = ROOT_PATH . 'admincp/template/';
$view->compile_dir    = ROOT_PATH . 'temp/compiled/admincp/';

$view->force_compile = true;

define('TMP_DIR', 'template/');
$view->assign('lang', $_LANG);

if((!isset($_SESSION['admin_id']) || intval($_SESSION['admin_id']) < 1) && strrpos(PHP_SELF, 'privilege.php') === false)
{
    Redirect("privilege.php"); 
}

header('content-type: text/html; charset=' . CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

(DEBUG_MODE & 1) == 1 ? error_reporting(E_ALL) : error_reporting(E_ALL ^ E_NOTICE);
gzipEnabled() ? ob_start('ob_gzhandler') : ob_start();

?>
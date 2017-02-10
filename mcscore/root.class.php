<?php
class Root
{
    public static function loadConfig($cfgname, $key = '', $reload = false)
    {
        static $configs = array();

        if(!$reload && isset($configs[$cfgname]))
        {
            return $key ? $configs[$cfgname][$key] : $configs[$cfgname];
        }

        $path = ROOT_PATH . 'data/configs/'. $cfgname .'.cfg.php';

        if(!is_file($path)) return false;

        $configs[$cfgname] = include $path;

        return $key ? $configs[$cfgname][$key] : $configs[$cfgname];
    }

	public static function loadFunc($fname)
	{
		static $funcs = array();
		$path   = ROOT_PATH . 'mcscore/'. $fname .'.func.php';
		$key    = md5($path);

		if(isset($funcs[$key])) return true;
		if(!is_file($path)) return false;

		include $path;
		$funcs[$key] = true;
		return true;
	}

    public static function loadClass($clsname, $init = 1)
    {
        static $classes = array();
        $path = ROOT_PATH . 'mcscore/'. $clsname .'.class.php';
        $key = md5($path);

        if(isset($classes[$key])) return $classes[$key];

        if(!is_file($path)) return false;

        include $path;

        if($init) $classes[$key] = new $clsname; else $classes[$key] = true;

        return $classes[$key];
    }
}
?>
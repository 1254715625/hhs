<?php
class view
{
    public $template_dir   = '';
    public $cache_dir      = '';
    public $compile_dir    = '';
    public $cache_lifetime = 3600; 
    public $direct_output  = false;
    public $force_compile  = false;
    public $caching        = false;

    private $_var           = array();
    private $_errorlevel    = 0;
    private $_nowtime       = 0;
    private $_seterror      = 0;
    private $_foreachmark   = '';

    private $_temp_key      = array();  // 临时存放 foreach 里 key 的数组
    private $_temp_val      = array();  // 临时存放 foreach 里 item 的数组

    public function __construct()
    {
        $this->_errorlevel = error_reporting();
        $this->_nowtime    = time();
    }

    public function assign($var, $val)
    {
        if(is_array($var))
        {
            $this->_var = array_merge($this->_var, $var);
        }
        else
        {
            $this->_var[$var] = $val; 
        }
    }

    public function display($tplname)
    {
        $this->_seterror++;
        error_reporting(E_ALL ^ E_NOTICE);

        $this->_checkfile = false;
        $out = $this->fetch($tplname, $cache_id);

        error_reporting($this->_errorlevel);
        $this->_seterror--;

        echo $out;
    }

    private function fetch($tplname, $cache_id = '')
    {
        if(!$this->_seterror) error_reporting(E_ALL ^ E_NOTICE);
        $this->_seterror++;

        $tplfile = $this->template_dir . $tplname . '.html';

        if(!is_file($tplfile)) die('Template does not exist.('. $tplfile .')');

        if($this->direct_output)
        {
            $out = $this->_eval($this->fetchCode(file_get_contents($filename)));
        }
        else
        {
            $out = $this->makeCompiledFile($tplfile);
        }

        $this->_seterror--;
        if(!$this->_seterror) error_reporting($this->_errorlevel);

        return $out;
    }

    private function makeCompiledFile($tplfile)
    {
        $modfile = str_replace($this->template_dir, '', $tplfile);

        $cmpfile = $this->compile_dir . str_replace('/', '_', $modfile) . '.php';

        $expires = @filemtime($cmpfile) - @filemtime($tplfile);

        if($expires > 0 && !$this->force_compile)
        {
            if(!is_file($cmpfile) || !$source = $this->_require($cmpfile)) $source = 0;
        }

        if($this->force_compile || $expires < 1)
        {
            $source = $this->fetchCode(file_get_contents($tplfile));

            if(file_put_contents($cmpfile, $source, LOCK_EX) === false) trigger_error('can\'t write:' . $cmpfile);

            $source = $this->_eval($source);
        }

        return $source;
    }

    private function fetchCode($source)
    {
        $source = $this->prefilterCompile($source);

        $source = preg_replace('/{include\s+(.+)}/Ui', '<?php echo $this->fetch("\\1"); ?>', $source);

        $source = preg_replace('/{\$([\[\]\w\.\$]+)}/Uie', "\$this->getVal('\\1', true);", $source);	

        $source = preg_replace('/{if\s+(.+)}/Uie', "\$this->compileIfTag('\\1');", $source);
		$source = preg_replace('/{elseif\s+(.+)}/Uie', "\$this->compileIfTag('\\1', true);", $source);
		$source = preg_replace('/{else}/Ui', '<?php }else{ ?>', $source);
		$source = preg_replace('/{\/if}/Ui', '<?php } ?>', $source);

		$source = preg_replace('/{foreach\s+(.+)}/Uie', "\$this->compileForeachTag('\\1');", $source);
		$source = preg_replace('/{\/foreach}/Ui', '<?php } ?>', $source);

		$source = preg_replace('/{for\s+(.+)}/Uie', "\$this->compileForTag('\\1');", $source);
		$source = preg_replace('/{\/for}/Ui', '<?php } ?>', $source);

        return $source;
    }

    private function prefilterCompile($source)
    {
        $source = preg_replace('/(<link\s+.*href=["|\'])(?:\.\/|\.\.\/)?(css\/[\w-\/]+\.css["|\'])/i', '\1' . TMP_DIR . '\2', $source);

        $source = preg_replace('/(<script\s+.*src=["|\'])(?:\.\/|\.\.\/)?(js\/[\w-\/\.]+\.js["|\'])/i', '\1' . TMP_DIR . '\2', $source);

        $pattern = array(
            '/<!--[^>|\n]*?({.+?})[^<|{|\n]*?-->/', // 替换smarty注释
            '/<!--[^<|>|{|\n]*?-->/',               // 替换不换行的html注释
            '/(href=["|\'])\.\.\/(.*?)(["|\'])/i',  // 替换相对链接
            '/((?:background|src)\s*=\s*["|\'])(?:\.\/|\.\.\/)?(images\/.*?["|\'])/is', // 在images前加上 $tmp_dir
            '/((?:background|background-image):\s*?url\()(?:\.\/|\.\.\/)?(images\/)/is', // 在images前加上 $tmp_dir
            '/([\'|"])\.\.\//is', // 以../开头的路径全部修正为空
            );
        $replace = array(
            '\1',
            '',
            '\1\2\3',
            '\1' . TMP_DIR . '\2',
            '\1' . TMP_DIR . '\2',
            '\1'
            );

        return preg_replace($pattern, $replace, $source);
    }

    private function compileForeachTag($str)
	{
		$attrs = $this->getParams($str, 0);

		$item = $this->getVal($attrs['item']);
		if($attrs['key']) $key = $this->getVal($attrs['key']) .' => ';
		$from = $attrs['from'];

		$str = '<?php if('. $from .')foreach('. $from .' as '. $key . $item .'){ ?>';

		return $str;
	}

    private function compileIfTag($str, $elseif = false)
    {
        preg_match_all('/\-?\d+[\.\d]+|\'[^\'|\s]*\'|"[^"|\s]*"|[\$\w\.]+|!==|===|==|!=|<>|<<|>>|<=|>=|&&|\|\||\(|\)|,|\!|\^|=|&|<|>|~|\||\%|\+|\-|\/|\*|\@|\S/', $str, $match);

		$tokens = $match[0];

		if (!empty($token_count['(']) && $token_count['('] != $token_count[')'])
        {
            // $this->_syntax_error('unbalanced parenthesis in if statement', E_USER_ERROR, __FILE__, __LINE__);
        }

        for ($i = 0, $count = count($tokens); $i < $count; $i++)
        {
            $token = &$tokens[$i];
            switch (strtolower($token))
            {
                case 'eq':
                    $token = '==';
                    break;

                case 'ne':
                case 'neq':
                    $token = '!=';
                    break;

                case 'lt':
                    $token = '<';
                    break;

                case 'le':
                case 'lte':
                    $token = '<=';
                    break;

                case 'gt':
                    $token = '>';
                    break;

                case 'ge':
                case 'gte':
                    $token = '>=';
                    break;

                case 'and':
                    $token = '&&';
                    break;

                case 'or':
                    $token = '||';
                    break;

                case 'not':
                    $token = '!';
                    break;

                case 'mod':
                    $token = '%';
                    break;

                default:
                    if ($token[0] == '$')
                    {
                        $token = $this->getVal(substr($token, 1));
                    }
                    break;
            }
        }

        if ($elseif)
        {
            return '<?php }elseif(' . implode(' ', $tokens) . '){ ?>';
        }
        else
        {
            return '<?php if(' . implode(' ', $tokens) . '){ ?>';
        }		
		
		return $str;
    }

    private function getVal($val, $echo = 0)
    {
        if(strrpos($val, '[') !== false)
        {
            $val = preg_replace("/\[([^\[\]]*)\]/eis", "'.'.str_replace('$','\$','\\1')", $val);
        }

        if(strrpos($val, '|') !== false)
        {
            $moddb = explode('|', $val);
            $val = array_shift($moddb);
        }

        if(empty($val)) return '';

        if(strpos($val, '.$') !== false)
        {
            $all = explode('.$', $val);

            foreach ($all AS $key => $val)
            {
                $all[$key] = $key == 0 ? $this->makeVar($val) : '['. $this->makeVar($val) . ']';
            }
            $p = implode('', $all);
        }
        else
        {
            $p = $this->makeVar($val);
        }

        if(!empty($moddb))
        {
            foreach ($moddb AS $key => $mod)
            {
                $s = explode(':', $mod);
                switch ($s[0])
                {
                    case 'escape':
                        $s[1] = trim($s[1], '"');
                        if ($s[1] == 'html')
                        {
                            $p = 'htmlspecialchars(' . $p . ')';
                        }
                        elseif ($s[1] == 'url')
                        {
                            $p = 'urlencode(' . $p . ')';
                        }
                        elseif ($s[1] == 'decode_url')
                        {
                            $p = 'urldecode(' . $p . ')';
                        }
                        elseif ($s[1] == 'quotes')
                        {
                            $p = 'addslashes(' . $p . ')';
                        }
                        elseif ($s[1] == 'u8_url')
                        {
                            if (CHARSET != 'utf-8')
                            {
                                $p = 'urlencode(ecs_iconv("' . CHARSET . '", "utf-8",' . $p . '))';
                            }
                            else
                            {
                                $p = 'urlencode(' . $p . ')';
                            }
                        }
                        else
                        {
                            $p = 'htmlspecialchars(' . $p . ')';
                        }
                        break;

                    case 'nl2br':
                        $p = 'nl2br(' . $p . ')';
                        break;

                    case 'default':
                        $s[1] = $s[1]{0} == '$' ?  $this->get_val(substr($s[1], 1)) : "'$s[1]'";
                        $p = 'empty(' . $p . ') ? ' . $s[1] . ' : ' . $p;
                        break;

                    case 'truncate':
                        $p = 'sub_str(' . $p . ",$s[1])";
                        break;

                    case 'strip_tags':
                        $p = 'strip_tags(' . $p . ')';
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        return $echo ? '<?php echo '. $p .'; ?>' : $p;
    }

	private function makeVar($val)
    {
        if (strrpos($val, '.') === false)
        {
            if (isset($this->_var[$val]) && isset($this->_patchstack[$val]))
            {
                $val = $this->_patchstack[$val];
            }
            $p = '$this->_var[\'' . $val . '\']';
        }
        else
        {
			$t = explode('.', $val);
			$_var_name = array_shift($t);
			$_sys_var = array('GET', 'POST', 'COOKIE', 'SESSION', 'REQUEST');
           
            if(in_array(strtoupper($_var_name), $_sys_var))
            {
                 $p = '$_'. strtoupper($_var_name);
            }
            else
            {
                $p = '$this->_var[\'' . $_var_name . '\']';
            }
            foreach ($t AS $val)
            {
                $p.= '[\'' . $val . '\']';
            }
        }

        return $p;
    }

    private function getParams($val, $type = false)
    {
        $pa = $this->strTrim($val); 
        foreach ($pa AS $value)
        {
            if (strrpos($value, '='))
            {
                list($a, $b) = explode('=', str_replace(array(' ', '"', "'", '&quot;'), '', $value));
                if ($b{0} == '$')
                {
                    if ($type)
                    {
                        eval('$para[\''. $a .'\']=' . $this->get_val(substr($b, 1)) . ';');
                    }
                    else
                    {
                        $para[$a] = $this->getVal(substr($b, 1));
                    }
                }
                else
                {
                    $para[$a] = $b;
                }
            }
        }

        return $para;
    }

	private function strTrim($str)
    {
        while(strpos($str, '= ') != 0)
        {
            $str = str_replace('= ', '=', $str);
        }
        while (strpos($str, ' =') != 0)
        {
            $str = str_replace(' =', '=', $str);
        }

        return explode(' ', trim($str));
    }

    private function _eval($content)
    {
        ob_start();
        eval('?' . '>' . trim($content));
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function _require($filename)
    {
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
?>
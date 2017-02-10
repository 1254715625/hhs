<?php
class mysql
{
    private $link_id    = NULL;

    public $qcount = 0;
    public $qtime  = 0;
    public $qlog   = array();
    public $wlog = false;

    private $err_msg  = array();
    private $version        = '';
    private $starttime      = 0;
    private $timeline       = 0;
    private $timezone       = 0;

    public function __construct(){}

    public function connect($db_host, $db_user, $db_pass, $db_name = '', $charset = 'gbk', $pconn = 0)
    {
        $charset = defined('CHARSET') ? strtolower(str_replace('-', '', CHARSET)) : $charset;

        if($pconn){
            if(!$this->link_id = @mysql_pconnect($db_host, $db_user, $db_pass))
            {
                $this->ErrorMsg("Can't pConnect MySQL Server($db_host)!");
                return false;
            }
        }else{
            if(PHP_VERSION >= '4.2')
            {
                $this->link_id = @mysql_connect($db_host, $db_user, $db_pass, true);
            }
            else
            {
                $this->link_id = @mysql_connect($db_host, $db_user, $db_pass);
                mt_srand((double)microtime() * 1000000);                
            }

            if(!$this->link_id)
            {
                 $this->ErrorMsg("Can't Connect MySQL Server($db_host)!");
                 return false;
            }
        }        

        $this->version = mysql_get_server_info($this->link_id);

        if ($this->version > '4.1')
        {
            if($charset != 'latin1')
            {
                mysql_query("SET character_set_connection=$charset, character_set_results=$charset, character_set_client=binary", $this->link_id);
            }

            if($this->version > '5.0.1') mysql_query("SET sql_mode=''", $this->link_id);
        }

        $this->starttime = time();

        if($db_name && mysql_select_db($db_name, $this->link_id) === false)
        {
            $this->ErrorMsg("Can't select MySQL database($db_name)!");
            return false;            
        }
        
        return true;
    }

    private function query($sql)
    {
        if($this->qtime == 0)
        {
            $this->qtime = (PHP_VERSION >= '5.0.0') ? microtime(true) : microtime();
        }

        if(PHP_VERSION >= '4.3' && time() > $this->starttime + 1) mysql_ping($this->link_id);

        if(!$query = mysql_query($sql, $this->link_id))
        {
            $this->err_msg['message'] = 'MySQL Query Error';
            $this->err_msg['sql'] = $sql;
            $this->err_msg['error'] = mysql_error($this->link_id);
            $this->err_msg['errno'] = mysql_errno($this->link_id);

            $this->ErrorMsg();
            return false;
        }


        if($this->wlog)
        {
            $log_dir = ROOT_PATH . 'data/logs/';

            if(!is_dir($log_dir))
            {
                @mkdir($log_dir, 0777, true);
                @chdir($log_dir, 0777);
            }

            $log_file = $log_dir . 'mysql_'. date('Ymd') .'.log';
            
            $str = "[". date('Y-m-d H:i:s') ."]----------------------------------------------------------------\r\n";
            $str .= $sql . "\r\n";

            if (PHP_VERSION >= '5.0')
            {
                file_put_contents($log_file, $str, FILE_APPEND);
            }
            else
            {
                $fp = @fopen($log_file, 'ab+');
                if($fp)
                {
                    fwrite($fp, $str);
                    fclose($fp);
                }
            }
        }

        return $query;
    }

    public function Execute($sql)
    {
        $res = $this->query($sql);
		if($res === false) return false;
        $count = @mysql_affected_rows($this->link_id);
        if ($count < 1) return false;
        return true;
    }

    public function getRow($sql)
    {
        $res = $this->query($sql);
		return $res === false ? false : mysql_fetch_assoc($res);
    }

    public function getAll($sql)
    {
        $res = $this->query($sql);
		if($res === false) return false;

		$arr = array();
		while($row = mysql_fetch_assoc($res)) $arr[] = $row;

		return $arr;        
	}

    public function getField($table, $field, $where='')
	{
		$sql = "select `$field` from $table";
		if($where)$sql .= " where $where";

		$res = $this->query($sql);
		if($res === false)return false;

		$arr = mysql_fetch_row($res);
		return $arr[0];
	}

    public function getCount($table, $where = '', $field = '*')
	{
		$sql = "select count($field) from $table";
		if($where)$sql .= " where $where";

		$res = $this->query($sql);
		if($res === false)return false;

		$arr = mysql_fetch_row($res);
		return $arr[0] ? $arr[0] : 0;
	}

	public function getSum($table, $field,  $where = '')
	{
		$sql = "select sum(`$field`) from $table";
		if($where)$sql .= " where $where";

		$res = $this->query($sql);
		if($res === false)return false;

		$arr = mysql_fetch_row($res);
		return $arr[0] ? $arr[0] : 0;
	}

    public function getCol($table, $field,  $where = '')
    {
        $sql = "select `$field` from $table";
		if($where)$sql .= " where $where";

        $res = $this->query($sql);
		if($res === false) return false;

		$arr = array();
		while($row = mysql_fetch_assoc($res)) $arr[] = $row[$field];

		return $arr;
    }

    public function error()
    {
        return mysql_error($this->link_id);
    }

    public function errno()
    {
        return mysql_errno($this->link_id);
    }

	public function insertId()
    {
        return mysql_insert_id($this->link_id);
    }

    public function close()
    {
        return mysql_close($this->link_id);
    }

    public function ErrorMsg($msg = '')
    {
        if($msg)
        {
            echo "<b>System info:</b> $msg";
        }
        else
        {
            echo "<b>MySQL server error report:</b>";
            print_r($this->err_msg);
        }
        exit;
    }

    public function getRowNum($sql)
    {
		$res = $this->query($sql);
		if($res === false) return false;
		return mysql_num_rows($res);
	}
	
	public function page($sql, $pagesize = 5, $pageshow =5)
	{
		$page=(isset($_REQUEST['page'])&&(intval($_REQUEST['page'])>0))?intval($_REQUEST['page']):1;
		$rstotal = self::getRowNum($sql);//总条数
		$pagetotal = $rstotal%$pagesize?intval($rstotal/$pagesize)+1:$rstotal/$pagesize;//总页数
		if($page>$pagetotal){$page=$pagetotal;}
		if($page<0){$page=1;}

		$str='';
		$limitstart=(($page-1)*$pagesize)>0?($page-1)*$pagesize:0;
		$record = self::getAll($sql." limit ".$limitstart.", $pagesize");
		if($pagetotal>=1)
		{
			$url = $_SERVER['QUERY_STRING'];
			$url = preg_replace('/[?|&]page=.+&?/', '', $url);
			$pagetotal<$pagesize?$pagesize=$pagetotal:$pagesize=$pagesize;
			$start=0;//开始页码
			$end=0;//末尾页码
			if($page>$pagetotal)
			{	
				$page=$pagetotal;
			}
			if($pageshow>$pagetotal){$pageshow=$pagetotal;}
			$pagesizes1=intval($pageshow/2);//开始项当前的个数
			$pagesizes2=$pageshow%2==0?$pagesizes1-1:$pagesizes1;//末尾项当前的个数 判断是偶数还是奇数,是偶数就减1
			if($page<=$pageshow-$pagesizes2) //当前页数小于或等于显示页码减去末尾项,当前位置还处于页码范围
			{		
				$start=1;
				$end=$pageshow;
			}
			else
			{	   		
				$start=$page-$pagesizes1;	
				$end=$page+$pagesizes2;	
			}
			if($end>$pagetotal)//当计算出来的末尾项大于总页数
			{   	
				$start=($pagetotal-$pageshow)+1;//开始项等于总页数减去要显示的数量然后再自身加1	
				$end=$pagetotal;
			}
			$last=$page-1<1?$page:$page-1;//上一页
			$next=$page+1>$pagetotal?$page:$page+1;//下一页

			//$str.="<a href='?".$url."&page=1'>首页</a> ";
			$str.="<a href='?".$url."&page=$last'>&lt;</a> ";
			if($start>$pageshow){
				$str.="<a href='?".$url."&page=1'>1</a><a class='n-page'>...</a>";
			}
			for($i=$start;$i<=$end;$i++)
			{	
				if($page==$i)	
				{		
					$str.="<a href='?".$url."&page=$i' class='now-page'>".$i."</a>";	
				}
				else	
				{		
					$str.="<a href='?".$url."&page=$i'>".$i."</a> ";	
				}	
			}
			$str.="<a href='?".$url."&page=$next'>&gt;</a> ";
			//$str.="<a href='?".$url."&page=$pagetotal'>尾页</a> ";
			$str.="<span class='total'>当前第<em class='now-show'> ".$page." </em>页 共{$pagetotal}页 </span>";
		}
		$pages['record']=$record;//数组数据
		$pages['pagestr']=$str;//格式化html

		$pages['pages']['rstotal']=$rstotal;//总条数
		$pages['pages']['pagetotal']=$pagetotal;//总页数
		$pages['pages']['page']=$page;//当前页
		$pages['pages']['last']=$last;//上一页
		$pages['pages']['next']=$next;//下一页
		$pages['pages']['url']=$url;//链接地址
		return $pages;
	}
	
	public function pagestrs($sql, $pagesize = 15, $pageshow =5, $pageurl, $pageinfo)
	{
		$page=(isset($_REQUEST['page'])&&(intval($_REQUEST['page'])>0))?intval($_REQUEST['page']):1;
		$rstotal = $this->getRowNum($sql);//总条数
		$pagetotal = $rstotal%$pagesize?intval($rstotal/$pagesize)+1:$rstotal/$pagesize;//总页数
		if($page>$pagetotal){$page=$pagetotal;}
		if($page<0){$page=1;}

		$str='';
		$limitstart=(($page-1)*$pagesize)>0?($page-1)*$pagesize:0;
		$record = $this->getAll($sql." limit ".$limitstart.", $pagesize");
		if($pagetotal>=1)
		{
			$url = $_SERVER['QUERY_STRING'];
			$url = preg_replace('/[?|&]page=.+&?/', '', $url);
			$pagetotal<$pagesize?$pagesize=$pagetotal:$pagesize=$pagesize;
			$start=0;//开始页码
			$end=0;//末尾页码
			if($page>$pagetotal)
			{	
				$page=$pagetotal;
			}
			if($pageshow>$pagetotal){$pageshow=$pagetotal;}
			$pagesizes1=intval($pageshow/2);//开始项当前的个数
			$pagesizes2=$pageshow%2==0?$pagesizes1-1:$pagesizes1;//末尾项当前的个数 判断是偶数还是奇数,是偶数就减1
			if($page<=$pageshow-$pagesizes2) //当前页数小于或等于显示页码减去末尾项,当前位置还处于页码范围
			{		
				$start=1;
				$end=$pageshow;
			}
			else
			{	   		
				$start=$page-$pagesizes1;	
				$end=$page+$pagesizes2;	
			}
			if($end>$pagetotal)//当计算出来的末尾项大于总页数
			{   	
				$start=($pagetotal-$pageshow)+1;//开始项等于总页数减去要显示的数量然后再自身加1	
				$end=$pagetotal;
			}
			$a=$page-1<1?$page:$page-1;//上一页
			$b=$page+1>$pagetotal?$page:$page+1;//下一页

			//$str.="<a href='javascript:;' onclick='".$pageurl."({page:1});'>首页</a> ";
			$str.="<a href='javascript:".$pageurl."({page:".$a.",".$pageinfo."});'>&lt;</a> ";
			if($start>$pageshow){
				$str.="<a href='javascript:".$pageurl."({page:1,".$pageinfo."});'>1</a><a class='n-page'>...</a>";
			}
			for($i=$start;$i<=$end;$i++)
			{	
				if($page==$i)	
				{		
					$str.="<a href='javascript:".$pageurl."({page:".$i.",".$pageinfo."});' class='now-page'>".$i."</a>";	
				}
				else	
				{		
					$str.="<a href='javascript:".$pageurl."({page:".$i.",".$pageinfo."});'>".$i."</a> ";	
				}	
			}
			$str.="<a href='javascript:".$pageurl."({page:".$b.",".$pageinfo."});'>&gt;</a> ";
			//$str.="<a href='javascript:".$pageurl."({page:".$pagetotal."});'>尾页</a> ";
			$str.="<p class='total'>当前第<span class='now-show'> ".$page." </span>页 共{$pagetotal}页 </p>";
		}
		$pages['record']=$record;
		$pages['pagestr']=$str;
		return $pages;
	}

    public function pageStr($sql, $page=1, $psize=15)
    {	
		$page = $GLOBALS['page'] ? intval($GLOBALS['page']) : intval($_GET['page']);
		$page = $page < 1 ? 1 : $page;
		$rscount=$this->getRowNum($sql);
		$url=basename($HTTP_SERVER_VARS['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'];
		$url=preg_replace('/(?|&)page=\d+/i','\1',$url);
		$pcount = ceil($rscount/$psize);

		if($page > $pcount) $page = $pcount;
		if($page < 1) $page = 1;

		$GLOBALS['page'] = $page;

        $record = $this->getAll($sql . " limit ". ($page-1)*$psize .", $psize");

		$pagestr="共".$rscount."条信息记录,当前第".$page."/".$pcount."页  <span style='float:right'>[ <a href='$url&page=1'>最前页</a> ] [ <a href='$url&page=".($page-1)."'>上一页</a> ] [ <a href='$url&page=".($page+1)."'>下一页</a> ] [ <a href='$url&page=$pcount'>最末页</a> ] </span>";
		
        return array('record'=>$record, 'pagestr'=>$pagestr);
	}



}
?>
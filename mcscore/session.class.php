<?php
class session
{
    private $db                     = NULL;
    private $session_table          = '';

    private $max_life_time          = 86400;

    private $session_name           = '';
    private $session_id             = '';

    private $session_expiry         = 3600;
    private $session_md5            = '';

    private $session_cookie_path    = '/';
    private $session_cookie_domain  = '';
    private $session_cookie_secure  = false;

    private $_ip                    = '';
    private $_time                  = 0;

    public function __construct(&$db, $session_table, $session_name = 'MCS_ID', $session_id = '')
    {
        $GLOBALS['_SESSION'] = array();

        $this->session_cookie_path = empty($GLOBALS['cookie_path']) ? '/' : $GLOBALS['cookie_path'];
        $this->session_cookie_domain = empty($GLOBALS['cookie_domain']) ? '' : $GLOBALS['cookie_domain'];
        $this->session_cookie_secure = empty($GLOBALS['cookie_secure']) ? false : $GLOBALS['cookie_secure'];
        
        $this->session_name       = $session_name;
        $this->session_table      = $session_table;

        $this->db  = &$db;
        $this->_ip = getRealIp();

        $this->session_id = (empty($session_id) && isset($_COOKIE[$this->session_name])) ? $_COOKIE[$this->session_name] : $session_id;
        
        if($this->session_id)
        {
            $tmp_session_id = substr($this->session_id, 0, 32);
            //$this->session_id = ($this->genSessionKey($tmp_session_id) == substr($this->session_id, 32)) ? $tmp_session_id : '';
            $this->session_id = $tmp_session_id;
        }

        $this->_time = time();

        if($this->session_id)
        {
            $this->loadSession();
        }
        else
        {
           $this->genSessionId();

           setcookie($this->session_name, $this->session_id . $this->genSessionKey($this->session_id), 0, $this->session_cookie_path, $this->session_cookie_domain, $this->session_cookie_secure);
        }

        register_shutdown_function(array(&$this, 'closeSession'));
    }

    private function genSessionId()
    {
        $this->session_id = md5(uniqid(mt_rand(), true));
        return $this->insertSession();
    }

    private function genSessionKey($session_id)
    {
        static $ip = '';

        if($ip == '') $ip = substr($this->_ip, 0, strrpos($this->_ip, '.'));

        return sprintf('%08x', crc32(ROOT_PATH . $ip . $session_id));
    }

    private function insertSession()
    {
        return $this->db->Execute('INSERT INTO ' . $this->session_table . " (sesskey, expiry, ip, data) VALUES ('" . $this->session_id . "', '". $this->_time ."', '". $this->_ip ."', 'a:0:{}')");
    }

    private function loadSession()
    {
        $session = $this->db->getRow('SELECT user_id, admin_id, user_name, user_rank, email, data, expiry FROM ' . $this->session_table . " WHERE sesskey = '" . $this->session_id . "'");

        if(empty($session))
        {
            $this->insertSession();

            $this->session_expiry = 0;
            $this->session_md5    = '40cd750bba9870f18aada2478b24840a';
            $GLOBALS['_SESSION']  = array();
        }
        else
        {
            if(!empty($session['data']) && $this->_time - $session['expiry'] < $this->max_life_time)
            {
                $this->session_expiry = $session['expiry'];
                $this->session_md5    = md5($session['data']);
                $GLOBALS['_SESSION']  = unserialize($session['data']);
                $GLOBALS['_SESSION']['user_id'] = $session['user_id'];
                $GLOBALS['_SESSION']['admin_id'] = $session['admin_id'];
                $GLOBALS['_SESSION']['user_name'] = $session['user_name'];
                $GLOBALS['_SESSION']['user_rank'] = $session['user_rank'];
                $GLOBALS['_SESSION']['email'] = $session['email'];
            }
            else
            {
                $this->session_expiry = 0;
                $this->session_md5    = '40cd750bba9870f18aada2478b24840a';
                $GLOBALS['_SESSION']  = array();
            }
        }        
    }

    private function updateSession()
    {
        $admin_id = empty($GLOBALS['_SESSION']['admin_id']) ? 0 : intval($GLOBALS['_SESSION']['admin_id']);
        $user_id  = empty($GLOBALS['_SESSION']['user_id'])  ? 0 : intval($GLOBALS['_SESSION']['user_id']);
        $user_name  = empty($GLOBALS['_SESSION']['user_name']) ? '' : trim($GLOBALS['_SESSION']['user_name']);
        $user_rank  = empty($GLOBALS['_SESSION']['user_rank']) ? 0 : intval($GLOBALS['_SESSION']['user_rank']);
        $email  = empty($GLOBALS['_SESSION']['email']) ? '' : trim($GLOBALS['_SESSION']['email']);
        unset($GLOBALS['_SESSION']['admin_id']);
        unset($GLOBALS['_SESSION']['user_id']);
        unset($GLOBALS['_SESSION']['user_name']);
        unset($GLOBALS['_SESSION']['user_rank']);
        unset($GLOBALS['_SESSION']['email']);

        $data        = serialize($GLOBALS['_SESSION']);
        $this->_time = time();

        //if($this->session_md5 == md5($data) && $this->_time < $this->session_expiry + 10) return true;

        $data = addslashes($data);

        return $this->db->Execute('UPDATE ' . $this->session_table . " SET expiry = '" . $this->_time . "', ip = '" . $this->_ip . "', user_id = '" . $user_id . "', admin_id = '" . $admin_id . "', user_name='" . $user_name . "', user_rank='" . $user_rank . "', email='" . $email . "', data = '$data' WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
    }

    public function closeSession()
    {
        $this->updateSession();

        if((time() % 2) == 0)
        {
            return $this->db->Execute('DELETE FROM ' . $this->session_table . ' WHERE expiry < ' . ($this->_time - $this->max_life_time));
        }

        return true;
    }

    function destroy_session()
    {
        $GLOBALS['_SESSION'] = array();

        setcookie($this->session_name, $this->session_id, 1, $this->session_cookie_path, $this->session_cookie_domain, $this->session_cookie_secure);

        return $this->db->Execute('DELETE FROM ' . $this->session_table . " WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
    }

    function getSessionId()
    {
        return $this->session_id;
    }

    function getUsersCount()
    {
        return $this->db->getOne('SELECT count(*) FROM ' . $this->session_table);
    }
}
?>
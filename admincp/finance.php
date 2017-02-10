<?php
require 'init.php';

switch($action)
{	
	case 'setwithrow':
		
		//$view->assign('data',$data);
		$view->display('finance'); 
	break;

    default:
        if(IS_POST)
        {
            $param = $_POST['param'];

            foreach($param as $key => $val)
            {
                $db->Execute("update mcs_configs set value='$val' where code='$key'");
            }

            Message('信息保存成功！');
        }


        $params = $db->getAll("select * from mcs_configs where pid=1 order by id asc");
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
        $view->display('system_base');
        break;
}
?>
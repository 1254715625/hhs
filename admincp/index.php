<?php
require 'init.php';
require 'menu.php';
switch($action)
{
    case 'main':
        $view->display('main');
        break;

    default:
        $view->display('index');
        break;
}
?>
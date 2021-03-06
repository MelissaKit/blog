<?php
include('config/database.inc.php');
include('files/PHPMailer/PHPMailerAutoload.php');
error_reporting(E_ALL);

spl_autoload_extensions('.inc.php');

spl_autoload_register(function($className)
{
   $path = 'core/'.$className.'.inc.php';
   if(is_file($path))
       include($path);
});

spl_autoload_register(function($className)
{
    $parts = explode('_', $className);
    $path = 'modules/'.strtolower(array_shift($parts)).'/'.strtolower(array_shift($parts)).'.inc.php';
    if(is_file($path))
        include($path);
});

Core::Init();
Core::Run();
Core::Done();

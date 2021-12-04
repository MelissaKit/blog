<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';

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

<?php

class Core
{
    private static $IndexTpl;
    private static $DB;

    public static function GetDB()
    {
        return self::$DB;
    }

    public static function Init()
    {
        session_start();
        self::$IndexTpl = new Template('templates/index.phtml');
        self::$IndexTpl->setParam('Title', 'Головна сторінка');
        self::$IndexTpl->setParam('Content', '');
        error_log(1);
        error_log(DATABASE_DBNAME);
        error_log(2);
        error_log(MAILING_EMAIL);
        self::$DB = new DB(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_DBNAME);
    }

    public static function Run()
    {
        $path = substr($_SERVER['REQUEST_URI'], 1);
        if ($path) {
            $pathParts = explode('/', $path);
            $className = ucfirst(array_shift($pathParts)) . '_Controller';
            $methodShortName = ucfirst(array_shift($pathParts));

            if (empty($methodShortName))
                $methodShortName = 'Index';
            $methodName = $methodShortName . 'Action';
        } else {
            $className = 'Users_Controller';
            $methodName = 'LoginAction';
            $pathParts = array();
        }
        if ((isset($_SESSION['authorized'])==false || $_SESSION['authorized']==false) && !($methodName=='LoginAction' || $methodName=='RegisterAction')) {
            self::$IndexTpl->setParams(Core::Warning('Authorize'));
            return;
        }

       /* if ((isset($_SESSION['mailConfirmation'])==false || $_SESSION['mailConfirmation'] != true) && !($methodName=='ActivateAction' || $methodName=='LoginAction' || $methodName=='RegisterAction' || $methodName=='ProfileAction'|| $methodName=='LogoutAction')) {
            self::$IndexTpl->setParams(Core::Warning('Mail'));
            return;
        }*/

        if(isset($_SESSION['login']) && $_SESSION['login']=='admin' || !($methodName=='AddAction' || $methodName=='EditAction' || $methodName=='DeleteAction' ||$methodName=='AddAlbumAction' || $methodName=='EditAlbumAction' || $methodName=='DeleteAlbumAction')) {
            if (class_exists($className)) {
                $controller = new $className();
                if (method_exists($controller, $methodName)) {
                    $paramsArray = $controller->$methodName($pathParts);
                    self::$IndexTpl->setParams($paramsArray);
                } else {
                    self::$IndexTpl->setParams(Core::Error404());
                }
            } else {
                self::$IndexTpl->setParams(Core::Error404());
            }
        }
        else self::$IndexTpl->setParams(Core::Error404());
    }

    public static function Done()
    {
        self::$IndexTpl->display();
    }

    public static function Error404()
    {
        $contentTpl = new Template('templates/other/404.phtml');
        return array('Title'=> '404',
            'Content'=>$contentTpl->fetch());
    }

    public static function Warning($var)
    {
        $contentTpl = new Template('templates/other/warning.phtml');
        switch ($var) {
            case 'Authorize':
                $contentTpl->setParam('Params', array('Message' => 'Будь - ласка авторизуйтесь, або здійчніть реєстрацію якщо ще не маєте власного аккаунту'));
                break;
            case 'Mail':
                $contentTpl->setParam('Params', array('Message' => 'Будь - ласка підтвердіть пошту вашого аккаунту'));
                break;
        }

        return array('Title'=> 'Warning',
            'Content'=>$contentTpl->fetch());
    }

}

?>
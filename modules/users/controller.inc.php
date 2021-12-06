<?php

class Users_Controller extends Controller
{
    public function IndexAction()
    {
        header('Location: /Posts/Index/');
    }

    function ProfileAction()
    {
        $user = Users_Model::getUserByLogin($_SESSION['login'])[0];
        return $this->view->generate('Профіль', 'templates/modules/users/profile.phtml', $user);
    }


    public function RegisterAction()
    {
        if (isset($_SESSION['authorized']) && $_SESSION['authorized']) {
            header('Location: /Posts/Index/');
        }
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Реєстрація', 'templates/modules/users/registration.phtml');
                break;
            case 'POST':
                if (Users_Model::checkLogin($_POST['login']) && Users_Model::checkMail($_POST['mail'])) {
                    if (!empty(($_POST['login'])) && !empty(($_POST['password'])) && ($_POST['password']) == ($_POST['passwordConfirm']) && !empty(($_POST['mail']))) {
                        if (strlen($_POST['password']) >= 6) {
                            if (empty($_POST['avatarPath'])) {
                                $_POST['avatarPath'] = 'jveqrwggircn2egahvtt'; //default avatar
                            }
                            Users_Model::registerUser($_POST);
                            $_SESSION['authorized'] = true;
                            $_SESSION['login'] = $_POST['login'];
                            $_SESSION['mailConfirmation'] = false;
                            header('Location: /Users/Profile/');
                        } else {
                            return $this->view->generate('Реєстрація', 'templates/modules/users/registration.phtml', array('Error' => 'Пароль замаленький (<6)'));
                        }
                    } else {
                        return $this->view->generate('Реєстрація', 'templates/modules/users/registration.phtml', array('Error' => 'Введено недостатньо даних'));
                    }
                } else {
                    return $this->view->generate('Реєстрація', 'templates/modules/users/registration.phtml', array('Error' => 'Користувач з таким логіном або поштою уже існує'));
                }
                break;
        }
    }

    public function LoginAction()
    {
        if (isset($_SESSION['authorized']) && $_SESSION['authorized'] == false) {
            header('Location: /Posts/Index/');
        }
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Вхід', 'templates/modules/users/login.phtml');
                break;
            case 'POST':
                if (!empty(($_POST['login'])) && !empty(($_POST['password']))) {
                    if (Users_Model::checkUserExists($_POST['login'], $_POST['password'])) {
                        $user = Users_Model::getUserByLogin($_POST['login'])[0];
                        $_SESSION['authorized'] = true;
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['mailConfirmation'] = (bool)$user['Status'];
                        return $this->view->generate('Профіль', 'templates/modules/users/profile.phtml', $user);
                    } else {
                        return $this->view->generate('Вхід', 'templates/modules/users/login.phtml', array('Error' => 'Невірно введений логін або пароль'));
                    }
                } else {
                    return $this->view->generate('Вхід', 'templates/modules/users/login.phtml', array('Error' => 'Недостатньо данних'));
                }
                break;
        }
    }

    public function LogoutAction()
    {
        session_destroy();
        header('Location: /Users/Login/');
    }

    public function ActivateAction($params)
    {
        if (isset($params)) {
            $token = array_shift($params);
            $userId = Users_Model::getUserIdByToken($token);
            if ($userId != null) {
                Users_Model::changeUserStatus($userId, 1);
                $_SESSION['mailConfirmation'] = true;
                header('Location: /Users/Profile/');
            } else return Core::Error404();
        } else return Core::Error404();
    }

    public function EditProfAction()
    {
        $user = Users_Model::getUserByLogin($_SESSION['login'])[0];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Профіль', 'templates/modules/users/edit.phtml', $user);
                break;
            case 'POST':
                if (!empty($_POST['login']) && !empty($_POST['mail'])) {
                    if (((count(Users_Model::getUserByLogin($_POST['login'])) == 1 && $_POST['login'] == $_SESSION['login']) || (count(Users_Model::getUserByLogin($_POST['login'])) == 0 && $_POST['login'] != $_SESSION['login']))
                        && (count(Users_Model::getUserByMail($_POST['mail'])) == 1 && $_POST['mail'] == $user['Mail']) || (count(Users_Model::getUserByMail($_POST['mail'])) == 0 && $_POST['mail'] != $user['Mail'])) {
                        $userId = $user['Id'];
                        if (empty($_POST['avatarPath'])) {
                            $_POST['avatarPath'] = $user['AvatarPath'];
                        }

                        if (isset($_POST['deleteAva'])) {
                            $user['AvatarPath'] = 'jveqrwggircn2egahvtt';
                            $_POST['avatarPath'] = 'jveqrwggircn2egahvtt'; // default image;
                        }
                        Users_Model::editUser($userId, $_POST);
                        $_SESSION['login'] = $_POST['login'];
                        if ($_POST['mail'] != $user['Mail']) {
                            $_SESSION['mailConfirmation'] = false;
                            Users_Model::changeUserStatus($userId, 0);
                            $newToken = md5(uniqid());
                            Users_Model::editUser($userId, array('token' => $newToken));
                            Users_Model::sendMail($_POST['mail'],
                                'Ви змінили пошту на сайті BEST FILM EVER',
                                "Для активації вашого профілю перейдіть за посиланням: http://{$_SERVER['HTTP_HOST']}/users/activate/{$newToken }.");
                        }
                        header('Location: /Users/Profile/');
                    } else {
                        $user['Error'] = 'Користувач з таки логіном або поштою уже існує';
                        return $this->view->generate('Профіль', 'templates/modules/users/edit.phtml', $user);
                    }
                } else {
                    $user['Error'] = 'Недостатньо данних';
                    return $this->view->generate('Профіль', 'templates/modules/users/edit.phtml', $user);
                }
                break;
        }
    }

    public function ChangePassAction()
    {
        $user = Users_Model::getUserByLogin($_SESSION['login'])[0];
        if (!empty($_POST['password']) && $_POST['password'] !== $_POST['passwordNew'] && Users_Model::checkUserExists($_SESSION['login'], $_POST['password'])) {
            if (strlen($_POST['passwordNew']) >= 6) {
                Users_Model::changeUserPass($_SESSION['login'], $_POST['passwordNew']);
                header('Location: /Users/Profile/');
            } else {
                $user['Error'] = 'Новий пароль замаленький';
                return $this->view->generate('Профіль', 'templates/modules/users/edit.phtml', $user);
            }
        } else {
            $user['Error'] = 'Некоректно введені дані';
            return $this->view->generate('Профіль', 'templates/modules/users/edit.phtml', $user);
        }
    }

    public function DeleteUserAction()
    {
        $user = Users_Model::getUserByLogin($_SESSION['login'])[0];
        Users_Model::deleteUser($user['Id']);
        if ($user['AvatarPath'] != '')
            unlink(substr($user['AvatarPath'], 1));
        session_destroy();
        header('Location: /Users/Login/');
    }

    public function RecoverPassAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Зміна паролю', 'templates/modules/users/recoverPass.phtml');
                break;
            case 'POST':
                if (!empty(($_POST['mail']))) {
                    $user = Users_Model::getUserByMail($_POST['mail']);
                    if ($user) {
                        $newToken = md5(uniqid());
                        Users_Model::editUser($user[0]['Id'], array('token' => $newToken));
                        Users_Model::sendMail($_POST['mail'],
                            'Ви подали заявку на змыну пароля на сайті BEST FILM EVER',
                            "Для пыдтвердження перейдіть за посиланням: http://{$_SERVER['HTTP_HOST']}/users/ActivateNewPass/{$newToken }.");
                        return $this->view->generate('Успіх', 'templates/other/message.phtml', array('Error' => 'Лист надісланоі тд'));

                    } else {
                        return $this->view->generate('Зміна паролю', 'templates/modules/users/recoverPass.phtml', array('Error' => 'Невірний e-mail'));
                    }

                } else {
                    return $this->view->generate('Зміна паролю', 'templates/modules/users/recoverPass.phtml', array('Error' => 'Недостатньо данних'));
                }
                break;
        }
    }

    public function ActivateNewPassAction($params = array())
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $token = array_shift($params);
                $userId = Users_Model::getUserIdByToken($token);
                if ($userId) {
                    $_SESSION['login'] = Users_Model::getUserById($userId)[0]['Login'];
                    return $this->view->generate('Зміна паролю', 'templates/modules/users/newPass.phtml');
                } else return Core::Error404();
                break;
            case 'POST':
                if (!empty($_POST['newPassword']) && $_POST['newPassword'] == $_POST['newPasswordConfirm']) {
                    if (strlen($_POST['newPassword']) >= 6) {
                        Users_Model::changeUserPass($_SESSION['login'], $_POST['newPassword']);
                        $_SESSION['authorized'] = true;
                        $_SESSION['mailConfirmation'] = (bool)Users_Model::getUserByLogin($_SESSION['login'])[0]['Status'];
                        header('Location: /Users/Profile/');
                    } else {
                        return $this->view->generate('Зміна паролю', 'templates/modules/users/newPass.phtml', array('Error' => 'Пароль замаленький'));
                    }
                } else {
                    return $this->view->generate('Зміна паролю', 'templates/modules/users/newPass.phtml', array('Error' => 'Паролі не співпадають'));
                }
                break;
        }
    }
}

?>

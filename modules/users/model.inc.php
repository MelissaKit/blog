<?php

class Users_Model extends Model
{
    public static function sendMail($email, $theme, $text)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;
        $mail->IsHTML(true);
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = MAILING_EMAIL;
        $mail->Password = MAILING_PASSWORD;
        $mail->setFrom(MAILING_EMAIL, 'BestFilmEver');
        $mail->addAddress($email);
        $mail->Subject = $theme;
        $mail->Body = $text;
        $mail->send();
    }

    public static function getUserIdByToken($token)
    {
        return Core::GetDB()->getRowWhere('User', 'Id', array('token' => $token));
    }

    public static function getUserByLogin($login)
    {
        return Core::GetDB()->getRowsWhere('User',  array('login' => $login));
    }

    public static function getUserInfoById ($id) {
        return Core::GetDB()->getRowsWhere('User',  array('Id' => $id), 0, 0, 'login, firstName, secondName, avatarPath ,shortDescription');
    }

    public static function getUserById($id)
    {
        return Core::GetDB()->getRowsWhere('User',  array('Id' => $id));
    }

    public static function changeUserStatus($userId, $status)
    {
        Core::GetDB()->update('User', array('Id' => $userId), array('status' => $status), array('status'));
    }

    public static function changeUserPass($userLogin, $pass)
    {
        $newPass = password_hash($pass, PASSWORD_BCRYPT);
        Core::GetDB()->update('User', array('Login' => $userLogin), array('password' => $newPass ), array('password'));
    }

    public static function editUser($userId, $fields)
    {
        Core::GetDB()->update('User', array('Id' => $userId),  $fields , array('login','mail', 'firstName', 'secondName','shortDescription','country', 'city', 'birthDate', 'avatarPath','token'));
    }

    public static function registerUser($row)
    {
        $fieldsArray = array('login', 'password', 'firstName', 'secondName', 'shortDescription', 'mail', 'country', 'city', 'birthDate', 'registrationDate', 'token', 'avatarPath');
        $row['token'] = md5(uniqid());
        $row['password'] = password_hash($row['password'], PASSWORD_BCRYPT);
        $row['registrationDate'] = date("y:m:d");
        Core::GetDB()->addRecordFromForm('User', $row, $fieldsArray);
        self::sendMail($row['mail'],
            'Ви зареєстровані на сайті BEST FILM EVER',
            "Для активації вашого профілю перейдіть за посиланням: http://{$_SERVER['HTTP_HOST']}/users/activate/{$row['token']}.");
    }

    public static function checkLogin($login)
    {
        $count = Core::GetDB()->getRowsCount('User', array('login' => $login));
        return ($count === 0);
    }


    public static function checkMail($mail)
    {
        $count = Core::GetDB()->getRowsCount('User', array('mail' => $mail));
        return ($count === 0);
    }

    public static function checkUserExists($login, $password)
    {
        $count = Core::GetDB()->getRowsCount('User', array('login' => $login));
        if($count === 1)
        {
            $user = Core::GetDB()->getRowsWhere('User', array('login' => $login));
            return password_verify($password, $user[0]["Password"]);
        }
    }

    public static function deleteUser($userId)
    {
        Core::GetDB()->delete('User', array('Id'=>$userId));
    }

    public static function getUserByMail($mail)
    {
        return Core::GetDB()->getRowsWhere('User',  array('mail' => $mail));
    }
}

?>
<?php

class Likes_Controller extends Controller
{
    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (isset($_GET['post'])) {
                    var_dump($_GET['post']);
                    $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                    Likes_Model::addNewLike($_GET['post'], $userId);
                    exit;
                }
                break;
        }
    }


    public function DeleteAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (isset($_GET['post'])) {
                    $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                    Likes_Model::deleteLike($_GET['post'], $userId);
                    exit;
                }
                break;
        }
    }
}

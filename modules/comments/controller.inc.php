<?php

class Comments_Controller extends Controller
{
    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $_POST['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                Comments_Model::addComment($_POST);
                header('Location: /Posts/Show/?Id='. $_POST['postId']);
                break;
        }
    }


    public function DeleteAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (isset($_GET['Id'])) {
                    Comments_Model::deleteComment($_GET['Id']);
                }
                break;
        }
    }
}

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
                    $likes = Likes_Model::getLikesCount($_GET['post'], $userId);

                    header('Content-Type: application/json');
                    echo json_encode(array('newButton' => '<a class="unlike-link" href="/Likes/Delete/?post=' . $_GET['post'] . '"><span class="likes glyphicon glyphicon-heart">' . $likes . '</span></a>'));
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
                    $likes = Likes_Model::getLikesCount($_GET['post']);

                    header('Content-Type: application/json');
                    echo json_encode(array('newButton' => '<a class="like-link" href="/Likes/Add/?post=' . $_GET['post'] . '"><span class="likes glyphicon glyphicon-heart-empty">' . $likes . '</span></a>'));
                    exit;
                }
                break;
        }
    }
}

<?php

class Comments_Controller extends Controller
{
    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $_POST['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                $json = file_get_contents('https://nlpservice.herokuapp.com/sentiment/?q=' . urlencode(strtolower($_POST['commentText'])));
                $result = get_object_vars(json_decode($json));
                $keys = array_keys($result);
                var_dump($result);
                $commentSentiment = 3;
                if ($result[$keys[0]] > $result[$keys[1]]) {
                    $commentSentiment = $keys[0] == 'positive' ? 1 : ($keys[0] == 'negative' ? 2 : 3);
                } else  {
                    $commentSentiment = $keys[1] == 'positive' ? 1 : ($keys[1] == 'negative' ? 2 : 3);
                }
                var_dump($commentSentiment);
                $_POST['sentiment'] = $commentSentiment;
                Comments_Model::addComment($_POST);
                header('Location: /Posts/Show/?Id='. $_POST['postId']. '#addComment');
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

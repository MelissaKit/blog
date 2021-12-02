<?php

class Subscriptions_Controller extends Controller
{
    public function IndexAction()
    {
        $reviewsCnt = Posts_Model::getReviewsCount();
        $limit = 4;
        $pagesCnt = (int)ceil($reviewsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;
        $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
        $reviews['Content'] = Posts_Model::getReviewsPage($limit, $limit * $page, $userId);
        $reviews['PagesCount'] = $pagesCnt;
        $reviews['CurrentPage'] = $page;
        return $this->view->generate('Головна сторінка', 'templates/modules/posts/postsMain.phtml', $reviews);
    }


    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                header('Location: /Subscriptions/Index/');
                break;
            case 'POST':
                $_POST['followDate'] = date("y:m:d");
                $_POST['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];

                Subscriptions_Model::addNewSubscription($_POST);
                header('Location: /Subscriptions/Index/');
                break;
        }
    }


    public function DeleteAction()
    {
        if (isset($_GET['user'])) {
            $user = Users_Model::getUserByLogin($_GET['user']);
            if (!$user) {
                return Core::Error404();
            }
            $subsc = Subscriptions_Model::getSubscriptionById($user[0]['Id']);
            if (!$subsc)
                return Core::Error404();
            Subscriptions_Model::deleteSubscription($subsc);
            header('Location: /Subscriptions/Index/');
        }
        else return Core::Error404();
    }
}
?>

<?php

class Subscriptions_Controller extends Controller
{
    public function IndexAction()
    {
        $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
        $subscCnt = Subscriptions_Model::getSubscriptionsCount($userId);
        $limit = 24;
        $pagesCnt = (int)ceil($subscCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;

        $followsData = Subscriptions_Model::getSubscriptionsPage($limit, $limit * $page, $userId);
        foreach ($followsData as $key => $item) {
            $follows['Subscriptions'][$key] = Users_Model::getUserInfoById($item['followId'])[0];
            $follows['Subscriptions'][$key]['Id'] = $item['Id'];
        }
        $follows['PagesCount'] = $pagesCnt;
        $follows['CurrentPage'] = $page;

        return $this->view->generate('Підписки', 'templates/modules/subscriptions/followList.phtml', $follows);
    }


    public function AddAction() //to do
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
        if (isset($_GET['Id'])) {
            $subsc = Subscriptions_Model::getSubscriptionById($_GET['Id']);
            $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
            if (!$subsc || $subsc[0]['userId'] != $userId)
                return Core::Error404();
            Subscriptions_Model::deleteSubscription($_GET['Id']);
            header('Location: /Subscriptions/Index/');
        } 
        else return Core::Error404();
    }
}

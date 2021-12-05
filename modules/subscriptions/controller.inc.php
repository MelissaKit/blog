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


    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $_GET['followDate'] = date("y:m:d");
                $_GET['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                $_GET['followId'] =  Users_Model::getUserByLogin($_GET['follow'])[0]['Id'];
                Subscriptions_Model::addNewSubscription($_GET)[0];
                break;
        }
    }


    public function DeleteAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                $followId = Users_Model::getUserByLogin($_GET['follow'])[0]['Id'];
                Subscriptions_Model::deleteSubscription($userId, $followId);
                break;
        }
    }

}

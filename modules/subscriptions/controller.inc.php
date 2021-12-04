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


    public function AddAction($request)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $_GET['followDate'] = date("y:m:d");
                $_GET['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                $_GET['followId'] =  Users_Model::getUserByLogin($_GET['follow'])[0]['Id'];
                Subscriptions_Model::addNewSubscription($_GET)[0];
                $newFollow = Subscriptions_Model::getSubscriptionByParams($_GET['userId'], $_GET['followId'])[0];

                header('Content-Type: application/json');
                echo json_encode(array('newButton' => '<a class="unfollow-link" href="/Subscriptions/Delete/?Id='.$newFollow['Id'] .'">Unfollow</a>'));
                exit;
                break;
        }
    }


    public function DeleteAction()
    {
        if (isset($_GET['Id'])) {
            $subsc = Subscriptions_Model::getSubscriptionById($_GET['Id']);
            $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
            $follow =  Users_Model::getUserById($subsc[0]['followId'])[0];
            if (!$subsc || $subsc[0]['userId'] != $userId)
                return Core::Error404();
            Subscriptions_Model::deleteSubscription($_GET['Id']);

            header('Content-Type: application/json');
            echo json_encode(array('newButton' => '<a class="follow-link" href="/Subscriptions/Add/?follow='. $follow['Login'] .'">Follow</a>'));
            exit;
        } 
        else return Core::Error404();
    }
}

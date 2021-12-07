<?php

class Analytics_Controller extends Controller
{
    public function IndexAction()
    {
        $currentUser =  Users_Model::getUserByLogin($_SESSION['login'])[0];

        $result['sex']['f'] = Subscriptions_Model::getFemaleSubscribersCount($currentUser['Id']);
        $result['sex']['m'] = Subscriptions_Model::getMaleSubscribersCount($currentUser['Id']);

        $result['country'] = Subscriptions_Model::getSubscribersCountByCountries($currentUser['Id']);
        $result['age'] = Subscriptions_Model::getSubscribersAge($currentUser['Id']);

        return $this->view->generate('Аналітика', 'templates/modules/analytics/overview.phtml', $result);
    }


    public function PostsAction()
    {
    }
}

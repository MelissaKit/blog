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
        $currentUser =  Users_Model::getUserByLogin($_SESSION['login'])[0];

        $postsCnt = Posts_Model::getPostsCount($currentUser['Id']);
        $limit = 10;
        $pagesCnt = (int)ceil($postsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;

        $posts['Content'] = Posts_Model::getPostersPage($limit, $limit * $page, $currentUser['Id'], $currentUser['Id']);

        foreach ($posts['Content'] as $key => $item) {
            $posts['Content'][$key]['LikesCount'] = Likes_Model::getLikesCount($item['Id']);
            $posts['Content'][$key]['LikesUser'] = !!Likes_Model::checkUserLike($item['Id'], $currentUser['Id']);
            $posts['Content'][$key]['CommentsCount'] = Comments_Model::getPostCommentsCount($item['Id']);
            $posts['Content'][$key]['CommentsGood'] = Comments_Model::getPostCommentsCountSentiment($item['Id'], 1);
            $posts['Content'][$key]['CommentsBad'] = Comments_Model::getPostCommentsCountSentiment($item['Id'], 2);
            $posts['Content'][$key]['CommentsNeutral'] = Comments_Model::getPostCommentsCountSentiment($item['Id'], 3);
        }

        $posts['Author'] = $currentUser;

        $posts['PagesCount'] = $pagesCnt;
        $posts['CurrentPage'] = $page;

        return $this->view->generate('Аналітика', 'templates/modules/analytics/postsAnalytics.phtml', $posts);
    }
}

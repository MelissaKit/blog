<?php

class Categories_Controller extends Controller
{
    public function IndexAction()
    {
        $categories['Content'] = array_reverse(Categories_Model::getAllCategories());

        return $this->view->generate('Категорії', 'templates/modules/categories/categoriesList.phtml', $categories);
    }


    public function ShowAction()
    {
        if (isset($_GET['Id'])) {
            $currentUser =  Users_Model::getUserByLogin($_SESSION['login'])[0];

            $postsCnt = Posts_Model::getPostsCountInCategory($_GET['Id']);
            $limit = 4;
            $pagesCnt = (int)ceil($postsCnt / $limit);

            if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
                $page = $_GET['page'] - 1;
            else
                $page = 0;

            $posts['Content'] = Posts_Model::getPostsPageInCategory($limit, $limit * $page, $currentUser['Id'], $_GET['Id']);

            foreach ($posts['Content'] as $key => $item) {
                $author = Users_Model::getUserInfoById($item['userId'])[0];
                $posts['Content'][$key]['Author'] = $author['login'];
                $posts['Content'][$key]['AuthorImage'] = $author['avatarPath'];

                $posts['Content'][$key]['LikesCount'] = Likes_Model::getLikesCount($item['Id']);
                $posts['Content'][$key]['LikesUser'] = !!Likes_Model::checkUserLike($item['Id'], $currentUser['Id']);
                $posts['Content'][$key]['CommentsCount'] = Comments_Model::getPostCommentsCount($item['Id']);
            }

            $posts['CurrentCategory'] = Categories_Model::getCategoryById($_GET['Id'])[0];

            $posts['PagesCount'] = $pagesCnt;
            $posts['CurrentPage'] = $page;

            return $this->view->generate($posts['CurrentCategory']['Name'], 'templates/modules/categories/categoryPosts.phtml', $posts);
        }
    }
}

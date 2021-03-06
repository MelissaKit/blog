<?php

class Posts_Controller extends Controller
{
    public function IndexAction()
    {
        $postsCnt = Posts_Model::getReviewsCount();
        $limit = 4;
        $pagesCnt = (int)ceil($postsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;
        $userId = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
        $postsContent = Posts_Model::getReviewsPage($limit, $limit * $page, $userId);
        foreach ($postsContent as $key => $item) {
            $posts['Content'][$key] =  $item;
            $author = Users_Model::getUserInfoById($item['userId'])[0];
            $posts['Content'][$key]['Author'] = $author['login'];
            $posts['Content'][$key]['AuthorImage'] = $author['avatarPath'];

            $posts['Content'][$key]['LikesCount'] = Likes_Model::getLikesCount($item['Id']);
            $posts['Content'][$key]['LikesUser'] = !!Likes_Model::checkUserLike($userId, $item['Id']);
            $posts['Content'][$key]['CommentsCount'] = Comments_Model::getPostCommentsCount($item['Id']);
        }

        $posts['PagesCount'] = $pagesCnt;
        $posts['CurrentPage'] = $page;
        return $this->view->generate('Головна сторінка', 'templates/modules/posts/postsMain.phtml', $posts);
    }

    public function ShowAction()
    {
        if (isset($_GET['Id'])) {
            $post = Posts_Model::getReviewById($_GET['Id']);
            if ($post != null) {
                $post = $post[0];
                $post['Comments'] = Comments_Model::getPostComments(10, 0, $post['Id']);
                usort($post['Comments'], function ($item1, $item2) {
                    return strtotime($item2['commentDate']) - strtotime($item1['commentDate']);
                });

                foreach ($post['Comments'] as $key => $comment) {
                    $post['Comments'][$key]['Author'] = Users_Model::getUserById($comment['userId'])[0];
                }

                return $this->view->generate($post['Name'], 'templates/modules/posts/postItem.phtml', $post);
            }
        }
        return Core::Error404();
    }

    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Огляд', 'templates/modules/posts/addPost.phtml');
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/posters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                }
                $_POST['publicationDate'] = date("y:m:d");
                $_POST['userId'] = Users_Model::getUserByLogin($_SESSION['login'])[0]['Id'];
                Posts_Model::addNewReview($_POST);
                header('Location: /Posts/Index/');
                break;
        }
    }

    public function EditAction()
    {
        if (!isset($_GET['Id']))
            return Core::Error404();
        $post = Posts_Model::getReviewById($_GET['Id']);
        if ($post == null)
            return Core::Error404();
        $post = $post[0];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Огляд', 'templates/modules/posts/editPost.phtml', $post);
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/posters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                    if ($post['PosterPath'] != '')
                        unlink(substr($post['PosterPath'], 1));
                }

                if (isset($_POST['deleteAva'])) {
                    if ($post['PosterPath'] != '')
                        unlink(substr($post['PosterPath'], 1));
                    $_POST['posterPath'] = '';
                }

                $_POST['publicationDate'] = date("y:m:d");
                Posts_Model::editReview($post['Id'], $_POST);
                header('Location: /Posts/Index/');
                break;
        }
    }

    public function DeleteAction()
    {
        if (isset($_GET['Id'])) {
            $post = Posts_Model::getReviewById($_GET['Id']);
            if ($post == null)
                return Core::Error404();
            $post = $post[0];
            Posts_Model::deleteReview($_GET['Id']);
            if ($post['PosterPath'] != '')
                unlink(substr($post['PosterPath'], 1));
            header('Location: /Posts/Index/');
        } else return Core::Error404();
    }

    public function UserAction($param)
    {
        $currentUser =  Users_Model::getUserByLogin($_SESSION['login'])[0];
        $getUser = $currentUser;

        if ($param && $param[0]) {
            $checkUser = Users_Model::getUserByLogin($param[0]);

            if ($checkUser) {
                $getUser = $checkUser[0];
            } else {
                return Core::Error404();
            }
        }

        $postsCnt = Posts_Model::getReviewsCount($getUser['Id']);
        $limit = 4;
        $pagesCnt = (int)ceil($postsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;

        $posts['Content'] = Posts_Model::getReviewsPage($limit, $limit * $page, $currentUser['Id'], $getUser['Id']);
        $posts['Author'] = $getUser;

        if ($getUser['Login'] != $currentUser['Login']) {
            $postsSubscr = Subscriptions_Model::getSubscriptionByParams($currentUser['Id'], $getUser['Id']);
            $posts['Subscription'] =  count($postsSubscr) ? $postsSubscr[0] : null;
        }

        $posts['PagesCount'] = $pagesCnt;
        $posts['CurrentPage'] = $page;

        return $this->view->generate($getUser['Login'], 'templates/modules/posts/userPosts.phtml', $posts);
    }

    public function SearchAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['searchParam'] != '') {
            $result = Posts_Model::FindElem($_POST['searchParam']);
            if ($result['posts']) {
                foreach ($result['posts'] as $key => $post) {
                    $result['posts'][$key]['Author'] = Users_Model::getUserById($result['posts'][$key]['userId'])[0];
                }
            }
            return $this->view->generate('Пошук', 'templates/modules/posts/searchRes.phtml', $result);
        } else {
            Core::Error404();
        }
    }

    public function AddViewAction() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                break;
            case 'POST':
                var_dump($_GET['Id']);
                Posts_Model::addView($_GET['Id']);
                break;
        }
    }
}

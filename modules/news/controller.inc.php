<?php

class News_Controller extends Controller
{
    public function IndexAction()
    {
        $newsCnt = News_Model::getNewsItemsCount();
        $limit = 8;
        $pagesCnt = (int)ceil($newsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;
        $news['Content'] = News_Model::getNewsPage($limit, $limit * $page);
        $news['PagesCount'] = $pagesCnt;
        $news['CurrentPage'] = $page;
        return $this->view->generate('Новини', 'templates/modules/news/newsList.tpl', $news);
    }

    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Новини', 'templates/modules/news/addNewsItem.tpl');
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/newsPosters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                }
                $_POST['publicationDate'] = date("y:m:d");
                News_Model::addNewsItem($_POST);
                header('Location: /News/Index/');
                break;
        }
    }

    public function EditAction()
    {
        if (!isset($_GET['Id']))
            return Core::Error404();
        $newsItem = News_Model::getNewsItemById($_GET['Id']);
        if ($newsItem == null)
            return Core::Error404();
        $newsItem = $newsItem[0];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Новини', 'templates/modules/news/editNewItem.tpl', $newsItem);
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/newsPosters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                    if ($newsItem['PosterPath'] != '')
                        unlink(substr($newsItem['PosterPath'], 1));
                }

                if (isset($_POST['deleteAva'])) {
                    if ($newsItem['PosterPath'] != '')
                        unlink(substr($newsItem['PosterPath'], 1));
                    $_POST['posterPath'] = '';
                }

                $_POST['publicationDate'] = date("y:m:d");
                News_Model::editNewsItem($newsItem['Id'], $_POST);
                header('Location: /News/Index/');
                break;
        }
    }

    public function DeleteAction()
    {
        if (!isset($_GET['Id']))
            Core::Error404();
        $review = News_Model::getNewsItemById($_GET['Id']);
        if ($review == null)
            return Core::Error404();

        $review = $review[0];
        News_Model::deleteNewsItem($_GET['Id']);
        if ($review['PosterPath'] != '')
            unlink(substr($review['PosterPath'], 1));
        header('Location: /News/Index/');
    }
}

?>
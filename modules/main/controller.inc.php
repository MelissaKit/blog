<?php

class Main_Controller extends Controller
{
    public function IndexAction()
    {
        $reviewsCnt = Main_Model::getReviewsCount();
        $limit = 4;
        $pagesCnt = (int)ceil($reviewsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;
        $reviews['Content'] = Main_Model::getReviewsPage($limit, $limit * $page);
        $reviews['PagesCount'] = $pagesCnt;
        $reviews['CurrentPage'] = $page;
        return $this->view->generate('Головна сторінка', 'templates/modules/main/content.phtml', $reviews);
    }

    public function ShowAction()
    {
        if (isset($_GET['Id'])) {
            $review = Main_Model::getReviewById($_GET['Id']);
            if ($review != null) {
                $review = $review[0];
                return $this->view->generate($review['Name'], 'templates/modules/main/review.phtml', $review);
            }
        }
        return Core::Error404();
    }

    public function AddAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Огляд', 'templates/modules/main/addReviewItem.phtml');
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/reviewsPosters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                }
                $_POST['publicationDate'] = date("y:m:d");
                Main_Model::addNewReview($_POST);
                header('Location: /Main/Index/');
                break;
        }
    }

    public function EditAction()
    {
        if (!isset($_GET['Id']))
            return Core::Error404();
        $review = Main_Model::getReviewById($_GET['Id']);
        if ($review == null)
            return Core::Error404();
        $review = $review[0];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Огляд', 'templates/modules/main/editReviewItem.phtml', $review);
                break;
            case 'POST':
                if ($_FILES && $_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                    $_POST['posterPath'] = '/files/reviewsPosters/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["poster"]["tmp_name"], substr($_POST['posterPath'], 1));
                    if ($review['PosterPath'] != '')
                        unlink(substr($review['PosterPath'], 1));
                }

                if (isset($_POST['deleteAva'])) {
                    if ($review['PosterPath'] != '')
                        unlink(substr($review['PosterPath'], 1));
                    $_POST['posterPath'] = '';
                }

                $_POST['publicationDate'] = date("y:m:d");
                Main_Model::editReview($review['Id'], $_POST);
                header('Location: /Main/Index/');
                break;
        }
    }

    public function DeleteAction()
    {
        if (isset($_GET['Id'])) {
            $review = Main_Model::getReviewById($_GET['Id']);
            if ($review == null)
                return Core::Error404();
            $review = $review[0];
            Main_Model::deleteReview($_GET['Id']);
            if ($review['PosterPath'] != '')
                unlink(substr($review['PosterPath'], 1));
            header('Location: /Main/Index/');
        }
        else return Core::Error404();
    }

    public function SearchAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['searchParam'] != '') {
            $result = Main_Model::FindElem($_POST['searchParam']);
            return $this->view->generate('Пошук', 'templates/modules/main/searchRes.phtml', $result);
        } else {
            Core::Error404();
        }
    }
}

?>

<?php

class Gallery_Controller extends Controller
{
    public function IndexAction()
    {
        $albumsCnt = Gallery_Model::getAlbumsCount();
        $limit = 12;
        $pagesCnt = (int)ceil($albumsCnt / $limit);
        if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
            $page = $_GET['page'] - 1;
        else
            $page = 0;
        $albums['Content'] = Gallery_Model::getAlbumsPage($limit, $limit * $page);
        $albums['PagesCount'] = $pagesCnt;
        $albums['CurrentPage'] = $page;
        return $this->view->generate('Галерея', 'templates/modules/gallery/albumsList.tpl', $albums);
    }

    public function OpenAction()
    {
        if (isset($_GET['Id'])) {
            $photosCnt = Gallery_Model::getAlbumPhotoCount($_GET['Id']);
            $limit = 12;
            $photos['AlbumId'] = $_GET['Id'];
            $pagesCnt = (int)ceil($photosCnt / $limit);
            if (isset($_GET['page']) && ((int)$_GET['page']) <= $pagesCnt)
                $page = $_GET['page'] - 1;
            else
                $page = 0;
            $photos['Content'] = Gallery_Model::getAlbumPhotoPage($photos['AlbumId'], $limit, $limit * $page);
            if ($photos['Content'] !=null) {
                $photos['PagesCount'] = $pagesCnt;
                $photos['CurrentPage'] = $page;
                return $this->view->generate('Галерея', 'templates/modules/gallery/album.tpl', $photos);
            }
            return Core::Error404();
        }
        return Core::Error404();
    }

    public function AddAlbumAction()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->view->generate('Галерея', 'templates/modules/gallery/addAlbum.tpl');
                break;
            case 'POST':
                $pictures = array();
                foreach ($_FILES["pictures"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                        $name = '/files/gallery/' . md5(uniqid(''));
                        array_push($pictures, $name);
                        move_uploaded_file($tmp_name, substr($name, 1));
                    }
                }
                if ($_FILES && $_FILES['mainPhoto']['error'] == UPLOAD_ERR_OK) {
                    $_POST['mainPhoto'] = '/files/gallery/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["mainPhoto"]["tmp_name"], substr($_POST['mainPhoto'], 1));
                }
                Gallery_Model::addNewAlbum($_POST, $pictures);
                header('Location: /Gallery/Index/');
                break;
        }
    }

    public function DeleteAlbumAction()
    {
        if (isset($_GET['Id'])) {
            if(count(Gallery_Model::getAlbum($_GET['Id']))!=0) {
                Gallery_Model::deleteAlbum($_GET['Id']);
                header('Location: /Gallery/Index/');
            }
            else return Core::Error404();
        } else return Core::Error404();
    }

    public function EditAlbumAction()
    {
        if (!isset($_GET['Id']))
            return Core::Error404();
        $album = Gallery_Model::getAlbumInfo($_GET['Id']);
        if ($album == null)
            return Core::Error404();
        $album = $album[0];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $albumPhoto = Gallery_Model::getAlbum($_GET['Id']);
                $album['photos'] = $albumPhoto;
                return $this->view->generate('Галерея', 'templates/modules/gallery/editAlbum.tpl', $album);
                break;
            case 'POST':
                $pictures = array();
                foreach ($_FILES["pictures"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                        $name = '/files/gallery/' . md5(uniqid(''));
                        array_push($pictures, $name);
                        move_uploaded_file($tmp_name, substr($name, 1));
                    }
                }
                if ($_FILES && $_FILES['mainPhoto']['error'] == UPLOAD_ERR_OK) {
                    if ($album['MainPhoto'] != '')
                        unlink(substr($album['MainPhoto'], 1));
                    $_POST['mainPhoto'] = '/files/gallery/' . md5(uniqid(''));
                    move_uploaded_file($_FILES["mainPhoto"]["tmp_name"], substr($_POST['mainPhoto'], 1));
                }
                if (isset($_POST['delMainPhoto'])) {
                    if ($album['MainPhoto'] != '') {
                        unlink(substr($album['MainPhoto'], 1));
                        $_POST['mainPhoto'] = '';
                    }
                }
                if (isset($_POST['delPhoto'])) {
                    foreach ($_POST['delPhoto'] as $photoId) {
                        $photo = Gallery_Model::getPhotoById($photoId)[0];
                        Gallery_Model::deletePhoto($photoId);
                        unlink(substr($photo['Path'], 1));
                    }
                }
                Gallery_Model::editAlbum($_POST, $pictures, $album['Id']);
                header('Location: /Gallery/');
                break;
        }
    }
}
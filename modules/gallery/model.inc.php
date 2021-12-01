<?php

class Gallery_Model extends Model
{
    public static function getAllAlbums()
    {
        return Core::GetDB()->getRowsWhere('Alboms');
    }

    public static function getAlbumsCount()
    {
        return Core::GetDB()->getRowsCount('Alboms','');
    }

    public static function getAlbumsPage($limit, $offset)
    {
        return Core::GetDB()->getRowsWhere('Alboms','',$limit, $offset);
    }

    public static  function getPhotoById($photoId)
    {
        return Core::GetDB()->getRowsWhere('Photos', array('Id' => $photoId));
    }

    public static function getAlbum($AlbumId)
    {
        return Core::GetDB()->getRowsWhere('Photos', array('AlbomId' => $AlbumId));
    }

    public static function getAlbumPhotoCount($Id)
    {
        return Core::GetDB()->getRowsCount('Photos', array('AlbomId' => $Id));
    }

    public static function getAlbumPhotoPage($Id,$limit, $offset)
    {

        return Core::GetDB()->getRowsWhere('Photos', array('AlbomId' => $Id), $limit,$offset);
    }

    public static function getAlbumInfo($AlbumId)
    {
        return Core::GetDB()->getRowsWhere('Alboms', array('Id' => $AlbumId));
    }

    public static function deleteAlbum($AlbumId)
    {
        $photos = Core::GetDB()->getRowsWhere('Photos', array('AlbomId' => $AlbumId));
        $album = Core::GetDB()->getRowsWhere('Alboms', array('Id' => $AlbumId));
        if($album==null)
            return Core::Error404();
        $album=$album[0];
        foreach ($photos as $photo)
        {
            if ($photo['Path'] != '')
                unlink(substr($photo['Path'], 1));
        }

        if ($album['MainPhoto'] != '')
            unlink(substr($album['MainPhoto'], 1));

        Core::GetDB()->delete('Alboms',array('Id'=>$AlbumId));
    }

    public static function addNewAlbum($row, $photos)
    {
        $fieldsArrayAlbum = array('name', 'mainPhoto');
        Core::GetDB()->addRecordFromForm('Alboms', $row, $fieldsArrayAlbum);
        $fieldsArrayPhotos = array('path', 'albomId');
        foreach ($photos as $photoPath)
        {
            $albumId=Core::GetDB()->getRowsWhere('Alboms', array('name' => $row['name'], 'mainPhoto'=>$row['mainPhoto']))[0]['Id'];
            $vals = array('path'=>$photoPath, 'albomId'=>$albumId);
            Core::GetDB()->addRecordFromForm('Photos', $vals, $fieldsArrayPhotos);
        }
    }

    public static function editAlbum($row, $photos, $albumId)
    {
        $fieldsArrayAlbum = array('name', 'mainPhoto');
        Core::GetDB()->update('Alboms',array('Id' => $albumId), $row, $fieldsArrayAlbum);
        $fieldsArrayPhotos = array('path', 'albomId');
        foreach ($photos as $photoPath)
        {
            $vals = array('path'=>$photoPath, 'albomId'=>$albumId);
            Core::GetDB()->addRecordFromForm('Photos', $vals, $fieldsArrayPhotos);
        }
    }

    public static function deletePhoto($photoId)
    {
        Core::GetDB()->delete('Photos',array('Id'=>$photoId));
    }

}
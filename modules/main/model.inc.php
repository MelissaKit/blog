<?php
class Main_Model extends Model
{
    public static function getAllReviews()
    {
        return Core::GetDB()->getRowsWhere('Posts');
    }

    public static function getReviewsCount()
    {
        return Core::GetDB()->getRowsCount('Posts');
    }
    public static function getReviewsPage($limit, $offset)
    {
        return Core::GetDB()->getRowsWhere('Posts','',$limit, $offset);
    }

    public static function addNewReview($row)
    {
        $fieldsArray = array('name', 'country', 'text', 'publicationDate', 'posterPath');
        Core::GetDB()->addRecordFromForm('Posts', $row, $fieldsArray);
    }

    public static function deleteReview($reviewId)
    {
        Core::GetDB()->delete('Posts',array('Id'=>$reviewId));
    }

    public static function editReview($reviewId, $row)
    {
        Core::GetDB()->update('Posts', array('Id' => $reviewId),  $row , array('name',  'country', 'text', 'posterPath'));
    }

    public static  function getReviewById($reviewId)
    {
        return Core::GetDB()->getRowsWhere('Posts', array('Id'=>$reviewId));
    }

    public static function FindElem($param)
    {
        $reviewsFields = array('Name','Country','Text');
        $newsFields = array('Title','Content');
        $galleryFields = array('Name');
        $result['reviews'] = Core::GetDB()->getRowsLike('Posts', $param, $reviewsFields);
        $result['news'] = Core::GetDB()->getRowsLike('FilmNews', $param, $newsFields);
        $result['gallery'] = Core::GetDB()->getRowsLike('Alboms', $param, $galleryFields);
        return $result;
    }
}
?>
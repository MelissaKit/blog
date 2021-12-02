<?php
class Posts_Model extends Model
{
    public static function getAllReviews()
    {
        return Core::GetDB()->getRowsWhere('Posts');
    }

    public static function getReviewsCount($getUser = null)
    {
        $conditions = $getUser ? array('userId' => $getUser) : '';
        return Core::GetDB()->getRowsCount('Posts', $conditions);
    }
    public static function getReviewsPage($limit, $offset, $currentUserId, $getUser = null)
    {
        if ($getUser) {
            $result = Core::GetDB()->getRowsWhere('Posts', array('userId' => $getUser), $limit, $offset);
        } else {
            $result = Core::GetDB()->getRowsWhere('Posts', '', $limit, $offset);
        }

        foreach ($result as $key => $post) {
            $result[$key]['isUserPost'] = !!($post['userId'] == $currentUserId);
        }
        return $result;
    }

    public static function addNewReview($row)
    {
        $fieldsArray = array('userId', 'name', 'text', 'publicationDate', 'posterPath');
        Core::GetDB()->addRecordFromForm('Posts', $row, $fieldsArray);
    }

    public static function deleteReview($reviewId)
    {
        Core::GetDB()->delete('Posts', array('Id' => $reviewId));
    }

    public static function editReview($reviewId, $row)
    {
        Core::GetDB()->update('Posts', array('Id' => $reviewId),  $row, array('name',  'text', 'posterPath'));
    }

    public static  function getReviewById($reviewId)
    {
        return Core::GetDB()->getRowsWhere('Posts', array('Id' => $reviewId));
    }

    public static function FindElem($param)
    {
        $reviewsFields = array('Name', 'Text');
        $newsFields = array('Title', 'Content');
        $result['reviews'] = Core::GetDB()->getRowsLike('Posts', $param, $reviewsFields);
        $result['news'] = Core::GetDB()->getRowsLike('FilmNews', $param, $newsFields);
        return $result;
    }
}

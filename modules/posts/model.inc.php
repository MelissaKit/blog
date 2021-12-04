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

    public static function deleteReview($postId)
    {
        Core::GetDB()->delete('Posts', array('Id' => $postId));
    }

    public static function editReview($postId, $row)
    {
        Core::GetDB()->update('Posts', array('Id' => $postId),  $row, array('name',  'text', 'posterPath'));
    }

    public static  function getReviewById($postId)
    {
        return Core::GetDB()->getRowsWhere('Posts', array('Id' => $postId));
    }

    public static function FindElem($param)
    {
        $postFields = array('Name', 'Text');
        $result['posts'] = Core::GetDB()->getRowsLike('Posts', $param, $postFields);
        return $result;
    }
}

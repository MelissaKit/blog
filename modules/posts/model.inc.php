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

    public static function getPostsPageInCategory($limit, $offset, $currentUserId, $category)
    {
        $result = Core::GetDB()->getRowsWhere('Posts', array('categoryId' => $category), $limit, $offset);

        foreach ($result as $key => $post) {
            $result[$key]['isUserPost'] = !!($post['userId'] == $currentUserId);
        }

        return $result;
    }

    public static function getPostsCountInCategory($categoryId)
    {
        return Core::GetDB()->getRowsCount('Posts', array('categoryId' => $categoryId));
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

    public static function addView($postId)
    {
        Core::GetDB()->incrementFieldWhere('Posts', array('Id' => $postId), 'views');
    }

    public static function FindElem($param)
    {
        $result['posts'] = Core::GetDB()->getRowsLike('Posts', $param,  array('Name', 'Text'));
        $result['users'] = Core::GetDB()->getRowsLike('User', $param,  array('Login', 'FirstName', 'SecondName', 'ShortDescription'));
        return $result;
    }
}

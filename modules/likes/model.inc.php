<?php
class Likes_Model extends Model
{
    public static function getLikesCount($postId)
    {
        return Core::GetDB()->getRowsCount('Likes', array('postId' => $postId));
    }

    public static function checkUserLike($postId, $userId){
        return Core::GetDB()->getRowsCount('Likes', array('postId' => $postId, 'userId' =>  $userId));
    }

    public static function addNewLike($postId, $userId)
    {
        $fieldsArray = array('userId', 'postId');
        Core::GetDB()->addRecordFromForm('Likes', array('postId' => $postId, 'userId' =>  $userId), $fieldsArray);
    }

    public static function deleteLike($postId, $userId)
    {
        Core::GetDB()->delete('Likes', array('postId'=>$postId, 'userId' => $userId));
    }
}

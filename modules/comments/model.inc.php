<?php
class Comments_Model extends Model
{
    public static function getPostComments($limit, $offset, $postId)
    {
        return Core::GetDB()->getRowsWhere('Comments', array('postId' => $postId), $limit, $offset);
    }

    public static function getPostCommentsCount($postId)
    {
        return Core::GetDB()->getRowsCount('Comments', array('postId' => $postId));
    }

    
    public static function getPostCommentsCountSentiment($postId, $sentimentId)
    {
        return Core::GetDB()->getRowsCount('Comments', array('postId' => $postId, 'sentiment' => $sentimentId));
    }

    public static function addComment($row)
    {
        $fieldsArray = array('userId', 'postId', 'commentText', 'sentiment');
        Core::
        
        GetDB()->addRecordFromForm('Comments', $row, $fieldsArray);
    }

    public static function deleteComment($Id)
    {
        Core::GetDB()->delete('Comments', array('Id' => $Id));
    }
}

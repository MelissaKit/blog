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
}

<?php
class Comments_Model extends Model
{
    public static function getPostComments($limit, $offset, $postId)
    {
        $comments = Core::GetDB()->getRowsWhere('Comments', array('postId' => $postId, 'isReply' => NULL), $limit, $offset);

        foreach ($comments as $key => $comment) {
            if (Comments_Model::getCommentRepliesCount($comment['Id'])) {
                $comments[$key]['replies'] = Comments_Model::getCommentReplies($comment['Id']);
            }
        }

        return $comments;
    }

    public static function getCommentReplies($commentId)
    {
        $replies = Core::GetDB()->getRowsWhere('Comments', array('replyCommentId' => $commentId));

        foreach ($replies as  $key => $reply) {
            if (Comments_Model::getCommentRepliesCount($reply['Id'])) {
                $replies[$key]['replies'] = Comments_Model::getCommentReplies($reply['Id']);
            }
        }

        return $replies;
    }

    public static function getCommentRepliesCount($commentId)
    {
        return Core::GetDB()->getRowsCount('Comments', array('replyCommentId' => $commentId));
    }
}

<?php
class Subscriptions_Model extends Model
{
    public static function getSubscriptionsPage($limit, $offset, $currentUserId)
    {
        $result = Core::GetDB()->getRowsWhere('Follow', array('userId' => $currentUserId), $limit, $offset);
        return $result;
    }

    public static function getSubscriptionsCount($userId)
    {
        return Core::GetDB()->getRowsCount('Follow', array('userId' => $userId));
    }

    public static function getSubscriptionById($subId){
        return Core::GetDB()->getRowsWhere('Follow', array('Id' => $subId));
    }

    public static function getSubscriptionByParams($userId, $followId){
        return Core::GetDB()->getRowsWhere('Follow', array('userId' => $userId, 'followId' => $followId));
    }

    public static function addNewSubscription($row)
    {
        $fieldsArray = array('userId', 'followId', 'followDate');
        Core::GetDB()->addRecordFromForm('Follow', $row, $fieldsArray);
    }

    public static function deleteSubscription($userId, $followId)
    {
        Core::GetDB()->delete('Follow', array('userId'=>$userId, 'followId' => $followId));
    }

    public static function getFemaleSubscribersCount($followId)
    {
        return Core::GetDB()->getRowsCountByCondition('User', "INNER JOIN Blog.Follow ON Blog.User.Id = Blog.Follow.userId WHERE Blog.User.Id IN (SELECT Blog.Follow.userId FROM Blog.Follow WHERE Blog.Follow.followId = ". $followId .") and Blog.User.Sex = 'f'");
    }

    public static function getMaleSubscribersCount($followId)
    {
        return Core::GetDB()->getRowsCountByCondition('User', "INNER JOIN Blog.Follow ON Blog.User.Id = Blog.Follow.userId WHERE Blog.User.Id IN (SELECT Blog.Follow.userId FROM Blog.Follow WHERE Blog.Follow.followId = ". $followId .") and Blog.User.Sex = 'm'");
    }

    public static function getSubscribersCountByCountries($followId)
    {
        return Core::GetDB()->getRowCountByCondition('User', 'Country' , "INNER JOIN Blog.Follow ON Blog.User.Id = Blog.Follow.userId  WHERE Blog.User.Id IN (SELECT Blog.Follow.userId FROM Blog.Follow WHERE Blog.Follow.followId = ". $followId .") GROUP by Blog.User.Country");
    }  

    public static function getSubscribersAge($followId)
    {
        return Core::GetDB()->getConditionCountByCondition('User', 'TIMESTAMPDIFF(YEAR, Blog.User.BirthDate, CURDATE()) AS age' , "INNER JOIN Blog.Follow ON Blog.User.Id = Blog.Follow.userId  WHERE Blog.User.Id IN (SELECT Blog.Follow.userId FROM Blog.Follow WHERE Blog.Follow.followId = ". $followId .")  GROUP by age ORDER BY age");
    }  
}

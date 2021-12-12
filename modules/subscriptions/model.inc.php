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

    public static function getSubscriptionById($subId)
    {
        return Core::GetDB()->getRowsWhere('Follow', array('Id' => $subId));
    }

    public static function getSubscriptionByParams($userId, $followId)
    {
        return Core::GetDB()->getRowsWhere('Follow', array('userId' => $userId, 'followId' => $followId));
    }

    public static function addNewSubscription($row)
    {
        $fieldsArray = array('userId', 'followId', 'followDate');
        Core::GetDB()->addRecordFromForm('Follow', $row, $fieldsArray);
    }

    public static function deleteSubscription($userId, $followId)
    {
        Core::GetDB()->delete('Follow', array('userId' => $userId, 'followId' => $followId));
    }

    public static function getFemaleSubscribersCount($followId)
    {
        $DATABASE_DBNAME = DATABASE_DBNAME;
        return Core::GetDB()->getRowsCountByCondition('User', "INNER JOIN " . $DATABASE_DBNAME . ".Follow ON " . $DATABASE_DBNAME . ".User.Id = " . $DATABASE_DBNAME . ".Follow.userId WHERE " . $DATABASE_DBNAME . ".User.Id IN (SELECT " . $DATABASE_DBNAME . ".Follow.userId FROM " . $DATABASE_DBNAME . ".Follow WHERE " . $DATABASE_DBNAME . ".Follow.followId = " . $followId . ") and " . $DATABASE_DBNAME . ".User.Sex = 'f'");
    }

    public static function getMaleSubscribersCount($followId)
    {
        $DATABASE_DBNAME = DATABASE_DBNAME;
        return Core::GetDB()->getRowsCountByCondition('User', "INNER JOIN " . $DATABASE_DBNAME . ".Follow ON " . $DATABASE_DBNAME . ".User.Id = " . $DATABASE_DBNAME . ".Follow.userId WHERE " . $DATABASE_DBNAME . ".User.Id IN (SELECT " . $DATABASE_DBNAME . ".Follow.userId FROM " . $DATABASE_DBNAME . ".Follow WHERE " . $DATABASE_DBNAME . ".Follow.followId = " . $followId . ") and " . $DATABASE_DBNAME . ".User.Sex = 'm'");
    }

    public static function getSubscribersCountByCountries($followId)
    {
        $DATABASE_DBNAME = DATABASE_DBNAME;
        return Core::GetDB()->getRowCountByCondition('User', 'Country', "INNER JOIN " . $DATABASE_DBNAME . ".Follow ON " . $DATABASE_DBNAME . ".User.Id = " . $DATABASE_DBNAME . ".Follow.userId  WHERE " . $DATABASE_DBNAME . ".User.Id IN (SELECT " . $DATABASE_DBNAME . ".Follow.userId FROM " . $DATABASE_DBNAME . ".Follow WHERE " . $DATABASE_DBNAME . ".Follow.followId = " . $followId . ") GROUP by " . $DATABASE_DBNAME . ".User.Country");
    }

    public static function getSubscribersAge($followId)
    {
        $DATABASE_DBNAME = DATABASE_DBNAME;
        return Core::GetDB()->getConditionCountByCondition('User', 'TIMESTAMPDIFF(YEAR, '. $DATABASE_DBNAME . '.User.BirthDate, CURDATE()) AS age', "INNER JOIN " . $DATABASE_DBNAME . ".Follow ON " . $DATABASE_DBNAME . ".User.Id = " . $DATABASE_DBNAME . ".Follow.userId  WHERE " . $DATABASE_DBNAME . ".User.Id IN (SELECT " . $DATABASE_DBNAME . ".Follow.userId FROM " . $DATABASE_DBNAME . ".Follow WHERE " . $DATABASE_DBNAME . ".Follow.followId = " . $followId . ")  GROUP by age ORDER BY age");
    }
}

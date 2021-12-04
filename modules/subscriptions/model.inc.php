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

    public static function deleteSubscription($subId)
    {
        Core::GetDB()->delete('Follow', array('Id'=>$subId));
    }
}

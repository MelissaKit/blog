<?php
class Subscriptions_Model extends Model
{
    public static function getSubscriptionsPage($limit, $offset, $currentUserId)
    {

    }

    public static function getSubscriptionById($subId){
        return Core::GetDB()->getRowsWhere('Follow', array('Id' => $subId));
    }

    public static function addNewSubscription($row)
    {

    }

    public static function deleteSubscription($subId)
    {
    }
}

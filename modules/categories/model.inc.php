<?php
class Categories_Model extends Model
{
    public static function getAllCategories()
    {
        return Core::GetDB()->getRowsWhere('Category');
    }

    public static function getCategoryById($categoryId)
    {
        return Core::GetDB()->getRowsWhere('Category', array('Id' => $categoryId));
    }
}

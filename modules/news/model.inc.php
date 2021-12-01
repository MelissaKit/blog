<?php
class News_Model extends Model
{
    public static function getAllNews()
    {
        return Core::GetDB()->getRowsWhere('News');
    }

    public static function addNewsItem($row)
    {
        $fieldsArray = array('title', 'content', 'publicationDate', 'posterPath');
        Core::GetDB()->addRecordFromForm('News', $row, $fieldsArray);
    }

    public static function deleteNewsItem($newsItemId)
    {
        Core::GetDB()->delete('News',array('Id'=>$newsItemId));
    }

    public static function editNewsItem($newsItemId, $row)
    {
        Core::GetDB()->update('News', array('Id' => $newsItemId),  $row , array('title','content', 'posterPath'));
    }

    public static  function getNewsItemById($newsItemId)
    {
        return Core::GetDB()->getRowsWhere('News', array('Id'=>$newsItemId));
    }

    public static function getNewsItemsCount()
    {
        return Core::GetDB()->getRowsCount('News');
    }
    public static function getNewsPage($limit, $offset)
    {
        return Core::GetDB()->getRowsWhere('News','',$limit, $offset);
    }
}
?>
<?php
namespace Model;

class Category extends \Model_Crud
{
    // 利用したいテーブル名をセット
    protected static $_table_name = 'category';
    protected static $_primary_key = 'id';

    public static function get_category()
      {
        $category = Category::find_all();
        return $category;

      }
    //カテゴリーの名前を取得
    public static function get_name($id)
      {
        $category = Category::find_one_by('id', $id);
        return $category['name'];
      }

}

 ?>

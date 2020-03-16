<?php
namespace Model;

class Favorite extends \Model_Crud
{
    // 利用したいテーブル名をセット
    protected static $_table_name = 'favorite';
    protected static $_primary_key = 'id';
    protected static $_mysql_timestamp = true;
    protected static $_properties = array(
    'id',
    'book_id',
    'user_id',
    'delete_flg',
    'updated_at',
    'created_at'
    );

    //全てのレコードを取得
    public static function get_all()
      {
        $favorite = Favorite::find_all();
        return $favorite;

      }

    //全てのレコードを取得（論理削除されていない）
    public static function find_exist()
      {
        $favorite = Favorite::find_by('delete_flg', 0);
        return $favorite;
      }


}

 ?>

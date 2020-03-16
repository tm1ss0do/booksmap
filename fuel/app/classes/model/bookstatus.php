<?php
namespace Model;

class Bookstatus extends \Model_Crud
{
    // 利用したいテーブル名をセット
    protected static $_table_name = 'book_status';
    protected static $_primary_key = 'id';

    //全てのレコードを取得
    public static function get_all()
      {
        $bookstatus = Bookstatus::find_all();
        return $bookstatus;

      }
    //カテゴリーの名前を取得
    public static function get_name($id)
      {
        $bookstatus = Bookstatus::find_one_by('id', $id);
        return $bookstatus['name'];

      }
      


}


 ?>

<?php
namespace Model;

class Users extends \Model_Crud
{
    // 利用したいテーブル名をセット
    protected static $_table_name = 'users';
    protected static $_primary_key = 'id';
    protected static $_mysql_timestamp = true;
    protected static $_properties = array(
    'id',
    'username',
    'password',
    'group',
    'email',
    'nickname',
    'last_login',
    'login_hash',
    'profile_fields',
    'created_at',
    'updated_at',
    );

    //全てのレコードを取得
    public static function get_all()
      {
        $books = Books::find_all();
        return $books;

      }

    //全てのレコードを取得（論理削除されていない）
    public static function find_exist()
      {
        $books = Books::find_by('delete_flg', 0);
        return $books;
      }


}


 ?>

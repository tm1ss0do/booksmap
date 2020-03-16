<?php
namespace Model;

//users_detail
class Usersdetail extends \Model_Crud{
  // Set the table to use
    protected static $_table_name = 'user_detail';
    protected static $_primary_key = 'id';
    protected static $_properties = array(
    'id',
    'u_id',
    'nickname'
);

    public static function get_results()
   {
     return 'dekita';

   }


}

 ?>

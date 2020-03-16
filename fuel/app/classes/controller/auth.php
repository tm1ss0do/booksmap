<?php

//------------action
//logout
//------------------


//定数
const EMAIL_MIN_LEN = 1;
const EMAIL_MAX_LEN =255;
const USER_NAME_LEN = 6;
const PASS_LEN = 6;

class Controller_Auth extends Controller_Template{


  public function action_logout(){
    //ログアウト
    // remember-me クッキーを削除し、意図的にログアウト
    \Auth::dont_remember_me();

    // ログアウト
    \Auth::logout();

    // ログアウトの成功をユーザーに知らせる
    Session::set_flash('sucMsg', 'ログアウトしました');

    // そして、あなたがやってきたところに (もしくは、前のページを
    // 決定することができない場合はアプリケーションのホームページに) 戻る
    \Response::redirect_back('book/booklists');
  }





}

 ?>

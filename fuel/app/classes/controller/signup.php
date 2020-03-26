<?php
//------------action
//signUp
//------------------


//定数
const USER_NAME_LEN = 6;//usernameの長さ
const PASS_LEN = 6; //パスワードの長さ
const EMAIL_MIN_LEN = 1; //emailの最短
const EMAIL_MAX_LEN = 255; //emailの最長

class Controller_Signup extends Controller_Template
{


  public function before()
   {
     //ログイン認証
       parent::before(); // この行がないと、テンプレートが動作しません!
       //auth check
       if( \Auth::check() && \Auth::get_groups() === 1 )
       {
         //ログインチェックok
         $loginuser = true;
         // 必要があれば画面遷移
         \Response::redirect_back('book/booklists');
         Session::set_flash('sucMsg','ログインユーザーです');
       }else{
         $loginuser = false;

         ////////////////////////////////////
         //ログインフォームの生成
         $login_form = Fieldset::forge('loginform');

         $login_form
         ->add('username','ユーザー名',
               array(
                 'type' => 'text',
                 'class' => 'form-control js-form-user-name',
                 'id' => 'login-user',
               )
         )
         ->add_rule('required')
         ->add_rule('exact_length', USER_NAME_LEN);

         $login_form
         ->add('password','パスワード',
               array(
                 'type' => 'password',
                 'class' => 'form-control js-form-user-pass',
                 'id' => 'login-user',
               )
         )
         ->add_rule('required')
         ->add_rule('exact_length', PASS_LEN);

         $login_form
         ->add('login', '',
               array('type' => 'submit',
                 'class' => 'btn btn-primary',
                 'value '=> 'ログイン'
               )
         )
         ->set_template(
           '<div class="modal-footer d-flex flex-column">{label}{required}{field} <span>{description}</span> {error_msg}</div>'
         );

         // error
         $errors = array();

         //ログインフォームが投稿されたら？
         // if(Input::method() === 'POST' ){
         if(Input::method() === 'POST' && Input::post('login') ){
           // 現在の Fieldset の Validation インスタンスを取得
           $val = $login_form->validation();
           //バリデーションチェック
           if( $val->run() ){
             // バリデーションに成功した場合の処理
             // 資格情報のチェック
             if( \Auth::instance()->login(\Input::param('username'), \Input::param('password')) )
             {
               // ユーザーを覚えてほしい？
               if (\Input::param('remember', false))
               {
                   // remember-me クッキーを作成
                   \Auth::remember_me();
               }
               else
               {
                   // 存在する場合、 remember-me クッキーを削除
                   \Auth::dont_remember_me();
               }

               // ログイン
               //ユーザーが居た以前のページか、
               //以前のページが検出できない場合
               \Response::redirect_back('book/booklists');
               //success message
               Session::set_flash('sucMsg','ログインしました');
             }else{
               //ユーザー情報が見つかりません
               $errors = $login_form->error();
               Session::set_flash('errMsg','ユーザー情報が見つかりません');
             }


           }else{

             // 失敗
             //エラーを配列形式で格納
             $errors = $login_form->error();
             //erorr message
             Session::set_flash('errMsg','ログインに失敗しました');

           }

           // フォーム送信からの入力値をフィールドに設定する。
           $login_form->repopulate();
         }

         //変数としてビューを割り当てる
         //login_formをviewへ渡す
         $this->template->login_form = View::set_global('login_form', $login_form->build(), false);
         $this->template->errors = View::set_global('errors', $errors);

         /////////////////////////////////////


       }
       //テンプレ
       $this->template->head = View::forge('template/head');
       $this->template->footer = View::forge('template/footer');
       $this->template->header = View::forge('template/header');
       $this->template->loginuser = View::set_global('loginuser' ,$loginuser);
   }


  public function action_index()
  {
    $error = '';
    $formData = '';

    //FieldSetクラス
    //Fieldsetクラスからインスタンスを生成
    $form = Fieldset::forge('signupform',
    array(
        'form_attributes' => array(
        'class' => 'col-sm-6 mx-auto',
        )
    )
  );

    // 検証ルール付きFieldset Fieldを生成
    $form
    ->add('username', 'ユーザー名',
      array('type' => 'text', 'class' => 'form-control js-form-user-name', 'placeholder'=>'半角英数字6文字', 'autocomplete' => 'off') )
    ->add_rule('required')
    ->add_rule('exact_length', USER_NAME_LEN);

    $form
    ->add('email', 'email',
      array('type' => 'email', 'class' => 'form-control js-form-email', 'autocomplete' => 'off') )
    ->add_rule('required')
    ->add_rule('valid_email')
    ->add_rule('min_length', EMAIL_MIN_LEN)
    ->add_rule('max_length', EMAIL_MAX_LEN);

    $form
    ->add(
      'password', 'パスワード',
      array('type' => 'password', 'class' => 'form-control js-form-user-name', 'placeholder'=>'半角英数字6文字', 'autocomplete' => 'off')
    )
    ->add_rule('required')
    ->add_rule('exact_length', PASS_LEN);

    $form
    ->add(
      'submit', '',
      array('type' => 'submit', 'class' => 'btn btn-outline-dark col-5 d-block mx-auto mt-4', 'value '=> '登録' )
    );


    //submitされた時、
    //ポスト送信か確認(⇨validationクラスでバリデーションを実行するためにはPOST送信でなければならないため。)
    if(Input::method() === 'POST'){

      $val = $form->validation();
      //入力を検証
      if( $val->run() ){
        //バリデーションに成功した場合の処理
        // バリデートに成功したフィールドと値の組を配列で取得する
          $formData = $val->validated(); //ok

        //Authインスタンス生成
          $auth = Auth::instance();
        //userの作成
        try{
          $create = $auth->create_user($formData['username'], $formData['password'], $formData['email']);

          if( $create ){
            Session::set_flash('sucMsg','登録しました！');
            //ログインさせる
            $name = Input::post('username');
            $pass = Input::post('password');
            Auth::login($name, $pass);

            // リダイレクト
            Response::redirect_back('book/bookLists');
          }else{
            Session::set_flash('errMsg','ユーザー登録に失敗しました。');
          }

        }
        catch (\SimpleUserUpdateException $e)
        {
          // メールアドレスが重複
          if ($e->getCode() == 2)
          {
            Session::set_flash('errMsg','登録済みのユーザーです。');
          }
          // ユーザー名が重複
          elseif ($e->getCode() == 3)
          {
            Session::set_flash('errMsg','登録済みのユーザーです。');
          }
          // これは起こり得ないが、ずっとそうとは限らない...
          else
          {
            Session::set_flash('errMsg',$e->getMessage());
          }
        }

      }
      else {
        //失敗
        // エラー格納
        $error = $val->error();
        //セッションに値をいれ、メッセージを出す
        Session::set_flash('errMsg','登録できませんでした！');
      }
      // フォームにPOSTされた値をセット
      $form->repopulate();

    }

    //view
    //テンプレ(beforeなどでまとめて読み込み)
    $this->template->head = View::forge('template/head');
    $this->template->footer = View::forge('template/footer');
    $this->template->header = View::forge('template/header');

      $this->template->content = View::forge('auth/signup');
      $this->template->btnContainer = View::set_global('btnContainer',View::forge('common/btnContainer'));
      $this->template->signupform = View::set_global('signupform',$form->build(), false);
      $this->template->error = View::set_global('error', $error);

  }

}


 ?>

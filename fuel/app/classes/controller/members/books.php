<?php
//------------action
//bookEdit
//bookdelete
//------------------



use \Model\Category;

const EMAIL_MIN_LEN = 1;
const EMAIL_MAX_LEN =255;
const USER_NAME_LEN = 6;
const PASS_LEN = 6;


class Controller_Members_Books extends Controller_Template{


  public function before()
   {
     //ログイン認証
       parent::before(); // この行がないと、テンプレートが動作しません!
       //auth check
       $groups = \Auth::get_groups();
       $group = $groups[0][1];
       //auth check
       if( \Auth::check() && $group == 1 )
       {
         //ログインチェックok
         $loginuser = true;

       }else{
         $loginuser = false;
         Session::set_flash('errMsg','ログインしていません');
         Response::redirect_back('/members/mypage/index');

       }
       //テンプレ
       $this->template->head = View::forge('template/head');
       $this->template->footer = View::forge('template/footer');
       $this->template->header = View::forge('template/header');
       $this->template->loginuser = View::set_global('loginuser' ,$loginuser);

   }

  //bookEdit
  public function action_bookEdit()
  {
    //ユーザがログイン中なら array(driver_id, user_id) 形式の配列を、そうでなければ false を返す。
    $u_id = Auth::instance()->get_user_id();
    //ユーザーIDを格納
    $u_id = $u_id[1];

    $errors = '';

    /////////////////////////////
    //編集画面 OR 投稿画面---------
    // getパラメーターから、books_idを取得
    if(!empty( Input::get('book') )){
      $books_id = Input::get('book');
      // books_idと合致する本の登録情報
      $book = \Model\Books::find_one_by('id', $books_id);
      $this->template->book = View::set_global('book',$book);
      //アップロードしている画像ファイル
      Asset::add_path('assets/img/uploads','img');
      $sub = 'edit_flg';

    }else{
      $book['title'] = '';
      $book['price'] = '';
      $book['img'] = 'dist/no_image.png';
      $book['short'] = '';
      $book['summary'] = '';
      $books_id = '';
      $sub = 'submit';
    }

    /////////////////////////////

    //fieldsetの作成
      //instance
      $booksform = Fieldset::forge(
        'booksform', array(
        'form_attributes' => array(
            'class' => 'col-sm-9 px-0',
            'enctype' => 'multipart/form-data'
            )
        )
      );
      //Fieldset_Field
      //title
      $booksform
      ->add('title','タイトル',
            array('type' => 'text',
                  'class' => 'form-control js-book-title',
                  'autocomplete' => 'off',
                  'value' => $book['title']
                ),
      )
      ->add_rule('required')
      ->add_rule('min_length', 1)
      ->add_rule('max_length', 100);


      //カテゴリーをモデルから取ってくる。
      $cateData = Category::get_category();
      $category = array();

      foreach( $cateData as $val => $key ){
        $category[$key['id']] = $key['name'];
      }

      $booksform
      ->add('category','カテゴリー',
            array('options' => $category,
                  'type' => 'select',
                  'class' => 'form-control',
                  'autocomplete' => 'off'
                ),
      )
      ->add_rule('required');


      //ステータスをモデルから取ってくる。
      $statusData = \Model\Bookstatus::get_all();
      $status = array();
      foreach( $statusData as $val => $key ){
        $status[$key['id']] = $key['name'];
      }

      $booksform
      ->add('status','ステータス',
            array('options' => $status,
                  'type' => 'select',
                  'class' => 'form-control'
                ),
      )
      ->add_rule('required');

      //price
      $booksform
      ->add('price','価格',
            array('type' => 'text',
                  'class' => 'form-control js-book-price',
                  'autocomplete' => 'off',
                  'placeholder' => '半角数字でご入力ください',
                  'value' => $book['price']
                ),
      )
      ->add_rule('match_pattern', '/^[0-9]+$/')
      ->set_error_message('match_pattern','価格は半角数字でご入力ください');



      //img
      $booksform
      ->add('bookimg','',
            array('type' => 'file',
                  'class' => 'custom-file-input js-upload-img',
                  'id' => 'customFile',
                ),

      )
      ->set_description( 'https://booksmap.tomomi-s.xyz/public/assets/img/uploads/'.$book['img'] )
      ->set_template('
      <label class="" for="">画像</label>
      <div class="p-fieldbox custom-file mb-4">
      <label class="custom-file-label" for="customFile">画像を選択してください</label>
      {label}{required}{field}
      <span></span> {error_msg}</div>

      <div class="mx-auto over col-sm-3 p-0 border height__250">
        <img class="js-view-img w-100 height__250 fit-cover" src="{description}" alt="">
      </div>
      ');

      $booksform
      ->add('short','あらすじ',
            array('type' => 'textarea',
                  'class' => 'form-control js-book-short height__150',
                  'autocomplete' => 'off',
                  'value' => $book['short']
                ),
      )
      ->add_rule('max_length', 300)
      ->set_template('
      <div class=\"p-fieldbox form-group\">{label}{required}{field}
      <p class="text-right js-counter">
      <span class="js-show-count">0</span>
      /300文字</p>
      <span>{description}</span> {error_msg}</div>
      ');

      $booksform
      ->add('summary','本文',
            array('type' => 'textarea',
                  'class' => 'form-control js-book-summary height__250',
                  'autocomplete' => 'off',
                  'value' => $book['summary']
                ),
      )
      ->add_rule('max_length', 1000)
      ->set_template('
      <div class=\"p-fieldbox form-group\">{label}{required}{field}
      <p class="text-right js-counter">
      <span class="js-show-count">0</span>
      /1000文字</p>
      <span>{description}</span> {error_msg}</div>
      ');


      $booksform
      ->add('bookid','',
            array('type' => 'text',
                  'class' => 'd-none',
                  'value' => $books_id
                ),
      );


      $booksform
      ->add( $sub,'',
            array('type' => 'submit',
                  'class' => 'btn btn-primary container-fluid',
                  'value' => '投稿',
                )
      );



        //Postされていたら、validation
        if( Input::method() === 'POST' ){
          //validationインスタンスの取得・生成
          $val = $booksform->validation();
          $err = '';

          // POSTに対してバリデーションを実行
          if ($val->run())
          {

            //画像の処理////////////
            // このアップロードのカスタム設定
            $config = array(
                'path' => 'assets/img/uploads/',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );
            // $_FILES 内のアップロードされたファイルを処理する
            Upload::process($config);

                  if(Upload::is_valid()){ //検証に成功した場合
                    // 設定にしたがって保存する
                    Upload::save();
                    //DBへ保存する情報を
                    $files = Upload::get_files();
                    // $filename = $files['saved_as'];
                    // $image = Upload::get_files();

                    Log::debug('=============================================== (Cc) エラーフラグに0追加');
                    $files += array('error_flg' => 0); //エラーフラグfalse

                  }else{

                      Log::debug('=================================================== (CB) チェック失敗の場合');
                      Log::debug('=============================================== (Ca) エラーメッセージ取得');

                      foreach (Upload::get_errors() as $file) //エラーメッセージ取得
                {

                          if(!empty($file)){
                              Log::debug('==========エラーあり');

                              foreach($file['errors'] as $key => $val){

                                  if($key == 'message' && !empty($val)){
                                      Log::debug('==========エラーメッセージ取得');

                                      $files['message'] = $val['message']; //メッセージを格納
                                      $files += array('error_flg' => 1); //エラーフラグtrue

                                  }
                              }
                          }
                }
                  }

            //////////////////////

            if(!empty($files[0]['saved_as'])){
              $img = $files[0]['saved_as'];
            }elseif(!empty($book['img'])){
              $img = $book['img'];
            }else{
              //画像が登録されていなかった場合 NO IMAGE
              $img = '';
            }

            // バリデーションに成功した場合
            //bookの情報をbooksテーブルへ追加
            $form = array();
            $form['title'] = Input::post('title');
            $form['cate_id'] = Input::post('category');
            $form['stat_id'] = Input::post('status');
            $form['price'] = (int)Input::post('price');
            //画像のファイルパスを指定
            $form['img'] = $img;
            $form['short'] = Input::post('short');
            $form['summary'] = Input::post('summary');
            $form['delete_flg'] = 0;
            $form['updated_at'] = null;
            $form['created_at'] = null;
            $form['user_id'] = $u_id;

            if(!empty( Input::post('edit_flg') )){
              //編集しアップデートする
              //データ取得
              $mt = \Model\Books::find_by_pk(Input::post('bookid'));
              $mt->set( $form );
              //更新
              $mt->save();
              //成功メッセージ
              Session::set_flash('sucMsg','編集できました！');

            }
            else{
              //本を新規登録する
              $books = \Model\Books::forge();
              $books->set($form); //配列をset
              $books->save(); //saveメソッドで、テーブルにレコードを書き込む
              //成功メッセージ
              Session::set_flash('sucMsg','登録できました！');
            }

            //ページ遷移->マイページの投稿一覧画面
            // Response::redirect('members/mypage/submitBookList');

          }
          else
          {
              // 失敗
              // バリデーションエラーをフィールドとエラー内容の組の配列で取得する
              $errors = $val->error();
              //失敗メッセージ
              Session::set_flash('errMsg','登録できませんでした');

          }

          //入力された値を保持
          $booksform->repopulate();

        }


      //HTMLフォームを生成
      //第3引数の自動エンコーディングをtrueにすると、htmlが表示されてしまうので、falseにする
      $this->template->booksform = View::set_global('booksform', $booksform->build(), false);
      $this->template->content = View::forge('pages/bookEdit');
      $this->template->btnContainer = View::set_global('btnContainer',View::forge('common/btnContainer'));
      $this->template->errors = View::set_global('errors', $errors);
      $this->template->u_id = View::set_global('u_id', $u_id);

  }


  //bookデータを論理削除
  public function action_bookdelete()
  {
    //削除対象となるbookのIDをgetパラメーターから取得
    $books_id = Input::get('book');

    //削除ボタンが押された場合、delete_flgを0→1へ変更
    $delete_book = \Model\Books::find_by_pk($books_id);
    $delete_book->set(array('delete_flg' => '1'));

    if( $delete_book->save() ){
      //削除完了メッセージを表示
      Session::set_flash('sucMsg','削除しました');

      //投稿一覧画面へ
      Response::redirect('book/booklists');
    }else{
      //削除未完了メッセージを表示
      Session::set_flash('errMsg','削除できませんでした。時間をおいてお試しください。');

    }

  }



}

 ?>

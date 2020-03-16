<?php



class Controller_Upld extends Controller_Rest{
  //定数
  const DOCROOT = 'https://booksmap.tomomi-s.xyz/public/assets/img/';

    public function post_img(){

      Log::debug('画像アップロード');

      // このアップロードのカスタム設定
      $config = array(
          'path' => DOCROOT,
          'randomize' => true,
          'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
      );
      // $_FILES 内のアップロードされたファイルを処理する
      Upload::process($config);

            Log::debug('======================================================== (C1) ファイルバリデーションチェック');

            if(Upload::is_valid()){ //検証に成功した場合

                Log::debug('=================================================== (CA) チェック成功の場合');
                Log::debug('=============================================== (Ca) ファイルを保存');

              Upload::save();

              Log::debug('=============================================== (Cb) ファイル情報を取得');

              $files = Upload::get_files();

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
            return $files;

    }
}

 ?>

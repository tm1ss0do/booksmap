<?php

class Controller_Test extends Controller_Template
{

  public function before()
   {
     //ログイン認証
       parent::before(); // この行がないと、テンプレートが動作しません!

       //テンプレ
       $this->template->head = View::forge('template/head');
       $this->template->footer = View::forge('template/footer');
       $this->template->header = View::forge('template/header');
       // $this->template->loginuser = View::set_global('loginuser' ,$loginuser);
   }

    public function action_index($link ='#', $bookTitle = 'title', $bookImg = 'dist/no_image.png', $summaryShort = null )
    {
        $data = array();
        $this->template->site_title = 'site_title';
        $this->template->content = View::forge('pages/index');
        $this->template->link = View::set_global('link',$link);
        $this->template->bookTitle = View::set_global('bookTitle',$bookTitle);
        $this->template->bookImg = View::set_global('bookImg',$bookImg);
        $this->template->summaryShort = View::set_global('summaryShort',$summaryShort);

    }
}

 ?>


<!--  *****  *****  *****  *****  *****  -->
<!-- main -->

<section id="main">

  <h2 class="page-title text-center mt-2">退会画面</h2>

  <!--  *****  *****  *****  *****  *****  -->
  <!-- withdraw 確認 -->

  <?php if(!empty($withdraw_form)): ?>
  <div class="d-flex justify-content-center text-center flex-column row mx-0 mt-4">
    退会しますか？<br>
    <?php echo $withdraw_form; ?>
  </div>

  <!--  *****  *****  *****  *****  *****  -->
  <?php echo $btnContainer; ?>

  <?php else: ?>

    <div class="d-flex justify-content-center text-center flex-column row mx-0 mt-4">
      退会を受け付けました。</br>
      ご利用ありがとうございました。</br>
      <?php echo Html::anchor('book/bookLists', 'Top画面へ', array('class' => 'btn btn-outline-dark col-sm-1 col-5 mx-auto mt-4' ) ); ?>
    </div>

  <?php endif;  ?>

</section>

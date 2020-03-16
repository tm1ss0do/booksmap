<!--  *****  *****  *****  *****  *****  -->
<!-- main -->

<section id="main">

  <h2 class="page-title text-center mt-2">新規登録画面</h2>
  <?php
      if(!empty($error)):
  ?>
      <ul class="area-error-msg">
  <?php
      foreach ($error as $key => $val):
  ?>
      <li><?=$val?></li>
  <?php
      endforeach;
  ?>
          </ul>
  <?php
      endif;
  ?>

  <?php echo $signupform; ?>

  <!--  *****  *****  *****  *****  *****  -->
  <?php echo $btnContainer; ?>

</section>

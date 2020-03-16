
<!--  *****  *****  *****  *****  *****  -->
<!-- main -->

<section id="main">

  <h2 class="page-title text-center mt-2">パスワードの編集</h2>

  <!--  *****  *****  *****  *****  *****  -->
  <!-- withdraw contents -->
  <div class="d-flex row mx-0 mt-4">
    <!-- error message -->
    <?php
    if(!empty($errors)){
      foreach($errors as $key => $val){
        ?>
        <li><?php echo $val; ?></li>
        <?php
      }
    }
    ?>
    <?php echo $usereditform; ?>

  </div>


  <!--  *****  *****  *****  *****  *****  -->
  <?php echo $btnContainer; ?>

</section>

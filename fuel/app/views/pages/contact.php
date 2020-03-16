

<!--  *****  *****  *****  *****  *****  -->
<!-- main -->

<section id="main">

  <h2 class="page-title text-center mt-2">お問い合わせ</h2>

  <!--  *****  *****  *****  *****  *****  -->
  <!-- mypage contents -->

  <section id="mypage-panels" class="d-flex justify-content-center my-5 mx-0 row">
    <div class="btn-group btn-group-lg col-sm-6 row" role="group" aria-label="Basic example">
      <!-- error message -->
      <ul>
        <?php
        if(!empty($errors_contact)){
          foreach($errors_contact as $key => $val){
            ?>
            <li><?php echo $val; ?></li>
            <?php
          }
        }
        ?>
      </ul>
      <?php echo $contact_form; ?>
    </div>
  </section>

    <!--  *****  *****  *****  *****  *****  -->
    <?php echo $btnContainer; ?>

  <!--  *****  *****  *****  *****  *****  -->
</section>

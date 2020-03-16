<!--  *****  *****  *****  *****  *****  -->
<!-- main -->

<section id="main">

      <h2 class="page-title text-center mt-2">投稿</h2>
      <?php
          if(!empty($errors)):
      ?>
          <ul class="area-error-msg col-sm-9 mx-auto px-4 py-2">
      <?php
          foreach ($errors as $key => $val):
      ?>
          <li><?=$val?></li>
      <?php
          endforeach;
      ?>
              </ul>
      <?php
          endif;
      ?>

  <!--  *****  *****  *****  *****  *****  -->
  <!-- book overview -->
      <div class="d-flex justify-content-center mt-5 mx-0 row">

        <?php echo $booksform; ?>
      </div>

        <?php echo $btnContainer; ?>

      </section>

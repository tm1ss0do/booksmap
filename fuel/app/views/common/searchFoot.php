<section class="row mx-0">

  <nav class="d-flex justify-content-center mx-auto" aria-label="Page navigation example">
    <?php
    if(!empty( Pagination::instance('mypagination') )){
      echo Pagination::instance('mypagination')->render();
    }
    ?>
  </nav>

</section>

<section id="search" class="row mx-0">
  <!-- search -->
</br>
  <div class="col-sm-9 row p-3 mx-auto">
    <!-- category -->
      <p class="col-sm-9 col-4 px-0">
        <a class="btn border js-animation-active" data-toggle="collapse" href="#search-category" aria-expanded="false" aria-controls="search-category">
          検索
          <i class="fas fa-chevron-down js-animation-target transition_5"></i>
        </a>
      </p>
  </div>

  <div class="collapse col-sm-9 row p-3 mx-auto" id="search-category">
    <div class="card card-body pl-sm-2">
      <?php echo $search_form; ?>
    </div>

  </div>

</section>

<section class="row d-flex flex-column mx-0">
  <p class="col-sm-9 px-4 pb-3 mb-0  mx-auto">
    表示件数
    <span class="font-weight-bold text-monospace">
      <?php if(!empty($count)) echo $count; ?>
    </span>
    件
  </p>


  <nav class="d-flex justify-content-center" aria-label="Page navigation example">
    <?php
    if(!empty( Pagination::instance('mypagination') )){
      echo Pagination::instance('mypagination')->render();
    }
    ?>
  </nav>


</section>

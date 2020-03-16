<!-- *****  *****  *****  *****  ***** -->
    <!-- main -->


    <section id="main">
      <!-- new -->
      <div class="card-columns w-75 mx-auto">

        <div class="card p-3 text-right">
          <blockquote class="blockquote mb-0">
            <p>
              読んだ本を記憶に残すために</br>
              作ろう
              BooksMap
            </p>
          </blockquote>
        </div>

        <?php
        Asset::add_path('assets/img/uploads','img');

        if(!empty($data)):

        foreach( $data as $key => $val ):

          ?>

          <div class="card">
            <?php
            if(!empty($val['img'])){
              echo Asset::img($val['img'], array('class' => 'bd-placeholder-img card-img-top w-100 height__250 fit-cover') );
            }else{
              echo Asset::img($bookImg, array('class' => 'bd-placeholder-img card-img-top w-100 height__250 fit-cover') );
            }
             ?>
            <div class="card-body">
              <h5 class="card-title text-truncate"><?php  echo $val['title'];?></h5>
                <div class="card-text mb-2 clamp__2">
                  <?php
                  echo $val['short'];
                   ?>
                </div>
                  <a href="<?php echo Uri::base().'home/bookDetail'.'?book='.$val['id']; ?>" class="btn btn-primary">read more</a>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated <?php echo $val['updated_at']; ?></small>
            </div>
          </div>

        <?php

        endforeach;

        endif;
        ?>

        <div class="card text-center">
          <?php echo Html::anchor('book/bookLists','<blockquote class="blockquote mb-0">
              <p>What are you looking for?</p>
              See more books
              <i class="fas fa-angle-double-right"></i>
          </blockquote>',array('class'=>'btn btn-primary text-white d-block') ); ?>
        </div>
      </div>

    </section>

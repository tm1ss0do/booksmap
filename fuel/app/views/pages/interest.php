
    <!-- *****  *****  *****  *****  ***** -->
    <!-- main -->
    <section id="main">
      <h2 class="page-title text-center mt-2">気になる一覧</h2>

      <?php echo $searchHead; ?>

      <!-- cards -->
      <section id="favorite-lists" class="row min-vh-210 mx-0">

        <div class="card-deck col-sm-9 row mx-auto d-flex">

                  <?php
                  Asset::add_path('assets/img/uploads','img');

                  if(!empty($data['books_data'])):

                  foreach( $data['books_data'] as $key => $val ):
                    //カテゴリID
                    $cateid = $val['cate_id'];
                    //カテゴリーの名前をモデルから取ってくる。
                    $categoryData = \Model\Category::get_name($cateid);
                    //ステータスID
                    $stid = $val['stat_id'];
                    //ステータスをモデルから取ってくる。
                    $statusData = \Model\Bookstatus::get_name($stid);

                    ?>

                    <div class="card my-2 col-sm-3 mx-0 p-0 flex-fill">
                      <?php
                      if(!empty($val['img'])){
                        echo Asset::img($val['img'], array('class' => 'bd-placeholder-img card-img-top w-100 height__250 fit-cover') );
                      }else{
                        echo Asset::img($bookImg, array('class' => 'bd-placeholder-img card-img-top w-100 height__250 fit-cover') );
                      }
                       ?>
                      <div class="card-body">
                        <h5 class="card-title text-truncate"><?php  echo $val['title'];?></h5>
                          <div class="card-text mb-2 clamp__4">
                            <?php
                            echo $val['short'];
                             ?>
                          </div>
                          <div class="text-right">
                            <small class="text-muted pr-2"><?php echo $statusData;?></small>
                            <small class="text-muted pr-2">カテゴリー：<?php echo $categoryData; ?></small>
                            <a href="<?php echo Uri::base().'home/bookDetail'.'?book='.$val['id']; ?>" class="btn btn-primary">read more</a>
                          </div>
                      </div>
                      <div class="card-footer">
                        <small class="text-muted">Last updated <?php echo $val['updated_at']; ?></small>
                      </div>
                    </div>

                  <?php

                endforeach;

                endif;
                  ?>

        </div>

      </section>

      <?php echo $searchFoot; ?>

    </section>
    <?php echo $btnContainer; ?>

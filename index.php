<?php get_header() ?>
<div class="__ss_insight">
    <div class="container">
        <h1 class="__title_insight">Insights</h1>
        <p class="__des_insight">A modern men’s lifestyle guide to fitness, food, drinks, sex, relationships, travel, advice, exclusive events and so much more.</p>
        <div class="__list_category">
            <?php wp_list_categories(array(
                'title_li' => '<h2>' . __('ALL CATEGORIES') .'</h2>'
            ));
            ?>
        </div>
        <div class="__featured_post">
            <?php
                $the_query1 = new WP_Query(array(
                    'meta_key' => 'featured-checkbox',
                    'meta_value' => 'yes',
                    'posts_per_page' => 3,
                ));
                $array_id = array();
            ?>
            <?php
                if($the_query1->have_posts()){
                  $i = 1;
                  while($the_query1->have_posts()){
                      $the_query1->the_post();
                      $array_id[] = get_the_ID();
                      if($i == 1){
                        get_template_part('template-parts/item_futured_big', get_post_format());
                        echo "<div class='__futured_small_wrap'>";
                      }else {

                        ?>
                        <div class="__item_futured_small">
                            <div class="__thumbnail_future_small">
                              <?php echo get_the_post_thumbnail(); ?>
                            </div>
                            <div class="_category">
                                <?php echo the_category() ?>
                            </div>
                            <a class="__link" href="<?php the_permalink() ?>">
                              <h2 class="__title_futured_small"><?php echo  get_the_title() ?></h2>
                            </a>
                            <div class="__meta">
                                <span class="__author"><?php the_author_meta('display_name', 1);?>.</span>
                                <span class="__date"><?php echo get_the_date();?></span>
                            </div>
                          </div>
                        <?php
                      }
                      $i++;
                  }
                  wp_reset_postdata();
                  echo '</div>';
                }
            ?>
        </div>
          <div class="__list_post_item_wrap">
              <?php
                  $the_query = new WP_Query(array(
                      'posts_per_page' => 10,
                      'paged' => get_query_var('paged'),
                      'post__not_in' => $array_id,
                  ));
              ?>
              <?php
                  if($the_query->have_posts()){
                    ?> <div class="__list_post_item"> <?php
                      while($the_query->have_posts()){
                          $the_query->the_post();
                          get_template_part('template-parts/item-post', get_post_format());
                      }
                      ?> </div> <?php
                     // wasamedia_pagination();
                     misha_paginator( get_pagenum_link());
                  }
              ?>
          </div>
        </div>
    </div>
</div>

<?php get_footer() ?>

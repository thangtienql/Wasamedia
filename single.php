<?php get_header();?>

<?php
  if(have_posts()){
    while (have_posts()) {
      the_post();
      ?>
      <div class="__single_wrap">
          <div class="__content_post">
              <div class="__category_single"><?php the_category() ?></div>
              <h1 class="__title_single"><?php the_title();?></h1>
              <div class="__meta">
                  <span class="__author"><?php the_author_meta('display_name', 1);?>.</span>
                  <span class="__date"><?php echo get_the_date();?></span>
              </div>
          </div>
          <div class="__body_single">
              <div class="_thumbnail_single">
                  <?php echo get_the_post_thumbnail()?>
              </div>
              <div class="__content_single">
                  <?php the_content(); ?>
              </div>
              <div class="__note">
              <?php echo get_post_meta(get_the_ID(),'hcf_note', true );?>
              </div>
          </div>
      </div>
      <?php
    }
  }
?>
<?php get_footer();?>

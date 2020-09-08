<div class="__item">
    <div class="__thumbnail_item">
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

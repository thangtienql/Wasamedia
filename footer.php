<footer class="footer">
    <div class="container">
        <div class="__menu_footer_top">
            <div class="__menu_logo_footer">
                <?php dynamic_sidebar('logo_footer'); ?>
            </div>
            <nav class="__list_menu_footer">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'menu_class'=> 'list_menu_footer'
                ));
            ?>
            </nav>
        </div>
        <div class="__menu_footer_center">
            <div class="__column_one">
                <?php dynamic_sidebar('footer_col_one'); ?>
            </div>
            <div class="__column_two">
                <?php dynamic_sidebar('footer_col_two'); ?>
            </div>
            <div class="__column_three">
                <?php dynamic_sidebar('footer_col_three'); ?>
            </div>
            <div class="__column_four">
                <?php dynamic_sidebar('footer_col_four'); ?>
            </div>
        </div>
        <div class="__menu_footer_bottom">
            <div class="__social_wrap">
                <?php dynamic_sidebar('social_list');?>
            </div>
            <div class="__copy_right">
                <span>WASA MEDIA ©2019 -</span>Terms and Conditions
            </div>
        </div>
    </div>
</footer>
    <?php wp_footer()?>
  </body>
</html>
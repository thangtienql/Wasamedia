<?php
    add_theme_support('post-thumbnails');

    function wasamedia_logo_setup() {
        $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
        );
        add_theme_support( 'custom-logo', $defaults );
       }
       add_action( 'after_setup_theme', 'wasamedia_logo_setup' );

    //css
    function theme_wasamedia_style(){
    wp_enqueue_style('style-css',get_stylesheet_directory_uri() . '/assets/scss/main.css');
    wp_enqueue_style('font-css',get_stylesheet_directory_uri() . '/assets/font/scandia/scandia.css');
    wp_enqueue_style('load-fa', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    }
    add_action('wp_enqueue_scripts', 'theme_wasamedia_style');

    //register menu
    function register_wasamedia_menu(){
        register_nav_menu('header-menu', __('Header Menu'));
        register_nav_menu('footer-menu', __('Footer Menu Top'));
        register_nav_menu('footer-menu_col_one', __('Footer Menu Column One'));
        register_nav_menu('footer-menu_col_two', __('Footer Menu Column Two'));
        register_nav_menu('footer-menu_col_three', __('Footer Menu Column Three'));
        register_nav_menu('footer-menu_col_four', __('Footer Menu Column Four'));
    }
    add_action('init','register_wasamedia_menu');

    //register widget
    function widget_register(){
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Logo Footer'),
            'id'   => 'logo_footer',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Footer Column One'),
            'id'   => 'footer_col_one',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Footer Column Two'),
            'id'   => 'footer_col_two',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Footer Column Three'),
            'id'   => 'footer_col_three',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Footer Column Four'),
            'id'   => 'footer_col_four',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Social List'),
            'id'   => 'social_list',
        ));
        register_sidebar(array(
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget_title">',
            'after_title' => '</h2>',
            'name' => __('Pagination Ajax'),
            'id'   => 'ajax_pagination',
        ));
    }
    add_action('init', 'widget_register');

    // Custom Field Featured Post
    function prfx_featured_meta() {
        add_meta_box( 'prfx_meta', __( 'Featured Posts'), 'prfx_meta_callback', 'post');
    }
    add_action( 'add_meta_boxes', 'prfx_featured_meta' );

    //Callback
    function prfx_meta_callback( $post ) {
        wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
        $prfx_stored_meta = get_post_meta( $post->ID );
        ?>
            <p>
                <span class="prfx-row-title"><?php _e( 'Check if this is a featured post: ')?></span>
                <div class="prfx-row-content">
                    <label for="featured-checkbox">
                        <input type="checkbox" name="featured-checkbox" id="featured-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['featured-checkbox'] ) ) checked( $prfx_stored_meta['featured-checkbox'][0], 'yes' ); ?> />
                        <?php _e( 'Featured Item')?>
                    </label>

                </div>
            </p>
        <?php
    }
    function prfx_meta_save( $post_id ) {
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }
        if( isset( $_POST[ 'featured-checkbox' ] ) ) {
            update_post_meta( $post_id, 'featured-checkbox', 'yes' );
        }else{
            update_post_meta( $post_id, 'featured-checkbox', 'no' );
        }

    }
    add_action( 'save_post', 'prfx_meta_save' );

    //Pagination
    function wasamedia_pagination($custom_query = null, $paged = null) {
    global $wp_query;
    if($custom_query) $main_query = $custom_query;
    else $main_query = $wp_query;
    $paged = ($paged) ? $paged : get_query_var('paged');
    $big = 999999999;
    $total = isset($main_query->max_num_pages)?$main_query->max_num_pages:'';
    if($total > 1) echo '<div class="pagenavi">';
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total' => $total,
        'mid_size' => '10', // Số trang hiển thị khi có nhiều trang trước khi hiển thị ...
        'prev_text'    => __('Prev','devvn'),
        'next_text'    => __('Next','devvn'),
    ) );
    if($total > 1) echo '</div>';
}
?>

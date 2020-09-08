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
      global $wp_query;
      wp_enqueue_style('style-css',get_stylesheet_directory_uri() . '/assets/scss/main.css');
      wp_enqueue_style('font-css',get_stylesheet_directory_uri() . '/assets/font/scandia/scandia.css');
      wp_enqueue_style('load-fa', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

      wp_enqueue_script('jquery-cdn','https://code.jquery.com/jquery-3.5.1.min.js');
      wp_enqueue_script('main-js', get_stylesheet_directory_uri(). '/assets/js/main.js');

      // wp_enqueue_script('jquery');
      wp_enqueue_script('my_loadmore', get_stylesheet_directory_uri() . '/assets/js/myloadmore.js', array('jquery'));
      wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		'posts' => json_encode( $wp_query->query_vars ),
    		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
    		'max_page' => $wp_query->max_num_pages,
        'first_page' => get_pagenum_link(1)
    	));
      // wp_enqueue_script('my_loadmore');

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

    // Create Option Field Featured Post
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
    // End Create Option Field Featured Post



    // Create Option Field Note
    function hcf_register_meta_boxes() {
    add_meta_box( 'hcf-1', __( 'Hello Custom Field', 'hcf' ), 'hcf_display_callback', 'post' );
    }
    add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );

    //Callback
    function hcf_display_callback( $post ) {
      ?>
      <p class="meta-options hcf_field">
          <label for="hcf_note">Note</label>
          <input id="hcf_note" type="text" name="hcf_note"
          value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'hcf_note', true));?>"
          >
      </p>
      <?php
    }

    //Save Data
    function hcf_save_meta_box($post_id){
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
      if ( $parent_id = wp_is_post_revision( $post_id ) ) {
          $post_id = $parent_id;
      }
      $fields = [
        'hcf_note',
      ];

      foreach ($fields as $field) {
        if(array_key_exists($field, $_POST)){
          update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
      }
    }
    add_action('save_post','hcf_save_meta_box');

    // End Create Option Field Note


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
    ));
    if($total > 1) echo '</div>';
  }
    //Ajax
    function misha_loadmore_ajax_hander(){
      //Featured Post
      $meta = new WP_Query(array(
          'meta_key' => 'featured-checkbox',
          'meta_value' => 'yes',
          'posts_per_page' => 3,
      ));
      $array_meta = array();
      if($meta->have_posts()):
        while ($meta->have_posts()):
          $meta->the_post();
          $array_meta[] = get_the_ID();
        endwhile;
      endif;


      $args = json_decode( stripslashes($_POST['query']), true);
      $args['paged'] = $_POST['page'] + 1;
      $args['post_status'] = 'publish';
      $args['post__not_in'] = $array_meta;

      query_posts($args);

      if(have_posts()){
        ?> <div class="__list_post_item"> <?php
        while(have_posts()){
          the_post();
          get_template_part('template-parts/item-post', get_post_format());
        }
        ?> </div> <?php
        misha_paginator( $_POST['first_page'] );
      }
      die;
    }
    add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_hander');
    add_action('wp_ajax_nopriv_loadmore','misha_loadmore_ajax_hander');

    function misha_paginator($first_page_url){
      global $wp_query;

	     // remove the trailing slash if necessary
    	$first_page_url = untrailingslashit( $first_page_url );


    	// it is time to separate our URL from search query
    	$first_page_url_exploded = array();
    	$first_page_url_exploded = explode("/?", $first_page_url);
    	// by default a search query is empty
    	$search_query = '';
    	// if the second array element exists
    	if( isset( $first_page_url_exploded[1] ) ) {
    		$search_query = "/?" . $first_page_url_exploded[1];
    		$first_page_url = $first_page_url_exploded[0];
    	}

    	// get parameters from $wp_query object
    	// how much posts to display per page (DO NOT SET CUSTOM VALUE HERE!!!)
    	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
    	// current page
    	$current_page = (int) $wp_query->query_vars['paged'];
    	// the overall amount of pages
    	$max_page = $wp_query->max_num_pages;

    	// we don't have to display pagination or load more button in this case
    	if( $max_page <= 1 ) return;

    	// set the current page to 1 if not exists
    	if( empty( $current_page ) || $current_page == 0) $current_page = 1;

    	// you can play with this parameter - how much links to display in pagination
    	$links_in_the_middle = 4;
    	$links_in_the_middle_minus_1 = $links_in_the_middle-1;

    	// the code below is required to display the pagination properly for large amount of pages
    	// I mean 1 ... 10, 12, 13 .. 100
    	// $first_link_in_the_middle is 10
    	// $last_link_in_the_middle is 13
    	$first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1/2 );
    	$last_link_in_the_middle = $current_page + ceil( $links_in_the_middle_minus_1/2 );

    	// some calculations with $first_link_in_the_middle and $last_link_in_the_middle
    	if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;
    	if( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_minus_1 ) { $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1; }
    	if( $last_link_in_the_middle > $max_page ) { $first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1; $last_link_in_the_middle = (int) $max_page; }
    	if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;

    	// begin to generate HTML of the pagination
    	$pagination = '<nav id="misha_pagination" class="navigation pagination" role="navigation"><div class="pagination-nav-links">';

    	// when to display "..." and the first page before it
    	if ($first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page) {
    		$pagination.= '<a href="'. $first_page_url . $search_query . '" class="page-numbers">1</a>';

    		if( $first_link_in_the_middle != 2 )
    			$pagination .= '<span class="page-numbers extend">...</span>';
    	}

    	// arrow left (previous page)
    	if ($current_page != 1)
    		$pagination.= '<a href="'. $first_page_url . '/page/' . ($current_page-1) . $search_query . '" class="prev page-numbers">'."Previous".'</a>';

    	// loop page links in the middle between "..." and "..."
    	for($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
    		if($i == $current_page) {
    			$pagination.= '<span class="page-numbers current">'.$i.'</span>';
    		} else {
    			$pagination .= '<a href="'. $first_page_url . '/page/' . $i . $search_query .'" class="page-numbers">'.$i.'</a>';
    		}
    	}

    	// arrow right (next page)
    	if ($current_page != $last_link_in_the_middle )
    		$pagination.= '<a href="'. $first_page_url . '/page/' . ($current_page+1) . $search_query .'" class="next page-numbers">' . "Next" . '</a>';


    	// when to display "..." and the last page after it
    	if ( $last_link_in_the_middle < $max_page ) {

    		if( $last_link_in_the_middle != ($max_page-1) )
    			$pagination .= '<span class="page-numbers extend">...</span>';

    		$pagination .= '<a href="'. $first_page_url . '/page/' . $max_page . $search_query .'" class="page-numbers">'. $max_page .'</a>';
    	}
    	// end HTML
    	$pagination.= "</div></nav>\n";

    	//this is our LOAD MORE posts link
    	// if( $current_page < $max_page )
    	// 	$pagination.= '<div id="misha_loadmore">More posts</div>';

    	// replace first page before printing it
    	echo str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
    }

    //Short code get post random
    function shortcode_get_post_random(){

        $data_src = 0;
        $query_random = new WP_Query(array(
          'posts_per_page' => 5,
          'orderby' => 'rand',
        ));
        ob_start();
        if($query_random->have_posts()){
          ?> <ol class="_list_post_random"><?php
          while($query_random->have_posts()){
            $query_random->the_post();
            ?> <li data-src="<?php echo ++$data_src?>"><a href="<?php the_permalink()?>"><?php the_title()?></a></li> <?php
          }
        }
        $list_post = ob_get_contents(); //Get All to $list_post
        ob_end_clean();
        return $list_post;
    }
    add_shortcode('get_post_random', 'shortcode_get_post_random');


?>

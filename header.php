<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title()?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open();?>

    <header class="header">
        <div class="container">
            <div class="__menu_wrap">
                <div class="__menu_left">
                    <div class="__menu_logo">
                        <?php 
                            if ( function_exists( 'the_custom_logo' ) ) {
                                the_custom_logo();
                            }
                        ?>
                    </div>
                    <nav class="__list_menu_wrap">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'container_class' => 'menu_wrap',
                            'menu_class'=> 'list_menu'
                        ));
                        ?>
                    </nav>
                </div>
                <div class="__menu_right">
                    <input class="get_touch" type="button" value="Get in touch">  
                </div>
            </div>
        </div>
    </header>

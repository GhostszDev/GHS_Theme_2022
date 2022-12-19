<?php

// Includes
require_once get_theme_file_path( '/src/php/admin.php' );;
require_once get_theme_file_path( '/src/php/frontend.php' );;
require_once get_theme_file_path( '/src/php/other.php' );;
require_once get_theme_file_path( '/src/php/rest_api.php' );;
require_once get_theme_file_path( '/src/php/theme.php' );;

//Actions
add_action('init', '_themename_init', 0);
add_action('admin_init', '_themename_admin_init');
add_action('admin_menu', '_themename_admin_page');
add_action('wp_enqueue_scripts', '_themename_assets');
add_action('admin_enqueue_scripts', '_themename_admin_assets');
add_action('after_setup_theme', '_themename_theme_setup');
add_action('after_setup_theme', '_themename_after_theme');
add_action('add_meta_boxes', '_themename_meta_boxes');
add_action('save_post', '_themename_save_postdata');
add_action('admin_post_nopriv_contact_form', '_themename_form');
add_action('admin_post_contact_form', '_themename_form');
add_action('rest_api_init', '_themename_rest_api_init');


//Filters
add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'lostpassword_url', 'reset_pass_url', 10, 2 );
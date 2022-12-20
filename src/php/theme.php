<?php

//Theme Functions
function _themename_assets() {
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
	wp_enqueue_script( 'media-upload');
	wp_enqueue_media();
	wp_enqueue_script( '_themename-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.2.0', true );
	wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );

	$ghs_obj = array(

	);

	wp_localize_script('_themename-scripts', 'ghs_obj', $ghs_obj);
}

function _themename_admin_assets() {
	wp_enqueue_style( '_themename-admin-stylesheet', get_template_directory_uri() . '/dist/css/admin.css', array(), '1.0.0', 'all' );
	wp_enqueue_script( 'media-upload');
	wp_enqueue_media();
	wp_enqueue_script( '_themename-admin-scripts', get_template_directory_uri() . '/dist/js/admin.js', array('jquery'), '1.0.0', false );

	$ghs_obj = array(
		'mediaPath' =>  get_stylesheet_directory_uri() . '/dist/media/',
		'featColumn' => get_option('featColumn'),
		'employees' => get_option('employee'),
		'spotlight' => get_option('spotlight')
	);

	wp_localize_script('_themename-admin-scripts', 'ghs_obj', $ghs_obj);
}

function _themename_after_theme(){}

function _themename_custom_post_types(){

	register_post_type('Games',
		array(
			'labels'      => array(
				'name'          => __( 'Games', 'textdomain' ),
				'singular_name' => __( 'Game', 'textdomain' ),
			),
			'supports'    => array(
				'title',
				'excerpt',
				'thumbnail',
				'content',
				'editor'
			),
			'public'      => true,
			'has_archive' => false,
			'rewrite'     => array(
				'with_front' => false,
				'slug' => 'games'
			),
			'exclude_from_search' => false,
			'taxonomies'   => array( 'category' ),
		)
	);

}

function _themename_get_navigation($name = ''){
	$menuItems = wp_get_nav_menu_items($name);
	$data = [];
	$key = 0;
	$subKey = 0;

	if($menuItems) {
		foreach ($menuItems as $mi):

			if ($mi->menu_item_parent == 0):
				$data[$key]['ID'] = $mi->ID;
				$data[$key]['url'] = $mi->url;
				$data[$key]['target'] = $mi->target;
				$data[$key]['title'] = $mi->title;
				$data[$key]['submenu'] = array();
				$key++;
				$subKey = 0;
			else:
				$parentKey = array_search($mi->menu_item_parent, array_column($data, 'ID'));
				$data[$parentKey]['submenu'][$subKey]['ID'] = $mi->ID;
				$data[$parentKey]['submenu'][$subKey]['url'] = $mi->url;
				$data[$parentKey]['submenu'][$subKey]['target'] = $mi->target;
				$data[$parentKey]['submenu'][$subKey]['title'] = $mi->title;
				$subKey++;
			endif;


		endforeach;
	}

	return $data;
}

function _themename_get_current_url(){
	global $wp;
	$current_url = home_url(add_query_arg(array(), $wp->request));
	return $current_url.'/';
}

function _themename_check_for_page($pageName, $postType){
	$check = get_page_by_title($pageName);

	if(empty($check->ID)):
		$args = [
			'post_title'=>$pageName,
			'post_status'=>'publish',
			'post_type'=>$postType
		];
		wp_insert_post($args);
	endif;
}

function _themename_random_posts($postType, $postAmount = 1){

	$args = [
		'post_type' => $postType,
		'post_status' => 'publish',
		'numberposts' => $postAmount,
		'orderby' => 'rand'
	];

	$data = get_posts( $args );

	return $data;

}

function _themename_add_cats($cat_list){

	foreach ($cat_list as $c):
		if(term_exists($c) == 0):
			wp_insert_term($c, 'category', []);
		endif;
	endforeach;

}

function _themename_theme_setup(){

	// Register Nav Menus
	register_nav_menu('navBar', __( 'Nav Bar', 'theme-slug' ) );
	register_nav_menu('companyNav', __( 'Company Nav', 'theme-slug' ) );
	register_nav_menu('contactNav', __( 'Contact Nav', 'theme-slug' ) );

	// Adding Theme Supports
	add_theme_support( 'html5', array(
			'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' )
	);
	add_theme_support('post-formats', array(
		'aside',
		'gallery',
		'image',
		'video',
		'audio'
	));
	add_theme_support( 'woocommerce' );
	add_theme_support('post-thumbnails');

	// Default Pages
	_themename_check_for_page('Blog', 'page');
	_themename_check_for_page('Games', 'page');
	_themename_check_for_page('Studio', 'page');
	_themename_check_for_page('Contact', 'page');
	_themename_check_for_page('Privacy Policy', 'page');
	_themename_check_for_page('My Account', 'page');
	_themename_check_for_page('Profile', 'page');

	// Create categories
	_themename_add_cats(GHS_GAME_CATS);

}

function _themename_init(){
	_themename_custom_post_types();
	_themename_rewrites();
	_themename_needed_DB();
}

function _themename_findInArray($array, $id, $sKey, $displayKey){

	foreach ($array as $key => $val) {
		if ($val[$sKey] == $id) {
			return $array[$key][$displayKey];
		}
	}
	return false;

}

function _themename_form(){
	$data = [];

	$formContact = [
		'to' => sanitize_email($_REQUEST['to']),
		'from' => sanitize_email($_REQUEST['from']),
		'body' => sanitize_text_field($_REQUEST['body']),
		'subject' => sanitize_text_field($_REQUEST['subject']),
		'name' => sanitize_text_field($_REQUEST['firstName'] . ' '. $_REQUEST['lastName'])
	];

	_themename_email($formContact);
}

function _themename_email($formData){

	if($formData['from']){
		$headers = [
			'FROM: ' . $formData['name'] . ' <'.$formData['from'].'>',
			'Content-Type: text/html; charset=UTF-8'
		];
		$mail = wp_mail($formData['to'], $formData['subject'], $formData['body'], $headers, '');

		return $mail;
	}

	return false;

}

function reset_pass_url() {
	$siteURL = get_option('siteurl');
	return "{$siteURL}/wp-login.php?action=lostpassword";
}

function _themename_permissions(){
	if(is_user_logged_in() && current_user_can( 'manage_options' )):
		return true;
	else:
		return false;
	endif;
}

function _themename_rewrites(){
	add_rewrite_rule('profile/([a-z]+[/]?$)','index.php?page_id='.get_page_by_title('profile')->ID.'&profile=$matches[1]','top');

}

function _themename_custom_query_vars($query_vars){
	$query_vars[] = 'profile';
	return $query_vars;
}

function _themename_needed_DB(){
	global $wpdb;

	$table_name = $wpdb->prefix . "friendsDB";

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
      		`ID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			`user_id` int NOT NULL,
  			`friends_list` json NULL);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

}

function _themename_user_friendslist(){
	global $wpdb;

}
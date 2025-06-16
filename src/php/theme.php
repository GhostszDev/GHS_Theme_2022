<?php

//Theme Functions
function _themename_assets() {
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
	wp_enqueue_script( 'media-upload');
	wp_enqueue_media();

	wp_enqueue_script( '_themename-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.2.0', true );
	wp_enqueue_script( '_themename-fontawesome', 'https://kit.fontawesome.com/2726d3179e.js', array('jquery'), '6.0.0', true );

	if(get_post_type() === 'projects'):
		wp_enqueue_script( '_themename-project-script', get_template_directory_uri() . '/dist/js/projectJS.js', array('jquery'), '1.0.0', true );
	endif;

	wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );

	$ghs_obj = array(
		'send_friend_request' => _themename_add_send_friends_list()
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
		'spotlight' => get_option('spotlight'),
		'ghs_endpoint' => site_url('/wp-json/_restroute')
	);

	wp_localize_script('_themename-admin-scripts', 'ghs_obj', $ghs_obj);
}

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

	register_post_type('Projects',
		array(
			'labels'      => array(
				'name'          => __( 'Projects', 'textdomain' ),
				'singular_name' => __( 'Project', 'textdomain' ),
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
				'slug' => 'projects'
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
	_themename_needed_DB(friends_DB);
}

function _themename_head(){

	if(is_user_logged_in()):
		$user_ID = get_current_user_id();
	else:
		$user_ID = 0;
	endif;

	if(is_page('profile')):

		$friend_ID = get_user_by('login',get_query_var('profile'))->ID;

		if($friend_ID != $user_ID):
			echo "<script>document.cookie = 'friend_ID=$friend_ID';</script>";
		endif;

	endif;
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
	add_rewrite_rule('profile/([a-z]+[/]?$)','index.php?pagename=profile&profile=$matches[1]','top');
	add_rewrite_rule('profile/([^/]*)/([^/]*)/?','index.php?pagename=profile&profile=$matches[1]&subpage=$matches[2]','top');
}

function _themename_custom_query_vars($query_vars){
	$query_vars[] = 'profile';
	$query_vars[] = 'subpage';
	return $query_vars;
}

function _themename_needed_DB($DB_name = ""){
	if($DB_name != "") {
		global $wpdb;

		$table_name = $wpdb->prefix . $DB_name;

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
      		`ID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  			`user_id` int NOT NULL,
  			`friends_list` json NULL);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	} else {
		return new WP_Error("Error: 1562", __("Database Failed to be Created!", "my_textdomain"));
	}

}

function _themename_add_send_friends_list($user_id = "", $friend_ID = ""){

	global $wpdb;
	$db_table = $wpdb->prefix . friends_DB;
	$data     = [];

	if(is_page('/profile/')) {

		if ( $user_id == "" ) {
			$user_id = get_current_user_id();
		}

		if ( $friend_ID == "" ) {
			$friend_ID = $_COOKIE['friend_ID'];
		}

		$data['friends_ID'] = $friend_ID;
		$data['user_ID']    = $user_id;


		$user_entry       = array(
			'user_id'      => $user_id,
			'friends_list' => [
				'friends' => [
					0 => [
						'friend_ID' => $friend_ID,
						'status'    => 'requested'
					]
				]
			]
		);
		$data['my_entry'] = _themename_friends_list_update( $user_entry );

		$friend_entry         = array(
			'user_id'      => $friend_ID,
			'friends_list' => [
				'friends' => [
					0 => [
						'friend_ID' => $user_id,
						'status'    => 'received'
					]
				]
			]
		);
		$data['friend_entry'] = _themename_friends_list_update( $friend_entry );
	}

	return $data;

}

function _themename_init_user_friendslist($user_id){

	$data = ['success' => false];

	if($user_id != 0) {
		$data['success'] = true;
	}

	if($data['success']){
		$default_entry = array(
			'user_id' => $user_id,
			'friends_list' => [
				'friends' =>[
				]
			]
		);
		$data['default'][$user_id] = $user_id;
		$data['test'][$user_id] = _themename_friends_list_update($default_entry);
	}

	return $data;
}

function _themename_friends_list_update($entry){
	global $wpdb;
	$db_table = $wpdb->prefix . friends_DB;
	$data = [];
	$data['testing'] = $entry['user_id'];

	if($entry["user_id"] != 0):
		$result = $wpdb->get_results(
			"SELECT `friends_list` FROM $db_table WHERE `user_id` = ".$entry["user_id"]." LIMIT 50"
		);

		if($result == null || count($result) === 0){
			$temp_friendsList = $entry['friends_list'];
			$entry['friends_list'] = json_encode($temp_friendsList);
			$wpdb->insert($db_table, $entry);
		} else {
			$retrieved_friends = json_decode($result[0]->friends_list);
			$friend_ID = $entry['friends_list']['friends'][0]['friend_ID'];

			if(count($retrieved_friends->friends) > 0){

			} else {
				$temp_friendsList = $entry['friends_list'];
				$wpdb->update($db_table, ['friends_list' => json_encode($temp_friendsList)], ['user_id' => $entry["user_id"]]);
			}

			$data['added'] = $retrieved_friends;
		}
		$wpdb->flush();
		$data['Message'] = "Friend List was created!";
	endif;

	return $data;
}

function _themename_restapi_friends_list_init(){
	$data = [
		'success' => false
	];
	global $wpdb;
	$db_table = $wpdb->prefix . friends_DB;

	$users = get_users(['orderby'=>'ID', 'order'=>'ASC']);

	$i = 1;
	foreach ($users as $user){

		$result = $wpdb->get_results(
			"SELECT `friends_list` FROM $db_table WHERE `user_id` = ".$user->ID." LIMIT 50"
		);

		if($result == null || count($result) === 0){
			$data['user'][$i] = _themename_init_user_friendslist($user->ID);
		}

		$i++;

	}

	return $data;
}
<?php

function _themename_assets() {
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
	wp_enqueue_script( '_themename-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.2.0', true );
	wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );
}

function ghs_get_navigation($name = ''){
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

function ghs_get_current_url(){
	global $wp;
	$current_url = home_url(add_query_arg(array(), $wp->request));
	return $current_url.'/';
}

function ghs_theme_setup(){

	register_nav_menu('navBar', __( 'Nav Bar', 'theme-slug' ) );
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

}

add_action('wp_enqueue_scripts', '_themename_assets');
add_action('after_setup_theme', 'ghs_theme_setup');
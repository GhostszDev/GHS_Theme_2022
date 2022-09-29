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
        'mediaPath' =>  get_stylesheet_directory_uri() . '/src/media/',
        'featColumn' => get_option('featColumn')
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
			'rewrite'     => array( 'slug' => 'games' ),
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

    // Create categories
	_themename_add_cats(GHS_GAME_CATS);

}

function _themename_init(){
	_themename_custom_post_types();
}

function _themename_findInArray($array, $id, $sKey, $displayKey){

	foreach ($array as $key => $val) {
		if ($val[$sKey] == $id) {
			return $array[$key][$displayKey];
		}
	}
	return false;

}


//Theme Frontend
function _themename_nav_bar(){ ?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
            <svg width="75px" height="75px" aria-hidden="true" focusable="false">
                <use href="<?php echo get_stylesheet_directory_uri() . '/src/media/icons.svg#icon-logo' ?>"></use>
            </svg>
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-lg-auto">
                    <?php foreach (_themename_get_navigation('Nav Bar') as $navItem): ?>
                        <?php if(empty($navItem['submenu'])): ?>
                            <li class="nav-item ">
                                <a class="nav-link <?php if($navItem['url'] == _themename_get_current_url()): echo "active"; endif; ?>" aria-current="page" href="<?php echo $navItem['url'] ?>">
                                    <?php echo $navItem['title'] ?>
                                </a>
                            </li>
                        <?php else: ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle"
                                       href="#" role="button"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <?php echo $navItem['title'] ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($navItem['submenu'] as $sub): ?>
                                        <li>
                                            <a class="dropdown-item"
                                               href="<?php echo $sub['url'] ?>">
                                                <?php echo $sub['title'] ?>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <?php if(is_user_logged_in()): ?>
    <!--                        <a class="nav-link" aria-current="page" href="--><?php //echo wp_logout_url( home_url() ); ?><!--">Logout</a>-->
                        <li class="nav-item dropdown ghs_user_dropdown">
                            <a class="nav-link dropdown-toggle d-flex" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo get_avatar_url(get_current_user_id(0)) ?>" alt="user-image" class="rounded-circle">
                                <p>Ghost</p>
                            </a>
                            <ul class="dropdown-menu">
    <!--                            <li><a class="dropdown-item" href="#">Action</a></li>-->
    <!--                            <li><hr class="dropdown-divider"></li>-->
                                <li>
                                    <a class="dropdown-item" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
                                </li>
                            </ul>
                        </li>

                        <?php else: ?>
                            <a class="nav-link" aria-current="page" href="<?php echo esc_url( wp_login_url( home_url() ) ); ?>" alt="<?php esc_attr_e( 'Login', 'textdomain' ); ?>">Sign In</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
}

function _themename_hero_banner(){
	$heroBanner = get_option('heroBanner');
    $i = 0;
    $k = 0;
    ?>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <?php foreach ($heroBanner as $key => $value): ?>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i; ?>" class="<?php if($i === 0): echo 'active'; endif; ?>" aria-current="<?php if($i === 0): echo 'true'; endif; ?>" aria-label="Slide <?php echo $i ?>"></button>
            <?php $i++; endforeach; ?>
        </div>
        <div class="carousel-inner">
	        <?php foreach ($heroBanner as $key => $value): ?>
                <div class="carousel-item <?php if($k === 0): echo 'active'; endif; ?>" style="background: url(<?php echo esc_url(wp_get_attachment_url($value['img']), 'full', false, '' ); ?>)">
<!--                    <img class="d-block img-fluid" src="--><?php //echo esc_url(wp_get_attachment_url($value['img']), 'full', false, '' ); ?><!--" alt="">-->

                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $value['title'] ?></h5>
                        <p><?php echo $value['body'] ?></p>
                    </div>
                </div>
            <?php $k++; endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

	<?php
}

function _themename_featured_posts($args, $title = 'Latest News'){
    $query = new WP_Query( $args );
	$counter = 1; ?>

    <div class="container">
        <h4 class="ghs_section_header mt-4"><?php echo $title ?></h4>

        <?php
        if ( $query->have_posts() ):
            while ( $query->have_posts() ) {
                $query->the_post();

                if($counter%3 == 1): ?> <div class="row mt-4"> <?php endif; ?>

                <div class="col-12 col-lg-4 pb-4">
                    <div class="ghs_feat_post h-100 position-relative">
                        <img class="ghs_feat_post_img w-100" src="<?php echo get_the_post_thumbnail_url(get_the_ID())?>" />

	                    <?php if(get_the_category(get_the_ID())[0]->term_id != 1): ?>
                            <a href="<?php echo get_category_link(get_the_category(get_the_ID())[0]->cat_ID) ?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4"><?php echo strtoupper(get_the_category(get_the_ID())[0]->name) ?></span></a>
	                    <?php else: ?>
                            <a href="<?php echo home_url('/blog')?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4"><?php echo strtoupper('post') ?></span></a>
	                    <?php endif; ?>

                        <div class="ghs_feat_post_text p-3">
                            <h5 class="pb-3"><?php echo get_the_title() ?></h5>
                            <p><?php echo get_the_excerpt() ?></p>
                            <a href="<?php echo get_the_permalink(get_the_ID()) ?>" class="btn btn-primary btn-sm active mx-auto text-dark" role="button">
                                <?php if(get_post_type(get_the_ID()) == 'post'): ?>
                                Read More
                                <?php elseif(get_post_type(get_the_ID()) == 'games'): ?>
                                View Game
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                if($counter%3 == 0): ?> </div> <?php endif;

                $counter++;
            }

        if(is_page('games')):
	        _themename_page_blog_pagination($query);
        endif;

        else:
            // no posts found
            echo '';
        endif;
        /* Restore original Post Data */
        wp_reset_postdata();

        ?>

        <div class="row">
<!--            <div class="d-flex justify-content-center align-items-center pb-2 pt-2">-->
<!--                <a href="#" class="btn btn-primary btn-lg active mx-auto text-dark" role="button" aria-pressed="true">Read More</a>-->
<!--            </div>-->
        </div>
    </div>
<?php
	wp_reset_postdata();
}

function _themename_insight(){
    $insight = get_option('insight');
    ?>

    <div class="w-100 mt-4 ghs_insight" style="background: url(<?php echo esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' ); ?>)">

        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h4 class="ghs_insight_header pt-4"><?php echo $insight['header'] ?></h4>
                    <h5 class="pt-3 ghs_insight_title"><?php echo $insight['title'] ?></h5>
                    <p class="pt-3"><?php echo $insight['body'] ?></p>
                </div>
            </div>
        </div>

    </div>

    <?php
}

function _themename_feat_column(){
    $featColumn = get_option('featColumn');
    $featSize = get_option('featColumnSize');
    ?>

    <div class="container mt-4 py-4 mb-5">
        <div class="row">

        <?php for ($i = 1; $i <= $featSize; $i++): ?>

        <div class="col-12 col-lg-<?php echo 12/$featSize;?>">

            <div class="ghs_feat_column_icon mb-1 ghs_primary_text_color">
                <svg class="ghs_feat_column_preview mb-3" aria-hidden="true" focusable="false">
                    <use href="<?php echo $featColumn['icon_'.$i] ?>"></use>
                </svg>
                <h5 class="ghs_primary_text_color"><?php echo $featColumn['title_'.$i] ?></h5>
            </div>

            <p><?php echo $featColumn['desc_'.$i] ?></p>

            <a href="<?php echo $featColumn['link_'.$i] ?>" class="ghs_primary_link"><?php echo $featColumn['link_text_'.$i] ?></a>

        </div>

        <?php endfor; ?>

        </div>
    </div>

    <?php
}

function _themename_newsletter(){
    ?>

    <div class="container py-4 my-4 ghs_border_bottom">
        <div class="row pb-4">

            <div class="col-12">
                <h4 class="ghs_section_header mt-4">Join the Newsletter</h4>
            </div>

            <div class="col-12 col-lg-6">
                <p><?php echo get_option('newsletter'); ?></p>
            </div>

            <div class="col-12 col-lg-6">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="button-addon2">
                    <button class="btn btn-primary text-dark" type="button" id="button-addon2">Sign Up</button>
                </div>
            </div>

        </div>
    </div>

    <?php
}

function _themename_footer(){
	$social = get_option('social');
	_themename_newsletter();
    ?>

    <div class="container my-4 py-4">
        <div class="row">

            <div class="col-12 col-lg-3">
                <svg width="120" height="120" aria-hidden="true" focusable="false">
                    <use href="<?php echo get_stylesheet_directory_uri() . '/src/media/icons.svg#icon-logo' ?>"></use>
                </svg>

                <p class="my-3"><?php echo $social['text'] ?></p>

                <div class="ghs_social_icons my-3">

                    <ul>
                        <?php foreach ($social['social'] as $s): ?>
                            <?php if(!empty($s['url'])): ?>
                                <li>
                                    <a href="<?php echo $s['url'] ?>">
                                        <svg aria-hidden="true" focusable="false">
                                            <use href="<?php echo get_stylesheet_directory_uri() . '/src/media/icons.svg#icon-'.$s['name'] ?>"></use>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <ul>
                        <?php foreach ($social['company'] as $c): ?>
                            <?php if(!empty($c['url'])): ?>
                                <li>
                                    <a href="<?php echo $c['url'] ?>">
                                        <svg width="1em" height="1em" aria-hidden="true" focusable="false">
                                            <use href="<?php echo get_stylesheet_directory_uri() . '/src/media/icons.svg#icon-'.$c['name'] ?>"></use>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

            <div class="col-12 col-lg-3">
                <h5 class="ghs_footer_title mb-4">Our Games</h5>
	            <?php $recent = _themename_random_posts('Games', 4); ?>


                <ul class="ghs_footer_list">
	                <?php foreach ($recent as $r): ?>
                        <li class="mb-2 pb-1"><a class="ghs_primary_link" href="<?php echo get_the_permalink($r->ID) ?>"><?php echo $r->post_title; ?></a></li>
	                <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-12 col-lg-3">
                <h5 class="ghs_footer_title mb-5">Company</h5>

                <ul class="ghs_footer_list">
	                <?php foreach (_themename_get_navigation('company nav') as $navItem):?>
                    <li class="mb-3"><a class="ghs_primary_link" href="<?php echo $navItem['url'] ?>"><?php echo $navItem['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-12 col-lg-3">
                <h5 class="ghs_footer_title mb-4">Contacts</h5>

                <ul class="ghs_footer_list">
		            <?php foreach (_themename_get_navigation('contact nav') as $navItem):?>
                        <li class="mb-3"><a class="ghs_primary_link" href="<?php echo $navItem['url'] ?>"><?php echo $navItem['title'] ?></a></li>
		            <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>

    <?php
}

function _themename_page_feat_image(){
	?>

    <div class="w-100 mt-4 ghs_insight d-flex align-items-center mb-3" style="background: url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID())); ?>)">

        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <?php if(is_single()): ?>

	                    <?php if(get_the_category(get_the_ID())[0]->term_id != 1): ?>
                            <a href="<?php echo get_category_link(get_the_category(get_the_ID())[0]->cat_ID) ?>">
                                <span class="ghs_feat_post_info btn btn-info btn-sm my-4">
                                    <?php echo strtoupper(get_the_category(get_the_ID())[0]->name) ?>
                                </span>
                            </a>
	                    <?php else: ?>
                            <a href="<?php echo home_url('/blog')?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4"><?php echo strtoupper('post') ?></span></a>
	                    <?php endif; ?>

                    <?php endif; ?>
                    <h5 class="pt-3 ghs_insight_title"><?php if(is_page() || is_single()): echo get_the_title(get_the_ID()); else: echo single_cat_title(); endif; ?></h5>
	                <?php if(is_page()):
                        echo get_the_content(get_the_ID());
                    elseif(is_single() && get_post_type() != 'games'):
	                    global $post;
	                    $author_ID = $post->post_author;
	                    $author_name =  get_the_author_meta('first_name', $author_ID) . ' ' . get_the_author_meta('nickname', $author_ID) . ' ' . get_the_author_meta('last_name', $author_ID);
	                    ?>
                        <ul class="d-flex flex-lg-row flex-column align-content-lg-center ghs_feat_post_post_data">
                            <li class="d-flex align-items-center"><img src="<?php echo get_avatar_url($author_ID); ?>" alt="user-image" class="rounded-circle"> <p>By <?php echo ucwords($author_name); ?></p></li>
                            <li><p><?php echo get_the_date('F j, Y'); ?></p></li>
                            <li>
                                <p>
                                    <?php
                                    $comment_num = get_comments_number();
                                    if($comment_num == 1):
                                        echo $comment_num . ' comment';
                                    else:
                                        echo $comment_num . ' comments';
                                    endif;
                                    ?>
                                </p>
                            </li>
                        </ul>
                    <?php else: echo ''; endif; ?>
                </div>
            </div>
        </div>

    </div>

    <?php
}

function _themename_page_blog_pagination(WP_Query $wp_query = null, $echo = true, $params = [] ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}

	$add_args = [];

	//add query (GET) parameters to generated page URLs
	/*if (isset($_GET[ 'sort' ])) {
		$add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
	}*/

	$pages = paginate_links( array_merge( [
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( '« Prev' ),
			'next_text'    => __( 'Next »' ),
			'add_args'     => $add_args,
			'add_fragment' => ''
		], $params )
	);

	if ( is_array( $pages ) ) {
		//$current_page = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
		$pagination = '<nav class="pagination d-flex justify-content-center"><ul class="pagination justify-content-center">';

		foreach ( $pages as $page ) {
			$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
		}

		$pagination .= '</ul></nav>';

		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}

	return null;
}

function _themename_page_blog_content(){
	if(is_category()):
		$args = [
			'cat' => get_queried_object()->term_id,
			'post_status' => 'publish',
			'posts_per_page' => 6
		];
	else:
		$args = [
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 6
		];
	endif;
    $query = new WP_Query( $args );
	$counter = 1; ?>

    <div class="container">
        <div class="row">

            <div class="col-12 col-lg-8 my-4">

                <div class="container">

                <?php
                if ( $query->have_posts() ):
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $author_ID = get_the_author_meta('ID');
                        $author_name =  get_the_author_meta('first_name') . ' ' . get_the_author_meta('nickname') . ' ' . get_the_author_meta('last_name');
                        ?>

                        <div class="col-12 pb-4">
                            <div class="ghs_feat_post h-100 position-relative">
                                <img class="ghs_feat_post_img w-100" src="<?php echo get_the_post_thumbnail_url(get_the_ID())?>" />
                                <div class="ghs_feat_post_text p-3">


                                    <?php if(get_the_category(get_the_ID())[0]->term_id != 1): ?>
                                        <a href="<?php echo get_category_link(get_the_category(get_the_ID())[0]->cat_ID) ?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4"><?php echo strtoupper(get_the_category(get_the_ID())[0]->name) ?></span></a>
                                    <?php else: ?>
                                        <a href="<?php echo home_url('/blog')?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4"><?php echo strtoupper('post') ?></span></a>
                                    <?php endif; ?>

                                    <h5 class="pb-3"><a class="ghs_primary_link" href="<?php echo get_the_permalink(get_the_ID()) ?>"><?php echo get_the_title(get_the_ID()) ?></a></h5>
                                    <p><?php echo get_the_excerpt(get_the_ID()) ?></p>

                                    <ul class="d-flex flex-lg-row flex-column align-content-lg-center ghs_feat_post_post_data">
                                        <li class="d-flex align-items-center"><img src="<?php echo get_avatar_url($author_ID); ?>" alt="user-image" class="rounded-circle"> <p>By <?php echo ucwords($author_name); ?></p></li>
                                        <li><p><?php echo get_the_date('F j, Y'); ?></p></li>
                                        <li>
                                            <p>
                                                <?php
                                                $comment_num = get_comments_number();
                                                if($comment_num == 1):
                                                    echo $comment_num . ' comment';
                                                else:
	                                                echo $comment_num . ' comments';
                                                endif;
                                                ?>
                                            </p>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                        <?php
                    }

	                _themename_page_blog_pagination($query);

                else:
                    // no posts found
                    echo '';
                endif;
                /* Restore original Post Data */
                wp_reset_postdata();

        ?>
    </div>

            </div>

            <div class="col-12 col-lg-4 my-4">

                <div class="ghs_side_card w-100 mb-4">
                    <?php $recent = _themename_random_posts('post', 4); ?>
                    <div class="ghs_side_card_title px-5 py-3">
                        <h5>Recent Post</h5>
                    </div>

                    <ul class="px-5 py-3">
                        <?php foreach ($recent as $r): ?>
                            <li class="mb-3 pb-2"><a class="ghs_primary_link" href="<?php echo get_the_permalink($r->ID) ?>"><?php echo $r->post_title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="ghs_side_card w-100 mb-4">
                    <div class="ghs_side_card_title px-5 py-3">
                        <h5>Sponsor</h5>
                    </div>

<!--                    --><?php //if(function_exists(the_ad_group())): ?>
<!--                    <div class="ghs_sponsor w-100">-->
<!--                        --><?php //the_ad_group(7); ?>
<!--                    </div>-->
<!--                    --><?php //endif; ?>

                </div>

            </div>

        </div>
    </div>

    <?php
}

function _themename_page_game_content(){
	_themename_featured_posts($args = [ 'post_type' => 'games', 'post_status' => 'publish', 'posts_per_page' => 6 ], '');
}

function _themename_single_post(){
    ?>
    <div class="container">

        <div class="row">

            <div class="col-12 col-lg-8 ghs_single_post">
                <?php echo get_the_content(); ?>
            </div>

            <div class="col-12 col-lg-4 my-4">

                <?php if(is_single() && get_post_type() != 'games'): ?>
                <div class="ghs_side_card w-100 mb-4">
			        <?php $recent = _themename_random_posts('post', 4); ?>
                    <div class="ghs_side_card_title px-5 py-3">
                        <h5>Recent Post</h5>
                    </div>

                    <ul class="px-5 py-3">
				        <?php foreach ($recent as $r): ?>
                            <li class="mb-3 pb-2"><a class="ghs_primary_link" href="<?php echo get_the_permalink($r->ID) ?>"><?php echo $r->post_title; ?></a></li>
				        <?php endforeach; ?>
                    </ul>
                </div>
                <?php elseif (is_single() && get_post_type() == 'games'): ?>

                <ul class="game_data p-0">
		            <?php if(get_post_meta(get_the_ID(), 'game_release', true)): ?>
                    <li class="mb-5">
                        <h5>Released on</h5>
                        <p><?php echo get_post_meta(get_the_ID(), 'game_release', true) ?></p>
                    </li>
                    <?php endif; ?>

		            <?php if(get_post_meta(get_the_ID(), 'game_publisher', true)): ?>
                    <li class="mb-5">
                        <h5>Publisher</h5>
                        <p><?php echo get_post_meta(get_the_ID(), 'game_publisher', true) ?></p>
                    </li>
                    <?php endif; ?>

		            <?php if(get_post_meta(get_the_ID(), 'game_rating', true)): ?>
                    <li class="mb-5">
                        <h5>ESRB Rating</h5>
                        <p><?php $arr = _themename_findInArray(GHS_ESRB_RATINGS, get_post_meta(get_the_ID(), 'game_rating', true), 'Rating', 'Name');
                        echo $arr;?></p>
                    </li>
                    <?php endif; ?>

                    <?php if(get_post_meta(get_the_ID(), 'game_size', true)): ?>
                    <li class="mb-5">
                        <h5>File Size</h5>
                        <p><?php echo get_post_meta(get_the_ID(), 'game_size', true) ?></p>
                    </li>
                    <?php endif; ?>

                    <?php if(!empty(get_post_meta(get_the_ID(), 'game_platform', true))): ?>
                    <li class="mb-5">
                        <h5>Platforms</h5>

                        <div class="ghs_social_icons my-3 w-50">

                            <ul>
                                <?php foreach (get_post_meta(get_the_ID(), 'game_platform', true)['company'] as $c): ?>
                                    <?php if(!empty($c['url'])): ?>
                                        <li>
                                            <a href="<?php echo $c['url'] ?>">
                                                <svg width="1em" height="1em" aria-hidden="true" focusable="false">
                                                    <use href="<?php echo get_stylesheet_directory_uri() . '/src/media/icons.svg#icon-'.$c['name'] ?>"></use>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </li>
                    <?php endif; ?>
                </ul>

                <?php endif; ?>


                <div class="ghs_side_card w-100 mb-4">
                    <div class="ghs_side_card_title px-5 py-3">
                        <h5>Sponsor</h5>
                    </div>

	                <?php if(function_exists(the_ad_group())): ?>
                        <div class="ghs_sponsor w-100">
			                <?php the_ad_group(7); ?>
                        </div>
	                <?php endif; ?>

                </div>

            </div>

            <div class="col-12">
	            <?php
                if(is_single() && get_post_type() == 'games'):
                    _themename_featured_posts($args = [ 'post_type' => 'games', 'post_status' => 'publish', 'posts_per_page' => 3 ], 'More Releases');
                endif;
                ?>
            </div>

        </div>

    </div>

    <?php
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
}


// Admin Settings
function _themename_admin_init(){
	register_setting(
		'hero-option-group',
		'heroSize'
	);

    register_setting(
		'hero-option-group',
		'heroBanner'
	);

    register_setting(
		'hero-option-group',
		'insight'
	);

    register_setting(
		'hero-option-group',
		'featColumnSize'
	);

    register_setting(
		'hero-option-group',
		'featColumn'
	);

    register_setting(
		'hero-option-group',
		'newsletter'
	);

    register_setting(
		'hero-option-group',
		'social'
	);

	if(get_option('heroBanner')):
		$heroBanner = get_option('heroBanner');
	else:
		$heroBanner = array();
        update_option('heroBanner', $heroBanner);
	endif;

    if(get_option('featColumn')):
		$featColumn = get_option('featColumn');
	else:
		$featColumn = array();
        update_option('featColumn', $featColumn);
	endif;

    if(get_option('social')):
		$social = get_option('social');
	else:
		$social = array(
                'text' => '',
                'social' => [
                    'facebook' => [
                        'name' => 'Facebook',
                        'url' => ''
                    ],
                    'twitter' => [
                        'name' => 'Twitter',
                        'url' => ''
                    ],
                    'instagram' => [
                        'name' => 'Instagram',
                        'url' => ''
                    ],
                    'youtube' => [
                        'name' => 'Youtube',
                        'url' => ''
                    ],
                    'tiktok' => [
                        'name' => 'Tiktok',
                        'url' => ''
                    ],
                    'twitch' => [
                        'name' => 'Twitch',
                        'url' => ''
                    ],
                    'itch' => [
                        'name' => 'Itch',
                        'url' => ''
                    ]
                ],
                'company' => [
	                'nintendo' => [
		                'name' => 'Nintendo',
		                'url' => ''
	                ],
	                'playstation' => [
		                'name' => 'Playstation',
		                'url' => ''
	                ],
	                'xbox' => [
		                'name' => 'Xbox',
		                'url' => ''
	                ],
	                'Windows' => [
		                'name' => 'Windows',
		                'url' => ''
	                ],
	                'steam' => [
		                'name' => 'Steam',
		                'url' => ''
	                ],
	                'android' => [
		                'name' => 'Android',
		                'url' => ''
	                ],
	                'ios' => [
		                'name' => 'IOS',
		                'url' => ''
	                ]
                ]
        );
        update_option('social', $social);
	endif;

	add_settings_section(
		'theme-index-options',
		'Hero Settings',
		null,
		'theme-options'
	);

	add_settings_field(
		'hero-size',
		'Hero Size',
		'hero_size_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'hero-banner-items',
		'Hero Banner',
		'hero_banner_items_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'insight-items',
		'Insight',
		'hero_insight_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'featColumnSize-items',
		'Feat Columns Size',
		'feat_columns_size_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'featColumn-items',
		'Feat Columns',
		'feat_columns_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'newsletter-items',
		'Newsletter',
		'newsletter_callback',
		'theme-options',
		'theme-index-options'
	);

    add_settings_field(
		'social-items',
		'Social',
		'social_callback',
		'theme-options',
		'theme-index-options'
	);
}

function _themename_options_page(){ ?>
    <h1>Hero Settings</h1>
    <?php settings_errors(); ?>

    <form action="options.php" method="POST">
    <?php settings_fields('hero-option-group'); ?>
    <?php do_settings_sections('theme-options'); ?>
    <?php submit_button() ?>
    </form>

<?php }

function hero_size_callback(){
    $heroMaxSize = 3;
    $heroSize = get_option('heroSize');
    ?>
<!--    <input type="text" name="heroSize" placeholder="Text" value="--><?php //echo $heroSize ?><!--">-->
    <select name="heroSize">
        <?php for($i = 1; $i <= $heroMaxSize; $i++): ?>
            <option value="<?php echo $i; ?>" <?php selected( $heroSize, $i ); ?>><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
<?php }

function hero_banner_items_callback(){
	$heroSize = get_option('heroSize');
    $heroBanner = get_option('heroBanner');
    ?>

    <ul class="heroBanner_list">
    <?php for($i = 1; $i <= $heroSize; $i++): ?>
            <li class="heroBanner_listItem" >

                <label for="profile-picture_<?php echo $i; ?>">
                   <img class="heroBanner_img_<?php echo $i; ?>" src="<?php
                    if(isset( $heroBanner['hero_'.$i]['img'] )):
                        if(wp_http_validate_url(esc_url(wp_get_attachment_url($heroBanner['hero_'.$i]['img']), 'full', false, '' ))):
                            echo esc_url(wp_get_attachment_url($heroBanner['hero_'.$i]['img']), 'full', false, '' );
                        else:
                            echo esc_url('https://placehold.jp/1920x1080.png');
                        endif;
                    else:
                        echo esc_url('https://placehold.jp/1920x1080.png');
                    endif;?>" value="Upload Profile Picture" id="upload-button_<?php echo $i ?>" />
                </label>
                <input id="profile-picture_<?php echo $i; ?>" name="heroBanner[hero_<?php echo $i; ?>][img]" value="<?php echo $heroBanner['hero_'.$i]['img'] ?>" />

                <input type="text" placeholder="Title" name="heroBanner[hero_<?php echo $i; ?>][title]" value="<?php echo $heroBanner['hero_'.$i]['title'] ?>">
                <textarea placeholder="Text Body" name="heroBanner[hero_<?php echo $i; ?>][body]" ><?php echo $heroBanner['hero_'.$i]['body'] ?></textarea>
                <input type="text" placeholder="Call to Action" name="heroBanner[hero_<?php echo $i; ?>][cta]" value="<?php echo $heroBanner['hero_'.$i]['cta'] ?>">
                <input type="url" placeholder="Url" name="heroBanner[hero_<?php echo $i; ?>][url]" value="<?php echo $heroBanner['hero_'.$i]['url'] ?>">
            </li>
    <?php endfor; ?>
    </ul>

<?php }

function hero_insight_callback(){
    $insight = get_option('insight');
    ?>

    <div class="ghs_insight_wrapper">
        <label for="insight_bg">
            <img class="insight_img" src="<?php
            if(isset( $insight['img'] )):
                if(wp_http_validate_url(esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' ))):
                    echo esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' );
                else:
                    echo esc_url('https://placehold.jp/1920x1080.png');
                endif;
            else:
                echo esc_url('https://placehold.jp/1920x1080.png');
            endif;?>" value="Upload Profile Picture" id="insight_submit" />
        </label>
        <input id="insight_bg" class="insight_bg" name="insight[img]" value="<?php echo $insight['img'] ?>" />
        <input type="text"  name="insight[header]" value="<?php echo $insight['header'] ?>" placeholder="Header Title">
        <input type="text"  name="insight[title]" value="<?php echo $insight['title'] ?>" placeholder="Main Title">
        <textarea placeholder="Text Body" name="insight[body]" ><?php echo $insight['body'] ?></textarea>
    </div>

<?php }

function feat_columns_size_callback(){
    $featColumnMaxSize = 3;
    $featColumn = get_option('featColumnSize');
    ?>

    <select name="featColumnSize">
        <?php for($i = 1; $i <= $featColumnMaxSize; $i++): ?>
            <option value="<?php echo $i; ?>" <?php selected( $featColumn, $i ); ?>><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
<?php }

function feat_columns_callback(){
    $featColumnSize = get_option('featColumnSize');
    $featColumn = get_option('featColumn');
    ?>

    <ul class="featColumn_list">
        <?php for($i = 1; $i <= $featColumnSize; $i++): ?>
            <li class="ghs_feat_column" >

                <svg class="ghs_feat_column_preview" aria-hidden="true" focusable="false">
                    <use href="<?php echo $featColumn['icon_'.$i] ?>"></use>
                </svg>
                <label for="featColumn[icon_<?php echo $i ?>]">
                    <select class="ghs_feat_column_select_<?php echo $i ?> icon_select"></select>
                </label>
                <input value="<?php echo $featColumn['icon_'.$i] ?>" name="featColumn[icon_<?php echo $i ?>]" type="text" class="ghs_feat_column_icon">

                <input value="<?php echo $featColumn['title_'.$i] ?>" name="featColumn[title_<?php echo $i ?>]" type="text" class="ghs_feat_column_title" placeholder="Title">

                <textarea name="featColumn[desc_<?php echo $i ?>]" placeholder="Description"><?php echo $featColumn['desc_'.$i] ?></textarea>

                <input value="<?php echo $featColumn['link_text_'.$i] ?>" name="featColumn[link_text_<?php echo $i ?>]" type="text" class="ghs_feat_column_link_text" placeholder="Link Text">

                <input value="<?php echo $featColumn['link_'.$i] ?>" name="featColumn[link_<?php echo $i ?>]" type="url" class="ghs_feat_column_link" placeholder="Link">
            </li>
        <?php endfor; ?>
    </ul>

<?php }

function newsletter_callback(){
    $newsletter = get_option('newsletter');
    ?>

    <textarea style="width: 35%" name="newsletter" placeholder="Newletter CTA"><?php echo $newsletter?></textarea>

<?php }

function social_callback(){
    $social = get_option('social');
    ?>

    <textarea name="social[text]" placeholder="Footer Blurb"><?php echo $social['text'] ?></textarea>

    <div class="ghs_social">

        <!-- Social Links -->
        <div class="ghs_social_links">
            <h5>Social Links</h5>
            <?php foreach ($social['social'] as $s): ?>
                <input hidden value="<?php echo $s['name'] ?>" name="social[social][<?php echo $s['name'] ?>][name]" type="text" placeholder="<?php echo $s['name'] ?>">
                <input value="<?php echo $s['url'] ?>" name="social[social][<?php echo $s['name'] ?>][url]" type="url" placeholder="<?php echo $s['name'] ?>">
            <?php endforeach; ?>
        </div>

        <!-- Company Links -->
        <div class="ghs_company_links">
            <h5>Company Links</h5>
	        <?php foreach ($social['company'] as $c): ?>
                <input hidden value="<?php echo $c['name'] ?>" name="social[company][<?php echo $c['name'] ?>][name]" type="text" placeholder="<?php echo $c['name'] ?>">
                <input value="<?php echo $c['url'] ?>" name="social[company][<?php echo $c['name'] ?>][url]" type="url" placeholder="<?php echo $c['name'] ?>">
	        <?php endforeach; ?>
        </div>

    </div>
<?php }

function _themename_admin_page(){
	add_menu_page(
        'Home Page Settings',
        'Theme Settings',
        'manage_options',
        'theme-options',
        '_themename_options_page',
        'dashicons-admin-generic',
        100
    );
}

function _themename_save_postdata($post_id){
    if(array_key_exists('game_rating_field', $_POST)){
        update_post_meta(
          $post_id,
          'game_rating',
          $_POST['game_rating_field']
        );
    }

    if(array_key_exists('game_release_field', $_POST)){
        update_post_meta(
          $post_id,
          'game_release',
          $_POST['game_release_field']
        );
    }

    if(array_key_exists('game_publisher_field', $_POST)){
        update_post_meta(
          $post_id,
          'game_publisher',
          $_POST['game_publisher_field']
        );
    }

    if(array_key_exists('game_size_field', $_POST)){
        update_post_meta(
          $post_id,
          'game_size',
          $_POST['game_size_field']
        );
    }

    if(array_key_exists('game_platform', $_POST)){
        update_post_meta(
          $post_id,
          'game_platform',
          $_POST['game_platform']
        );
    }
}

function game_rating_meta_box($post){
    if(get_post_meta($post->ID, 'game_rating', true)):
        $value = get_post_meta($post->ID, 'game_rating', true);
    else:
        $value = 'RP';
    endif;
    ?>

    <select name="game_rating_field" id="game_rating_field" class="ghs_game_rating">
        <?php foreach (GHS_ESRB_RATINGS as $rating): ?>
        <option value="<?php echo $rating['Rating'] ?>" <?php selected($value, $rating['Rating']) ?>><?php echo $rating['Name'] ?></option>
        <?php endforeach; ?>
    </select>

    <?php
}

function game_release_meta_box($post){
    $value = get_post_meta($post->ID, 'game_release', true);
    ?>

    <input type="date" id="game_release_field" name="game_release_field" value="<?php echo $value ?>">

    <?php
}

function game_publisher_meta_box($post){
    $value = get_post_meta($post->ID, 'game_publisher', true);
    ?>

    <input type="text" name="game_publisher_field" id="game_publisher_field" value="<?php echo $value?>">

    <?php
}

function game_size_meta_box($post){
    $value = get_post_meta($post->ID, 'game_size', true);
    ?>

    <input type="text" name="game_size_field" id="game_size_field" value="<?php echo $value ?>">

    <?php
}

function game_platform_meta_box($post){
    if(get_post_meta($post->ID, 'game_platform', true)):
        $value = get_post_meta($post->ID, 'game_platform', true);
    else:
        $value = [
	        'company' => [
		        'nintendo' => [
			        'name' => 'Nintendo',
			        'url' => ''
		        ],
		        'playstation' => [
			        'name' => 'Playstation',
			        'url' => ''
		        ],
		        'xbox' => [
			        'name' => 'Xbox',
			        'url' => ''
		        ],
		        'Windows' => [
			        'name' => 'Windows',
			        'url' => ''
		        ],
		        'steam' => [
			        'name' => 'Steam',
			        'url' => ''
		        ],
		        'android' => [
			        'name' => 'Android',
			        'url' => ''
		        ],
		        'ios' => [
			        'name' => 'IOS',
			        'url' => ''
		        ]
	        ]
        ];
    endif;

    foreach ($value['company'] as $c):
    ?>
        <input hidden value="<?php echo $c['name'] ?>" name="game_platform[company][<?php echo $c['name'] ?>][name]" type="text" placeholder="<?php echo $c['name'] ?>">
        <input style="margin-bottom: .5rem; width: 100%;" value="<?php echo $c['url'] ?>" name="game_platform[company][<?php echo $c['name'] ?>][url]" type="url" placeholder="<?php echo $c['name'] ?>">
    <?php
    endforeach;
}

function _themename_meta_boxes(){

    add_meta_box('game_rating', 'Game Rating', 'game_rating_meta_box', 'games', 'side');
    add_meta_box('game_release', 'Game Release', 'game_release_meta_box', 'games', 'side');
    add_meta_box('game_publisher', 'Game Publisher', 'game_publisher_meta_box', 'games', 'side');
    add_meta_box('game_size', 'Game Size', 'game_size_meta_box', 'games', 'side');
    add_meta_box('game_platform_links', 'Game Platforms', 'game_platform_meta_box', 'games', 'side');

}

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

//Filters
add_filter( 'show_admin_bar', '__return_false' );

// Const
const GHS_GAME_CATS = array(
	0 => 'Action',
	1 => 'Action-Adventure',
	2 => 'Adventure',
	3 => 'Arcade',
	4 => 'Puzzle',
	5 => 'FPS',
	6 => 'Platformer',
	7 => 'RPG',
	8 => 'Simulation',
	9 => 'Strategy',
	10 => 'Sports',
	11 => 'MMO',
	12 => 'Open World',
);

const GHS_ESRB_RATINGS = array(
        0 => [
            'Rating' => 'E',
            'Name' => 'Everyone',
            'Desc' => 'Content is generally suitable for all ages. May contain minimal cartoon, fantasy or mild violence and/or infrequent use of mild language.'
        ],
        1 => [
            'Rating' => 'E10+',
            'Name' => 'Everyone 10+',
            'Desc' => 'Content is generally suitable for ages 10 and up. May contain more cartoon, fantasy or mild violence, mild language and/or minimal suggestive themes.'
        ],
        2 => [
            'Rating' => 'T',
            'Name' => 'Teen',
            'Desc' => 'Content is generally suitable for ages 13 and up. May contain violence, suggestive themes, crude humor, minimal blood, simulated gambling and/or infrequent use of strong language.'
        ],
        3 => [
            'Rating' => 'M',
            'Name' => 'Mature 17+',
            'Desc' => 'Content is generally suitable for ages 17 and up. May contain intense violence, blood and gore, sexual content and/or strong language.'
        ],
        4 => [
            'Rating' => 'AO',
            'Name' => 'Adults Only 18+',
            'Desc' => 'Content suitable only for adults ages 18 and up. May include prolonged scenes of intense violence, graphic sexual content and/or gambling with real currency.'
        ],
        5 => [
            'Rating' => 'RP',
            'Name' => 'Rating Pending',
            'Desc' => 'Not yet assigned a final ESRB rating. Appears only in advertising, marketing and promotional materials related to a physical (e.g., boxed) video game that is expected to carry an ESRB rating, and should be replaced by a game\'s rating once it has been assigned.'
        ],
        6 => [
            'Rating' => 'RP17+',
            'Name' => 'Rating Pending — Likely Mature 17+',
            'Desc' => 'Not yet assigned a final ESRB rating but anticipated to be rated Mature 17+. Appears only in advertising, marketing, and promotional materials related to a physical (e.g., boxed) video game that is expected to carry an ESRB rating, and should be replaced by a game’s rating once it has been assigned.'
        ],
);

const GHS_PEGI_RATINGS = array(
	0 => [
		'Rating' => 'PEGI3',
		'Name' => 'PEGI 3',
		'Desc' => 'The majority of games rated PEGI 3 do not contain issues that require a content warning. Games given this rating are considered suitable for all age groups. There may be very mild and unrealistic violence in a child-like setting. There may also be nudity when shown in a completely natural and non-sexual manner, for example during breastfeeding. Games rated at PEGI 3 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	1 => [
		'Rating' => 'PEGI7',
		'Name' => 'PEGI 7',
		'Desc' => 'Games rated PEGI 7 may contain unrealistic violence, often directed towards fantasy characters. Violence towards human characters will be unrealistic and undetailed, of a minor nature, or only implied. For example, a city being bombed or cars crashing, where the violence to humans is not actually shown. Games may also be rated PEGI 7 because they contain elements, including sounds, that might be scary or frightening to younger children. Games rated at PEGI 7 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	2 => [
		'Rating' => 'PEGI12',
		'Name' => 'PEGI 12',
		'Desc' => 'Games rated PEGI 12 may contain more detailed and realistic-looking violence towards fantasy characters. However, any violence towards human characters must look unrealistic or be minor in nature. There may be moderate horror sequences, such as characters in danger and jump scares, as well as disturbing images, such as sight of injuries or dead bodies. Milder forms of swearing may be present but not the strongest terms. While sex may not be shown, there may be sexual innuendo and sexual activity can be implied (eg a couple getting into bed). The type of suggestive posing and dancing that\'s familiar from music videos may also be allowed, although there will be no sexual nudity. Games rated at PEGI 12 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	3 => [
		'Rating' => 'PEGI!',
		'Name' => 'Parental Guidance',
		'Desc' => 'In addition to the numerical PEGI ratings, you will also see the \'Parental Guidance Recommended \' rating for some non-game apps, introduced by PEGI for storefronts that use IARC (https://www.globalratings.com/). This serves as a warning that these apps can offer a broad and unpredictable variety of user-generated or curated content. Typically, this warning applies to products such as Facebook, Twitter or YouTube.'
	],
	4 => [
		'Rating' => 'PEGI16',
		'Name' => 'PEGI 16',
		'Desc' => 'Games rated PEGI 16 may contain more realistic and sustained violence against human characters, including sight of blood. The stronger forms of violence, such as torture and a focus on pain and injury, will not normally be allowed unless they are against fantasy characters. Games at this level will not necessarily show any negative consequences to crime. There may also be intense and sustained horror sequences or strong gory images. Strong language can occur, including the crudest sexual expletives. Sexual activity may be shown provided there is no sight of genitals. Depictions of erotic nudity may feature. There may be depictions of the use of illegal drugs, as well as prominent use of tobacco and alcohol. Games rated at PEGI 16 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons.'
	],
	5 => [
		'Rating' => 'PEGI18',
		'Name' => 'PEGI 18',
		'Desc' => 'Games rated PEGI 18 can contain very strong content and are only suitable for adults. This could include torture and the infliction of severe pain and injury to human characters. It could also include violence towards defenceless or vulnerable human characters, including children. Sexual violence and sexual threats may also occur. Very strong and crude language may feature throughout. There may be strong depictions of sexual activity with sight of genitals*. Games rated PEGI 18 may also feature detailed descriptions of criminal techniques, as well as the teaching and glamorisation of gambling, and the glamorisation and promotion of illegal drug use. Games rated at PEGI 18 may also contain in-game purchases. If a game contains such purchases, this will be indicated by an icon on the box, as shown below. Where these purchases are for randomly selected items, you will also see the text \'In-game Purchases (Includes Random Items)\' beneath the PEGI rating and content icons. '
	],
);

const GHS_CERO_RATINGS = array(
	0 => [
		'Rating' => 'CEROA',
		'Name' => 'CERO A',
		'Desc' => 'Titles rated A have been assessed to be suitable for gamers of all ages.'
	],
	1 => [
		'Rating' => 'CEROB',
		'Name' => 'CERO B',
		'Desc' => 'Titles rated B have been assessed to be suitable for gamers ages 12 and up.'
	],
	2 => [
		'Rating' => 'CEROC',
		'Name' => 'CERO C',
		'Desc' => 'Titles rated C have been assessed to be suitable for gamers ages 15 and up.'
	],
	3 => [
		'Rating' => 'CEROD',
		'Name' => 'CERO D',
		'Desc' => 'Titles rated D have been assessed to be suitable for gamers ages 17 and up.'
	],
	4 => [
		'Rating' => 'CEROZ',
		'Name' => 'CERO Z',
		'Desc' => 'Titles rated Z have been assessed to be suitable only for gamers ages 18 and up. These titles contain explicit content and are banned for sale to any person under the age of 18.'
	],
	5 => [
		'Rating' => 'CERO_Statistical',
		'Name' => 'CERO - Statistical',
		'Desc' => 'Titles with this mark are Statictical software releases and have not been reviewed under the typical terms of CERO. Programs rated in this manner may or may not be appropriate for all ages.'
	],
	6 => [
		'Rating' => 'CERO_Sampler',
		'Name' => 'CERO - Sampler',
		'Desc' => 'Titles rated with this mark are Trial Versions of software. Programs rated in this manner may or may not be appropriate for all ages, and they also may not contain all of the content that will be considered for the CERO rating of the final game release.'
	],
	7 => [
		'Rating' => 'CERO_RP',
		'Name' => 'CERO - Rating Pending',
		'Desc' => 'Titles rated with this mark have not yet been rated, as they are not yet complete in production and have not yet been evaluated by CERO. Programs marked in this manner may or may not be appropriate for all ages. Please check back for the final rating at a later date.'
	],
);

const GHS_AUSSIE_RATINGS = array();

const GHS_UK_RATINGS = array();

// Defines
// Includes
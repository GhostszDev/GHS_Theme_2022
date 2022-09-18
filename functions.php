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

function _themename_theme_setup(){

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


//Theme Frontend
function _themename_nav_bar(){ ?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
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
                        <a class="nav-link" aria-current="page" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
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

function _themename_featured_posts(){

    $args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 6
    ];
    $query = new WP_Query( $args );
	$counter = 1; ?>

    <div class="container">
        <h4 class="ghs_section_header mt-4">Latest News</h4>

        <?php
        if ( $query->have_posts() ):
            while ( $query->have_posts() ) {
                $query->the_post();

                if($counter%3 == 1): ?> <div class="row mt-4"> <?php endif; ?>

                <div class="col-12 col-lg-4 pb-4">
                    <div class="ghs_feat_post h-100 position-relative">
                        <img class="ghs_feat_post_img w-100" src="<?php echo get_the_post_thumbnail_url(get_the_ID())?>" />
                        <span class="ghs_feat_post_info btn btn-info btn-sm position-absolute"><?php echo strtoupper(get_post_type(get_the_ID())) ?></span>
                        <div class="ghs_feat_post_text p-3">
                            <h5 class="pb-3"><?php echo get_the_title() ?></h5>
                            <p><?php echo get_the_excerpt() ?></p>
                            <a href="<?php echo get_the_permalink(get_the_ID()) ?>" class="btn btn-primary btn-sm active mx-auto text-dark" role="button">Read More</a>
                        </div>
                    </div>
                </div>

                <?php
                if($counter%3 == 0): ?> </div> <?php endif;

                $counter++;
            }

        else:
            // no posts found
            echo '';
        endif;
        /* Restore original Post Data */
        wp_reset_postdata();

        ?>

        <div class="row">
            <div class="d-flex justify-content-center align-items-center pb-2 pt-2">
                <a href="#" class="btn btn-primary btn-lg active mx-auto text-dark" role="button" aria-pressed="true">Read More</a>
            </div>
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

            <a href="<?php echo $featColumn['link_'.$i] ?>" class="stretched-link ghs_primary_link"><?php echo $featColumn['link_text_'.$i] ?></a>

        </div>

        <?php endfor; ?>

        </div>
    </div>

    <?php
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
//    var_dump($featColumn);
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

//Actions
add_action('wp_enqueue_scripts', '_themename_assets');
add_action( 'admin_enqueue_scripts', '_themename_admin_assets' );
add_action('after_setup_theme', '_themename_theme_setup');
add_action('after_setup_theme', '_themename_after_theme');
add_action('admin_init', '_themename_admin_init');
add_action('admin_menu', '_themename_admin_page');

//Filters
add_filter( 'show_admin_bar', '__return_false' );
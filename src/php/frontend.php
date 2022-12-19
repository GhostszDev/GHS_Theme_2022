<?php

//Theme Frontend Functions
function _themename_nav_bar(){
	$user = wp_get_current_user();
	?>
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
		<div class="container-fluid navbar-dark bg-dark">
			<a class="navbar-brand" href="<?php echo get_home_url() ?>">
				<svg width="75px" height="75px" aria-hidden="true" focusable="false">
					<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-logo' ?>"></use>
				</svg>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
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
					<li class="nav-item dropdown ghs_user_dropdown">
						<a class="nav-link dropdown-toggle d-flex" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?php echo get_avatar_url(get_current_user_id($user->ID)) ?>" alt="user-image" class="rounded-circle">
							<p><?php echo $user->display_name ?></p>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="<?php echo get_home_url(); ?>/profile" rel="nofollow">Profile</a></li>
							<li><a class="dropdown-item" href="<?php echo get_home_url(); ?>/my-account" rel="nofollow">Account</a></li>
							<?php if ( current_user_can( 'manage_options' ) ): ?>
								<li><a class="dropdown-item" href="<?php echo get_admin_url(); ?>">Admin</a></li>
							<?php endif; ?>
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item" href="<?php echo wp_logout_url( home_url() ); ?>" rel="nofollow">Logout</a>
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
				<div class="carousel-item <?php if($k === 0): echo 'active'; endif; ?>" style="background: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)), url(<?php echo esc_url(wp_get_attachment_url($value['img']), 'full', false, '' ); ?>)">
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
							<a href="<?php echo get_category_link(get_the_category(get_the_ID())[0]->cat_ID) ?>"><span class="ghs_feat_post_info btn btn-info btn-sm my-4 position-absolute d-block"><?php echo strtoupper(get_the_category(get_the_ID())[0]->name) ?></span></a>
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
	if(!is_page('studio')):
		$insight = get_option('insight');
	else:
		$insight = get_option('insight_company');
	endif;
	?>

	<div class="w-100 mt-4 ghs_insight" style="background: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)), url(<?php echo esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' ); ?>)">

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

	<!--    <div class="container py-4 my-4 ghs_border_bottom">-->
	<!--        <div class="row pb-4">-->
	<!---->
	<!--            <div class="col-12">-->
	<!--                <h4 class="ghs_section_header mt-4">Join the Newsletter</h4>-->
	<!--            </div>-->
	<!---->
	<!--            <div class="col-12 col-lg-6">-->
	<!--                <p>--><?php //echo get_option('newsletter'); ?><!--</p>-->
	<!--            </div>-->
	<!---->
	<!--            <div class="col-12 col-lg-6">-->
	<!--                <div class="input-group mb-3">-->
	<!--                    <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="button-addon2">-->
	<!--                    <button class="btn btn-primary text-dark" type="button" id="button-addon2">Sign Up</button>-->
	<!--                </div>-->
	<!--            </div>-->
	<!---->
	<!--        </div>-->
	<!--    </div>-->

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
					<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-logo' ?>"></use>
				</svg>

				<p class="my-3"><?php echo $social['text'] ?></p>

				<div class="ghs_social_icons my-3">

					<ul>
						<?php foreach ($social['social'] as $s): ?>
							<?php if(!empty($s['url'])): ?>
								<li>
									<a href="<?php echo $s['url'] ?>" target="_blank" rel="noopener external nofollow">
										<svg aria-hidden="true" focusable="false">
											<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-'.$s['name'] ?>"></use>
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
									<a href="<?php echo $c['url'] ?>" target="_blank" rel="noopener external nofollow">
										<svg width="1em" height="1em" aria-hidden="true" focusable="false">
											<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-'.$c['name'] ?>"></use>
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

	<div class="w-100 mt-4 ghs_insight d-flex align-items-center mb-3" style="background: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)), url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID())); ?>)">

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
					<?php if(is_page() && !is_privacy_policy()):
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
				<?php if(function_exists('the_ad_group')): ?>
					<div class="ghs_side_card w-100 mb-4">
						<div class="ghs_side_card_title px-5 py-3">
							<h5>Sponsor</h5>
						</div>


						<div class="ghs_sponsor w-100">
							<?php the_ad_group(get_option('side_ad_select')); ?>
						</div>


					</div>
				<?php endif; ?>

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

			<div class="<?php if(!is_privacy_policy()): ?>col-12 col-lg-8 ghs_single_post <?php else: ?> col-12 ghs_single_post <?php endif; ?>">
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
													<a href="<?php echo $c['url'] ?>" target="_blank" rel="noopener external nofollow">
														<svg width="1em" height="1em" aria-hidden="true" focusable="false">
															<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-'.$c['name'] ?>"></use>
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

				<?php if(function_exists('the_ad_group') && !is_privacy_policy()): ?>
					<div class="ghs_side_card w-100 mb-4">
						<div class="ghs_side_card_title px-5 py-3">
							<h5>Sponsor</h5>
						</div>


						<div class="ghs_sponsor w-100">
							<?php the_ad_group(get_option('side_ad_select')); ?>
						</div>

					</div>
				<?php endif; ?>

			</div>

			<div class="col-12">
				<?php
				if(is_single() && get_post_type() == 'games'):
					_themename_featured_posts($args = [ 'post_type' => 'games', 'post_status' => 'publish', 'posts_per_page' => 3, 'orderby' => 'rand' ], 'More Releases');
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

function _themename_team(){
	$employees = get_option('employee'); ?>

	<div class="container">

		<h4 class="ghs_section_header mt-4">Meet the team</h4>
		<div class="row">



			<?php foreach ($employees as $em): ?>

				<div class="col-12 col-md-4 p-2 ghs_employee_team position-relative">
					<img src="<?php echo esc_url(wp_get_attachment_url($em['image']), 'full', false, '' ); ?>">
					<span class="position-absolute ghs_employee_team_text">
                        <p class="ghs_employee_team_name"><?php echo $em['name'] ?></p>
                        <p class="ghs_employee_team_pos ghs_primary_text_color"><?php echo $em['position'] ?></p>
                    </span>
				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<?php
}

function _themename_focus_text(){}

function _themename_spotlight(){
	$spotlight = get_option('spotlight');
	$counter = 1;

	if($spotlight):?>

		<div class="container ghs_spotlight my-3">
			<div class="row">

				<?php foreach($spotlight as $key => $sl): ?>

					<div class="col-12 col-md-4 my-2 <?php if(($key % 2) != 0): ?> order-md-2 <?php endif; ?>">
						<ul class="mb-5">
							<li><span class="ghs_white_text ghs_spotlight_number"><?php echo $counter; $counter++; ?></span></li>
							<li><h5 class="ghs_primary_text_color"><?php echo $sl['topTitle'] ?></h5></li>
							<li><p><?php echo $sl['topDescription'] ?></p></li>
						</ul>

						<ul>
							<li><span class="ghs_white_text ghs_spotlight_number"><?php echo $counter; $counter++; ?></span></li>
							<li><h5 class="ghs_primary_text_color"><?php echo $sl['bottomTitle'] ?></h5></li>
							<li><p><?php echo $sl['bottomDescription'] ?></p></li>
						</ul>
					</div>

					<div class="col-12 col-md-8 ghs_spotlight_image mt-2 mb-4 <?php if(($key % 2) != 0): ?> order-md-1 <?php endif; ?>">
						<img src="<?php echo esc_url(wp_get_attachment_url($sl['image']), 'full', false, '' ); ?>">
					</div>

				<?php endforeach; ?>

			</div>
		</div>

	<?php
	endif;
}

function _themename_page_contact_info(){
	$contact = get_option('contact');
	$social = get_option('social');?>

	<div class="container ghs_contact">
		<div class="row">

			<div class="col-12 col-md-6">
				<h5>General Inquiry</h5>
				<?php if($contact['general']): ?>
					<p><a href="mailto: <?php echo $contact['general'] ?>"><?php echo $contact['general'] ?></a></p>
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6">
				<h5>Headquarters</h5>
				<?php if(!empty($contact['address']['address_1'])): ?>
					<p><a href="http://maps.google.com/?q=<?php echo $contact['address']['address_1'] . ' ' . $contact['address']['address_2'] . ', ' . $contact['address']['city']  . ', ' . $contact['address']['state'] . ', ' . $contact['address']['zip'] ?>" target="_blank" rel="noopener external nofollow"><?php echo $contact['address']['name'] .'<br />'. $contact['address']['address_1'] . ' ' . $contact['address']['address_2'] . ', ' . $contact['address']['city']  . ', ' . $contact['address']['state'] . ', ' . $contact['address']['zip'] ?></a></p>
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6">
				<h5>Support Inquiry</h5>
				<?php if($contact['support']): ?>
					<p><a href="mailto: <?php echo $contact['support'] ?>"><?php echo $contact['support'] ?></a></p>
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6">
				<h5>Phone</h5>
				<?php if($contact['phone']): ?>
					<p><a href="tel: <?php echo '+1'.$contact['phone'] ?>"><?php echo $contact['phone'] ?></a></p>
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6">
				<h5>Career Inquiry</h5>
				<?php if($contact['career']): ?>
					<p><a href="mailto: <?php echo $contact['career'] ?>"><?php echo $contact['career'] ?></a></p>
				<?php endif; ?>
			</div>

			<div class="col-12 col-md-6">
				<h5>Social</h5>
				<div class="ghs_social_icons my-3">
					<ul>
						<?php foreach ($social['social'] as $s): ?>
							<?php if(!empty($s['url'])): ?>
								<li>
									<a href="<?php echo $s['url'] ?>">
										<svg aria-hidden="true" focusable="false">
											<use href="<?php echo get_stylesheet_directory_uri() . '/dist/media/icons.svg#icon-'.$s['name'] ?>"></use>
										</svg>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>

			</div>


		</div>
	</div>

	<?php
}

function _themename_page_contact_form(){
	$contact = get_option('contact');

	$user = [];
	if(is_user_logged_in()):
		$user = wp_get_current_user();
	endif;
	?>

	<div class="container my-3">
		<h4 class="ghs_section_header my-4">Contact Us</h4>
		<form class="row g-3" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<div class="col-md-6 col-12">
				<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php if(!empty($user)): echo $user->user_firstname; endif; ?>" required>
			</div>
			<div class="col-md-6 col-12">
				<input type="text" class="form-control" id="lastName"  name="lastName" placeholder="Last Name" value="<?php if(!empty($user)): echo $user->user_lastname; endif; ?>" required>
			</div>
			<div class="col-12 col-md-6">
				<input type="email" class="form-control" id="from"  name="from" placeholder="Email" value="" required>
			</div>
			<div class="col-12 col-md-6">
				<select class="form-select" id="to" name="to" required>
					<option value="" disabled selected>Select Inquiry Type</option>
					<option value="<?php echo $contact['general'] ?>">General Inquiry</option>
					<option value="<?php echo $contact['support'] ?>">Support Inquiry</option>
				</select>
			</div>
			<div class="col-12">
				<input type="text" class="form-control" id="subject" placeholder="Subject"  name="subject">
			</div>
			<div class="col-12">
				<textarea id="body" name="body" class="form-control" rows="5" required placeholder="Email Body"></textarea>
			</div>
			<div class="col-12">
				<button type="submit" class="btn btn-primary btn-sm active mx-auto text-dark">Submit</button>
			</div>
		</form>


	</div>

	<?php
}

function _themename_account_page(){
	?>

	<div class="container ghs_content_top">

		<div class="row">

			<div class="col-12 col-lg-8 ghs_single_post my-4 ghs_woocommerce_content">
				<?php echo woocommerce_account_content(); ?>
			</div>

			<div class="col-12 col-lg-4 my-4">

				<div class="ghs_side_card w-100 mb-4">
					<div class="ghs_side_card_title px-5 py-3">
						<h5>Account Settings</h5>
					</div>

					<ul class="px-5 py-3">
						<?php foreach (wc_get_account_menu_items() as $endpoint => $label): ?>
							<li class="mb-3 pb-2"><a class="ghs_primary_link" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

			</div>

		</div>

	</div>

	<?php
}

function _themename_page_profile_image(){
	$user = wp_get_current_user();
	?>

	<div class="w-100 mt-4 ghs_insight d-flex align-items-center mb-3" style="background: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)), url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID())); ?>)">

		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6">
					<h5 class="pt-3 ghs_insight_title"><?php echo $user->display_name; ?></h5>
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
		</div>

	</div>

	<?php
}
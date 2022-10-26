<?php
get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		woocommerce_content();
	endwhile;
else :
	_e( 'Sorry, no posts matched your criteria.', 'textdomain' );
endif;

get_footer();
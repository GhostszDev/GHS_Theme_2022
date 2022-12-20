<?php

if(empty(get_query_var('profile')) || !get_user_by('slug', get_query_var('profile'))):
	wp_redirect(site_url('not_found'));
else:

get_header();

_themename_page_profile_image();

get_footer();

endif;
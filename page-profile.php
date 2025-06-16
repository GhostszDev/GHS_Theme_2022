<?php


$gamesList = [];
$subpages = ['', 'friends', 'badges'];
$current_uri = profileBase_URI .get_query_var('profile');

if(empty(get_query_var('profile'))
   || !get_user_by('slug', get_query_var('profile'))
   || !in_array(get_query_var('subpage'), $subpages)):
	wp_redirect(site_url('404'));
else:

	get_header();

	_themename_page_profile_image($current_uri);

	if(get_query_var('subpage') == "friends"):
		_themename_get_users_friends(get_user_by('login',get_query_var('profile'))->ID);

	elseif (get_query_var('subpage') == "badges"):
		echo "<p>Badge Page</p>";

	endif;

	get_footer();

endif;
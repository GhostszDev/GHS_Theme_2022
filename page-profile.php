<?php


$gamesList = [];
$subpages = ['', 'friends', 'badges-list'];
$current_uri = profileBase_URI .get_query_var('profile');
$user_ID = get_user_by('login',get_query_var('profile'))->ID;

if(empty(get_query_var('profile'))
   || !get_user_by('slug', get_query_var('profile'))
   || !in_array(get_query_var('subpage'), $subpages)):
	wp_redirect(site_url('404'));
else:

	get_header();

	_themename_page_profile_image($current_uri);

	if(get_query_var('subpage') == "friends"):
		_themename_get_users_friends($user_ID);

	elseif (get_query_var('subpage') == "badges-list"):
		_themename_get_users_played_game_list($user_ID);

	endif;

	get_footer();

endif;
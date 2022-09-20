<?php
get_header();

_themename_hero_banner();
_themename_featured_posts($args = [ 'post_type' => array('games', 'post'), 'post_status' => 'publish', 'posts_per_page' => 6, 'orderby' => 'rand' ]);
_themename_insight();
_themename_feat_column();


get_footer();
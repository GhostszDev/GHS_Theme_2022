<?php

//if(post_password_required()):
//    return;
//endif;

?>

<div id="comments" class="container">
    <div class="row">

        <ul class="comment-list">
		    <?php
		    wp_list_comments( array(
			    'avatar_size' => 60,
			    'max_depth'   => '',
			    'style'       => 'li',
			    'short_ping'  => true,
			    'type'        => 'comment',
			    'reverse_top_level' => true
		    ) );
		    ?>
        </ul>

    </div>
</div>

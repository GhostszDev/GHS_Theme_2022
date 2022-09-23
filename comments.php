<?php

//if(post_password_required()):
//    return;
//endif;

?>

<div id="comments" class="container">
    <div class="row">

        <div>
            <?php
            //Declare Vars
            $comment_send = 'Send';
            $comment_reply = 'Leave a Message';
            $comment_reply_to = 'Reply';

            $comment_author = 'Name';
            $comment_email = 'E-Mail';
            $comment_body = 'Comment';
            $comment_url = 'Website';
            $comment_cookies_1 = ' By commenting you accept the';
            $comment_cookies_2 = ' Privacy Policy';

            $comment_before = 'Registration isn\'t required.';

            $comment_cancel = 'Cancel Reply';

            $commentFormAgrs = [
	            //Define Fields
                'fields' => array(
                    //Author field
                    'author' => '<div class="d-flex items-justified-space-between ghs_half_forms mb-3">
                                    <div class="comment-form-author form-floating">
                                         <input type="author" class="form-control" id="author" placeholder="'.$comment_author.'">
                                         <label for="author">Name</label>
                                    </div>',
                    //Email Field
                    'email' => '    <div class="comment-form-email form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="' . $comment_email . '" value="">
                                        <label for="email">Email address</label>
                                    </div>
                                </div>',
                    //URL Field
                    'url' => '
                        <div class="comment-form-url form-floating mb-3">
                            <input type="url" class="form-control" id="url" placeholder="'. $comment_url.'">
                            <label for="url">Website</label>
                        </div>
                    ',
                    //Cookies
                    'cookies' => '
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label ghs_white_text" for="flexCheckDefault">
                               ' . $comment_cookies_1 . '<a class="ghs_primary_link" href="' . get_privacy_policy_url() . '">' . $comment_cookies_2 . '</a>
                            </label>
                        </div>
                        ',
                ),
                // Change the title of send button
                'label_submit' => __( $comment_send ),
                // Change the title of the reply section
                'title_reply' => __( $comment_reply ),
                // Change the title of the reply section
                'title_reply_to' => __( $comment_reply_to ),
                //Cancel Reply Text
                'cancel_reply_link' => __( $comment_cancel ),
                // Redefine your own textarea (the comment body).
                'comment_field' => '<div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Comments</label>
                                    </div>',
                //Message Before Comment
                'comment_notes_before' => __( $comment_before),
                // Remove "Text or HTML to be displayed after the set of comment fields".
                'comment_notes_after' => '',
                //Submit Button ID
                'id_submit' => __( 'comment-submit' ),
            ];
            comment_form($commentFormAgrs); ?>
        </div>

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

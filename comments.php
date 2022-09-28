<?php

if(post_password_required()):
    return;
endif;

?>

<div class="container">
    <div class="row">
        <div class="col-12">

            <div id="comments" class="comments-area">

                <?php
                $comment_cookies_1 = ' By commenting you accept the';
                $comment_cookies_2 = ' Privacy Policy';

                comment_form([
                    'comment_field' =>
                        '<div class="comment-form-comment form-floating mb-3">
                            <textarea class="form-control" id="comment" name="comment" maxlength="65525" required=""></textarea>
                            <label for="comment">Comments</label>
                        </div>',
                    'fields' => [
                        'author' =>
                            '<div class="d-flex justify-content-between ghs_half_forms">
                                <div class="comment-form-author form-floating mb-3">
                                     <input id="author" class="form-control" name="author" type="text" value="" size="30" maxlength="245" required="">
                                     <label for="author">Name</label>
                                 </div>',
                        'email' =>
                                '<div class="comment-form-email form-floating mb-3">
                                    <input class="form-control" id="email" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" required="">
                                    <label for="email">Email address</label>
                                </div>
                            </div>',
                        'url' =>
                            '<div class="comment-form-url form-floating mb-3">
                                <input class="form-control" id="url" name="url" type="url" value="" size="30" maxlength="200">
                                <label for="url">Website</label>
                            </div>',
                        'cookies' =>
                            '<div class="comment-form-cookies-consent form-check mb-3 ghs_white_text">
                                <input class="form-check-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="" checked=""> 
                                <label class="form-check-label" for="wp-comment-cookies-consent">' . $comment_cookies_1 . '<a href="' . get_privacy_policy_url() . '">' . $comment_cookies_2 . '</a></label>
                            </div>'
                    ],
                    'class_submit' => 'btn btn-primary mb-5'
                ]); ?>

                <?php if(have_comments()): ?>

                <ul class="ghs_comment_list">
                    <?php $comments = get_comments([
	                    'status'      => 'approve',
	                    'parent'      => 0
                    ]);

                    foreach ($comments as $c):
	                    $commenter = [
		                    'ID' => $c->user_id,
                            'name' => $c->comment_author,
                            'date' => get_comment_date('M j, Y', $c->comment_ID),
                            'comment' => $c->comment_content
                        ];

	                    $comment_children = $c->get_children();
                    ?>

                    <li>
                        <div class="card mb-3">
                            <div class="card-header d-flex align-items-center">
                                <img class="rounded-circle" src="<?php echo get_avatar_url($commenter['ID']) ?>">
                                <div class="ghs_comment_commenter_info d-flex flex-lg-column my-auto ms-2">
                                    <p><?php echo $commenter['name'] ?></p>
                                    <p><?php echo $commenter['date'] ?></p>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-3"><?php echo $commenter['comment'] ?></li>

                                <?php if($comment_children): ?>
                                    <?php foreach($comment_children as $c_c):
                                        $commenter_child = [
	                                        'ID' => $c_c->user_id,
	                                        'name' => $c_c->comment_author,
	                                        'date' => get_comment_date('M j, Y', $c_c->comment_ID),
	                                        'comment' => $c_c->comment_content
                                        ];
                                    ?>
                                    <li class="list-group-item p-3">

                                        <div class="card mb-3">
                                            <div class="card-header d-flex align-items-center">
                                                <img class="rounded-circle" src="<?php echo get_avatar_url($commenter_child['ID']) ?>">
                                                <div class="ghs_comment_commenter_info d-flex flex-lg-column my-auto ms-2">
                                                    <p><?php echo $commenter_child['name'] ?></p>
                                                    <p><?php echo $commenter_child['date'] ?></p>
                                                </div>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item p-3"><?php echo $commenter_child['comment'] ?></li>
                                            </ul>
                                        </div>

                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </li>

                    <?php endforeach; ?>
                </ul>

                    <?php if(!comments_open() && get_comments_number()): ?>
                    <p>Comments are closed!</p>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
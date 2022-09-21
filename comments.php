<div class="container my-4">

	<div class="row">

		<div class="col-12">
			<?php comment_form([
				'comment_field' =>
                    '<div class="form-floating mb-3 ghs_comment_form">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Comments</label>
                    </div>',
                'fields' =>[
                    'author'=>
                        '<div class="form-floating">
                            <input type="Name" class="form-control" id="floatingPassword" placeholder="name">
                            <label for="floatingPassword">Name</label>
                        </div>'
                    ],
			]); ?>
		</div>

	</div>

</div>
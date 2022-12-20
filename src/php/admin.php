<?php

// Admin Settings
function _themename_admin_init(){
	register_setting(
		'hero-option-group',
		'heroSize'
	);

	register_setting(
		'hero-option-group',
		'heroBanner'
	);

	register_setting(
		'hero-option-group',
		'insight'
	);

	register_setting(
		'hero-option-group',
		'featColumnSize'
	);

	register_setting(
		'hero-option-group',
		'featColumn'
	);

	register_setting(
		'hero-option-group',
		'newsletter'
	);

	register_setting(
		'hero-option-group',
		'social'
	);

	if(function_exists('the_ad_group')):
		register_setting(
			'hero-option-group',
			'side_ad_select'
		);
	endif;

	register_setting(
		'company-option-group',
		'employee'
	);

	register_setting(
		'company-option-group',
		'insight_company'
	);

	register_setting(
		'company-option-group',
		'spotlight'
	);

	register_setting(
		'contact-option-group',
		'contact'
	);

	register_setting(
		'other-option-group',
		'game_lock_icon'
	);

	if(get_option('heroBanner')):
		$heroBanner = get_option('heroBanner');
	else:
		$heroBanner = array();
		update_option('heroBanner', $heroBanner);
	endif;

	if(get_option('featColumn')):
		$featColumn = get_option('featColumn');
	else:
		$featColumn = array();
		update_option('featColumn', $featColumn);
	endif;

	if(get_option('social')):
		$social = get_option('social');
	else:
		$social = array(
			'text' => '',
			'social' => [
				'facebook' => [
					'name' => 'Facebook',
					'url' => ''
				],
				'twitter' => [
					'name' => 'Twitter',
					'url' => ''
				],
				'instagram' => [
					'name' => 'Instagram',
					'url' => ''
				],
				'youtube' => [
					'name' => 'Youtube',
					'url' => ''
				],
				'tiktok' => [
					'name' => 'Tiktok',
					'url' => ''
				],
				'twitch' => [
					'name' => 'Twitch',
					'url' => ''
				],
				'itch' => [
					'name' => 'Itch',
					'url' => ''
				]
			],
			'company' => [
				'nintendo' => [
					'name' => 'Nintendo',
					'url' => ''
				],
				'playstation' => [
					'name' => 'Playstation',
					'url' => ''
				],
				'xbox' => [
					'name' => 'Xbox',
					'url' => ''
				],
				'Windows' => [
					'name' => 'Windows',
					'url' => ''
				],
				'steam' => [
					'name' => 'Steam',
					'url' => ''
				],
				'android' => [
					'name' => 'Android',
					'url' => ''
				],
				'ios' => [
					'name' => 'IOS',
					'url' => ''
				]
			]
		);
		update_option('social', $social);
	endif;

	if(get_option('employee')):
		$employee = get_option('employee');
	else:
		$employee = array(
			[
				'image' => '',
				'name' => '',
				'position' => '',
				'Description' => ''
			]
		);
		update_option('employee', $employee);
	endif;

	if(get_option('spotlight')):
		$spotlight = get_option('spotlight');
	else:
		$spotlight = array();
		update_option('spotlight', $spotlight);
	endif;

	if(get_option('contact')):
		$contact = get_option('contact');
	else:
		$contact = array();
		update_option('contact', $contact);
	endif;



	add_settings_section(
		'theme-index-options',
		'Hero Settings',
		null,
		'theme-options'
	);

	add_settings_section(
		'theme-index-options',
		'Company Setting',
		null,
		'company-options'
	);

	add_settings_section(
		'theme-index-options',
		'Contact Setting',
		null,
		'contact-options'
	);

    add_settings_section(
		'theme-index-options',
		'Other Setting',
		null,
		'other-options'
	);

	add_settings_field(
		'hero-size',
		'Hero Size',
		'hero_size_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'hero-banner-items',
		'Hero Banner',
		'hero_banner_items_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'insight-items',
		'Insight',
		'hero_insight_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'featColumnSize-items',
		'Feat Columns Size',
		'feat_columns_size_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'featColumn-items',
		'Feat Columns',
		'feat_columns_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'newsletter-items',
		'Newsletter',
		'newsletter_callback',
		'theme-options',
		'theme-index-options'
	);

	add_settings_field(
		'social-items',
		'Social',
		'social_callback',
		'theme-options',
		'theme-index-options'
	);

	if(function_exists('the_ad_group')):
		add_settings_field(
			'ad-side-select',
			'Side Bar Ads',
			'ad_side_select_callback',
			'theme-options',
			'theme-index-options'
		);
	endif;

	add_settings_field(
		'insight_company',
		'Insight',
		'company_insight_callback',
		'company-options',
		'theme-index-options'
	);

	add_settings_field(
		'employee',
		'Employees',
		'employee_callback',
		'company-options',
		'theme-index-options'
	);

	add_settings_field(
		'spotlight',
		'Spotlight',
		'spotlight_callback',
		'company-options',
		'theme-index-options'
	);

	add_settings_field(
		'contact',
		'Contact',
		'contact_callback',
		'contact-options',
		'theme-index-options'
	);

	add_settings_field(
		'game_lock_icon',
		'Game Lock',
		'game_lock_callback',
		'other-options',
		'theme-index-options'
	);

	add_settings_field(
		'friends_list_init',
		'Friends List Init',
		'init_friends_list_button_callback',
		'other-options',
		'theme-index-options'
	);
}

function _themename_options_page(){ ?>
	<h1>Hero Settings</h1>
	<?php settings_errors(); ?>

	<form action="options.php" method="POST">
		<?php settings_fields('hero-option-group'); ?>
		<?php do_settings_sections('theme-options'); ?>
		<?php submit_button() ?>
	</form>

<?php }

function _themename_options_company_page(){ ?>
	<h1>Company Settings</h1>
	<?php settings_errors(); ?>

	<form action="options.php" method="POST">
		<?php settings_fields('company-option-group'); ?>
		<?php do_settings_sections('company-options'); ?>
		<?php submit_button() ?>
	</form>

<?php }

function _themename_options_contact_page(){ ?>
	<h1>Contact Settings</h1>
	<?php settings_errors(); ?>

	<form action="options.php" method="POST">
		<?php settings_fields('contact-option-group'); ?>
		<?php do_settings_sections('contact-options'); ?>
		<?php submit_button() ?>
	</form>

<?php }

function _themename_options_other_page(){ ?>
	<h1>Other Settings</h1>
	<?php settings_errors(); ?>

	<form action="options.php" method="POST">
		<?php settings_fields('other-option-group'); ?>
		<?php do_settings_sections('other-options'); ?>
		<?php submit_button() ?>
	</form>

<?php }

function hero_size_callback(){
	$heroMaxSize = 3;
	$heroSize = get_option('heroSize');
	?>
	<!--    <input type="text" name="heroSize" placeholder="Text" value="--><?php //echo $heroSize ?><!--">-->
	<select name="heroSize">
		<?php for($i = 1; $i <= $heroMaxSize; $i++): ?>
			<option value="<?php echo $i; ?>" <?php selected( $heroSize, $i ); ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
<?php }

function hero_banner_items_callback(){
	$heroSize = get_option('heroSize');
	$heroBanner = get_option('heroBanner');
	?>

	<ul class="heroBanner_list">
		<?php for($i = 1; $i <= $heroSize; $i++): ?>
			<li class="heroBanner_listItem" >

				<label for="profile-picture_<?php echo $i; ?>">
					<img class="heroBanner_img_<?php echo $i; ?>" src="<?php
					if(isset( $heroBanner['hero_'.$i]['img'] )):
						if(wp_http_validate_url(esc_url(wp_get_attachment_url($heroBanner['hero_'.$i]['img']), 'full', false, '' ))):
							echo esc_url(wp_get_attachment_url($heroBanner['hero_'.$i]['img']), 'full', false, '' );
						else:
							echo esc_url('https://placehold.jp/1920x1080.png');
						endif;
					else:
						echo esc_url('https://placehold.jp/1920x1080.png');
					endif;?>" value="Upload Profile Picture" id="upload-button_<?php echo $i ?>" />
				</label>
				<input id="profile-picture_<?php echo $i; ?>" name="heroBanner[hero_<?php echo $i; ?>][img]" value="<?php echo $heroBanner['hero_'.$i]['img'] ?>" />

				<input type="text" placeholder="Title" name="heroBanner[hero_<?php echo $i; ?>][title]" value="<?php echo $heroBanner['hero_'.$i]['title'] ?>">
				<textarea placeholder="Text Body" name="heroBanner[hero_<?php echo $i; ?>][body]" ><?php echo $heroBanner['hero_'.$i]['body'] ?></textarea>
				<input type="text" placeholder="Call to Action" name="heroBanner[hero_<?php echo $i; ?>][cta]" value="<?php echo $heroBanner['hero_'.$i]['cta'] ?>">
				<input type="url" placeholder="Url" name="heroBanner[hero_<?php echo $i; ?>][url]" value="<?php echo $heroBanner['hero_'.$i]['url'] ?>">
			</li>
		<?php endfor; ?>
	</ul>

<?php }

function hero_insight_callback(){
	$insight = get_option('insight');
	?>

	<div class="ghs_insight_wrapper">
		<label for="insight_bg">
			<img class="insight_img" src="<?php
			if(isset( $insight['img'] )):
				if(wp_http_validate_url(esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' ))):
					echo esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' );
				else:
					echo esc_url('https://placehold.jp/1920x1080.png');
				endif;
			else:
				echo esc_url('https://placehold.jp/1920x1080.png');
			endif;?>" value="Upload Profile Picture" id="insight_submit" />
		</label>
		<input id="insight_bg" class="insight_bg" name="insight[img]" value="<?php echo $insight['img'] ?>" />
		<input type="text"  name="insight[header]" value="<?php echo $insight['header'] ?>" placeholder="Header Title">
		<input type="text"  name="insight[title]" value="<?php echo $insight['title'] ?>" placeholder="Main Title">
		<textarea placeholder="Text Body" name="insight[body]" ><?php echo $insight['body'] ?></textarea>
	</div>

<?php }

function company_insight_callback(){
	$insight = get_option('insight_company');
	?>

	<div class="ghs_insight_wrapper">
		<label for="insight_bg">
			<img class="insight_img" src="<?php
			if(isset( $insight['img'] )):
				if(wp_http_validate_url(esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' ))):
					echo esc_url(wp_get_attachment_url($insight['img']), 'full', false, '' );
				else:
					echo esc_url('https://placehold.jp/1920x1080.png');
				endif;
			else:
				echo esc_url('https://placehold.jp/1920x1080.png');
			endif;?>" value="Upload Profile Picture" id="insight_submit" />
		</label>
		<input id="insight_bg" class="insight_bg" name="insight_company[img]" value="<?php echo $insight['img'] ?>" />
		<input type="text"  name="insight_company[header]" value="<?php echo $insight['header'] ?>" placeholder="Header Title">
		<input type="text"  name="insight_company[title]" value="<?php echo $insight['title'] ?>" placeholder="Main Title">
		<textarea placeholder="Text Body" name="insight_company[body]" ><?php echo $insight['body'] ?></textarea>
	</div>

<?php }

function feat_columns_size_callback(){
	$featColumnMaxSize = 3;
	$featColumn = get_option('featColumnSize');
	?>

	<select name="featColumnSize">
		<?php for($i = 1; $i <= $featColumnMaxSize; $i++): ?>
			<option value="<?php echo $i; ?>" <?php selected( $featColumn, $i ); ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
<?php }

function feat_columns_callback(){
	$featColumnSize = get_option('featColumnSize');
	$featColumn = get_option('featColumn');
	?>

	<ul class="featColumn_list">
		<?php for($i = 1; $i <= $featColumnSize; $i++): ?>
			<li class="ghs_feat_column" >

				<svg class="ghs_feat_column_preview" aria-hidden="true" focusable="false">
					<use href="<?php echo $featColumn['icon_'.$i] ?>"></use>
				</svg>
				<label for="featColumn[icon_<?php echo $i ?>]">
					<select class="ghs_feat_column_select_<?php echo $i ?> icon_select"></select>
				</label>
				<input value="<?php echo $featColumn['icon_'.$i] ?>" name="featColumn[icon_<?php echo $i ?>]" type="text" class="ghs_feat_column_icon">

				<input value="<?php echo $featColumn['title_'.$i] ?>" name="featColumn[title_<?php echo $i ?>]" type="text" class="ghs_feat_column_title" placeholder="Title">

				<textarea name="featColumn[desc_<?php echo $i ?>]" placeholder="Description"><?php echo $featColumn['desc_'.$i] ?></textarea>

				<input value="<?php echo $featColumn['link_text_'.$i] ?>" name="featColumn[link_text_<?php echo $i ?>]" type="text" class="ghs_feat_column_link_text" placeholder="Link Text">

				<input value="<?php echo $featColumn['link_'.$i] ?>" name="featColumn[link_<?php echo $i ?>]" type="url" class="ghs_feat_column_link" placeholder="Link">
			</li>
		<?php endfor; ?>
	</ul>

<?php }

function newsletter_callback(){
	$newsletter = get_option('newsletter');
	?>

	<textarea style="width: 35%" name="newsletter" placeholder="Newletter CTA"><?php echo $newsletter?></textarea>

<?php }

function social_callback(){
	$social = get_option('social');
	?>

	<textarea name="social[text]" placeholder="Footer Blurb"><?php echo $social['text'] ?></textarea>

	<div class="ghs_social">

		<!-- Social Links -->
		<div class="ghs_social_links">
			<h5>Social Links</h5>
			<?php foreach ($social['social'] as $s): ?>
				<input hidden value="<?php echo $s['name'] ?>" name="social[social][<?php echo $s['name'] ?>][name]" type="text" placeholder="<?php echo $s['name'] ?>">
				<input value="<?php echo $s['url'] ?>" name="social[social][<?php echo $s['name'] ?>][url]" type="url" placeholder="<?php echo $s['name'] ?>">
			<?php endforeach; ?>
		</div>

		<!-- Company Links -->
		<div class="ghs_company_links">
			<h5>Company Links</h5>
			<?php foreach ($social['company'] as $c): ?>
				<input hidden value="<?php echo $c['name'] ?>" name="social[company][<?php echo $c['name'] ?>][name]" type="text" placeholder="<?php echo $c['name'] ?>">
				<input value="<?php echo $c['url'] ?>" name="social[company][<?php echo $c['name'] ?>][url]" type="url" placeholder="<?php echo $c['name'] ?>">
			<?php endforeach; ?>
		</div>

	</div>
<?php }

function ad_side_select_callback(){
	if(function_exists('the_ad_group')):
		$ads = Advanced_Ads_Shortcode_Creator::items_for_select()['groups'];
	else:
		$ads = [];
	endif;
	$selected_ad = get_option('side_ad_select');
	?>

	<select name="side_ad_select" style="width: 100%;">
		<?php foreach($ads as $ad): ?>
			<option value="<?php echo explode('_', array_search($ad, $ads))[1]; ?>" <?php selected( $selected_ad, $ad ); ?>><?php echo $ad; ?></option>
		<?php endforeach; ?>
	</select>
<?php }

function employee_callback() {
	$employees = get_option('employee');?>

	<span class="ghs_add_button ghs_employee_add">
        &#43;
    </span>

	<ul class="ghs_employee_list">
		<?php foreach ($employees as $key => $em): ?>

			<li>
				<label for="insight_bg">
					<img class="insight_img" src="<?php
					if(isset( $em['image'] )):
						if(wp_http_validate_url(esc_url(wp_get_attachment_url($em['image']), 'full', false, '' ))):
							echo esc_url(wp_get_attachment_url($em['image']), 'full', false, '' );
						else:
							echo esc_url('https://placehold.jp/1920x1080.png');
						endif;
					else:
						echo esc_url('https://placehold.jp/1920x1080.png');
					endif;?>" value="Upload Profile Picture" id="insight_submit" />
				</label>
				<input id="insight_bg" class="insight_bg" name="employee[<?php echo $key ?>][image]" value="<?php echo $em['image'] ?>" />

				<input type="text"  name="employee[<?php echo $key ?>][name]" value="<?php echo $em['name'] ?>" placeholder="Name">
				<input type="text"  name="employee[<?php echo $key ?>][position]" value="<?php echo $em['position'] ?>" placeholder="Position">
				<textarea placeholder="Description" name="employee[<?php echo $key ?>][description]" ><?php echo $em['description'] ?></textarea>
				<span class="ghs_delete_button ghs_employee_delete"> X </span>
			</li>

		<?php endforeach; ?>
	</ul>

<?php }

function spotlight_callback(){
	$spotlight = get_option('spotlight');
	?>

	<span class="ghs_add_button ghs_spotlight_add">
        &#43;
    </span>

	<ul class="ghs_spotlight_list">
		<?php foreach ($spotlight as $key => $em): ?>

			<li>
				<label for="insight_bg">
					<img class="insight_img" src="<?php
					if(isset( $em['image'] )):
						if(wp_http_validate_url(esc_url(wp_get_attachment_url($em['image']), 'full', false, '' ))):
							echo esc_url(wp_get_attachment_url($em['image']), 'full', false, '' );
						else:
							echo esc_url('https://placehold.jp/1920x1080.png');
						endif;
					else:
						echo esc_url('https://placehold.jp/1920x1080.png');
					endif;?>" value="Upload Profile Picture" id="insight_submit" />
				</label>
				<input id="insight_bg" class="insight_bg" name="spotlight[<?php echo $key ?>][image]" value="<?php echo $em['image'] ?>" />

				<input type="text"  name="spotlight[<?php echo $key ?>][topTitle]" value="<?php echo $em['topTitle'] ?>" placeholder="Top Title">
				<textarea placeholder="Description" name="spotlight[<?php echo $key ?>][topDescription]" ><?php echo $em['topDescription'] ?></textarea>

				<input type="text"  name="spotlight[<?php echo $key ?>][bottomTitle]" value="<?php echo $em['bottomTitle'] ?>" placeholder="Bottom Title">
				<textarea placeholder="Description" name="spotlight[<?php echo $key ?>][bottomDescription]" ><?php echo $em['bottomDescription'] ?></textarea>
				<span class="ghs_delete_button ghs_employee_delete"> X </span>
			</li>

		<?php endforeach; ?>
	</ul>

	<?php
}

function contact_callback(){
	$contact = get_option('contact');
	?>

	<div class="contact-group">
		<input type="email" name="contact[general]" value="<?php echo $contact['general'] ?>" placeholder="General Email">
		<input type="email" name="contact[support]" value="<?php echo $contact['support'] ?>" placeholder="Support Email">
		<input type="email" name="contact[career]" value="<?php echo $contact['career'] ?>" placeholder="Career Email">
	</div>

	<div class="contact-group">
		<input type="text" name="contact[address][name]" value="<?php echo $contact['address']['name'] ?>" placeholder="Name">
		<input type="text" name="contact[address][address_1]" value="<?php echo $contact['address']['address_1'] ?>" placeholder="Address">
		<input type="text" name="contact[address][address_2]" value="<?php echo $contact['address']['address_2'] ?>" placeholder="Address 2">
		<input type="text" name="contact[address][city]" value="<?php echo $contact['address']['city'] ?>" placeholder="City">
		<input type="text" name="contact[address][state]" value="<?php echo $contact['address']['state'] ?>" placeholder="State">
		<input type="text" name="contact[address][zip]" value="<?php echo $contact['address']['zip'] ?>" placeholder="Zip">
	</div>

	<div class="contact-group">
		<input type="number" name="contact[phone]" value="<?php echo $contact['phone'] ?>" placeholder="Phone">
	</div>

	<?php
}

function game_lock_callback(){
	$game_icon = get_option('game_lock_icon');
	?>

	<div class="ghs_insight_wrapper game_lock_icon_wrapper">
		<label for="insight_bg">
			<img class="insight_img" src="<?php
			if(isset( $game_icon )):
				if(wp_http_validate_url(esc_url(wp_get_attachment_url($game_icon), 'full', false, '' ))):
					echo esc_url(wp_get_attachment_url($game_icon), 'full', false, '' );
				else:
					echo esc_url('https://placehold.jp/1920x1080.png');
				endif;
			else:
				echo esc_url('https://placehold.jp/1920x1080.png');
			endif;?>" value="Upload Profile Picture" id="insight_submit" />
		</label>
        <input id="insight_bg" class="insight_bg" name="game_lock_icon" value="<?php echo $game_icon ?>" />
	</div>


	<?php
}

function init_friends_list_button_callback(){ ?>

    <div class="ghs_button">
        Run
    </div>

    <?php
}

function _themename_admin_page(){
	add_menu_page(
		'Home Page Settings',
		'Theme Settings',
		'manage_options',
		'theme-options',
		'_themename_options_page',
		'dashicons-admin-generic',
		100
	);

	add_submenu_page(
		'theme-options',
		'Company Page Settings',
		'Company Page Settings',
		'manage_options',
		'company-options',
		'_themename_options_company_page'
	);

	add_submenu_page(
		'theme-options',
		'Contact Page Settings',
		'Contact Page Settings',
		'manage_options',
		'contact-options',
		'_themename_options_contact_page'
	);

	add_submenu_page(
		'theme-options',
		'Other Settings',
		'Other Settings',
		'manage_options',
		'other-options',
		'_themename_options_other_page'
	);
}

function _themename_save_postdata($post_id){
	if(array_key_exists('game_rating_field', $_POST)){
		update_post_meta(
			$post_id,
			'game_rating',
			$_POST['game_rating_field']
		);
	}

	if(array_key_exists('game_release_field', $_POST)){
		update_post_meta(
			$post_id,
			'game_release',
			$_POST['game_release_field']
		);
	}

	if(array_key_exists('game_publisher_field', $_POST)){
		update_post_meta(
			$post_id,
			'game_publisher',
			$_POST['game_publisher_field']
		);
	}

	if(array_key_exists('game_size_field', $_POST)){
		update_post_meta(
			$post_id,
			'game_size',
			$_POST['game_size_field']
		);
	}

	if(array_key_exists('game_platform', $_POST)){
		update_post_meta(
			$post_id,
			'game_platform',
			$_POST['game_platform']
		);
	}
}

function game_rating_meta_box($post){
	if(get_post_meta($post->ID, 'game_rating', true)):
		$value = get_post_meta($post->ID, 'game_rating', true);
	else:
		$value = 'RP';
	endif;
	?>

	<select name="game_rating_field" id="game_rating_field" class="ghs_game_rating">
		<?php foreach (GHS_ESRB_RATINGS as $rating): ?>
			<option value="<?php echo $rating['Rating'] ?>" <?php selected($value, $rating['Rating']) ?>><?php echo $rating['Name'] ?></option>
		<?php endforeach; ?>
	</select>

	<?php
}

function game_release_meta_box($post){
	$value = get_post_meta($post->ID, 'game_release', true);
	?>

	<input type="date" id="game_release_field" name="game_release_field" value="<?php echo $value ?>">

	<?php
}

function game_publisher_meta_box($post){
	$value = get_post_meta($post->ID, 'game_publisher', true);
	?>

	<input type="text" name="game_publisher_field" id="game_publisher_field" value="<?php echo $value?>">

	<?php
}

function game_size_meta_box($post){
	$value = get_post_meta($post->ID, 'game_size', true);
	?>

	<input type="text" name="game_size_field" id="game_size_field" value="<?php echo $value ?>">

	<?php
}

function game_platform_meta_box($post){
	if(get_post_meta($post->ID, 'game_platform', true)):
		$value = get_post_meta($post->ID, 'game_platform', true);
	else:
		$value = [
			'company' => [
				'nintendo' => [
					'name' => 'Nintendo',
					'url' => ''
				],
				'playstation' => [
					'name' => 'Playstation',
					'url' => ''
				],
				'xbox' => [
					'name' => 'Xbox',
					'url' => ''
				],
				'Windows' => [
					'name' => 'Windows',
					'url' => ''
				],
				'steam' => [
					'name' => 'Steam',
					'url' => ''
				],
				'android' => [
					'name' => 'Android',
					'url' => ''
				],
				'ios' => [
					'name' => 'IOS',
					'url' => ''
				]
			]
		];
	endif;

	foreach ($value['company'] as $c):
		?>
		<input hidden value="<?php echo $c['name'] ?>" name="game_platform[company][<?php echo $c['name'] ?>][name]" type="text" placeholder="<?php echo $c['name'] ?>">
		<input style="margin-bottom: .5rem; width: 100%;" value="<?php echo $c['url'] ?>" name="game_platform[company][<?php echo $c['name'] ?>][url]" type="url" placeholder="<?php echo $c['name'] ?>">
	<?php
	endforeach;
}

function _themename_meta_boxes(){

	add_meta_box('game_rating', 'Game Rating', 'game_rating_meta_box', 'games', 'side');
	add_meta_box('game_release', 'Game Release', 'game_release_meta_box', 'games', 'side');
	add_meta_box('game_publisher', 'Game Publisher', 'game_publisher_meta_box', 'games', 'side');
	add_meta_box('game_size', 'Game Size', 'game_size_meta_box', 'games', 'side');
	add_meta_box('game_platform_links', 'Game Platforms', 'game_platform_meta_box', 'games', 'side');

}

function _themename_admin_init_friends_list(){
}

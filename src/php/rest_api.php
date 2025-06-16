<?php

function _themename_disable_wp_api(){
	add_filter( 'rest_authentication_errors', function( $access ){
		if ( ! is_user_logged_in() ) {
			$access = new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', [ 'status' => 401 ] );
		}

		return $access;
	} );

	// also remove actions added by wp-includes/default-filters.php
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'template_redirect', 'rest_output_link_header' );
}

//Rest API
function _themename_restapi_schema(){
	$schema = [
		'$schema' => "http://json-schema.org/draft-04/schema#",
		'title' => '',
		'type' => 'object',
		'property' => [
		]
	];

	return $schema;
}

function _themename_rest_api_init(){
	register_rest_route('_restroute', 'test', [
		'methods' => 'POST',
		'callback' => '_themename_restapi_test',
		'permission_callback' => '_themename_permissions',
		'args' => [
			'args1' => [
				'required'          => true,
				'default'           => "test",
				'validate_callback' => function($param, $request, $key){
					return !is_numeric($param);
				}
			]
		],
		'schema' => '_themename_restapi_schema'
	]);

	register_rest_route('_restroute', 'add-user-game-badge-list', [
		'methods' => 'POST',
		'callback' => '_themename_restapi_add_badge_init_for_user',
		'permission_callback' => '_themename_permissions',
		'args' => [
			'game_id' => [
				'required'          => true,
				'validate_callback' => function($param, $request, $key){
					return is_numeric($param);
				}
			]
		],
	]);

    register_rest_route('_restroute', 'add-user-to-friends-list', [
        'methods' => 'POST',
        'callback' => '_themename_restapi_add_user_to_friends_list',
        'permission_callback' => function($request){
		 return current_user_can('manage_options');
        },
        'args' => [
            'friend_ID' => [
                'required'          => true,
                'validate_callback' => function($param, $request, $key){
                    return is_numeric($param);
                }
            ]
        ],
    ]);

	register_rest_route('_restroute', 'friends-list-init', [
		'methods' => 'POST',
		'callback' => '_themename_restapi_friends_list_init',
		'args' => [
		],
	]);

	register_rest_route('_restroute', 'delete-user-account', [
        'methods' => 'POST',
        'callback' => '_themename_restapi_delete_user',
        'permission_callback' => '_themename_permissions',
        'args' => [
            'id' => [
                'required'          => true,
                'validate_callback' => function($param, $request, $key){
                    return is_numeric($param);
                }
            ]
        ],
    ]);

}

// Rest EndPoint Functions
function _themename_restapi_test(WP_REST_Request $request){
	if(!empty($request->get_param('args1'))):
		return rest_ensure_response(['data' => 'test']);
	else:
		return new WP_Error('ghs_test_404', 'No data found!',
			[
				'status' => 404,
				'test' => 'test'
			]);
	endif;
}

function _themename_restapi_add_badge_init_for_user(WP_REST_Request $request){
	$userData = [
		'ID' => get_current_user_id(),
		'gameID' => absint($request->get_param('game_id'))
	];

	if(!empty($userData['ID']) && !empty($userData['gameID'])):


		return rest_ensure_response(['data' => [
			'ID' => $userData['ID'],
			'gameID' => $userData['gameID']
		]]);
	else:
		return new WP_Error('ghs_badge_add_404', 'No data found!',
			[
				'status' => 404,
				'data' => 'Failed to add ' . $userData['ID'] . ' badge list for' . $userData['gameID']
			]);
	endif;
}

function _themename_restapi_add_user_to_friends_list(WP_REST_Request $request){
    $data = [
		'success' => false
    ];

	$userData = [
        'ID' => get_current_user_id(),
        'friendID' => sanitize_text_field(absint($request->get_param('friend_ID')))
    ];

	$data['success'] = $userData['ID'] != 0;

	if($data['success']) {

		_themename_add_send_friends_list($userData['ID'], $userData['friendID']);
		$data['Message'] = "Friend request was sent!";
	}

	return $data;
}

function _themename_restapi_delete_user(WP_REST_Request $request){
	$userData = [
		'ID' => get_current_user_id()
	];

	if(!empty($userData['ID'])):


		return rest_ensure_response(['data' => [
			'ID' => $userData['ID'],
		]]);
	else:
		return new WP_Error('ghs_delete_account_404', 'No data found!',
			[
				'status' => 404,
				'data' => 'Failed to delete ' . $userData['ID']
			]);
	endif;
}

//_themename_disable_wp_api();
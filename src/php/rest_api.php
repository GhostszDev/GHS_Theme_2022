<?php

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
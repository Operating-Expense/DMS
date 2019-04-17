<?php

namespace DMS\Controller;

use DMS\DMS_API\DMS_API_Manager;



class DMS_API {
	
	
	
	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {
		
		// API user registration
		add_filter( 'dms/user_registration/api_process', [ DMS_API_Manager::class, 'user_registration' ], 10, 3 );
		
		// receive and save token after user registration
		add_action( 'dms/user_registration/after', [ DMS_API_Manager::class, 'user_save_api_token' ], 10, 2 );
		
		// receive and save user data after user registration
		add_action( 'dms/user_registration/after', [ DMS_API_Manager::class, 'user_save_api_data' ], 10, 2 );
		
		// receive and save token after user signin
		add_action( 'dms/user_signin/after', [ DMS_API_Manager::class, 'user_save_api_token' ], 10, 1 );
		
		// receive and save user data after user signin
		add_action( 'dms/user_signin/after', [ DMS_API_Manager::class, 'user_save_api_data' ], 10, 1 );
		
		// api search
		add_action( 'wp_ajax_' . 'dms/api_search/field/first', [ DMS_API_Manager::class, 'search_first' ] );
		add_action( 'wp_ajax_' . 'dms/api_search/field/middle', [ DMS_API_Manager::class, 'search_middle' ] );
		add_action( 'wp_ajax_' . 'dms/api_search/field/city', [ DMS_API_Manager::class, 'search_city' ] );
		add_action( 'wp_ajax_' . 'dms/api_search/field/street', [ DMS_API_Manager::class, 'search_street' ] );
		add_action( 'wp_ajax_' . 'dms/api_search/field/house', [ DMS_API_Manager::class, 'search_house' ] );
		
		// limit results
		add_action( 'dms/api_search/fields/data', [ DMS_API_Manager::class, 'search_all_fields_limit' ], 10, 1 );
		
		// escape results
		add_action( 'dms/api_search/fields/data', [ DMS_API_Manager::class, 'search_all_fields_esc' ], 20, 1 );
		
	}
	
	
}
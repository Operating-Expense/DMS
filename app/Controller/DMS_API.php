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
		add_filter( 'dms/user_registration/api_process', array( DMS_API_Manager::class, 'user_registration' ), 10, 3 );
		
		// receive and save token after user registration
		add_action( 'dms/user_registration/after', array( DMS_API_Manager::class, 'user_save_api_token' ), 10, 2 );
		
		// receive and save user data after user registration
		add_action( 'dms/user_registration/after', array( DMS_API_Manager::class, 'user_save_api_data' ), 10, 2 );
		
		// receive and save token after user signin
		add_action( 'dms/user_signin/after', array( DMS_API_Manager::class, 'user_save_api_token' ), 10, 1 );
		
		// receive and save user data after user signin
		add_action( 'dms/user_signin/after', array( DMS_API_Manager::class, 'user_save_api_data' ), 10, 1 );
		
		// api search
		add_action( 'wp_ajax_' . 'dms/api_search/field/first', array(  DMS_API_Manager::class, 'search_first' ) );
		
		
	}
	
	
}
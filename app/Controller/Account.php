<?php

namespace DMS\Controller;

use DMS\Helper\DMS_API_Request;
use DMS\Helper\Utils;
use DMS\Helper\Logger;
use DMS\Exception\DMS_Exeption;




class Account {
	
	
	public static $err_codes = [
		777100 => 'ERR_REG__CURL_ERROR',
		777210 => 'ERR_REG__ALREADY_EXISTS',
		777220 => 'ERR_REG__INVALID_EMAIL',
		777230 => 'ERR_REG__INVALID_PASSWORD',
		777240 => 'ERR_REG__UNKNOWN',
		777300 => 'ERR_REG__EMPTY_RESPONSE',
		777400 => 'ERR_TOKEN__UNKNOWN',
		777410 => 'ERR_TOKEN__INVALID_GRANT',
		777500 => 'ERR_USER__UNKNOWN',
		777510 => 'ERR_USER__ACCESS_DENIED',
	];
	
	// !!! Don't change this values
	public static $api_fields = [
		'token' => [   // api_key => part_of_meta_key
			'access_token' => 'access_token', 
			'token_type'   => 'token_type',
			'expires_in'   => 'expires_in',
			'userName'     => 'user_name',
			'.issued'      => 'issued',
			'.expires'     => 'expires',
		],
		'data'  => [
			'UserID'             => 'user_id',
			'Name'               => 'name',
			'DateInsert'         => 'date_insert',
			'IsActive'           => 'is_active',
			'Balance'            => 'balance',
			'LastTransationDate' => 'last_transation_date',
		],
	];
	
	
	
	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {
		
		if ( wp_doing_ajax() ) {
			
			// user signin
			add_action( 'wp_ajax_' . 'dms/account/user_signin', array( __CLASS__, 'user_signin' ) );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_signin', array( __CLASS__, 'user_signin' ) );
			
			// check is_user_email_exists
			add_action( 'wp_ajax_' . 'dms/account/is_user_email_exists', array( __CLASS__, 'is_user_email_exists' ) );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/is_user_email_exists', array( __CLASS__, 'is_user_email_exists' ) );
			
			// user registration
			add_action( 'wp_ajax_' . 'dms/account/user_registration', array( __CLASS__, 'user_registration' ) );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_registration', array( __CLASS__, 'user_registration' ) );
			
			// user forgot password
			add_action( 'wp_ajax_' . 'dms/account/user_forgot', array( __CLASS__, 'user_forgot' ) );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_forgot', array( __CLASS__, 'user_forgot' ) );
			
		}
		
		// redirect after password reset
		add_action( 'after_password_reset', array( __CLASS__, 'after_password_reset_redirect' ), 77 );
		
		// receive and save token after user registration
		add_action( 'dms/user_registration/after', array( __CLASS__, 'user_save_api_token' ), 10, 2 );
		
		// receive and save user data after user registration
		add_action( 'dms/user_registration/after', array( __CLASS__, 'user_save_api_data' ), 10, 2 );
		
		// receive and save token after user signin
		add_action( 'dms/user_signin/after', array( __CLASS__, 'user_save_api_token' ), 10, 1 );
		
		// receive and save user data after user signin
		add_action( 'dms/user_signin/after', array( __CLASS__, 'user_save_api_data' ), 10, 1 );
	}
	
	
	
	public static function user_signin(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		$form_data = [];
		parse_str( $_POST['form_data'], $form_data );
		
		// data
		$user_email = ! empty( $form_data['email'] ) ? trim( $form_data['email'] ) : '';
		$user_pass  = ! empty( $form_data['pass'] ) ? $form_data['pass'] : '';
		
		// checks
		$user         = wp_authenticate( $user_email, $user_pass );
		$redirect_url = esc_url( home_url( '/account' ) );
		do_action( 'dms/user_signin/before', $user );
		
		if ( ! is_wp_error( $user ) && self::user_signin_process( $user ) ) {
			
			do_action( 'dms/user_signin/after', $user );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $user->ID,
				'error_html' => '',
				'redirect'   => $redirect_url,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : authenticate error',
			'user_id'    => 0,
			'error_html' => __( 'Ошибка входа, введите правельный e-mail и пароль', 'dms' ),
			'redirect'   => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	private static function user_signin_process( $user ): bool {
		
		if ( ! ( $user instanceof \WP_User ) ) {
			return false;
		}
		
		if ( is_user_logged_in() ) {
			wp_logout();
		}
		
		clean_user_cache( $user->ID );
		wp_clear_auth_cookie();
		
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true );
		
		update_user_caches( $user );
		
		if ( is_user_logged_in() ) {
			return true;
		}
		
		return false;
	}
	
	
	
	public static function is_user_email_exists(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() || email_exists( $_POST['email'] ) ) {
			die( 'false' );
		}
		die( 'true' );
	}
	
	
	
	public static function user_registration(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		$form_data = [];
		parse_str( $_POST['form_data'], $form_data );
		
		// data
		$user_email = ! empty( $form_data['email'] ) ? trim( $form_data['email'] ) : '';
		$user_pass1 = ! empty( $form_data['pass1'] ) ? $form_data['pass1'] : '';
		$user_pass2 = ! empty( $form_data['pass2'] ) ? $form_data['pass2'] : '';
		
		$user_fio             = ! empty( trim( $form_data['fio'] ) ) ? trim( $form_data['fio'] ) : '';
		$user_position        = ! empty( trim( $form_data['position'] ) ) ? trim( $form_data['position'] ) : '';
		$user_company_name    = ! empty( trim( $form_data['company_name'] ) ) ? trim( $form_data['company_name'] ) : '';
		$user_company_address = ! empty( trim( $form_data['company_address'] ) ) ? trim( $form_data['company_address'] ) : '';
		$user_phone           = ! empty( trim( $form_data['phone'] ) ) ? trim( $form_data['phone'] ) : '';
		$user_reg_code        = ! empty( trim( $form_data['reg_code'] ) ) ? (int) trim( $form_data['reg_code'] ) : '';
		
		
		// checks for wp
		if ( ! is_email( $user_email ) ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : некорректный e-mail', 'dms' ) );
		}
		
		if ( $user_pass1 !== $user_pass2 || mb_strlen( $user_pass1 ) < 8 ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : некорректный пароль', 'dms' ) );
		}
		
		if ( ! $user_fio ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "ФИО"', 'dms' ) );
		}
		
		if ( ! $user_position ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "Должность"', 'dms' ) );
		}
		
		if ( ! $user_company_name ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "Название компании"', 'dms' ) );
		}
		
		if ( ! $user_company_address ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "Юр. адрес"', 'dms' ) );
		}
		
		if ( ! $user_phone ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "Телефон"', 'dms' ) );
		}
		
		if ( ! $user_reg_code ) {
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации : пустое поле "ЕГРПОУ"', 'dms' ) );
		}
		
		// try to register via API
		$api__register_user_process = self::api__register_user( $user_email, $user_pass1 );
		
		if ( ! $api__register_user_process['success'] ) {
			
			Logger::log( "RESOLVE : ERROR [email({$user_email})]", '', 'user_registration' );
			
			self::_user_reg__send_valid_error(
				__( 'Ошибка регистрации', 'dms' ) . ' : ' . $api__register_user_process['message_front'],
				$api__register_user_process['message']
			);
			/*
			if ( $api__register_user_process['error_code'] === self::get_error_code( 'ERR_REG__ALREADY_EXISTS' ) ) {
				Logger::log( "RESOLVE : SUCCESS [email({$user_email})]", '', 'user_registration' );
			} else {
				Logger::log( "RESOLVE : ERROR [email({$user_email})]", '', 'user_registration' );
				
				self::_user_reg__send_valid_error(
					__( 'Ошибка регистрации', 'dms' ) . ' : ' . $api__register_user_process['message_front'],
					$api__register_user_process['message']
				);
			} */
		}
		
		// fill data
		$user_data               = [];
		$user_data['user_login'] = sanitize_user( $user_email );
		$user_data['first_name'] = $user_fio;
		$user_data['last_name']  = '';
		$user_data['user_email'] = sanitize_email( $user_email );
		$user_data['user_pass']  = $user_pass1;
		$user_data['role']       = 'subscriber';
		
		do_action( 'dms/user_registration/before', $user_data );
		
		if ( is_wp_error( $user_id = wp_insert_user( $user_data ) ) ) {
			Logger::log( "WP : ERROR [email({$user_email})]", '', 'user_registration' );
			self::_user_reg__send_valid_error( __( 'Ошибка регистрации', 'dms' ), $user_id->get_error_message() );
		}
		
		// update user meta
		Utils::set_user_meta( $user_id, 'dms--user_position', $user_position );
		Utils::set_user_meta( $user_id, 'dms--user_company_name', $user_company_name );
		Utils::set_user_meta( $user_id, 'dms--user_company_address', $user_company_address );
		Utils::set_user_meta( $user_id, 'dms--user_phone', $user_phone );
		Utils::set_user_meta( $user_id, 'dms--user_reg_code', $user_reg_code );
		self::set_api_pass( $user_id, $user_pass1 );
		
		self::user_signin_process( get_user_by( 'id', $user_id ) );
		
		Logger::log(
			"WP : SUCCESS [email({$user_email}), user_id({$user_id}), first_name({$user_data['first_name']})]",
			'', 'user_registration'
		);
		
		do_action( 'dms/user_registration/after', $user_id, $user_data );
		
		$redirect_url = add_query_arg( array( 'created_account' => 'true' ), esc_url( home_url( '/account' ) ) );
		
		wp_send_json_success( [
			'message'    => __FUNCTION__ . ' : success',
			'user_id'    => $user_id,
			'error_html' => '',
			'redirect'   => $redirect_url,
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	private static function _user_reg__send_valid_error( $error_html, $message = '' ): void {
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : user registration error. ' . $message,
			'user_id'    => 0,
			'error_html' => $error_html,
			'redirect'   => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function get_api_pass( int $user_id ): string {
		return base64_decode( get_user_meta( $user_id, '_dms--user_api_pass', true ) );
	}
	
	
	
	public static function set_api_pass( int $user_id, string $value ): void {
		update_user_meta( $user_id, '_dms--user_api_pass', base64_encode( $value ) );
	}
	
	
	public static function get_saved_api_access_token( int $user_id ): string {
		return get_user_meta( $user_id, '_dms--user_api_token__access_token', true );
	}
	
	
	
	private static function api__register_user( string $user_email, string $user_pass ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => 'http://217.147.161.26:2660/api/Account/Register',
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS    => "{\n\"Email\": \"{$user_email}\",\n\"Password\": \"{$user_pass}\",\n\"ConfirmPassword\": \"{$user_pass}\"\n}",
			];
			
			$request->init( $options );
			$res = $request->exec();
			
			
			// error cURL
			if ( $res['curl_error'] ) {
				throw new DMS_Exeption(
					$res['curl_error'],
					self::get_error_code( 'ERR_REG__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			// error e-mail already taken
			if (
				$res['http_code'] === 400
				&&
				! empty( $response_message = $res['body']['ModelState'][''][1] )
				&&
				strpos( $response_message, 'Email' ) !== false
				&&
				strpos( $response_message, 'already taken' ) !== false
			) {
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_message}",
					self::get_error_code( 'ERR_REG__ALREADY_EXISTS' ),
					null,
					$response_message
				);
			}
			
			
			// error e-mail invalid
			if (
				$res['http_code'] === 400
				&&
				! empty( $response_message = $res['body']['ModelState'][''][0] )
				&&
				strpos( $response_message, 'Email' ) !== false
				&&
				strpos( $response_message, 'is invalid' ) !== false
			) {
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_message}",
					self::get_error_code( 'ERR_REG__INVALID_EMAIL' ),
					null,
					$response_message
				);
			}
			
			
			// error pass
			if (
				$res['http_code'] === 400
				&&
				! empty( $response_message = $res['body']['ModelState'][''][0] )
				&&
				strpos( $response_message, 'Password' ) !== false
			) {
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_message}",
					self::get_error_code( 'ERR_REG__INVALID_PASSWORD' ),
					null,
					$response_message
				);
			}
			
			// error unknown error by http code not 200
			if ( $res['http_code'] !== 200 ) {
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}",
					self::get_error_code( 'ERR_REG__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			Logger::log( "API: ERROR [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}", '', 'user_registration' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})]", '', 'user_registration' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
		];
	}
	
	
	
	
	/**
	 * @param $user mixed   \WP_User object or user ID
	 *
	 * @return void
	 */
	public static function user_save_api_token( $user ): void {
		
		$user = ( $user instanceof \WP_User ) ? $user : \get_user_by( 'ID', $user );
		
		$user_email = $user->user_email;
		$user_pass  = self::get_api_pass( $user->ID );
		
		// try to get token for the user
		$api_process = self::api__get_token( $user_email, $user_pass );
		
		// update meta fields
		self::update_user_fields_by_api( $user, 'token', $api_process['data'] );
		
	}
	
	
	
	public static function update_user_fields_by_api( \WP_User $user, string $context, array $data ): void {
		foreach ( self::$api_fields[ $context ] as $field_api => $field_meta ) {
			if ( ! empty( $data[ $field_api ] ) ) {
				update_user_meta( $user->ID, "_dms--user_api_{$context}__{$field_meta}", $data[ $field_api ] );
			}
		}
	}
	
	
	
	public static function api__get_token( $user_email, $user_pass, $grant_type = 'password' ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => 'http://217.147.161.26:2660/Token',
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS    => "username={$user_email}&password={$user_pass}&grant_type={$grant_type}",
				CURLOPT_HTTPHEADER    => [
					'Content-Type: application/x-www-form-urlencoded',
				],
			];
			
			$request->init( $options );
			$res = $request->exec();
			
			
			// error cURL
			if ( $res['curl_error'] ) {
				throw new DMS_Exeption(
					$res['curl_error'],
					self::get_error_code( 'ERR_REG__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			// error 
			if ( $res['http_code'] !== 200 ) {
				
				$response_error      = ! empty( $res['body']['error'] ) ? $res['body']['error'] : '';
				$response_error_desc = ! empty( $res['body']['error_description'] ) ? $res['body']['error_description'] : '';
				
				$err_name      = $response_error === 'invalid_grant' ? 'ERR_TOKEN__INVALID_GRANT' : 'ERR_TOKEN__UNKNOWN';
				$err_for_front = $response_error === 'invalid_grant' ? __( 'ошибка доступа', 'dms' ) : __( 'неизвестная ошибка', 'dms' );
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error}; {$response_error_desc}",
					self::get_error_code( $err_name ),
					null,
					$err_for_front
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			Logger::log( "API: ERROR [email({$user_email})] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}", '', 'user_get_token' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})]", '', 'user_get_token' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	
	
	/**
	 * @param $user mixed   \WP_User object or user ID
	 *
	 * @return void
	 */
	public static function user_save_api_data( $user ): void {
		
		$user = ( $user instanceof \WP_User ) ? $user : \get_user_by( 'ID', $user );
		
		$user_email = $user->user_email;
		$user_token = self::get_saved_api_access_token( $user->ID );
		
		// try to get api data for the user
		$api_process = self::api__get_data( $user_email, $user_token );
		
		// update meta fields
		self::update_user_fields_by_api( $user, 'data', $api_process['data'] );
	}
	
	
	
	public static function api__get_data( string $user_email, string $token ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => 'http://217.147.161.26:2660/api/Users',
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER    => [
					'Content-Type: application/json',
					"Authorization: Bearer {$token}",
				],
			];
			
			$request->init( $options );
			$res = $request->exec();
			
			
			// error cURL
			if ( $res['curl_error'] ) {
				throw new DMS_Exeption(
					$res['curl_error'],
					self::get_error_code( 'ERR_REG__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			// error 
			if ( $res['http_code'] !== 200 ) {
				// "Message": "Authorization has been denied for this request."
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				$err_name      = $response_error === 'Authorization has been denied for this request.'
					? 'ERR_USER__ACCESS_DENIED' : 'ERR_USER__UNKNOWN';
				$err_for_front = $response_error === 'Authorization has been denied for this request.'
					? __( 'ошибка доступа', 'dms' ) : __( 'неизвестная ошибка', 'dms' );
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( $err_name ),
					null,
					$err_for_front
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			Logger::log( "API: ERROR [email({$user_email})] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}", '', 'user_get_data' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . "] : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})]", '', 'user_get_data' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => self::get_curr_user_data( $user_email, $res['body'] ),
		];
	}
	
	
	
	public static function get_curr_user_data( $user_email, $response_data ) {
		foreach ( $response_data as $item_user_data ) {
			if ( $item_user_data['Name'] === $user_email ) {
				return $item_user_data;
			}
		}
		
		return $response_data[0];
	}
	
	
	
	public static function get_error_code( $error_name ) {
		return array_search( $error_name, self::$err_codes, true );
	}
	
	
	
	
	public static function get_error_name( $error_code ) {
		return ! empty( self::$err_codes[ $error_code ] ) ? self::$err_codes[ $error_code ] : false;
	}
	
	
	
	public static function user_forgot(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		$form_data = [];
		parse_str( $_POST['form_data'], $form_data );
		
		// data
		$user_email = ! empty( $form_data['email'] ) ? trim( $form_data['email'] ) : '';
		
		// checks
		if ( ! is_email( $user_email ) || ! ( $user = get_user_by( 'email', $user_email ) ) ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : user forgot error : is not email passed ',
				'user_id'    => 0,
				'error_html' => __( 'Ошибка : неверный e-mail ', 'dms' ),
				'redirect'   => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		do_action( 'dms/user_before_send_password_reset_mail', $user );
		
		self::send_password_reset_mail( $user );
		
		$redirect_url = esc_url( home_url( '/account' ) );
		
		wp_send_json_success( [
			'message'    => __FUNCTION__ . ' : success',
			'user_id'    => $user->ID,
			'error_html' => '',
			'redirect'   => $redirect_url,
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function send_password_reset_mail( $user ) {
		
		if ( ! ( $user instanceof \WP_User ) ) {
			return false;
		}
		
		$firstname  = $user->first_name;
		$email      = $user->user_email;
		$user_login = $user->user_login;
		$adt_rp_key = get_password_reset_key( $user );
		
		if ( is_wp_error( $adt_rp_key ) ) {
			return false;
		}
		
		$rp_link = network_site_url( "wp-login.php?action=rp&key={$adt_rp_key}&login=" . rawurlencode( $user_login ), 'login' );
		
		$rp_link_html = "<a href=\"{$rp_link}\">{$rp_link}</a>";
		
		if ( $firstname === '' ) {
			$firstname = 'User';
		}
		$message = sprintf( __( 'Hi %1s!<br>', 'dms' ), $firstname );
		$message .= sprintf( __( 'An account has been created on %1s for email address %2s<br>', 'dms' ), get_bloginfo( 'name' ), $email );
		$message .= __( 'Click here to set the password for your account: <br>', 'dms' );
		$message .= $rp_link_html . '<br>';
		
		$subject    = sprintf( __( 'Your account on %1s', 'dms' ), get_bloginfo( 'name' ) );
		$headers    = array();
		$email_from = get_option( 'admin_email' );
		
		add_filter( 'wp_mail_content_type', function ( $content_type ) { return 'text/html'; } );
		$headers[] = 'From: DM Solutions <' . $email_from . '>' . "\r\n";
		wp_mail( $email, $subject, $message, $headers );
		
		// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
		remove_filter( 'wp_mail_content_type', function ( $content_type ) { return 'text/html'; } );
	}
	
	
	
	public static function after_password_reset_redirect() {
		wp_redirect( home_url() );
		exit;
	}
	
	
}

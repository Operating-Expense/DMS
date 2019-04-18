<?php

namespace DMS\DMS_API;

use DMS\Helper\Logger;
use DMS\Exception\DMS_Exeption;


class DMS_API_Process {
	
	
	public static $err_codes = [
		777100 => 'ERR__CURL_ERROR',
		
		777210 => 'ERR_REG__ALREADY_EXISTS',
		777220 => 'ERR_REG__INVALID_EMAIL',
		777230 => 'ERR_REG__INVALID_PASSWORD',
		777240 => 'ERR_REG__UNKNOWN',
		
		777400 => 'ERR_TOKEN__UNKNOWN',
		777410 => 'ERR_TOKEN__INVALID_GRANT',
		
		777500 => 'ERR_USER__UNKNOWN',
		777510 => 'ERR_USER__ACCESS_DENIED',
		
		777610 => 'ERR_SEARCH_FIRST__UNKNOWN',
		777611 => 'ERR_SEARCH_FIRST__ACCESS_DENIED',
		
		777630 => 'ERR_SEARCH_MIDDLE__UNKNOWN',
		777631 => 'ERR_SEARCH_MIDDLE__ACCESS_DENIED',
		
		777650 => 'ERR_SEARCH_CITY__UNKNOWN',
		777651 => 'ERR_SEARCH_CITY__ACCESS_DENIED',
		
		777660 => 'ERR_SEARCH_STREET__UNKNOWN',
		777661 => 'ERR_SEARCH_STREET__ACCESS_DENIED',
		
		777670 => 'ERR_SEARCH_HOUSE__UNKNOWN',
		777671 => 'ERR_SEARCH_HOUSE__ACCESS_DENIED',
	];
	
	
	
	public static function api__register_user( string $user_email, string $user_pass ): array {
		
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
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
	
	
	
	public static function api__get_user_data( string $user_email, string $token ): array {
		
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_USER__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_USER__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
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
	
	
	
	public static function api__get_field_First( string $user_email, string $token, array $query ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => add_query_arg( $query, 'http://217.147.161.26:2660/api/Firsts' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_SEARCH_FIRST__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_SEARCH_FIRST__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			$err_details = "[email({$user_email})] [" . self::query_arr_to_str( $query ) . "] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . ']';
			
			Logger::log( "API: ERROR {$err_details} : {$e->getMessage()}", '', 'search__First' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR {$err_details} : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})] [" . self::query_arr_to_str( $query ) . ']', '', 'search__First' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	
	
	public static function api__get_field_Middle( string $user_email, string $token, array $query ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => add_query_arg( $query, 'http://217.147.161.26:2660/api/Middles' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_SEARCH_MIDDLE__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_SEARCH_MIDDLE__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			$err_details = "[email({$user_email})] [" . self::query_arr_to_str( $query ) . "] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . ']';
			
			Logger::log( "API: ERROR {$err_details} : {$e->getMessage()}", '', 'search__Middle' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR {$err_details} : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})] [" . self::query_arr_to_str( $query ) . ']', '', 'search__Middle' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	
	
	public static function api__get_field_City( string $user_email, string $token, array $query ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => add_query_arg( $query, 'http://217.147.161.26:2660/api/Cities' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_SEARCH_CITY__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_SEARCH_CITY__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			$err_details = "[email({$user_email})] [" . self::query_arr_to_str( $query ) . "] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . ']';
			
			Logger::log( "API: ERROR {$err_details} : {$e->getMessage()}", '', 'search__City' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR {$err_details} : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})] [" . self::query_arr_to_str( $query ) . ']', '', 'search__City' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	
	
	public static function api__get_field_Street( string $user_email, string $token, array $query ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => add_query_arg( $query, 'http://217.147.161.26:2660/api/Streets' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_SEARCH_CITY__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_SEARCH_CITY__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			$err_details = "[email({$user_email})] [" . self::query_arr_to_str( $query ) . "] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . ']';
			
			Logger::log( "API: ERROR {$err_details} : {$e->getMessage()}", '', 'search__Street' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR {$err_details} : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})] [" . self::query_arr_to_str( $query ) . ']', '', 'search__Street' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	
	
	public static function api__get_field_House( string $user_email, string $token, array $query ): array {
		
		try {
			// ------------------------------------------------------------------
			$request = new DMS_API_Request();
			
			$options = [
				CURLOPT_URL           => add_query_arg( $query, 'http://217.147.161.26:2660/api/Houses' ),
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
					self::get_error_code( 'ERR__CURL_ERROR' ),
					null,
					__( 'ошибка cURL ', 'dms' )
				);
			}
			
			
			// 401 Unauthorized
			if ( $res['http_code'] === 401 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']}; {$response_error}",
					self::get_error_code( 'ERR_SEARCH_CITY__ACCESS_DENIED' ),
					null,
					__( 'ошибка доступа', 'dms' )
				);
			}
			
			
			// error other 
			if ( $res['http_code'] !== 200 ) {
				$response_error = ! empty( $res['body']['Message'] ) ? $res['body']['Message'] : '';
				
				throw new DMS_Exeption(
					"HTTP Code = {$res['http_code']} {$response_error};",
					self::get_error_code( 'ERR_SEARCH_CITY__UNKNOWN' ),
					null,
					__( 'неизвестная ошибка', 'dms' )
				);
			}
			
			// ------------------------------------------------------------------
			
		} catch ( DMS_Exeption $e ) {
			
			$err_details = "[email({$user_email})] [" . self::query_arr_to_str( $query ) . "] [{$e->getCode()}|" . self::get_error_name( $e->getCode() ) . ']';
			
			Logger::log( "API: ERROR {$err_details} : {$e->getMessage()}", '', 'search__House' );
			
			return [
				'success'       => false,
				'message'       => "API: ERROR {$err_details} : {$e->getMessage()}",
				'message_front' => $e->getMessageFront(),
				'error_code'    => $e->getCode(),
				'data'          => [],
			];
		}
		
		// http_code === 200 OK
		
		Logger::log( "API: SUCCESS [email({$user_email})] [" . self::query_arr_to_str( $query ) . ']', '', 'search__House' );
		
		return [
			'success'       => true,
			'message'       => '',
			'message_front' => '',
			'error_code'    => 0,
			'data'          => $res['body'],
		];
	}
	
	// ==========================================================================
	
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
	
	
	
	public static function query_arr_to_str( $arr, $trimmed = true ): string {
		if ( ! is_array( $arr ) ) {
			return '';
		}
		$str = '';
		foreach ( $arr as $key => $value ) {
			if ( is_int( $value ) || is_string( $value ) ) {
				$str = "&{$key}={$value}";
			}
		}
		if ( $trimmed ) {
			$str = trim( $str, '&' );
		}
		
		return $str;
	}
	
	
	
	
}

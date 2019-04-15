<?php

namespace DMS\DMS_API;

use DMS\Helper\Logger;
use DMS\Exception\DMS_Exeption;


class DMS_API_Process {
	
	
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
	
	
	
	
}

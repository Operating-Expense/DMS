<?php

namespace DMS\DMS_API;

use DMS\Helper\Utils;
use DMS\Helper\Logger;
use DMS\Exception\DMS_Exeption;


class DMS_API_Manager {
	
	
	public const MAX_NUMBER_OF_RESULTS = -1; // -1 - all,
	public const MONIKER_LIVE_PERIOD = 840;  // sec,  api - 900
	public const DEFAULT_LANG = 'uk_UA';
	
	
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
	 * @param $data_arr
	 * @param $user_email
	 * @param $user_pass
	 *
	 * @return array
	 */
	public static function user_registration( $data_arr, $user_email, $user_pass ): array {
		return DMS_API_Process::api__register_user( $user_email, $user_pass );
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
		$api_process = DMS_API_Process::api__get_token( $user_email, $user_pass );
		
		// update meta fields
		self::update_user_fields_by_api( $user, 'token', $api_process['data'] );
		
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
		$api_process = DMS_API_Process::api__get_user_data( $user_email, $user_token );
		
		// update meta fields
		self::update_user_fields_by_api( $user, 'data', $api_process['data'] );
	}
	
	
	
	public static function user_refresh_api_data(): void {
		if ( ! is_page( 'account' ) ) {
			return;
		}
		
		$current_user = wp_get_current_user();
		
		if ( $current_user->ID ) {
			self::user_save_api_data( $current_user );
		}
	}
	
	
	
	public static function search_first(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		// data
		$search_request = ! empty( trim( $_POST['value'] ) ) ? trim( $_POST['value'] ) : '';
		$lang           = ! empty( $_POST['Lang'] ) ? $_POST['Lang'] : self::DEFAULT_LANG;
		$sexid          = ! empty( $_POST['SexId'] ) ? $_POST['SexId'] : '';
		$current_user   = wp_get_current_user();
		
		$home_url = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( home_url() )
			: home_url();
		$home_url = esc_url( $home_url );
		
		// checks
		if ( ! $current_user->ID ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : User not Authorized',
				'user_id'    => 0,
				'error_html' => __( 'Вы не авторизованы. Перезайдите в кабинет', 'dms' ),
				'redirect'   => $home_url,
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $search_request ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : search_request is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Пустой поисковый запрос', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		$user_email = $current_user->user_email;
		$user_token = self::get_saved_api_access_token( $current_user->ID );
		
		// try to get api data
		$query = [ 'sRequest' => urlencode( $search_request ) ];
		if ( $sexid ) {
			$query['iSexId'] = $sexid;
		}
		
		$headers = [ 'Accept-Language: ' . urlencode( $lang ) ];
		
		$api_process = DMS_API_Process::api__get_field_First( $user_email, $user_token, $query, $headers );
		
		// checks
		
		if ( isset( $api_process['data'] ) ) {
			
			$data = apply_filters( 'dms/api_search/fields/data', $api_process['data'], $user_email, $query );
			$data = apply_filters( 'dms/api_search/field/first/data', $data, $user_email, $query );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $current_user->ID,
				'error_html' => '',
				'redirect'   => '',
				'result'     => $data,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : unknown error',
			'user_id'    => $current_user->ID,
			'error_html' => __( 'Неизвестная ошибка', 'dms' ),
			'redirect'   => '',
			'result'     => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function search_middle(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		// data
		$search_request = ! empty( trim( $_POST['value'] ) ) ? trim( $_POST['value'] ) : '';
		$lang           = ! empty( $_POST['Lang'] ) ? $_POST['Lang'] : self::DEFAULT_LANG;
		$sexid          = ! empty( $_POST['SexId'] ) ? $_POST['SexId'] : '';
		$current_user   = wp_get_current_user();
		
		$home_url = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( home_url() )
			: home_url();
		$home_url = esc_url( $home_url );
		
		// checks
		if ( ! $current_user->ID ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : User not Authorized',
				'user_id'    => 0,
				'error_html' => __( 'Вы не авторизованы. Перезайдите в кабинет', 'dms' ),
				'redirect'   => $home_url,
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $search_request ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : search_request is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Пустой поисковый запрос', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		$user_email = $current_user->user_email;
		$user_token = self::get_saved_api_access_token( $current_user->ID );
		$query      = [ 'sRequest' => urlencode( $search_request ) ];
		if ( $sexid ) {
			$query['iSexId'] = $sexid;
		}
		
		$headers = [ 'Accept-Language: ' . urlencode( $lang ) ];
		
		// try to get api data for the user
		$api_process = DMS_API_Process::api__get_field_Middle( $user_email, $user_token, $query, $headers );
		
		// checks
		
		if ( isset( $api_process['data'] ) ) {
			
			$data = apply_filters( 'dms/api_search/fields/data', $api_process['data'], $user_email, $query );
			$data = apply_filters( 'dms/api_search/field/middle/data', $data, $user_email, $query );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $current_user->ID,
				'error_html' => '',
				'redirect'   => '',
				'result'     => $data,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : unknown error',
			'user_id'    => $current_user->ID,
			'error_html' => __( 'Неизвестная ошибка', 'dms' ),
			'redirect'   => '',
			'result'     => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function search_city(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		// data
		$search_request = ! empty( trim( $_POST['value'] ) ) ? trim( $_POST['value'] ) : '';
		$lang           = ! empty( $_POST['Lang'] ) ? $_POST['Lang'] : self::DEFAULT_LANG;
		$current_user   = wp_get_current_user();
		
		$home_url = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( home_url() )
			: home_url();
		$home_url = esc_url( $home_url );
		
		// checks
		if ( ! $current_user->ID ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : User not Authorized',
				'user_id'    => 0,
				'error_html' => __( 'Вы не авторизованы. Перезайдите в кабинет', 'dms' ),
				'redirect'   => $home_url,
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $search_request ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : search_request is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Пустой поисковый запрос', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		$user_email = $current_user->user_email;
		$user_token = self::get_saved_api_access_token( $current_user->ID );
		$query      = [ 'sRequest' => urlencode( $search_request ) ];
		$headers    = [ 'Accept-Language: ' . urlencode( $lang ) ];
		
		// try to get api data for the user
		$api_process = DMS_API_Process::api__get_field_City( $user_email, $user_token, $query, $headers );
		
		// checks
		
		if ( isset( $api_process['data'] ) ) {
			
			$data = apply_filters( 'dms/api_search/fields/data', $api_process['data'], $user_email, $query );
			$data = apply_filters( 'dms/api_search/field/city/data', $data, $user_email, $query );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $current_user->ID,
				'error_html' => '',
				'redirect'   => '',
				'result'     => $data,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : unknown error',
			'user_id'    => $current_user->ID,
			'error_html' => __( 'Неизвестная ошибка', 'dms' ),
			'redirect'   => '',
			'result'     => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function search_street(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		// data
		$search_request = ! empty( trim( $_POST['value'] ) ) ? trim( $_POST['value'] ) : '';
		$st_moniker     = ! empty( $_POST['st_moniker'] ) ? $_POST['st_moniker'] : '';
		$lang           = ! empty( $_POST['Lang'] ) ? $_POST['Lang'] : self::DEFAULT_LANG;
		$current_user   = wp_get_current_user();
		
		$home_url = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( home_url() )
			: home_url();
		$home_url = esc_url( $home_url );
		
		// checks
		if ( ! $current_user->ID ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : User not Authorized',
				'user_id'    => 0,
				'error_html' => __( 'Вы не авторизованы. Перезайдите в кабинет', 'dms' ),
				'redirect'   => $home_url,
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $search_request ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : search_request is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Пустой поисковый запрос', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $st_moniker ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : st_moniker is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Отсутствует моникер', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		$user_email = $current_user->user_email;
		$user_token = self::get_saved_api_access_token( $current_user->ID );
		$query      = [ 'sRequest' => urlencode( $search_request ), 'stMoniker' => urlencode( $st_moniker ) ];
		$headers    = [ 'Accept-Language: ' . urlencode( $lang ) ];
		
		// try to get api data for the user
		$api_process = DMS_API_Process::api__get_field_Street( $user_email, $user_token, $query, $headers );
		
		// checks
		
		if ( isset( $api_process['data'] ) ) {
			
			$data = apply_filters( 'dms/api_search/fields/data', $api_process['data'], $user_email, $query );
			$data = apply_filters( 'dms/api_search/field/street/data', $data, $user_email, $query );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $current_user->ID,
				'error_html' => '',
				'redirect'   => '',
				'result'     => $data,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : unknown error',
			'user_id'    => $current_user->ID,
			'error_html' => __( 'Неизвестная ошибка', 'dms' ),
			'redirect'   => '',
			'result'     => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function search_house(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		// data
		$search_request = ! empty( trim( $_POST['value'] ) ) ? trim( $_POST['value'] ) : '';
		$house_moniker  = ! empty( $_POST['house_moniker'] ) ? $_POST['house_moniker'] : '';
		$lang           = ! empty( $_POST['Lang'] ) ? $_POST['Lang'] : self::DEFAULT_LANG;
		$current_user   = wp_get_current_user();
		
		$home_url = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( home_url() )
			: home_url();
		$home_url = esc_url( $home_url );
		
		// checks
		if ( ! $current_user->ID ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : User not Authorized',
				'user_id'    => 0,
				'error_html' => __( 'Вы не авторизованы. Перезайдите в кабинет', 'dms' ),
				'redirect'   => $home_url,
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $search_request ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : search_request is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Пустой поисковый запрос', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		if ( ! $house_moniker ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : house_moniker is empty',
				'user_id'    => $current_user->ID,
				'error_html' => __( 'Отсутствует моникер', 'dms' ),
				'redirect'   => '',
				'result'     => '',
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		$user_email = $current_user->user_email;
		$user_token = self::get_saved_api_access_token( $current_user->ID );
		$query      = [ 'sRequest' => urlencode( $search_request ), 'houseMoniker' => urlencode( $house_moniker ) ];
		$headers    = [ 'Accept-Language: ' . urlencode( $lang ) ];
		
		// try to get api data for the user
		$api_process = DMS_API_Process::api__get_field_House( $user_email, $user_token, $query, $headers );
		
		// checks
		
		if ( isset( $api_process['data'] ) ) {
			
			$data = apply_filters( 'dms/api_search/fields/data', $api_process['data'], $user_email, $query );
			$data = apply_filters( 'dms/api_search/field/house/data', $data, $user_email, $query );
			
			wp_send_json_success( [
				'message'    => __FUNCTION__ . ' : success',
				'user_id'    => $current_user->ID,
				'error_html' => '',
				'redirect'   => '',
				'result'     => $data,
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		wp_send_json_error( [
			'message'    => __FUNCTION__ . ' : unknown error',
			'user_id'    => $current_user->ID,
			'error_html' => __( 'Неизвестная ошибка', 'dms' ),
			'redirect'   => '',
			'result'     => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	public static function search_all_fields_limit( $data ) {
		if ( is_array( $data ) && self::MAX_NUMBER_OF_RESULTS !== - 1 ) {
			$data = \array_slice( $data, 0, self::MAX_NUMBER_OF_RESULTS );
		}
		
		return $data;
	}
	
	
	
	public static function search_all_fields_esc( $data ) {
		if ( is_array( $data ) ) {
			\array_walk_recursive( $data, function ( &$value, $key ) {
				if ( is_string( $value ) ) {
					$value = esc_attr( $value );
				}
			} );
		}
		
		return $data;
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
	
	
	
	public static function update_user_fields_by_api( \WP_User $user, string $context, array $data ): void {
		foreach ( self::$api_fields[ $context ] as $field_api => $field_meta ) {
			if ( isset( $data[ $field_api ] ) ) {
				update_user_meta( $user->ID, "_dms--user_api_{$context}__{$field_meta}", $data[ $field_api ] );
			}
		}
	}
	
	
	
}

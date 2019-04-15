<?php

namespace DMS\DMS_API;

use DMS\Helper\Utils;
use DMS\Helper\Logger;
use DMS\Exception\DMS_Exeption;


class DMS_API_Manager {
	
	
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
		$api_process = DMS_API_Process::api__get_data( $user_email, $user_token );
		
		// update meta fields
		self::update_user_fields_by_api( $user, 'data', $api_process['data'] );
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
			if ( ! empty( $data[ $field_api ] ) ) {
				update_user_meta( $user->ID, "_dms--user_api_{$context}__{$field_meta}", $data[ $field_api ] );
			}
		}
	}
	
	
	
}

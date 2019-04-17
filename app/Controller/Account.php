<?php

namespace DMS\Controller;

use DMS\Helper\Utils;
use DMS\Helper\Logger;
use DMS\DMS_API\DMS_API_Manager;



class Account {
	
	
	
	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {
		
		if ( wp_doing_ajax() ) {
			
			// user signin
			add_action( 'wp_ajax_' . 'dms/account/user_signin', [ __CLASS__, 'user_signin' ] );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_signin', [ __CLASS__, 'user_signin' ] );
			
			// check is_user_email_exists
			add_action( 'wp_ajax_' . 'dms/account/is_user_email_exists', [ __CLASS__, 'is_user_email_exists' ] );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/is_user_email_exists', [ __CLASS__, 'is_user_email_exists' ] );
			
			// user registration
			add_action( 'wp_ajax_' . 'dms/account/user_registration', [ __CLASS__, 'user_registration' ] );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_registration', [ __CLASS__, 'user_registration' ] );
			
			// user forgot password
			add_action( 'wp_ajax_' . 'dms/account/user_forgot', [ __CLASS__, 'user_forgot' ] );
			add_action( 'wp_ajax_nopriv_' . 'dms/account/user_forgot', [ __CLASS__, 'user_forgot' ] );
			
		}
		
		// redirect after password reset
		add_action( 'after_password_reset', [ __CLASS__, 'after_password_reset_redirect' ], 77 );
		
		
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
		$user            = wp_authenticate( $user_email, $user_pass );
		$account_url_std = class_exists( 'WPGlobus_Utils' )
			? \WPGlobus_Utils::localize_url( get_permalink( get_page_by_path( 'account' ) ) )
			: get_permalink( get_page_by_path( 'account' ) );
		$redirect_url    = esc_url( $account_url_std );
		
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
		$api__user_registration_data = apply_filters( 'dms/user_registration/api_process', [], $user_email, $user_pass1 );
		
		if ( empty( $api__user_registration_data['success'] ) ) {
			
			Logger::log( "RESOLVE : ERROR [email({$user_email})]", '', 'user_registration' );
			
			if ( isset( $api__user_registration_data['message_front'], $api__user_registration_data['message'] ) ) {
				self::_user_reg__send_valid_error(
					__( 'Ошибка регистрации', 'dms' ) . ' : ' . $api__user_registration_data['message_front'],
					$api__user_registration_data['message']
				);
			}
			
			self::_user_reg__send_valid_error(
				__( 'Ошибка регистрации', 'dms' ),
				'dms/user_registration/api_process - incorrect return value'
			);
			
			/*
			if ( $api__user_registration_data['error_code'] === DMS_API_Process::get_error_code( 'ERR_REG__ALREADY_EXISTS' ) ) {
				Logger::log( "RESOLVE : SUCCESS [email({$user_email})]", '', 'user_registration' );
			} else {
				Logger::log( "RESOLVE : ERROR [email({$user_email})]", '', 'user_registration' );
				
				self::_user_reg__send_valid_error(
					__( 'Ошибка регистрации', 'dms' ) . ' : ' . $api__user_registration_data['message_front'],
					$api__user_registration_data['message']
				);
			}*/
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
		DMS_API_Manager::set_api_pass( $user_id, $user_pass1 );
		
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

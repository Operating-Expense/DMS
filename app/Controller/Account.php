<?php

namespace DMS\Controller;

use Carbon_Fields\Helper\Helper;
use DMS\Helper\Utils;
use DMS\Helper\Logger;
use DMS\Helper\Media;
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
			
			// user_save_profile
			add_action( 'wp_ajax_' . 'dms/account/user_save_profile', [ __CLASS__, 'user_save_profile' ] );
			
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
		
		if ( ! Utils::verify_post_antispam_form( $form_data ) ) {
			return;
		}
		
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
			'error_html' => __( 'Ошибка входа, введите правильный e-mail и пароль', 'dms' ),
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
		
		if (  ! Utils::verify_post_antispam_form($form_data) ) {
			return;
		}
		
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
		
		if (  ! Utils::verify_post_antispam_form($form_data) ) {
			return;
		}
		
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
		$message = sprintf( __( 'Добрый день %1s!<br>', 'dms' ), $firstname );
		$message .= sprintf( __( 'Аккаунт на %1s создан для адреса электронной почты %2s<br>', 'dms' ), get_bloginfo( 'name' ), $email );
		$message .= __( 'Нажмите здесь, чтобы установить пароль для вашей учетной записи:<br>', 'dms' );
		$message .= $rp_link_html . '<br>';
		
		$subject    = sprintf( __( 'Ваш аккаунт на %1s', 'dms' ), get_bloginfo( 'name' ) );
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
	
	
	
	public static function user_save_profile(): void {
		
		if ( ! Utils::verify_post_ajax_nonce() ) {
			return;
		}
		
		
		$user = wp_get_current_user();
		
		if ( empty( $user->ID ) ) {  // no user - no work
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : no current user ID  ',
				'user_id'    => 0,
				'error_html' => __( 'Ошибка : пользователь не определен ', 'dms' ),
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		
		
		$us_POST = wp_unslash( $_POST );  // Wordpress add slashes to $_POST automatically
		
		// data
		$fio             = ! empty( $us_POST['pf_fio'] ) ? sanitize_text_field( trim( $us_POST['pf_fio'] ) ) : '';
		$position        = ! empty( $us_POST['pf_position'] ) ? sanitize_text_field( trim( $us_POST['pf_position'] ) ) : '';
		$company_name    = ! empty( $us_POST['pf_company_name'] ) ? sanitize_text_field( trim( $us_POST['pf_company_name'] ) ) : '';
		$company_address = ! empty( $us_POST['pf_company_address'] ) ? sanitize_text_field( trim( $us_POST['pf_company_address'] ) ) : '';
		$reg_code        = ! empty( $us_POST['pf_reg_code'] ) ? sanitize_text_field( trim( $us_POST['pf_reg_code'] ) ) : '';
		$phone           = ! empty( $us_POST['pf_phone'] ) ? sanitize_text_field( trim( $us_POST['pf_phone'] ) ) : '';
		
		$ava_data = ! empty( $_FILES['pf_ava'] ) ? $_FILES['pf_ava'] : [];
		
		// checks
		if ( ! $fio ) {
			wp_send_json_error( [
				'message'    => __FUNCTION__ . ' : no fio  ',
				'user_id'    => $user->ID,
				'error_html' => __( 'Ошибка : поле пустое ФИО ', 'dms' ),
				'_REQUEST'   => $_REQUEST,
			] );
		}
		
		do_action( 'dms/account/profile/before_update', $user );
		
		// AVA
		
		/*
		Array
        (
            [name] => face1.jpg
            [type] => image/jpeg
            [tmp_name] => F:\OSPanel\userdata\temp\php588.tmp
            [error] => 0
            [size] => 295038
        )*/
		
		$max_file_size       = wp_convert_hr_to_bytes( '4MB' );
		$valid_ava_formats   = [ 'jpeg', 'jpg', 'jpe', 'png' ];
		$ava_must_be_updated = false;
		$ava_attach_id       = 0;
		
		if (
			$ava_data
			&&
			$ava_data['error'] === UPLOAD_ERR_OK
			&&
			$ava_data['size'] < $max_file_size
			&&
			in_array( strtolower( pathinfo( $ava_data['name'], PATHINFO_EXTENSION ) ), $valid_ava_formats, true )
			&&
			( $ava_attach_id = Media::import_media( $ava_data ) ?: 0 )
		) {
			$ava_must_be_updated = true;
		}
		
		
		wp_update_user( [ 'ID' => $user->ID, 'user_firstname' => $fio ] );
		Utils::set_user_meta( $user->ID, 'dms--user_position', $position );
		Utils::set_user_meta( $user->ID, 'dms--user_company_name', $company_name );
		Utils::set_user_meta( $user->ID, 'dms--user_company_address', $company_address );
		Utils::set_user_meta( $user->ID, 'dms--user_phone', $phone );
		Utils::set_user_meta( $user->ID, 'dms--user_reg_code', $reg_code );
		if ( $ava_must_be_updated ) {
			Utils::set_user_meta( $user->ID, 'dms--user_ava', $ava_attach_id );
		}
		
		
		wp_send_json_success( [
			'message'    => __FUNCTION__ . ' : success',
			'user_id'    => $user->ID,
			'saved'      => [
				'pf_fio'              => $fio,
				'pf_position'         => $position,
				'pf_company_name'     => $company_name,
				'pf_company_address'  => $company_address,
				'pf_reg_code'         => $reg_code,
				'pf_phone'            => $phone,
				'ava_must_be_updated' => $ava_must_be_updated,
				'ava_attach_id'       => $ava_attach_id,
			],
			'error_html' => '',
			'_REQUEST'   => $_REQUEST,
		] );
	}
	
	
	
	
}

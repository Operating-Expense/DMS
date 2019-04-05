<?php

namespace DMS\Controller;

class Account {
	
	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {
		
		// user registration
		add_action( 'wp', array( __CLASS__, 'user_registration' ), 77 );
		
		// user signin
		add_action( 'wp', array( __CLASS__, 'user_signin' ), 77 );
		
		// user forgot password
		add_action( 'wp', array( __CLASS__, 'user_forgot' ), 77 );
		
		// redirect after password reset
		add_action( 'after_password_reset', array( __CLASS__, 'after_password_reset_redirect' ), 77 );
		
	}
	
	
	public static function user_signin() {
		
		if ( ! isset( $_POST['account_nonce'] ) || ! wp_verify_nonce( $_POST['account_nonce'], 'dms_account_signin' ) ) {
			return;
		}
		
		// data
		$user_email = ! empty( trim( $_POST['email'] ) ) ? trim( $_POST['email'] ) : '';
		$user_pass  = ! empty( $_POST['pass'] ) ? $_POST['pass'] : '';
		
		// checks
		if ( ! is_email( $user_email ) ) {
			return;
		}
		
		if ( ! $user_pass ) {
			return;
		}
		
		$user = get_user_by( 'email', $user_email );
		
		if ( ! $user ) {
			return;
		}
		
		do_action( 'dms/user_registration', $user );
		
		wp_set_auth_cookie( $user->ID );
		wp_redirect( esc_url( home_url( '/account' ) ) );
		exit;
		
	}
	
	
	public static function user_registration() {
		
		if ( ! isset( $_POST['account_nonce'] ) || ! wp_verify_nonce( $_POST['account_nonce'], 'dms_account_reg' ) ) {
			return;
		}
		
		// data
		$user_email = ! empty( trim( $_POST['email'] ) ) ? trim( $_POST['email'] ) : '';
		$user_pass1 = ! empty( $_POST['pass1'] ) ? $_POST['pass1'] : '';
		$user_pass2 = ! empty( $_POST['pass2'] ) ? $_POST['pass2'] : '';
		
		$user_fio             = ! empty( trim( $_POST['fio'] ) ) ? trim( $_POST['fio'] ) : '';
		$user_position        = ! empty( trim( $_POST['position'] ) ) ? trim( $_POST['position'] ) : '';
		$user_company_name    = ! empty( trim( $_POST['company_name'] ) ) ? trim( $_POST['company_name'] ) : '';
		$user_company_address = ! empty( trim( $_POST['company_address'] ) ) ? trim( $_POST['company_address'] ) : '';
		$user_phone           = ! empty( trim( $_POST['phone'] ) ) ? trim( $_POST['phone'] ) : '';
		$user_reg_code        = ! empty( trim( $_POST['reg_code'] ) ) ? (int) trim( $_POST['reg_code'] ) : '';
		
		
		// checks
		if ( ! is_email( $user_email ) ) {
			return;
		}
		
		if ( $user_pass1 !== $user_pass2 || mb_strlen( $user_pass1 ) < 8 ) {
			return;
		}
		
		if ( ! $user_fio ) {
			return;
		}
		
		if ( ! $user_position ) {
			return;
		}
		
		if ( ! $user_company_name ) {
			return;
		}
		
		if ( ! $user_company_address ) {
			return;
		}
		
		if ( ! $user_phone ) {
			return;
		}
		
		if ( ! $user_reg_code ) {
			return;
		}
		
		
		// fill data
		$user_data               = [];
		$user_data['user_login'] = sanitize_user( $user_email );
		$user_data['first_name'] = $user_fio;
		$user_data['last_name']  = '';
		$user_data['user_email'] = sanitize_email( $user_email );
		$user_data['user_pass']  = $user_pass1;
		$user_data['role']       = 'subscriber';
		
		if ( is_wp_error( $user_id = wp_insert_user( $user_data ) ) ) {
			return;
		}
		
		// update user meta
		update_user_meta( $user_id, 'dms/user_position', $user_position );
		update_user_meta( $user_id, 'dms/user_company_name', $user_company_name );
		update_user_meta( $user_id, 'dms/user_company_address', $user_company_address );
		update_user_meta( $user_id, 'dms/user_phone', $user_phone );
		update_user_meta( $user_id, 'dms/user_reg_code', $user_reg_code );
		
		do_action( 'dms/user_registration', $user_id, $user_data['user_pass'] );
		
		// variant with auto auth
		wp_set_auth_cookie( $user_id );
		
		wp_redirect( add_query_arg( array( 'created_account' => 'true' ), esc_url( home_url( '/account' ) ) ) );
		exit;
	}
	
	
	public static function user_forgot() {
		
		if ( ! isset( $_POST['account_nonce'] ) || ! wp_verify_nonce( $_POST['account_nonce'], 'dms_account_forgot' ) ) {
			return;
		}
		
		// data
		$user_email = ! empty( trim( $_POST['email'] ) ) ? trim( $_POST['email'] ) : '';
		
		// checks
		if ( ! is_email( $user_email ) ) {
			return;
		}
		
		$user = get_user_by( 'email', $user_email );
		
		if ( ! $user ) {
			return;
		}
		
		do_action( 'dms/user_before_send_password_reset_mail', $user );
		
		self::send_password_reset_mail( $user );
	}
	
	
	public static function send_password_reset_mail( $user ) {
		
		if ( ! ( $user instanceof \WP_User ) ) {
			return;
		}
		
		$firstname  = $user->first_name;
		$email      = $user->user_email;
		$user_login = $user->user_login;
		$adt_rp_key = get_password_reset_key( $user );
		
		if ( is_wp_error( $adt_rp_key ) ) {
			return;
		}
		
		$rp_link = network_site_url( "wp-login.php?action=rp&key=$adt_rp_key&login=" . rawurlencode( $user_login ), 'login' );
		
		$rp_link_html = "<a href=\"{$rp_link}\">{$rp_link}</a>";
		
		if ( $firstname === '' ) {
			$firstname = 'User';
		}
		$message = 'Hi ' . $firstname . ',<br>';
		$message .= 'An account has been created on ' . get_bloginfo( 'name' ) . ' for email address ' . $email . '<br>';
		$message .= 'Click here to set the password for your account: <br>';
		$message .= $rp_link_html . '<br>';
		
		$subject    = __( 'Your account on ' . get_bloginfo( 'name' ), 'dms' );
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

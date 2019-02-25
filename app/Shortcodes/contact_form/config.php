<?php

return array(
	'name'                    => esc_html__( 'Contact Form', 'dms' ),
	'base'                    => 'contact_form',
	'icon'                    => DMS()->config['shortcodes_icon_uri'] . '259550.svg',
	'category'                => esc_html__( 'Theme Elements', 'dms' ),
	'description'             => esc_html__( 'Add contact form', 'dms' ),
	'as_parent'               => array(
		'only' =>                 'vc_column_text, heading, vc_row',
	),
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => true,
	'js_view'                 => is_admin() ? 'VcColumnView' : '',
	'params'                  => array(
		
		/**
		 *  Form tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Email To', 'dms' ),
			'description' => esc_html__( 'The form will be sent to this email address.', 'dms'),
			'param_name'  => 'email_to',
			'save_always' => true,
			'value'       => get_option( 'admin_email' ),
			'group'       => esc_html__( 'Form', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Subject Message', 'dms' ),
			'description' => esc_html__( 'This text will be used as subject message for the email', 'dms' ),
			'param_name'  => 'subject_message',
			'value'       => esc_html__( 'New message', 'dms' ),
			'group'       => esc_html__( 'Form', 'dms' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Form', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		),

		/**
		 *  Redirect tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Redirect on success', 'dms' ),
			'description' => esc_html__( 'Type here any URL where user will be redirected after form submit, e.g. to the Thank You page.', 'dms' ),
			'param_name'  => 'redirect_on_success',
			'value'       => '',
			'group'       => esc_html__( 'Redirect', 'dms' ),
		),
		
		/**
		 * Messages tab
		 **/
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Success Message', 'dms' ),
			'description' => esc_html__( 'This text will be displayed when the form will successfully send', 'dms' ),
			'param_name'  => 'success_message',
			'value'       => esc_html__( 'Message sent!', 'dms' ),
			'group'       => esc_html__( 'Messages', 'dms' ),
		),	
		
	),
);

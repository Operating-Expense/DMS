<?php

return array(
	'name'        => esc_html__( 'Alert', 'dms' ),
	'base'        => 'alert',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'alerts.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add an alert', 'dms' ),
	'params'      => array(

		array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Alert Content', 'dms' ),
			'param_name' => 'content',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'dms' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'classes',
			'value'      => '',
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'Element ID', 'dms' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'dms' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Primary', 'dms' )   => 'primary',
				esc_html__( 'Secondary', 'dms' ) => 'secondary',
				esc_html__( 'Success', 'dms' )   => 'success',
				esc_html__( 'Danger', 'dms' )    => 'danger',
				esc_html__( 'Warning', 'dms' )   => 'warning',
				esc_html__( 'Info', 'dms' )      => 'info',
				esc_html__( 'Light', 'dms' )     => 'light',
				esc_html__( 'Dark', 'dms' )      => 'dark',
			),
		),

	)
);
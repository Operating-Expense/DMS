<?php

return array(
	'name'        => esc_html__( 'Button', 'dms' ),
	'base'        => 'button',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'button.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add a button', 'dms' ),
	'params'      => array(

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button title', 'dms' ),
			'param_name' => 'title',
			'holder'     => 'h2',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button link', 'dms' ),
			'param_name' => 'link',
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
			'heading'    => esc_html__( 'Button Align', 'dms' ),
			'param_name' => 'button_align',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'Left', 'dms' )        => 'left',
				esc_html__( 'Center', 'dms' )      => 'center',
				esc_html__( 'Right', 'dms' )       => 'right',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Size', 'dms' ),
			'param_name' => 'button_size',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'Small', 'dms' )       => 'btn-sm',
				esc_html__( 'Large', 'dms' )       => 'btn-lg',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Button Style', 'dms' ),
			'param_name' => 'button_style',
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
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Outline', 'dms' ),
			'param_name' => 'outline',
			'value'      => array(
				esc_html__( 'No', 'dms' )  => '',
				esc_html__( 'Yes', 'dms' ) => 'yes',
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS', 'dms' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'dms' ),
		),


	)
);

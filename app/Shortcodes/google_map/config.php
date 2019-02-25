<?php

return array(
	'name'        => esc_html__( 'Map', 'dms' ),
	'base'        => 'google_map',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'map-location.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add Google Map', 'dms' ),
	'params'      => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Google API Key', 'dms' ),
			'description' => esc_html__( 'Insert here your Google API Key to avoid request limitations and JavaScript errors.',
				'dms' ),
			'param_name'  => 'api_key',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Address', 'dms' ),
			'param_name' => 'address',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Map Height', 'dms' ),
			'param_name' => 'height',
			'value'      => '650',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Map zoom', 'dms' ),
			'param_name'  => 'zoom',
			'save_always' => true,
			'value'       => array(
				'16' => '16',
				'15' => '15',
				'14' => '14',
				'13' => '13',
				'12' => '12',
				'11' => '11',
				'10' => '10',
				'9'  => '9',
				'8'  => '8',
				'7'  => '7',
				'6'  => '6',
				'5'  => '5',
				'4'  => '4',
				'3'  => '3',
				'2'  => '2',
				'1'  => '1',
			),
		),

		array(
			'type'       => 'attach_image',
			'heading'    => esc_html__( 'Pin Icon', 'dms' ),
			'param_name' => 'pin_icon',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label', 'dms' ),
			'param_name' => 'pin_label',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Label color', 'dms' ),
			'param_name' => 'pin_color',
			'value' => '#333333',
			'description' => esc_html__( 'Select color', 'dms' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Font weight', 'dms' ),
			'param_name'  => 'pin_fontweight',
			'save_always' => true,
			'value'       => array(
				'normal' => 'normal',
				'lighter' => 'lighter',
				'bolder' => 'bolder',
				'bold' => 'bold',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label offset', 'dms' ),
			'param_name' => 'pin_labelorigin',
			'description' => esc_html__( 'x,y', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pin offset X', 'dms' ),
			'param_name' => 'pin_offset_x',
			'value'      => 0,
			'default'    => 0,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pin offset Y', 'dms' ),
			'param_name' => 'pin_offset_y',
			'value'      => 0,
			'default'    => 0,
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Hue', 'dms' ),
			'param_name' => 'hue',
			'value'      => '#e5e5e5',
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Saturation', 'dms' ),
			'param_name' => 'saturation',
			'value'      => '-100',
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Lightness', 'dms' ),
			'param_name' => 'lightness',
			'value'      => '50',
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Gamma', 'dms' ),
			'param_name' => 'gamma',
			'value'      => '1',
			'group'      => esc_html__( 'Styling', 'dms' ),
		),

	)
);

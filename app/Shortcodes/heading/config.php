<?php

return array(
	'name'        => esc_html__( 'Heading', 'dms' ),
	'base'        => 'heading',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'heading.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add a heading', 'dms' ),
	'params'      => array(

		/**
		 *  Header attributes tab
		 **/
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Heading Title', 'dms' ),
			'description' => esc_html__( 'Write the heading title content.', 'dms' ),
			'param_name'  => 'title',
			'value'       => '',
			'holder'      => 'h2',
			'group'       => esc_html__( 'Header Attributes', 'dms' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Heading Size', 'dms' ),
			'param_name'  => 'heading',
			'save_always' => true,
			'value'       => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
			),
			'group'       => esc_html__( 'Header Attributes', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'classes',
			'value'      => '',
			'group'      => esc_html__( 'Header Attributes', 'dms' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Header Attributes', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		),


		/**
		 *  Styling tab
		 **/
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Header text color', 'dms' ),
			'param_name' => 'header_color',
			'value'      => '',
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Align', 'dms' ),
			'param_name' => 'text_align',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'Left', 'dms' )        => 'left',
				esc_html__( 'Center', 'dms' )      => 'center',
				esc_html__( 'Right', 'dms' )       => 'right',
			),
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Text Transform', 'dms' ),
			'param_name' => 'text_transform',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'None', 'dms' )        => 'none',
				esc_html__( 'Uppercase', 'dms' )   => 'uppercase',
			),
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Style', 'dms' ),
			'param_name' => 'font_style',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'Normal', 'dms' )      => 'normal',
				esc_html__( 'Italic', 'dms' )      => 'italic',
			),
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Font Weight', 'dms' ),
			'param_name' => 'font_weight',
			'value'      => array(
				esc_html__( '- Default -', 'dms' ) => '',
				esc_html__( 'Light', 'dms' )       => 'lighter',
				esc_html__( 'Normal', 'dms' )      => 'normal',
				esc_html__( 'Bold', 'dms' )        => 'bold',
				esc_html__( 'Bolder', 'dms' )      => 'bolder',
				'100'                                                  => '100',
				'200'                                                  => '200',
				'300'                                                  => '300',
				'400'                                                  => '400',
				'500'                                                  => '500',
				'600'                                                  => '600',
				'700'                                                  => '700',
				'800'                                                  => '800',
				'900'                                                  => '900',
			),
			'group'      => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Letter spacing', 'dms' ),
			'description' => esc_html__( 'In pixels, for example: 10', 'dms' ),
			'param_name'  => 'letter_spacing',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size', 'dms' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'dms' ),
			'param_name'  => 'font_size',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height', 'dms' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'dms' ),
			'param_name'  => 'line_height',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Font size (small screens)', 'dms' ),
			'description' => esc_html__( 'In pixels, for example: 18', 'dms' ),
			'param_name'  => 'font_size_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line height (small screens)', 'dms' ),
			'description' => esc_html__( 'In pixels, for example: 24', 'dms' ),
			'param_name'  => 'line_height_mobile',
			'value'       => '',
			'group'       => esc_html__( 'Styling', 'dms' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'dms' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'dms' ),
		),

	)
);

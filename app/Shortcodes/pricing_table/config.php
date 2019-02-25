<?php

return array(
	'name'        => esc_html__( 'Pricing Table', 'dms' ),
	'base'        => 'pricing_table',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Param Group', 'dms' ),
	'params'      => array(

		/**
		 * Columns Repeater (to manage columns data)
		 */

		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Columns', 'dms' ),
			'param_name' => 'columns',
			'value'      => '',
			'group'      => esc_html__( 'Columns', 'dms' ),
			'params'     => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'dms' ),
					'param_name' => 'title',
					'value'      => '',
				),
				array(
					'type'       => 'exploded_textarea',
					'heading'    => esc_html__( 'Features', 'dms' ),
					'param_name' => 'features',
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Currency', 'dms' ),
					'param_name' => 'currency',
					'value'      => '$',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Price', 'dms' ),
					'param_name' => 'price',
					'value'      => '',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Period', 'dms' ),
					'param_name' => 'period',
					'value'      => array(
						"Per Day" => "per<br>day",
						"Per Week" => "per<br>week",
						"Per Month" => "per<br>month",
						"Per Year" => "per<br>year",
						"Forever" => "forever"
					)
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button URL', 'dms' ),
					'param_name' => 'button_url',
					'value'      => '#',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button Title', 'dms' ),
					'param_name' => 'button_title',
					'value'      => '',
				)
			)
		),

		/**
		 * Fonts
		 */

		/*

		array(
			'type' => 'google_fonts',
			'param_name' => 'heading_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Heading Font Family.', 'dms' ),
					'font_style_description' => esc_html__( 'Select Heading Font Style.', 'dms' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__('Fonts', 'dms' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'features_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Features Font Family.', 'dms' ),
					'font_style_description' => esc_html__( 'Select Features Font Style.', 'dms' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'dms' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'price_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Price Font Family.', 'dms' ),
					'font_style_description' => esc_html__( 'Select Price Font Style.', 'dms' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'dms' )
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'button_font',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select Button Font Family.', 'dms' ),
					'font_style_description' => esc_html__( 'Select Button Font Style.', 'dms' ),
				),
			),
			'weight' => 0,
			'group' => esc_html__( 'Fonts', 'dms' ),
		),

		*/

		/**
		 * Colors
		 */

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'dms' ),
			'param_name' => 'border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Background Color', 'dms' ),
			'param_name' => 'header_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading Text Color', 'dms' ),
			'param_name' => 'header_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Background Color', 'dms' ),
			'param_name' => 'button_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Background Color', 'dms' ),
			'param_name' => 'button_hover_bg_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Text Color', 'dms' ),
			'param_name' => 'button_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Hover Text Color', 'dms' ),
			'param_name' => 'button_hover_text_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Button Border Color', 'dms' ),
			'param_name' => 'button_border_color',
			'value'      => '',
			'group'      => esc_html__( 'Colors', 'dms' ),
		),

		/**
		 * Borders
		 */

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Radius', 'dms' ),
			'param_name' => 'border_radius',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Border Width', 'dms' ),
			'param_name' => 'border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button Border Width', 'dms' ),
			'param_name' => 'button_border_width',
			'value'      => '',
			'group'      => esc_html__( 'Borders', 'dms' ),
		)
	)
);

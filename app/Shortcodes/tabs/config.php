<?php

return [
	'name'                    => esc_html__( 'Tabs', 'dms' ),
	'base'                    => 'tabs',
	'icon'                    => DMS()->config['shortcodes_icon_uri'] . 'tabs.svg',
	'category'                => esc_html__( 'Theme Elements', 'dms' ),
	'description'             => esc_html__( 'Add Tabs', 'dms' ),
	'as_parent'               => [ 'only' => 'tab' ],
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => true,
	'params'                  => [
		[
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Position Tabs', 'dms' ),
			'description' => esc_html__( 'Please select position', 'dms' ),
			'param_name'  => 'position',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'Vertical', 'dms' )   => 'vertical',
				esc_html__( 'Horizontal', 'dms' ) => 'horizontal',
			),
			'group'       => esc_html__( 'Tabs', 'dms' ),
		],
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'classes',
			'value'      => 'dms_tabs',
			'group'      => esc_html__( 'Header Attributes', 'dms' ),
		],
		[
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Tabs', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		],
	],
	'js_view'                 => is_admin() ? 'VcColumnView' : ''
];
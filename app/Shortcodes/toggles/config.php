<?php

return array(
	'name'                    => esc_html__( 'Toggles', 'dms' ),
	'base'                    => 'toggles',
	'icon'                    => DMS()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'category'                => esc_html__( 'Theme Elements', 'dms' ),
	'description'             => esc_html__( 'Add accordion / toggles', 'dms' ),
	'as_parent'               => [ 'only' => 'toggle' ],
	'content_element'         => true,
	'is_container'            => true,
	'show_settings_on_create' => false,
	'params'                  => [
		[
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'classes',
			'value'      => 'accordion',
			'group'      => esc_html__( 'Header Attributes', 'dms' ),
		],
		[
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => [
				'auto_generate' => true,
			],
			'group'       => esc_html__( 'Header Attributes', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		],
	],
	'js_view'                 => 'VcColumnView'
);
<?php
return [
	'name'            => esc_html__( 'Tab', 'dms' ),
	'base'            => 'tab',
	'content_element' => true,
	'as_child'        => [ 'only' => 'tabs'	],
	'params'          => [
		[
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'dms' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		],
		[
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Text', 'dms' ),
			'param_name'  => 'content',
			'value'       => '',
			'description' => esc_html__( 'Enter your content.', 'dms' )
		],
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'dms' ),
			'param_name' => 'icon',
			'settings'   => array(
				'emptyIcon' => true,
				'type'      => 'fontawesome',
			)
		)
	]
];




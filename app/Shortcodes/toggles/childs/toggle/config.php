<?php

return array(
	'name'            => esc_html__( 'Toggle Section', 'dms' ),
	'base'            => 'toggle',
	'icon'            => DMS()->config['shortcodes_icon_uri'] . 'toggle.svg',
	'content_element' => true,
	'as_child'        => array( 'only' => 'toggles' ),
	'params'          => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'dms' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Text', 'dms' ),
			'param_name' => 'content',
			'value'      => '',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Open by defaults', 'dms' ),
			'param_name' => 'open',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
		),

	)
);

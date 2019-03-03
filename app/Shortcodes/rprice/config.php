<?php

return array(
	'name'     => esc_html__( 'Price of request', 'dms' ),
	'base'     => 'rprice',
	'category' => esc_html__( 'DMS', 'dms' ),
	'params'   => array(
		// ============================ Block Settings =============================
		array(
			'type'        => 'textfield',
			'param_name'  => 'title',
			'heading'     => esc_html__( 'Title', 'dms' ),
			'value'       => '',
			'group'       => esc_html__( 'General', 'dms' ),
			'admin_label' => true
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'accent_text',
			'heading'    => esc_html__( 'Accent Text', 'dms' ),
			'value'      => '',
			'group'       => esc_html__( 'General', 'dms' ),
			'admin_label' => true
		),
		array(
			'type'       => 'textarea_html',
			'param_name' => 'content',   // !!! must be “content”, and  only one per shortcode 
			'heading'    => esc_html__( 'Text', 'dms' ),
			'value'      => '',
			'group'       => esc_html__( 'General', 'dms' ),
			//'admin_label' => true
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'el_classes',
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'CSS id', 'dms' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
	
	
	)
);
